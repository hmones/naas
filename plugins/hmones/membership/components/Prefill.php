<?php namespace Hmones\Membership\Components;

use Hmones\Membership\Models\Submission;
use Hmones\Membership\Models\Round;
use Hmones\Membership\Models\Question;
use Hmones\Membership\Models\Response;
use Carbon\Carbon;
use Auth;
use Redirect;
use Input;
use Lang;
use Flash;

class Prefill extends \Cms\Classes\ComponentBase
{
    public function componentDetails(){
        return [
            'name' => 'Prefill Application',
            'description' => 'Retrieves old applications and prefills the questions that can be prefilled'
        ];
    }

    public function onRun(){
        if(Auth::user()){
            $userLatestSubmission = Submission::where('user_id',Auth::user()->id)->where('round_id','!=',$this->param('id'))->orderBy('created_at', 'desc')->first();
            if($userLatestSubmission){
                $this->page['userLatestSubmission'] = $userLatestSubmission->toArray();
            }
        }
        
    }
    public function onPrefill(){

        // Retrieve responses from previous submission
        $submissionID = Input('submission_id');
        $oldSubmission = Submission::findOrFail($submissionID);
        $oldResponses = $oldSubmission->responses()->get();
        
        // Create a new submission for the user in this round and set it to draft
        $user = Auth::getUser();
        $round = Round::find($this->param('id'));

        $draftSubmission = Submission::where('round_id',$this->param('id'))->where('user_id',$user->id)->first();
        if($draftSubmission){
            $submission = $draftSubmission;
        }else{
            $submission = new Submission();
            $submission->status = 0;
            $submission->round = $round;
            $submission->user = $user;
            $submission->created_at = Carbon::now();
            $submission->updated_at = Carbon::now();
            $submission->lang = Lang::getLocale();
            $submission->save();
        }
        
        
        //Filter responses to those that can be prefilled and change the contents
        $questions = Question::where('published',1)->where('prefill',1)->get();
        $newResponses = collect();
        foreach ($questions as $question) {
            $record = $oldResponses->where('question_id',$question->id)->first();
            $response = array();
            if($record){
                $response = array(
                    "question_id" => $record->question_id,
                    "submission_id" => $submission->id,
                    "text" => $record->text,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                );
            }
            if(!empty($response)){
                $newResponses->push($response);
            }
        }
        $submission->responses()->delete();
        $submission->save();
    
        foreach ($newResponses->toArray() as $newResponse) {
            //Create records from previous responses
            Response::create($newResponse);
        }
        

        // Return to the dashboard
        Flash::success(Lang::get('hmones.membership::lang.messages.applicationPrefilled',[],$this->page['activeLocale']));
        return Redirect::refresh();
    }
}

?>