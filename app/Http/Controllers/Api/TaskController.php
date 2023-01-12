<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(Activity $activity)
    {
        $data = Task::join('activities', 'activity_id', '=', 'activities.id')
                ->where('activity_id', $id_activity)
                ->get(['tasks.id', 'activities.id', 'deskripsi']);

        return response()->json($data);
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (!$task)
            return response()->json(['message' => 'id tidak ditemukan']);

        $task->delete();

        return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id, 'error' => false]);
    }
}
