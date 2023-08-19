<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Mail\ActivityCreated;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Participation;
use App\Models\KabarTerbaru;
use App\Models\Task;
use App\Models\Criteria;
use Carbon\Carbon;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsRedirected;

class ActivityController extends Controller
{
    private $data = NULL;

    private function categoryFiltering($id)
    {
        $this->data = Activity::where("category_id", $id);
    }

    private function orderByFiltering($order)
    {
        if ($order === "mendesak") {
            $this->data = $this->data ? $this->data->orderBy("activities.batas_waktu", 'ASC') : Activity::orderBy("activities.batas_waktu", 'ASC');
        } else if ($order === "populer") {
            $this->data = $this->data ? $this->data->orderBy(DB::raw('total_volunteer'), 'DESC') : Activity::orderBy(DB::raw('total_volunteer'), 'DESC');
        } else if ($order === "terbaru") {
            $this->data = $this->data ? $this->data->orderBy('activities.created_at', 'DESC') : Activity::orderBy('activities.created_at', 'DESC');
        } else {
            throw new HttpClientException("invalid order key", 400);
        }
    }

    private function byFiltering($filter)
    {
        $roles = [
            'peduly' => 'users.tipe = "Fundraiser" OR users.tipe = "Volunteer"',
            'organisasi' => 'users.tipe = "organisasi"',
            'pribadi' => 'users.tipe = "pribadi" OR users.tipe = "Individu"'
        ];

        if (!array_key_exists($filter, $roles)) {
            throw new HttpClientException("invalid filter key", 400);
        }

        $this->data = $this->data ? $this->data->join('users', 'users.id', "=", 'activities.user_id')
            ->whereRaw($roles[$filter])
            : Activity::join('users', 'users.id', "=", 'activities.user_id')->whereRaw($roles[$filter]);
    }

    private function getAllActivitiesWithoutFiltering()
    {
        return Activity::orderBy('created_at', 'DESC');
    }

    private function getAllActivitiesWithoutFilteringWithLimit($limit)
    {
        $this->data = $this->data ? $this->data->limit($limit) : Activity::limit($limit);
    }

    public function index()
    {
        try {
            if (request()->kategori) {
                $this->categoryFiltering(request()->kategori);
            }

            if (request()->urutan) {
                $this->orderByFiltering(request()->urutan);
            }

            if (request()->filter) {
                $this->byFiltering(request()->filter);
            }

            if (request()->limit) {
                $this->getAllActivitiesWithoutFilteringWithLimit(request()->limit);
            }

            $activities = $this->data ? $this->data : $this->getAllActivitiesWithoutFiltering();

            $joinWithRelatedTables = $activities->leftJoin("participations", "participations.activity_id", "=", "activities.id")
                ->groupBy("activities.id")
                ->where('status_publish', 'published')
                ->orWhere('status_publish', NULL)
                ->get([
                    'activities.id',
                    "judul_activity",
                    "judul_slug",
                    "foto_activity",
                    "batas_waktu",
                    "activities.created_at",
                    "tipe_activity",
                    DB::raw("CONCAT(DATEDIFF(batas_waktu, CURRENT_DATE), ' hari') as sisa_waktu"),
                    DB::raw("COUNT(participations.id) as total_volunteer")
                ]);

            return response()->json(["data" => $joinWithRelatedTables]);
        } catch (HttpClientException $err) {
            return response()->json(["message" => $err->getMessage()], $err->getCode());
        }
    }

    public function bySlug($activity)
    {
        $data_activity = DB::table('activities')
            ->where('judul_slug', $activity)
            ->get();

        if ($data_activity->isEmpty()) {
            return response()->json(['message' => 'activity tidak ditemukan'], 404);
        }

        $id_activity = $data_activity[0]->id;
        $id_activist = $data_activity[0]->user_id;

        $activist = DB::table('users')
            ->where('id', $id_activist)
            ->get(['username', 'photo', 'name', 'status_akun', 'role', 'tipe', 'jenis_organisasi']);


        $total_volunteer = DB::table('participations')
            ->select(DB::raw('COUNT(participations.id) as total_volunteer'))
            ->where('activity_id', '=', $id_activity)
            ->get();

        $volunteer = Participation::join('users', 'user_id', '=', 'users.id')
            ->where('activity_id', $id_activity)
            ->get(['photo', 'username',  'name', 'nomor_hp', 'participations.created_at']);

        $tasks = Task::join('activities', 'activity_id', '=', 'activities.id')
            ->where('activity_id', $id_activity)
            ->get(DB::raw('tasks.id, tasks.deskripsi, tasks.created_at'));

        $criterias = Criteria::join('activities', 'activity_id', '=', 'activities.id')
            ->where('activity_id', $id_activity)
            ->get(DB::raw('criterias.id, criterias.deskripsi, criterias.created_at'));

        $user = auth('api')->user();

        $now = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
        $batas_waktu = Carbon::createFromFormat('Y-m-d H:s:i', $data_activity[0]->batas_waktu);

        $data_activity[0]->sisa_hari = $batas_waktu->diffInDays($now);

        return response()->json([
            'data' => [
                'activity' => $data_activity,
                'user' => $activist,
                'total_volunteer' => $total_volunteer,
                'volunteer' => $volunteer,
                'tugas' => $tasks,
                'kriteria' => $criterias,
                'is_mine' => $user ? ($user->id === $id_activist) : false
            ]
        ]);
    }

