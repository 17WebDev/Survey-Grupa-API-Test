<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\User;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->is_admin) {
            return Response()->json(['message'=>'Permission Denied'],401);
        }
        return Response()->json(Answer::all());
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
        if (is_null(json_decode($request->answer_json))) {
            return Response()->json(['message'=>'Invalid JSON'],400);
        }
        $answer = new Answer;
        
        $answer->answer_json = trim(preg_replace('/\s+/', ' ', $request->answer_json));
        $answer->user_id = $request->user()->id;
        $answer->survey_id = $request->survey_id;
        $answer->status = $request->status;
        $answer->save();

        return Response()->json($answer);
    }

    public function getMyAnswers(Request $request,$id){
        if ($id == "all") {
            $answers  = $request->user()->answers;
            return Response()->json($answers);

        }
        $answer = Answer::where('user_id',$request->user()->id)->where('survey_id',$id)->first();

        return Response()->json($answer);
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
    public function edit($id)
    {
        //
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
        if (is_null(json_decode($request->answer_json))) {
            return Response()->json(['message'=>'Invalid JSON'],400);
        }
        $answer = Answer::find($id);

        if ($request->user()->id =! $answer->user_id) {
            return Response()->json(['message'=>'Permission Denied'],400);   
        }
        $answer->answer_json = trim(preg_replace('/\s+/', ' ', $request->answer_json));
        $answer->status = $request->status;

        $answer->save();

        return Response()->json($answer);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
