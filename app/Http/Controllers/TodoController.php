<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Todo;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $success_status = 200;

    public function index(Request $request)
    {   
        
        $param = $request->all();
       // dd($param);
     //  dd($request->token);
        $todolist = array();
     //   $user     = Auth::user();
       $todolist = Todo::where("user_id",$request->user_id)->get();
       // dd($user->id);

        if (count($todolist)> 0) {
            return response()->json(["todos" => $todolist, "status"=>$this->success_status, "message"=> "Todo list successfully retrieved"]);
        }
        else
        {
            return response()->json(["status"=>"Failed", "message"=>"Todo list not founnd!"]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'body' => 'required',
                
            ]
        );

        if($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $todo_array         =       array(
            "body"        =>      $request->body,
            "is_complete"       =>      0,
            "user_id"           =>      $user->id
        );

        $todo = Todo::create($todo_array);

        if(!is_null($todo)) {
            return response()->json(["status" => $this->success_status, "success" => true, "data" => $todo]);
        }

        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Error! Todo item not created."]);
        }

    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $user = Auth::user();
        $exist_todo = Todo::find($id);

        if ($exist_todo) {
            $exist_todo->body = $request->body;
            $exist_todo->save();
            return response()->json(["status" => $this->success_status, "success" => true, "body" => $exist_todo->body]);

        }

        return response()->json(["status" => "Item not found!"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $user = Auth::user();
        $exist_todo = Todo::find($id);

        if ($exist_todo) {
            $exist_todo->is_complete = $request->is_complete ? 0 : 1;
            $exist_todo->save();
            return response()->json(["status" => $this->success_status, "success" => true, "is_complete" => $exist_todo->is_complete]);

        }

        return response()->json(["status" => "Item not found!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $exist_todo = Todo::find($id);

        if ($exist_todo) {
            $exist_todo->delete();
            return response()->json(["status" => $this->success_status, "message" => "Todo item successfully deleted"]);
        }

        return response()->json(["status" => "Item not found!"]);
    }
}