    public function show(Activity $activity): JsonResponse
    {
        $id_activity = $activity->id;

        $total_volunteer = DB::table('participations')
            ->select(DB::raw('COUNT(participations.id) as total_volunteer'))
            ->where('activity_id', '=', $id_activity)
            ->get();

        $tasks = Task::join('activities', 'activity_id', '=', 'activities.id')
            ->where('activity_id', $id_activity)
            ->get();

        $criterias = Criteria::join('activities', 'activity_id', '=', 'activities.id')
            ->where('activity_id', $id_activity)
            ->get();

        $user = $activity->user;

        return response()->json([
            'data' => [
                'activity' => $activity,
                'total_volunteer' => $total_volunteer,
                'tugas' => $tasks,
                'kriteria' => $criterias
            ]
        ]);
    }

    private function imageValidation(Request $request, $imageName)
    {
        $validator = Validator::make($request->all(), [
            $imageName => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);
        return $validator;
    }

    private function uploadImage(Request $request, $file, $judul_slug)
    {
        $fileName     = $judul_slug . '.' . $request->file($file)->extension();
        $path = 'images/images_activity';
        $request->file($file)->move(public_path($path), $fileName);
        return env('APP_URL') . "/$path/$fileName";
    }

    public function publish(Request $request)
    {
        $request['status_publish'] = 'published';
        return $this->create($request);
    }

    public function draft(Request $request)
    {
        $request['status_publish'] = 'drafted';
        return $this->create($request);
    }

    public function create(Request $request)
    {
        $rules = [
            'status_publish' => 'required|in:published,drafted',
        ];
        if ($request->status_publish === 'published') {
            // dicek dulu lah
            $rules = [
                'category_id'     => 'required|numeric',
                'judul_activity'  => 'required|string|max:255',
                'foto_activity'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'detail_activity' => 'required|string',
                'batas_waktu'     => 'required|numeric',
                'waktu_activity'  => 'required|string',
                'lokasi'          => 'required|string|max:255',
                'tipe_activity'   => 'required|in:Virtual,In-Person,Hybrid',
                'kuota'           => 'required|numeric',
                'tautan'          => 'required|string'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        // check category_id is exist
        $category = Category::find($request->category_id);
        if (!$category) {
            return response()->json(['message' => "category with id: $request->category_id not found!"]);
        }

        $judul_slug = "";
        // dicek apakah ada custom slug
        if ($request->judul_slug) {
            // cek apakah slug sudah digunakan
            if (Activity::where('judul_slug', $request->judul_slug)->first()) {
                return response()->json(['message' => 'judul slug sudah digunakan'], 400);
            } else {
                $judul_slug = $request->judul_slug;
            }
        } else {
            // kalo gaada custom maka dibikinin
            $judul_slug = SlugService::createSlug(Activity::class, 'judul_slug', request('judul_activity'));
        }

        $foto_activity = NULL;

        if ($request->file('foto_activity')) {
            $validator = $this->imageValidation($request, 'foto_activity');
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_activity = $this->uploadImage($request, 'foto_activity', $judul_slug);
        }

        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['message' => 'user not found!'], 404);
        }

        $activity = Activity::create([
            'category_id'     => $category->id,
            'user_id'         => $user->id,
            'judul_activity'  => $request->judul_activity,
            'judul_slug'      => $judul_slug,
            'foto_activity'   => $foto_activity,
            'detail_activity' => $request->detail_activity,
            'batas_waktu'     => Carbon::now()->addDays($request->batas_waktu),
            'waktu_activity'  => $request->waktu_activity,
            'lokasi'          => $request->lokasi,
            'tipe_activity'   => $request->tipe_activity,
            'status_publish'  => $request->status_publish,
            'status'          => 'Pending',
            'kuota'           => $request->kuota ? $request->kuota : 0,
            'tautan'          => $request->tautan ? $request->tautan : 'involuntir',
            'updated_at'      => $request->status_publish === 'published' ? Carbon::now() : null
        ]);

        $tasks = $request->tasks ? json_decode($request->tasks) : [];
        foreach ($tasks as $task) {
            $task = Task::create([
                'activity_id' => $activity->id,
                'deskripsi' => $task
            ]);
        }

        $activity->tasks = $tasks;

        $criterias = $request->criterias ? json_decode($request->criterias) : [];
        foreach ($criterias as $criteria) {
            Criteria::create([
                'activity_id' => $activity->id,
                'deskripsi' => $criteria
            ]);
        }

        $activity->criterias = $criterias;

        return response()->json(['data' => $activity], 201);
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $user = auth('api')->user();

        if ($user->id !== intval($activity->user_id)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $rules = [
            'status_publish' => 'required|in:published,drafted',
        ];
        if ($request->status_publish === 'published') {
            // dicek dulu lah
            $rules = [
                'category_id'     => 'numeric',
                'judul_activity'  => 'string|max:255',
                'foto_activity'   => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'detail_activity' => 'string',
                'batas_waktu'     => 'numeric',
                'waktu_activity'  => 'string',
                'lokasi'          => 'string|max:255',
                'tipe_activity'   => 'in:Virtual,In-Person,Hybrid'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        // check category_id is exist
        $category_id = $request->category_id ? Category::find($request->category_id) : $activity->category_id;
        if (!$category_id) {
            return response()->json(['message' => "category with id: $request->category not found!"]);
        }

        $judul_activity = $request->judul_activity ? $request->judul_activity : $activity->judul_activity;

        $judul_slug = $request->judul_slug ? $request->judul_slug : $activity->judul_slug;

        $detail_activity = $request->detail_activity ? $request->detail_activity : $activity->detail_activity;

        $batas_waktu = $request->batas_waktu ? $activity->created_at->addDays($request->batas_waktu) : $activity->batas_waktu;

        if ($batas_waktu < Carbon::now()) {
            return response()->json(['message' => 'batas waktu sudah terlewati']);
        }

        $waktu_activity = $request->waktu_activity ? $request->waktu_activity : $activity->waktu_activity;

        $lokasi = $request->lokasi ? $request->lokasi : $activity->lokasi;

        $tipe_activity = $request->tipe_activity ? $request->tipe_activity : $activity->tipe_activity;


        $foto_activity = $activity->foto_activity;

        if ($request->file('foto_activity')) {
            $validator = $this->imageValidation($request, 'foto_activity');
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_activity/' . $activity->foto_activity));
            $foto_activity = $this->uploadImage($request, 'foto_activity', $judul_slug);
        }

        $user = auth('api')->user();

        // $detail_campaign = $this->detailToHTML(
        //     $request->cerita_tentang_pembuat_campaign,
        //     $request->cerita_tentang_penerima_manfaat,
        //     $request->cerita_tentang_masalah_dan_usaha,
        //     $request->berapa_biaya_yang_dibutuhkan,
        //     $request->kenapa_galangdana_dibutuhkan,
        //     $foto_tentang_campaign,
        //     $foto_tentang_campaign_2,
        //     $foto_tentang_campaign_3
        // );

        $activity->update([
            'category_id'     => $category_id,
            'judul_activity'  => $judul_activity,
            'judul_slug'      => $judul_slug,
            'foto_activity'   => $foto_activity,
            'detail_activity' => $detail_activity,
            'batas_waktu'     => $batas_waktu,
            'waktu_activity'  => $waktu_activity,
            'lokasi'          => $lokasi,
            'tipe_activity'   => $tipe_activity,
            'status_publish'  => $request->status_publish,
            'updated_at'      => $request->status_publish === 'published' ? Carbon::now() : $activity->updated_at
        ]);


        //      send email after campaign created
        // if($request->status_publish === 'published' && !$campaign->email_sent_at) {
        //     Mail::to($user->email)->send(new CampaignCreated($campaign));
        //     $campaign->update([
        //         'email_sent_at' => Carbon::now()
        //     ]);
        // }

        $activity->user = $user;

        return response()->json(['data' => $activity], 201);
    }

    private function getCategory(Category $category)
    {
        return Activity::orderBy('activities.created_at')
            ->where('category_id', $category->id)->leftJoin("participations", "participations.activity_id", "=", "activities.id")->groupBy("activities.id")->get(['activities.id', "judul_activity", "judul_slug", "foto_activity", "batas_waktu", "activities.created_at", DB::raw("COUNT(participations.id) as total_volunteer")]);
    }

    public function isExist($slug)
    {
        return response()->json(['isExist' => Activity::where('judul_slug', $slug)->first() ? true : false]);
    }

    public function destroy(Activity $activity)
    {
        // old image is not deleted because this is a soft delete
        $activity->delete();
        return response()->json(['message' => 'berhasil menghapus activity'], 200);
    }

    public function myActivities()
    {
        $user = Auth::user();

        $activities = Activity::where('activities.user_id', $user->id)->leftJoin("participations", "participations.activity_id", "=", "activities.id")
            ->groupBy("activities.id")->orderBy('activities.created_at', 'DESC')
            ->get([
                'activities.id', "judul_activity", "judul_slug",
                "foto_activity", "batas_waktu",
                "activities.created_at",
                DB::raw("COUNT(participations.id) as total_volunteer")
            ]);

        return response()->json(["data" => $activities], 200);
    }
}
