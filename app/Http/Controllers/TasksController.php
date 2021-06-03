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

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = json_decode(file_get_contents("php://input"), true);

        $input = array_filter($request, function ($key){
            return in_array($key, ['date', 'title']);
        }, ARRAY_FILTER_USE_KEY);

        $task = Task::create($input);
        return response()->json(['message' => 'Success', 'data' => $task], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['message' => 'Success', 'data' =>  Task::find($id)]);
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
        $request = json_decode(file_get_contents("php://input"), true);

        $input = array_filter($request, function ($key){
            return in_array($key, ['date', 'title', 'is_completed']);
        }, ARRAY_FILTER_USE_KEY);

        Task::find($id)->update($input);
        return response()->json(['message' => 'Success', 'data' => Task::find($id)], 200);
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
