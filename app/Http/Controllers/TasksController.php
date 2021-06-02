<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $isCompleted = $request->is_completed ? ($request->status == 1 ? true:false) : null;
        $date = $request->date;

        $query = Task::where('title', 'LIKE', '%'.$keyword.'%');

        if($isCompleted != null){
            $query = $query->where('is_completed', $isCompleted);
        }

        if($date){
            $query = $query->whereDate('date', $date);
        }

        return $query->select('id', 'title', 'date', 'is_completed')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Task::create($request->only(['date', 'title']));
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Task::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Task::find($id)->update($request->only(['date', 'title', 'is_completed']));
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(['message' => 'Success'], 200);
    }
}
