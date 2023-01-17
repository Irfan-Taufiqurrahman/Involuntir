<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CriteriaController extends Controller
{
    public function create(Request $request, Activity $activity)
    {
        Validator::make($request->all(), [
            'deskripsi' => 'required|string'
        ]);
        $activity = Activity::find($activity->id);

        if(!$activity)
            return response()->json(['message' => 'id tidak ditemukan']);

        $criteria = Criteria::create([
            'activity_id' => $activity->id,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json($criteria);
    }

    public function show(Activity $activity)
    {
        $data = Criteria::join('activities', 'activity_id', '=', 'activities.id')
                ->where('activity_id', $activity->id)
                ->get(['criterias.id', 'activity_id', 'deskripsi']);

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'deskripsi' => 'required|string'
        ]);
        $criteria = Criteria::find($id);

        if (!$criteria)
            return response()->json(['message' => 'id tidak ditemukan']);

        $criteria->deskripsi = $request->deskripsi;
        $criteria->save();

        return response()->json(['data' => $criteria]);
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