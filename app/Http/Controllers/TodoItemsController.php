<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;

class TodoItemsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = TodoItem::query();

        if(!empty($keyword)) {
            $todo_items = TodoItem::whereHas('User',function($q) use ($keyword){
                $q->where('name', 'LIKE', "%{$keyword}%");
            })->orwhere('item_name', 'LIKE', "%{$keyword}%")
            ->orderBy('expire_date','asc')->get();
        } else {
            $todo_items = TodoItem::orderBy('expire_date','asc')->get();
            $keyword = " ";
        }

        $user = auth()->user();
 
        return view('todo_items.index',compact('todo_items','user','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $type = "store";
        $button = "登録";
        return view('todo_items.form',compact('users','type','button'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $todo_item = new TodoItem;
        $todo_item->insertTodo($request);
        return redirect()->route('todo_items.index')->with('message','作業登録が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function show(TodoItem $todo_item)
    {
        $users = User::all();
        $type = "delete";
        $button = "削除";
        return view('todo_items.form', compact('todo_item','users','type','button'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoItem $todo_item)
    {
        $users = User::all();
        $type = "update";
        $button = "更新";
        return view('todo_items.form',compact('users','todo_item','type','button'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, TodoItem $todo_item)
    {
        $todo_item->insertTodo($request);
        return redirect()->route('todo_items.index')->with('message','作業登録を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoItem $todo_item)
    {
        $todo_item->is_deleted = 1;
        $todo_item->save();
        return redirect()->route('todo_items.index')->with('message','作業登録を削除しました。');
    }

    public function is_completed(TodoItem $todo_item)
    {
        
        $todo_item->finished_date =  date("Y-m-d H:i:s"); 

        $todo_item->save();
        return redirect()->route('todo_items.index');
    }

    
    
}
