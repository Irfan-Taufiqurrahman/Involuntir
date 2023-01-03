<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdaYangBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdaYangBaruController extends Controller
{
    private function timestamp_to_date($timestamp) {
        $date = date('Y-m-d', strtotime($timestamp));
        $months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $splittedDate = explode('-', $date);
        return $splittedDate[2] . ' ' . $months[(int)$splittedDate[1]] . ' ' . $splittedDate[0];
    }
    public function index()
    {
        $data = AdaYangBaru::orderBy('tanggal', 'DESC')->get();

        foreach ($data as $item) {
            $item->tanggal = $this->timestamp_to_date($item->tanggal);
        }

        return response()->json($data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        };

        $adaYangBaru = AdaYangBaru::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json(['message' => 'Berhasil menambahkan data', 'data' => $adaYangBaru, 'error' => false]);
    }

    public function update(Request $request, $id)
    {
        $adaYangBaru = AdaYangBaru::find($id);

        if (!$adaYangBaru)
            return response()->json(['message' => 'id tidak ditemukan']);

        $validator = Validator::make($request->all(), [
            'judul' => 'string|max:255',
            'tanggal' => 'date',
            'deskripsi' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        };

        if ($request->has('judul'))
            $adaYangBaru->judul = $request->judul;
        if ($request->has('tanggal'))
            $adaYangBaru->tanggal = $request->tanggal;
        if ($request->has('deskripsi'))
            $adaYangBaru->deskripsi = $request->deskripsi;

        $adaYangBaru->save();

        return response()->json(['message' => 'Berhasil mengubah data', 'data' => $adaYangBaru, 'error' => false]);
    }

    public function delete($id)
    {
        $adaYangBaru = AdaYangBaru::find($id);

        if (!$adaYangBaru)
            return response()->json(['message' => 'id tidak ditemukan']);

        $adaYangBaru->delete();

        return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id, 'error' => false]);
    }
}
