<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function showOperator()
    {
        $user = Auth::user();
        $tasks = Orders::where('operator_id', $user->id)->get();

        $activeTask = Orders::where('status', 'Dikerjakan')
            ->where('operator_id', $user->id)
            ->first();

        $pendingTasks = Orders::where('status', 'Diproses')
            ->where('operator_id', $user->id)
            ->get();

        return view('operator.operator', compact('tasks', "activeTask", 'pendingTasks'));
    }

    public function start($id)
    {
        $task = Orders::findOrFail($id);

        $task->update([
            'status' => 'Dikerjakan'
        ]);

        return redirect()->back()->with('success', 'Tugas telah ditandai sebagai sedang dikerjakan.');
    }

    public function finish($id)
    {
        $task = Orders::findOrFail($id);


        $task->update([
            'status' => 'Selesai'
        ]);

        return redirect()->back()->with('success', 'Tugas telah diselesaikan.');
    }

    public function historyTask(){

        $user = Auth::user();
        $tasks = Orders::where('operator_id', $user->id)->get();

        return view('others.task-history',compact('tasks'));
    }
}
