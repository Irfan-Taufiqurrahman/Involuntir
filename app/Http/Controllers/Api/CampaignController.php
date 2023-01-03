<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CampaignCreated;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;
use App\Models\KabarTerbaru;
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
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsRedirected;

class CampaignController extends Controller
{
    private $data = NULL;

    private function categoryFiltering($kategori)
    {
        $this->data = Campaign::where("kategori_campaign", ucwords(str_replace('_', ' & ', $kategori)));
    }

    private function orderByFiltering($order)
    {
        if ($order === "mendesak") {
            $this->data = $this->data ? $this->data->orderBy('campaigns.batas_waktu_campaigns', 'ASC') : Campaign::orderBy('campaigns.batas_waktu_campaign', 'ASC');
        } else if ($order === "populer") {
            $this->data = $this->data ? $this->data->orderBy(DB::raw('donations_count'), 'DESC') : Campaign::orderBy(DB::raw('donations_count'), 'DESC');
        } else if ($order === "terbaru") {
            $this->data = $this->data ? $this->data->orderBy('campaigns.created_at', 'DESC') : Campaign::orderBy('campaigns.created_at', 'DESC');
        }else {
            return new Error("order salah");
        }
    }

    private function byFiltering($filter)
    {
        $this->data = $this->data ? $this->data->join('users', 'users.id', "=", 'campaigns.user_id')->where('users.tipe', $filter) : Campaign::join('users', 'users.id', "=", 'campaigns.user_id')->where('users.tipe', $filter);
    }

    private function getAllCampaignsWithoutFiltering() {
        return Campaign::leftJoin("donations", "donations.campaign_id", "=", "campaigns.id")->groupBy("campaigns.id")->orderBy('campaigns.created_at', 'DESC')->where('status_publish', 'published')->orWhere('status_publish', NULL)->get(['campaigns.id', "judul_campaign", "campaigns.judul_slug", "foto_campaign", "nominal_campaign", "batas_waktu_campaign", "campaigns.created_at", DB::raw("SUM(IF(donations.status_donasi = 'Approved', donations.donasi, 0)) as total_donasi, sum(if(donations.status_donasi = 'Approved', 1, 0)) as donations_count")]);
    }

    private function getAllCampaignsWithoutFilteringWithLimit($limit) {
        return Campaign::leftJoin("donations", "donations.campaign_id", "=", "campaigns.id")->groupBy("campaigns.id")->limit($limit)->orderBy('campaigns.created_at', 'DESC')->where('status_publish', 'published')->orWhere('status_publish', NULL)->get(['campaigns.id', "judul_campaign", "campaigns.judul_slug", "foto_campaign", "nominal_campaign", "batas_waktu_campaign", "campaigns.created_at", DB::raw("SUM(IF(donations.status_donasi = 'Approved', donations.donasi, 0)) as total_donasi, sum(if(donations.status_donasi = 'Approved', 1, 0)) as donations_count")]);
    }

    public function index()
    {
        try {
            if (request()->urutan) {
                $this->orderByFiltering(request()->urutan);
            }

            if (request()->kategori) {
                $this->categoryFiltering(request()->kategori);
            }

            if (request()->filter) {
                $this->byFiltering(request()->filter);
            }

            if(request()->limit) {
                $this->data = $this->data ? $this->data->leftJoin("donations", "donations.campaign_id", "=", "campaigns.id")->groupBy("campaigns.id")->limit(request()->limit)->orderBy('campaigns.created_at', 'DESC')->where('status_publish', 'published')->orWhere('status_publish', NULL)->get(['campaigns.id', "judul_campaign", "campaigns.judul_slug", "foto_campaign", "nominal_campaign", "batas_waktu_campaign", "campaigns.created_at", DB::raw("SUM(IF(donations.status_donasi = 'Approved', donations.donasi, 0)) as total_donasi, sum(if(donations.status_donasi = 'Approved', 1, 0)) as donations_count")]) : $this->getAllCampaignsWithoutFilteringWithLimit(request()->limit);
            }else {
                $this->data = $this->data ? $this->data->leftJoin("donations", "donations.campaign_id", "=", "campaigns.id")->groupBy("campaigns.id")->orderBy('campaigns.created_at', 'DESC')->where('status_publish', 'published')->orWhere('status_publish', NULL)->get(['campaigns.id', "judul_campaign", "campaigns.judul_slug", "foto_campaign", "nominal_campaign", "batas_waktu_campaign", "campaigns.created_at", DB::raw("SUM(IF(donations.status_donasi = 'Approved', donations.donasi, 0)) as total_donasi, sum(if(donations.status_donasi = 'Approved', 1, 0)) as donations_count")]) : $this->getAllCampaignsWithoutFiltering();
            }

            return response()->json(["data" => $this->data ? $this->data : $this->getAllCampaignsWithoutFiltering()]);
        }catch(Error $err) {
            return response()->json(["message" => $err->getMessage()], 401);
        }
    }

