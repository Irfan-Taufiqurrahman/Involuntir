<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function create(Request $request, Activity $activity)
    {
        Validator::make($request->all(), [
            'deskripsi' => 'required|string'
        ]);
        $activity = Activity::find($activity->id);

        if(!$activity)
            return response()->json(['message' => 'id tidak ditemukan']);

        $task = Task::create([
            'activity_id' => $activity->id,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json($task);
    }

    public function show(Activity $activity)
    {
        $data = Task::join('activities', 'activity_id', '=', 'activities.id')
                ->where('activity_id', $activity->id)
                ->get(['tasks.id', 'activity_id', 'deskripsi']);

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'deskripsi' => 'required|string'
        ]);
        $task = Task::find($id);

        if (!$task)
            return response()->json(['message' => 'id tidak ditemukan']);

        $task->deskripsi = $request->deskripsi;
        $task->save();
        
        return response()->json(['data' => $task]);
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
