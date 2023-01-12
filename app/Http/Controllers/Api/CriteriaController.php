<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function show(Activity $activity)
    {
        $data = Criteria::join('activities', 'activity_id', '=', 'activities.id')
                ->where('activity_id', $id_activity)
                ->get(['criterias.id', 'activities.id', 'deskripsi']);

        return response()->json($data);
    }

    public function delete($id)
    {
        $criteria = Criteria::find($id);

        if (!$criteria)
            return response()->json(['message' => 'id tidak ditemukan']);

        $criteria->delete();

        return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id, 'error' => false]);
    }
}