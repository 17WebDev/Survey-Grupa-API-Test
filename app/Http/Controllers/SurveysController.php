<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;

class SurveysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response()->json(Survey::all());
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
        if (!$request->user()->is_admin) {
            return Response()->json(['message'=>'Permission Denied'],401);
        }

        $survey = new Survey;
        $survey->name = $request->name;
        $survey->survey_json = trim(preg_replace('/\s+/', ' ', $request->survey_json));

        $survey->save();
        $pages = $survey->survey_json->pages;
        foreach($pages as $page){
            foreach ($page->questions as $question) {
                if ($question->type == "checkbox" || $question->type == "radiogroup") {
                    $q = new Question;
                    $q->name = $question->name;
                    $q->question_text = $question->title;
                    $q->survey_id = $survey->id;
                    $q->save();

                    foreach ($question->choices as $choice) {
                        $c = new Option;
                        $c->option_text = $choice;
                        $c->question_id = $q->id;
                        $c->count = 0;
                        $c->save();
                    }
                }
            }
        }
        foreach ($survey->questions as $question) {
            $question->options;
        }
        

        return Response()->json($survey);
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
        if (!$request->user()->is_admin) {
            return Response()->json(['message'=>'Permission Denied'],401);
        }

        if (is_null(json_decode(trim(preg_replace('/\s+/', ' ', $request->survey_json))))) {
            return Response()->json(['message'=>'Invalid JSON'],400);
        }

        $survey = Survey::find($id);
        $survey->name = $request->name;
        $survey->survey_json = $request->survey_json;

        foreach ($survey->questions as $question) {
            $question->survey()->dissociate();
        }
        $pages = $survey->survey_json->pages;
        foreach($pages as $page){
            foreach ($page->questions as $question) {
                if ($question->type == "checkbox" || $question->type == "radiogroup") {
                    $q = new Question;
                    $q->name = $question->name;
                    $q->question_text = $question->title;
                    $q->survey_id = $survey->id;
                    $q->save();

                    foreach ($question->choices as $choice) {
                        $c = new Option;
                        $c->option_text = $choice;
                        $c->question_id = $q->id;
                        $c->count = 0;
                        $c->save();
                    }
                }
            }
        }
        foreach ($survey->questions as $question) {
            $question->options;
        }
        $survey->status = $request->status;
        $survey->save();

        return Response()->json($survey);
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

    public function results(Request $request,$id){
        $survey = Survey::find($id);
        foreach ($survey->questions as $question) {
            $question->options;
        }

        return Response()->json($survey);
    }
}
