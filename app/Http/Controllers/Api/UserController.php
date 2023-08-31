<?php

namespace App\Http\Controllers\Api;

use App\Enums\LinkType;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\KodeReferal;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class UserController extends Controller
{
    protected function getValidationRules($linkType)
    {
        $commonRules = [
            'url' => ['string']
        ];

        if ($linkType === LinkType::WEBSITE->value) {
            return [
                'url' => array_merge($commonRules['url'], ['url', 'active_url'])
            ];
        } else {
            return [
                'username' => array_merge($commonRules['url'], ['alpha_dash'])
            ];
        }
    }

    public function pekerjaan(): JsonResponse
    {
        $data = DB::table('pekerjaans')->select('id', 'pekerjaan')->get();

        return response()->json($data);
    }

    public function organisasi(): JsonResponse
    {
        $data = DB::table('lembagas')->select('id', 'jenis_lembaga')->get();

        return response()->json($data);
    }

    public function provinsi(): JsonResponse
    {
        $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json')->json();

        return response()->json($response);
    }

    public function kabupaten(Request $request): JsonResponse
    {
        $provinceId = $request->input('provinceId');
        $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/regencies/' . $provinceId . '.json')->json();

        return response()->json($response);
    }

    public function kecamatan(Request $request): JsonResponse
    {
        $regencyId = $request->input('regencyId');
        $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/districts/' . $regencyId . '.json')->json();

        return response()->json($response);
    }

    public function editProfil(Request $request): JsonResponse
    {
        $user = User::find(Auth::user()->id);

        if ($request->has("socials")) {
            $request->validate([
                'socials.*.name' => ['required', 'string', new Enum(LinkType::class)],
                'socials.*.url' => ['string', 'url', 'active_url'],
                'socials.*.username' => ['string', 'alpha_dash']
            ]);

            foreach ($request->input('socials') as $socialLinkData) {
                $linkType = $socialLinkData['name'];

                $validationRules = $this->getValidationRules($linkType);

                $validatedData = Validator::make($socialLinkData, $validationRules)->validate();
                if ($linkType === LinkType::WEBSITE->value) {
                    $user->socials()->updateOrCreate([
                        'name' => $linkType,
                        'url' => $validatedData['url']
                    ]);
                } else {
                    $user->socials()->updateOrCreate([
                        'name' => $linkType,
                        'username' => $validatedData['username']
                    ]);
                }
            }
        }


        if ($request->has('email')) {
            $validator = Validator::make(request()->only('email'), [
                'email' => 'email|unique:users',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 403);
            }
        }

        if (strtolower($request->input('tipe')) == 'organisasi') {
            $user->jenis_organisasi = $request->input('jenis_organisasi') ? $request->input('jenis_organisasi') : $user->jenis_organisasi;
            $user->tanggal_berdiri = $request->input('tanggal_berdiri') ? $request->input('tanggal_berdiri') : $user->tanggal_berdiri;
        } else {
            $user->pekerjaan = $request->input('pekerjaan') ? $request->input('pekerjaan') : $user->pekerjaan;
            $user->tanggal_lahir = $request->input('tanggal_lahir') ? date('Y-m-d', strtotime($request->input('tanggal_lahir'))) : $user->tanggal_lahir;
            $user->jenis_kelamin = $request->input('jenis_kelamin') ? $request->input('jenis_kelamin') : $user->jenis_kelamin;
        }

        try {
            // required in twice type
            $user->name = $request->input('name') ? $request->input('name') : $user->name;
            $user->email = $request->input('email') ? $request->input('email') : $user->email;
            $user->username = $request->input('username') ? $request->input('username') : $user->username;
            $user->tipe = $request->input('tipe') ? $request->input('tipe') : $user->tipe;
            $user->no_telp = $request->input('no_telp') ? $request->input('no_telp') : $user->no_telp;
            $user->provinsi = $request->input('provinsi') ? $request->input('provinsi') : $user->provinsi;
            $user->kabupaten = $request->input('kabupaten') ? $request->input('kabupaten') : $user->kabupaten;
            $user->kecamatan = $request->input('kecamatan') ? $request->input('kecamatan') : $user->kecamatan;
            $user->alamat = $request->input('alamat') ? $request->input('alamat') : $user->alamat;
            $user->description = $request->input('description') ? $request->input('description') : $user->description;

            if ($request->file('photo') && $request->file('photo')->isValid()) {
                $photo = time() . '.' . $request->file('photo')->extension();
                $request->file('photo')->move(public_path('images/images_profile'), $photo);
                $user->photo = "/images/images_profile/$photo";
            }

            if ($request->file('banner') && $request->file('banner')->isValid()) {
                $banner = time() . '.' . $request->file('banner')->extension();
                $request->file('banner')->move(public_path('images/banner'), $banner);
                $user->banner = "/images/banner/$banner";
            }

            $user->update();

            return response()->json(['status' => true, 'msg' => 'Profile Updated!', 'data' => $user->load('socials')]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage(), 'data' => []], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $user = Auth::user();
        try {
            if ((Hash::check($request->old_password, Auth::user()->password)) == false) {
                return response()->json(['message' => 'Check your old password.'], 400);
            } elseif ((Hash::check($request->new_password, Auth::user()->password)) == true) {
                return response()->json(['message' => 'Please enter a password which is not similar then current password.'], 400);
            } else {
                User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);

                return response()->json(['message' => 'Password updated successfully.'], 200);
            }
        } catch (Exception $e) {
            if (isset($e->errorInfo[2])) {
                $msg = $e->errorInfo[2];
            } else {
                $msg = $e->getMessage();
            }

            return response()->json(['message' => $msg], 400);
        }
    }

    public function kodeReferal()
    {
        $user = Auth::user();

        $kode = KodeReferal::where('id_user', $user->id)->first();

        return response()->json(['data' => ['kode_referal' => $kode ? $kode->kode_referal : null]]);
    }

    public function show(User $user)
    {
        $user->load("socials");

        $activities = Activity::where('activities.user_id', $user->id)->leftJoin('participations', 'participations.activity_id', '=', 'activities.id')
            ->groupBy('activities.id')->orderBy('activities.created_at', 'DESC')
            ->get([
                'activities.id', 'judul_activity', 'judul_slug',
                'judul_activity', 'judul_slug', 'foto_activity',
                'batas_waktu', 'activities.created_at', 'tipe_activity',
                'activities.created_at',
                DB::raw('COUNT(participations.id) as total_volunteer'),
            ]);

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user,
                'activities' => $activities,
            ],
        ]);
    }
}
