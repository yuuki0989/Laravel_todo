<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;//追加
use Illuminate\Support\Facades\Validator;//追加

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('status', false)->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'task_name' => 'required|max:100',
        ];
 
        $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];
 
        Validator::make($request->all(), $rules, $messages)->validate();

        //モデルをインスタンス化
        $task = new Task;
 
        //モデル->カラム名 = 値 で、データを割り当てる
        $task->name = $request->input('task_name');
 
        //データベースに保存
        $task->save();
 
        //リダイレクト
        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    //「編集する」ボタンをおしたとき
    if ($request->status === null) {

            $rules = [
            'task_name' => 'required|max:100',
            ];
        
            $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];
        
            Validator::make($request->all(), $rules, $messages)->validate();
        
        
            //該当のタスクを検索
            $task = Task::find($id);
        
            //モデル->カラム名 = 値 で、データを割り当てる
            $task->name = $request->input('task_name');
        
            //データベースに保存
            $task->save();
        } else {
            //「完了」ボタンを押したとき
        
            //該当のタスクを検索
            $task = Task::find($id);
        
            //モデル->カラム名 = 値 で、データを割り当てる
            $task->status = true; //true:完了、false:未完了
        
            //データベースに保存
            $task->save();
        }
    
        //リダイレクト
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
  
        return redirect('/tasks');
    }
}