    public function bySlug($campaign)
    {
        $data_campaign = DB::table('campaigns')
            ->where('judul_slug', $campaign)
            ->get();

        if($data_campaign->isEmpty()) {
            return response()->json(['message' => 'campaign tidak ditemukan'], 404);
        }

        $id_campaign = $data_campaign[0]->id;
        $id_fundraiser = $data_campaign[0]->user_id;

        $fundraiser = DB::table('users')
            ->where('id', $id_fundraiser)
            ->get(['users.id', 'photo', 'name', 'status_akun', 'role', 'tipe']);

        $curr_donation = DB::table('donations')
            ->selectRaw('SUM(donasi) current_donation')
            ->where('campaign_id', $id_campaign)
            ->where('status_donasi', 'Approved')
            ->get();

        $jumlah_donatur = DB::table('donations')
            ->selectRaw('COUNT(id) jumlah_donatur')
            ->where('campaign_id', $id_campaign)
            ->where('status_donasi', 'Approved')
            ->first();

        $doa_donatur = DB::table('donations')->join('users', 'user_id', '=', 'users.id')
            ->select('komentar', 'nama', 'photo', 'users.id')
            ->where('campaign_id', $id_campaign)
            ->where('status_donasi', 'Approved')
            ->where('komentar', '!=', NULL)
            ->get();

        $donatur = Donation::join('users', 'user_id', '=', 'users.id')->where('campaign_id', $id_campaign)
            ->where('status_donasi', 'Approved')
            ->get(['users.id', 'donasi', 'photo', 'nama', 'donations.created_at']);

        $kabar_terbaru = KabarTerbaru::join('users', 'user_id', '=', 'users.id')->where('campaign_id', $id_campaign)->get(['kabar_terbarus.id as id', 'judul', 'body', 'kabar_terbarus.created_at as tanggal_dibuat', 'user_id', 'name', 'photo', 'status_akun', 'role', 'tipe']);

        $user = auth('api')->user();

        return response()->json([
            'data' => [
                'campaign' => $data_campaign,
                'user' => $fundraiser,
                'current_donation' => $curr_donation,
                'jumlah_donatur' => $jumlah_donatur,
                'doa_donatur' => $doa_donatur,
                'kabar_terbaru' => $kabar_terbaru,
                'donatur' => $donatur,
                'is_mine' => $user ? ($user->id === $id_fundraiser) : false
            ]
        ]);
    }

    public function show(Campaign $campaign): JsonResponse
    {
        $id_campaign = $campaign->id;

        $curr_donation = DB::table('donations')
            ->selectRaw('SUM(donasi) current_donation')
            ->where('campaign_id', $id_campaign)
            ->where('status_donasi', 'Approved')
            ->get();

        $jumlah_donatur = DB::table('donations')
            ->selectRaw('COUNT(id) jumlah_donatur')
            ->where('campaign_id', $id_campaign)
            ->where('status_donasi', 'Approved')
            ->first();

        return response()->json([
            'data' => [
                'campaign' => $campaign,
                'user' => $campaign->user,
                'current_donation' => $curr_donation,
                'jumlah_donatur' => $jumlah_donatur
            ]
        ]);
    }

