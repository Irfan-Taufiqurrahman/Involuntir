<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityType;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\Participation;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ActivityController extends Controller
{
    private $data = null;

    private function categoryFiltering($id)
    {
        $this->data = Activity::where('category_id', $id);
    }

    private function orderByFiltering($order)
    {
        if ($order === 'mendesak') {
            $this->data = $this->data ? $this->data->orderBy('activities.batas_waktu', 'ASC') : Activity::orderBy('activities.batas_waktu', 'ASC');
        } elseif ($order === 'populer') {
            $this->data = $this->data ? $this->data->orderBy(DB::raw('total_volunteer'), 'DESC') : Activity::orderBy(DB::raw('total_volunteer'), 'DESC');
        } elseif ($order === 'terbaru') {
            $this->data = $this->data ? $this->data->orderBy('activities.created_at', 'DESC') : Activity::orderBy('activities.created_at', 'DESC');
        } else {
            throw new HttpClientException('invalid order key', 400);
        }
    }

    private function byFiltering($filter)
    {
        $roles = [
            'peduly' => 'users.tipe = "Fundraiser" OR users.tipe = "Volunteer"',
            'organisasi' => 'users.tipe = "organisasi"',
            'pribadi' => 'users.tipe = "pribadi" OR users.tipe = "Individu"',
        ];

        if (! array_key_exists($filter, $roles)) {
            throw new HttpClientException('invalid filter key', 400);
        }

        $this->data = $this->data ? $this->data->join('users', 'users.id', '=', 'activities.user_id')
            ->whereRaw($roles[$filter])
            : Activity::join('users', 'users.id', '=', 'activities.user_id')->whereRaw($roles[$filter]);
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

            $joinWithRelatedTables = $activities->leftJoin('participations', 'participations.activity_id', '=', 'activities.id')
                ->groupBy('activities.id')
                ->where('status_publish', 'published')
                ->orWhere('status_publish', null)
                ->with('prices')
                ->get([
                    'activities.id',
                    'judul_activity',
                    'judul_slug',
                    'foto_activity',
                    'batas_waktu',
                    'activities.created_at',
                    'jenis_activity',
                    'tipe_activity',
                    DB::raw("CONCAT(DATEDIFF(batas_waktu, CURRENT_DATE), ' hari') as sisa_waktu"),
                    DB::raw('COUNT(participations.id) as total_volunteer'),
                ]);

            return response()->json(['data' => $joinWithRelatedTables]);
        } catch (HttpClientException $err) {
            return response()->json(['message' => $err->getMessage()], $err->getCode());
        }
    }

    public function bySlug($activity)
    {
        $data_activity = Activity::where('judul_slug', $activity)->with('prices')->first();

        if (empty($data_activity)) {
            return response()->json(['message' => 'activity tidak ditemukan'], 404);
        }

        $id_activity = $data_activity->id;
        $id_activist = $data_activity->user_id;

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
        $batas_waktu = Carbon::createFromFormat('Y-m-d H:s:i', $data_activity->batas_waktu);

        $data_activity->sisa_hari = $batas_waktu->diffInDays($now);

        return response()->json([
            'data' => [
                'activity' => $data_activity,
                'user' => $activist,
                'total_volunteer' => $total_volunteer,
                'volunteer' => $volunteer,
                'tugas' => $tasks,
                'kriteria' => $criterias,
                'is_mine' => $user ? ($user->id === $id_activist) : false,
            ],
        ]);
    }

    public function show(Activity $activity): JsonResponse
    {
        $activity = $activity->load([
            'prices', 'participants',
            'tasks',
            'criterias',
        ])->loadCount('participants');

        return response()->json([
            'data' => [
                'activity' => $activity,
            ],
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
        $fileName = $judul_slug . '.' . $request->file($file)->extension();
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
    $user = auth('api')->user();

    if (!$user) {
        return response()->json(['message' => 'user not found!'], 404);
    }

    $validator = Validator::make($request->all(), [
        'judul_activity' => 'required|string|max:255',
        'judul_slug' => 'sometimes|string|unique:activities,judul_slug|max:255',
        'category_id' => ['required', 'exists:categories,id'],
        'detail_activity' => 'required|string',
        'batas_waktu' => 'required|numeric',
        'foto_activity' => 'required|string', // Corrected the type to 'string'
        'lokasi' => 'required|string|max:255',
        'waktu_activity' => 'required|string',
        'tipe_activity' => 'required|in:Virtual,In-Person,Hybrid',
        'status_publish' => 'required|in:drafted,published',
        'kuota' => 'required|numeric',
        'tautan' => 'required|string',
        'jenis_activity' => ['nullable', new Enum(ActivityType::class)],
        'biaya_activity' => ['required_if:jenis_activity,paid', 'array'],
        'biaya_activity.*.per' => ['required_if:jenis_activity,paid', 'numeric'],
        'biaya_activity.*.price' => ['required_if:jenis_activity,paid', 'numeric'],
        'tasks' => 'sometimes|array',
        'tasks.*.deskripsi' => 'required|string',
        'criterias' => 'sometimes|array',
        'criterias.*.deskripsi' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors()], 400);
    }

    $validated = $validator->validated();

    $slug = !empty($request->judul_slug) ? $validated['judul_slug'] : Str::slug($request->judul_activity . ' ' . Str::random(6));
    $photo = $request->file('foto_activity');
    $activityType = $request->jenis_activity ?? ActivityType::FREE->value;
    $activityPrices = $request->biaya_activity ?? [];

    if (!empty($photo)) {
        // Assuming you have an 'uploadImage' method
        $photo = $this->uploadImage($request, 'foto_activity', $slug);
    }

    $activity = Activity::create([
        'category_id' => $validated['category_id'],
        'user_id' => $user->id,
        'judul_activity' => $request->judul_activity,
        'judul_slug' => $slug,
        'foto_activity' => $photo,
        'detail_activity' => $request->detail_activity,
        'batas_waktu' => Carbon::now()->addDays($request->batas_waktu),
        'waktu_activity' => $request->waktu_activity,
        'lokasi' => $request->lokasi,
        'tipe_activity' => $request->tipe_activity,
        'status_publish' => $request->status_publish,
        'status' => 'Pending',
        'kuota' => $request->kuota ? $request->kuota : 0,
        'tautan' => $request->tautan ? $request->tautan : 'involuntir',
        'jenis_activity' => $activityType,
        'updated_at' => $request->status_publish === 'published' ? Carbon::now() : null,
    ]);

    if (!empty($activityType) && ActivityType::PAID->equals(ActivityType::from($activityType))) {
        foreach ($activityPrices as $value) {
            $activity->prices()->updateOrCreate($value);
        }
        $activity->save();
    }

    $tasks = $request->tasks ?? [];

    foreach ($tasks as $task) {
        Task::create([
            'activity_id' => $activity->id,
            'deskripsi' => $task['deskripsi'],
        ]);
    }

    $activity->tasks = $tasks;

    $criterias = $request->criterias ?? [];

    foreach ($criterias as $criteria) {
        Criteria::create([
            'activity_id' => $activity->id,
            'deskripsi' => $criteria['deskripsi'],
        ]);
    }

    $activity->criterias = $criterias;

    $activity->load('prices','tasks','criterias');

    return response()->json(['data' => $activity], 201);
}


    public function update(Request $request, $id)
    {
        $user = auth('api')->user();

        if (! $user) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        $activity = Activity::find($id);

        if (empty($activity)) {
            return response()->json(['message' => 'activitas tidak ada'], 404);
        }

        // Otorisasi: Hanya pemilik aktivitas yang dapat mengubahnya
        if ($user->id !== intval($activity->user_id)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'judul_activity' => 'sometimes|required|string|max:255',
            'judul_slug' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                Rule::unique('activities')->ignore($activity->id),
            ],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'detail_activity' => 'sometimes|required|string',
            'batas_waktu' => 'sometimes|required|numeric',
            'foto_activity' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lokasi' => 'sometimes|required|string|max:255',
            'waktu_activity' => 'sometimes|required|string',
            'tipe_activity' => 'sometimes|required|in:Virtual,In-Person,Hybrid',
            'kuota' => 'sometimes|required|numeric',
            'tautan' => 'sometimes|required|string',
            'jenis_activity' => 'nullable', // Validasi yang boleh bernilai null
            'biaya_activity' => ['sometimes', 'nullable', 'array'], // Validasi yang boleh bernilai null
            'biaya_activity.*.per' => ['sometimes', 'nullable', 'numeric'], // Validasi yang boleh bernilai null
            'biaya_activity.*.price' => ['sometimes', 'nullable', 'numeric'], // Validasi yang boleh bernilai null
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $validated = $validator->validated();

        // Update hanya nilai yang berubah
        $activity->fill(array_filter($validated))->save();

        $activityType = $validated['jenis_activity'] ?? null;

        if (! empty($activityType) && ActivityType::FREE->equals(ActivityType::from($activityType))) {
            // Menghapus semua biaya aktivitas jika jenis aktivitas berubah menjadi "free"
            $activity->prices()->delete();
        }

        // Handle pembaruan tugas (tasks) dan kriteria (criterias) seperti dalam fungsi create

        $activity->load('prices');

        return response()->json(['data' => $activity], 200);
    }

    private function getCategory(Category $category)
    {
        return Activity::orderBy('activities.created_at')
            ->where('category_id', $category->id)->leftJoin('participations', 'participations.activity_id', '=', 'activities.id')->groupBy('activities.id')->get(['activities.id', 'judul_activity', 'judul_slug', 'foto_activity', 'batas_waktu', 'activities.created_at', DB::raw('COUNT(participations.id) as total_volunteer')]);
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

        $activities = Activity::where('activities.user_id', $user->id)->leftJoin('participations', 'participations.activity_id', '=', 'activities.id')
            ->groupBy('activities.id')->orderBy('activities.created_at', 'DESC')
            ->get([
                'activities.id', 'judul_activity', 'judul_slug',
                'foto_activity', 'batas_waktu',
                'activities.created_at',
                DB::raw('COUNT(participations.id) as total_volunteer'),
            ]);

        return response()->json(['data' => $activities], 200);
    }
}