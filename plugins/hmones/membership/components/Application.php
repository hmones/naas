<?php namespace Hmones\Membership\Components;

use Hmones\Membership\Models\Submission;
use Hmones\Membership\Models\Theme;
use Hmones\Membership\Models\Round;
use Hmones\Membership\Models\Response;
use Hmones\Membership\Models\Question;
use Hmones\Membership\Classes\Utilities;
use Carbon\Carbon;
use Auth;
use Redirect;
use Input;
use ApplicationException;
use Lang;
use Flash;
use Storage;

class Application extends \Cms\Classes\ComponentBase
{
    public function componentDetails(){
        return [
            'name' => 'Application Functions',
            'description' => 'Retrieves info about an application and submits an application'
        ];
    }

    public function onRun(){
        $this->page['round'] = Round::find($this->param('id'));
        $this->page['submission'] = Submission::where('round_id',$this->param('id'))->where('user_id',Auth::user()->id)->first();
        if(!$this->page['round']){
            Flash::error('This application round does not exist!');
            return Redirect::to('account/dashboard');
        }
        if(!$this->page['round']->active || ($this->page['round']->start > Carbon::now()) || ($this->page['round']->end < Carbon::now())){
            Flash::error('The application round is not currently active');
            return Redirect::to('account/dashboard');
        }
        if($this->page['submission']->status != 0){
            Flash::error('We received your application for this round, it can not be modified');
            return Redirect::to('account/dashboard');
        }    
        $this->page['sections'] = Theme::with([
            'questions' => function ($query) {
                $query->orderBy('display_order', 'asc');
            }])->get();
        $this->page['repeat_groups'] = Question::select('group','repeat_text')->where('published','1')->whereNotNull('group')->distinct('group')->get()->toJson();
        if($this->page['submission']){
            $this->page['responses'] = $this->page['submission']->responses()->get()->groupBy('question_id');
            $this->page['group_responses'] = $this->page['submission']->responses()->select('text','question_id')->with('question:id,type,group')->where('text','regexp','\"group\"\:')->get()->toJson();
        }
    }
    public function onSubmit(){
        $submissionStatus = 0;
        if(Input::post('applicationStatus') == "final"){
            $submissionStatus = 1;
        }
        $files = Input::file();
        $inputs = Input::except(array_keys($files));
        //Remove Inputs that are used for verification
        unset($inputs['_session_key'],$inputs['_token'],$inputs['applicationStatus']);
        //Remove empty inputs that are submitted with the application
        foreach($inputs as $key => $record){
            if(Utilities::is_array_empty($record)){
                unset($inputs[$key]);
            }
        }
        $user = Auth::getUser();
        $round = Round::find($this->param('id'));

        // Check if a user has a submissions
        $submission = Submission::where('user_id',$user->id)->first();
        if($submission){
            // If yes: Delete all responses except files;
            $submission->status = $submissionStatus;
            $submission->updated_at = Carbon::now();
            $submission->lang = Lang::getLocale();
            $submission->responses()->where('text','regexp','^((?!\"file\"\:\"uploads).)*$')->delete();
            $submission->save();
        }else{
            // If no: create a new submission with a status draft & link to round
            $submission = new Submission();
            $submission->status = $submissionStatus;
            $submission->round = $round;
            $submission->user = $user;
            $submission->created_at = Carbon::now();
            $submission->updated_at = Carbon::now();
            $submission->lang = Lang::getLocale();
            $submission->save();
            $round->submissions()->add($submission);
            $round->save();
        }
        // Loop through all files received in input
        $submissionDirectory = "uploads/{$submission->id}"; 
        foreach($files as $key => $file){
            $question_id = intval(preg_replace("/q_/","",$key));
            Storage::deleteDirectory("{$submissionDirectory}/{$key}");
            $path = "{$submissionDirectory}/{$key}/{$file->getClientOriginalName()}";
            Storage::put($path, $file);
            $submission->responses()->where('question_id',$question_id)->delete();
            Response::create([
                "question_id" => $question_id,
                "submission_id" => $submission->id,
                "text" => ["file" => $path],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
        foreach($inputs as $key => $input){
            // If input is not empty create a record and add it to a general collection
            $record = Response::create([
                "question_id" => intval(preg_replace("/q_/","",$key)),
                "submission_id" => $submission->id,
                "text" => $input,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }

        //Condition to determine where the user should be redirected after filling the application
        if($submissionStatus == 1){
            // Return to the dashboard
            Flash::success('Application has been submitted successfully!');
            return Redirect::to('account/dashboard');
        }else{
            // Return to application page
            Flash::success('Application Saved Successfully!');
            return Redirect::refresh();
        }
        
    }
}

?>