    private function imageValidation(Request $request, $imageName) {
        $validator = Validator::make($request->all(), [
            $imageName => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);
        return $validator;
    }

    private function uploadImage(Request $request, $file, $judul_slug) {
        $fileName     = $judul_slug . '.' . $request->file($file)->extension();
        $request->file($file)->move(public_path('images/images_campaign'), $fileName);
        return $fileName;
    }

    private function detailToHTML($cerita_tentang_pembuat_campaign, $cerita_tentang_penerima_manfaat, $cerita_tentang_masalah_dan_usaha,  $berapa_biaya_yang_dibutuhkan, $kenapa_galangdana_dibutuhkan, $foto_tentang_campaign, $foto_tentang_campaign_2, $foto_tentang_campaign_3)
    {
        $base_url = env('APP_URL');
        $pembuat_campaign = "<p>$cerita_tentang_pembuat_campaign<br><br>";
        $penerima_manfaat = "$cerita_tentang_penerima_manfaat<br><br>";
        $masalah_dan_usaha = "$cerita_tentang_masalah_dan_usaha<br><br>";
        $biaya_yang_dibutuhkan = "$berapa_biaya_yang_dibutuhkan<br><br>";
        $alasan = "$kenapa_galangdana_dibutuhkan<br><br></p>";
        $foto_tentang_campaign = $foto_tentang_campaign ? "<img width='100%' src='$base_url/images/images_campaign/$foto_tentang_campaign' ><br><br>" : "";
        $foto_tentang_campaign_2 = $foto_tentang_campaign_2 ? "<img width='100%' src='$base_url/images/images_campaign/$foto_tentang_campaign_2' ><br><br>" : "";
        $foto_tentang_campaign_3 = $foto_tentang_campaign_3 ? "<img width='100%' src='$base_url/images/images_campaign/$foto_tentang_campaign_3' ><br><br>" : "";

        return $pembuat_campaign . $penerima_manfaat . $foto_tentang_campaign . $masalah_dan_usaha . $foto_tentang_campaign_2 . $biaya_yang_dibutuhkan . $foto_tentang_campaign_3 . $alasan;
    }

    public function publish(Request $request) {
        $request->status_publish = 'published';
        return $this->create($request);
    }

    public function draft(Request $request) {
        $request->status_publish = 'drafted';
        $this->create($request);
    }

    public function create(Request $request) {
        $rules = [
            'status_publish' => 'required|in:published,drafted',
        ];
        if($request->status_publish === 'published') {
            // dicek dulu lah
            $rules = [
                'judul_campaign' => 'required|string|max:255',
                'category_id'   => 'required',
                'campaign_type' => 'required|in:event,compensation,operational,construction',
                'foto_campaign' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'kategori_penerima_manfaat' => 'required|in:sendiri,keluarga,orang_lain',
                'penerima'      => 'required|string|max:255',
                'tujuan'        => 'required|string|max:255',
                'lokasi'    => 'required|string|max:255',
                'alamat'   => 'required|string|max:255',
                'nominal_campaign' => 'required|numeric',
                'batas_waktu_campaign' => 'required|numeric', // per hari
                'rincian_penggunaan' => 'required|string',
                'cerita' => 'required|string',
                'ajakan' => 'required|string',
                'cerita_tentang_pembuat_campaign' => 'required|string',
                'cerita_tentang_penerima_manfaat' => 'required|string',
                'cerita_tentang_masalah_dan_usaha' => 'required|string',
                'berapa_biaya_yang_dibutuhkan' => 'required|string',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        // check category_id is exist
        $category = Category::find($request->category_id);
        if (!$category) {
            return response()->json(['message' => "category with id: $request->category not found!"]);
        }

        $judul_slug = $request->judul_slug ? $request->judul_slug : SlugService::createSlug(Campaign::class, 'judul_slug', request('judul_campaign'));


        $foto_campaign = NULL;
        $foto_campaign_2 = NULL;
        $foto_campaign_3 = NULL;
        $foto_campaign_4 = NULL;
        $foto_tentang_campaign = NULL;
        $foto_tentang_campaign_2 = NULL;
        $foto_tentang_campaign_3 = NULL;

        if($request->file('foto_campaign')) {
            $validator = $this->imageValidation($request,'foto_campaign');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_campaign = $this->uploadImage($request, 'foto_campaign', $judul_slug);
        }
        if($request->file('foto_campaign_2')) {
            $validator = $this->imageValidation($request, 'foto_campaign_2');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_campaign_2 = $this->uploadImage($request, 'foto_campaign_2', $judul_slug . "-2");
        }
        if($request->file('foto_campaign_3')) {
            $validator = $this->imageValidation($request, 'foto_campaign_3');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_campaign_3 = $this->uploadImage($request, 'foto_campaign_3', $judul_slug . "-3");
        }
        if($request->file('foto_campaign_4')) {
            $validator = $this->imageValidation($request, 'foto_campaign_4');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_campaign_4 = $this->uploadImage($request, 'foto_campaign_4', $judul_slug . "-4");
        }
        if($request->file('foto_tentang_campaign')) {
            $validator = $this->imageValidation($request, 'foto_tentang_campaign');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_tentang_campaign = $this->uploadImage($request, 'foto_tentang_campaign', "foto-tentang-campaign-" . $judul_slug);
        }
        if($request->file('foto_tentang_campaign_2')) {
            $validator = $this->imageValidation($request, 'foto_tentang_campaign_2');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_tentang_campaign_2 = $this->uploadImage($request, 'foto_tentang_campaign_2', "foto-tentang-campaign-" . $judul_slug . "-2");
        }
        if($request->file('foto_tentang_campaign_3')) {
            $validator = $this->imageValidation($request, 'foto_tentang_campaign_3');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $foto_tentang_campaign_3 = $this->uploadImage($request, 'foto_tentang_campaign_3', "foto-tentang-campaign-" . $judul_slug . "-3");
        }

        $user = auth('api')->user();

        if(!$user) {
            return response()->json(['message' => 'user not found!'], 404);
        }

        $detail_campaign = $this->detailToHTML(
            $request->cerita_tentang_pembuat_campaign,
            $request->cerita_tentang_penerima_manfaat,
            $request->cerita_tentang_masalah_dan_usaha,
            $request->berapa_biaya_yang_dibutuhkan,
            $request->kenapa_galangdana_dibutuhkan,
            $foto_tentang_campaign,
            $foto_tentang_campaign_2,
            $foto_tentang_campaign_3
        );

        $campaign = Campaign::create([
            'campaign_type' => $request->campaign_type,
            'kategori_penerima_manfaat' => $request->kategori_penerima_manfaat,
            'penerima' => $request->penerima,
            'tujuan' => $request->tujuan,
            'regencies' => $request->lokasi,
            'alamat_lengkap' => $request->alamat,
            'nominal_campaign' => $request->nominal_campaign,
            'batas_waktu_campaign' => Carbon::now()->addDays($request->batas_waktu_campaign),
            'rincian' => $request->rincian_penggunaan,
            'judul_campaign' => $request->judul_campaign,
            'judul_slug' => $judul_slug,
            'foto_campaign' => $foto_campaign,
            'foto_campaign_2' => $foto_campaign_2,
            'foto_campaign_3' => $foto_campaign_3,
            'foto_campaign_4' => $foto_campaign_4,
            'detail_campaign' => $detail_campaign,
            'ajakan' => $request->ajakan,
            'cerita_tentang_pembuat_campaign' => $request->cerita_tentang_pembuat_campaign,
            'cerita_tentang_penerima_manfaat' => $request->cerita_tentang_penerima_manfaat,
            'cerita_tentang_masalah_dan_usaha' => $request->cerita_tentang_masalah_dan_usaha,
            'berapa_biaya_yang_dibutuhkan' => $request->berapa_biaya_yang_dibutuhkan,
            'kenapa_galangdana_dibutuhkan' => $request->kenapa_galangdana_dibutuhkan,
            'foto_tentang_campaign' => $foto_tentang_campaign,
            'foto_tentang_campaign_2' => $foto_tentang_campaign_2,
            'foto_tentang_campaign_3' => $foto_tentang_campaign_3,
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'status_publish' => $request->status_publish,
            'updated_at' => $request->status_publish === 'published' ? Carbon::now() : null,
            'kategori_campaign' => $category->name // sementara pake ini
        ]);


//      send email after campaign created
        if($request->status_publish === 'published') {
            Mail::to($user->email)->send(new CampaignCreated($campaign));
            $campaign->update([
                'email_sent_at' => Carbon::now()
            ]);
        }

        $campaign->user = $user;

        return response()->json(['data' => $campaign], 201);
    }

    public function update(Request $request, $id) {
        $campaign = Campaign::findOrFail($id);
        $user = auth('api')->user();

        if($user->id !== intval($campaign->user_id)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $rules = [
            'status_publish' => 'required|in:published,drafted',
        ];
        if($request->status_publish === 'published') {
            // dicek dulu lah
            $rules = [
                'judul_campaign' => 'required|string|max:255',
                'category_id'   => 'required',
                'campaign_type' => 'required|in:event,compensation,operational,construction',
                'foto_campaign' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'kategori_penerima_manfaat' => 'required|in:sendiri,keluarga,orang_lain',
                'penerima'      => 'required|string|max:255',
                'tujuan'        => 'required|string|max:255',
                'lokasi'    => 'required|string|max:255',
                'alamat'   => 'required|string|max:255',
                'nominal_campaign' => 'required|numeric',
                'batas_waktu_campaign' => 'required|numeric', // per hari
                'rincian_penggunaan' => 'required|string',
                'cerita' => 'required|string',
                'ajakan' => 'required|string',
                'cerita_tentang_pembuat_campaign' => 'required|string',
                'cerita_tentang_penerima_manfaat' => 'required|string',
                'cerita_tentang_masalah_dan_usaha' => 'required|string',
                'berapa_biaya_yang_dibutuhkan' => 'required|string',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        // check category_id is exist
        $category = Category::find($request->category_id);
        if (!$category) {
            return response()->json(['message' => "category with id: $request->category not found!"]);
        }

        $judul_slug = $request->judul_slug ? $request->judul_slug : SlugService::createSlug(Campaign::class, 'judul_slug', request('judul_campaign'));


        $foto_campaign = $campaign->foto_campaign;
        $foto_campaign_2 = $campaign->foto_campaign_2;
        $foto_campaign_3 = $campaign->foto_campaign_3;
        $foto_campaign_4 = $campaign->foto_campaign_4;
        $foto_tentang_campaign = $campaign->foto_tentang_campaign;
        $foto_tentang_campaign_2 = $campaign->foto_tentang_campaign_2;
        $foto_tentang_campaign_3 = $campaign->foto_tentang_campaign_3;

        if($request->file('foto_campaign')) {
            $validator = $this->imageValidation($request,'foto_campaign');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_campaign/' . $campaign->foto_campaign));
            $foto_campaign = $this->uploadImage($request, 'foto_campaign', $judul_slug);
        }
        if($request->file('foto_campaign_2')) {
            $validator = $this->imageValidation($request, 'foto_campaign_2');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_campaign/' . $campaign->foto_campaign_2));
            $foto_campaign_2 = $this->uploadImage($request, 'foto_campaign_2', $judul_slug . "-2");
        }
        if($request->file('foto_campaign_3')) {
            $validator = $this->imageValidation($request, 'foto_campaign_3');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_campaign/' . $campaign->foto_campaign_3));
            $foto_campaign_3 = $this->uploadImage($request, 'foto_campaign_3', $judul_slug . "-3");
        }
        if($request->file('foto_campaign_4')) {
            $validator = $this->imageValidation($request, 'foto_campaign_4');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_campaign/' . $campaign->foto_campaign_4));
            $foto_campaign_4 = $this->uploadImage($request, 'foto_campaign_4', $judul_slug . "-4");
        }
        if($request->file('foto_tentang_campaign')) {
            $validator = $this->imageValidation($request, 'foto_tentang_campaign');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_campaign/' . $campaign->foto_tentang_campaign));
            $foto_tentang_campaign = $this->uploadImage($request, 'foto_tentang_campaign', "foto-tentang-campaign-" . $judul_slug);
        }
        if($request->file('foto_tentang_campaign_2')) {
            $validator = $this->imageValidation($request, 'foto_tentang_campaign_2');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_campaign/' . $campaign->foto_tentang_campaign_2));
            $foto_tentang_campaign_2 = $this->uploadImage($request, 'foto_tentang_campaign_2', "foto-tentang-campaign-" . $judul_slug . "-2");
        }
        if($request->file('foto_tentang_campaign_3')) {
            $validator = $this->imageValidation($request, 'foto_tentang_campaign_3');
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            File::delete(public_path('images/images_campaign/' . $campaign->foto_tentang_campaign_3));
            $foto_tentang_campaign_3 = $this->uploadImage($request, 'foto_tentang_campaign_3', "foto-tentang-campaign-" . $judul_slug . "-3");
        }

        $user = auth('api')->user();

        $detail_campaign = $this->detailToHTML(
            $request->cerita_tentang_pembuat_campaign,
            $request->cerita_tentang_penerima_manfaat,
            $request->cerita_tentang_masalah_dan_usaha,
            $request->berapa_biaya_yang_dibutuhkan,
            $request->kenapa_galangdana_dibutuhkan,
            $foto_tentang_campaign,
            $foto_tentang_campaign_2,
            $foto_tentang_campaign_3
        );

        $campaign->update([
            'campaign_type' => $request->campaign_type,
            'kategori_penerima_manfaat' => $request->kategori_penerima_manfaat,
            'penerima' => $request->penerima,
            'tujuan' => $request->tujuan,
            'regencies' => $request->lokasi,
            'alamat_lengkap' => $request->alamat,
            'nominal_campaign' => $request->nominal_campaign,
            'batas_waktu_campaign' => Carbon::now()->addDays($request->batas_waktu_campaign),
            'rincian' => $request->rincian_penggunaan,
            'judul_campaign' => $request->judul_campaign,
            'judul_slug' => $judul_slug,
            'foto_campaign' => $foto_campaign,
            'foto_campaign_2' => $foto_campaign_2,
            'foto_campaign_3' => $foto_campaign_3,
            'foto_campaign_4' => $foto_campaign_4,
            'detail_campaign' => $detail_campaign,
            'ajakan' => $request->ajakan,
            'cerita_tentang_pembuat_campaign' => $request->cerita_tentang_pembuat_campaign,
            'cerita_tentang_penerima_manfaat' => $request->cerita_tentang_penerima_manfaat,
            'cerita_tentang_masalah_dan_usaha' => $request->cerita_tentang_masalah_dan_usaha,
            'berapa_biaya_yang_dibutuhkan' => $request->berapa_biaya_yang_dibutuhkan,
            'kenapa_galangdana_dibutuhkan' => $request->kenapa_galangdana_dibutuhkan,
            'foto_tentang_campaign' => $foto_tentang_campaign,
            'foto_tentang_campaign_2' => $foto_tentang_campaign_2,
            'foto_tentang_campaign_3' => $foto_tentang_campaign_3,
            'category_id' => $request->category_id,
            'status_publish' => $request->status_publish,
            'updated_at' => $request->status_publish === 'published' ? Carbon::now() : NULL,
            'kategori_campaign' => $category->name // sementara pake ini
        ]);


//      send email after campaign created
        if($request->status_publish === 'published' && !$campaign->email_sent_at) {
            Mail::to($user->email)->send(new CampaignCreated($campaign));
            $campaign->update([
                'email_sent_at' => Carbon::now()
            ]);
        }

        $campaign->user = $user;

        return response()->json(['data' => $campaign], 201);
    }

    // @deprecated
    public function create_old(Request $request) {
        $validator = Validator::make($request->all(), [
            'kategori_campaign' => 'required|string',
            'judul_campaign' => 'required|string',
            'target_donasi' => 'required|numeric',
            'batas_waktu_campaign' => 'required|date',
            'lokasi' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'tujuan' => 'required|string',
            'penerima' => 'required|string',
            'rincian' => 'required|string',
            'judul_slug' => 'unique:campaigns',
            'detail_campaign' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        $judul_slug = $request->judul_slug ? $request->judul_slug : SlugService::createSlug(Campaign::class, 'judul_slug', request('judul_campaign'));

        $foto_campaign = null;
        if($request->foto_campaign) {
            $image_64 = $request->foto_campaign; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $foto_campaign = $judul_slug . '.' . $extension;

            Storage::disk('local')->put('images/images_campaign/'.$foto_campaign, base64_decode($image));
        }

        // if ($request->foto_campaign && $request->foto_campaign->isValid()) {
        //     $foto_campaign     = $judul_slug . '.' . $request->foto_campaign->extension();
        //     $request->foto_campaign->move(public_path('images/images_campaign'), $foto_campaign);
        // }

        $campaign = Campaign::create([
            'kategori_campaign' => $request->kategori_campaign,
            'judul_campaign' => $request->judul_campaign,
            'nominal_campaign' => $request->target_donasi,
            'batas_waktu_campaign' => date("Y-m-d", strtotime($request->batas_waktu_campaign)),
            'regencies' => $request->lokasi,
            'alamat_lengkap' => $request->alamat_lengkap,
            'tujuan' => $request->tujuan,
            'penerima' => $request->penerima,
            'detail_campaign' => $request->detail_campaign,
            "user_id" => Auth::user()->id,
            'foto_campaign' => $foto_campaign,
            'judul_slug' => $judul_slug,
            'detail_campaign' => $request->detail_campaign,
            'status' => 'Pending'
        ]);

        return response()->json(['message' => 'berhasil membuat campaign', 'data' => $campaign, 'error' => false]);
    }

    private function getCategory(string $category)
    {
        return Campaign::orderBy('campaigns.created_at')
            ->where('kategori_campaign', $category)->leftJoin("donations", "donations.campaign_id", "=", "campaigns.id")->groupBy("campaigns.id")->get(['campaigns.id', "judul_campaign", "campaigns.judul_slug", "foto_campaign", "nominal_campaign", "batas_waktu_campaign", DB::raw('sum(donasi) as total_donasi')]);
    }

    public function isExist($slug) {
        return response()->json(['isExist' => Campaign::where('juduL_slug', $slug)->first() ? true : false]);
    }

    public function destroy(Campaign $campaign) {
        // old image is not deleted because this is a soft delete
        $campaign->delete();
        return response()->json(['message' => 'berhasil menghapus campaign'], 200);
    }

    public function myCampaigns() {
        $user = Auth::user();

        $campaigns = Campaign::where('campaigns.user_id', $user->id)->leftJoin("donations", "donations.campaign_id", "=", "campaigns.id")
                    ->groupBy("campaigns.id")->orderBy('campaigns.created_at', 'DESC')
                    ->get(['campaigns.id', "judul_campaign", "campaigns.judul_slug",
                            "foto_campaign", "nominal_campaign", "batas_waktu_campaign",
                            "campaigns.created_at",
                            DB::raw("SUM(IF(donations.status_donasi = 'Approved', donations.donasi, 0)) as total_donasi, sum(if(donations.status_donasi = 'Approved', 1, 0)) as donations_count")]);;

        return response()->json(["data" => $campaigns], 200);
    }
}
