<?php namespace Hmones\Membership\Components;

use Hmones\Membership\Models\Submission;
use Hmones\Membership\Models\Theme;
use Hmones\Membership\Models\Round;
use Hmones\Membership\Models\Response;
use Hmones\Membership\Models\Question;
use Hmones\Membership\Classes\Utilities;
use Illuminate\Support\Facades\URL;
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
            Flash::error(
                Lang::get('hmones.membership::lang.messages.roundNotExist',[],$this->page['activeLocale'])
            );
            return Redirect::to('account/dashboard');
        }
        if(!$this->page['round']->active || ($this->page['round']->start > Carbon::now()) || ($this->page['round']->end < Carbon::now())){
            Flash::error(
                Lang::get('hmones.membership::lang.messages.roundNotActive',[],$this->page['activeLocale'])
            );
            return Redirect::to('account/dashboard');
        }
        if($this->page['submission']){
            if($this->page['submission']->status != 0){
                Flash::error(
                    Lang::get('hmones.membership::lang.messages.applicationAlreadySubmitted',[],$this->page['activeLocale'])
                );
                return Redirect::to('account/dashboard');
            }
        }
        $isMember = Auth::user()->old_member;
        $selectColumn = 'old_member'; // Default selection
        if($isMember == 0){ // In case the member is a new member
            $selectColumn = 'new_member';
        }    
        $this->page['sections'] = Theme::with([
            'questions' => function ($query) use ($selectColumn){
                $query->where($selectColumn, 1)->where('published',1)->orderBy('display_order', 'asc');
            }])->orderBy('display_order', 'asc')->get();
        
        $this->page['repeat_groups'] = Question::select('group','repeat_text')->where('published','1')->whereNotNull('group')->distinct('group')->get()->toJson();
        if($this->page['submission']){
            $responses = $this->page['submission']->responses()->with('question:id,type,group')->get();
            $this->page['responses'] = $responses->groupBy('question_id');
            $this->page['group_responses'] = $this->page['submission']->responses()->select('text','group','question_id')->with('question:id,type,group')->where('group',1)->get()->toJson();
        }
    }
    public function onSubmit(){
        // Check if the user is signed in and the round exists in the database
        $user = Auth::getUser();
        $round = Round::find($this->param('id'));
        if(!$round || !$user){
            Flash::error(
                Lang::get('hmones.membership::lang.messages.roundNotActive',[],$this->page['activeLocale'])
            );
            return Redirect::to('account\dashboard');
        }

        $submissionStatus = 0;
        if(Input::post('applicationStatus') == "final"){
            $submissionStatus = 1;
        }
        $files = Input::file();
        $inputs = Input::except(array_keys($files));
        $prevLocation = $inputs['applicationLocation'];

        //Remove Inputs that are used for verification
        unset($inputs['_session_key'],$inputs['_token'],$inputs['applicationStatus'],$inputs['applicationLocation']);
        
        //Remove empty inputs that are submitted with the application
        foreach($inputs as $key => $record){
            if(Utilities::is_array_empty($record)){
                unset($inputs[$key]);
            }
        }
        
        // Check if a user has a submissions
        $submission = Submission::where('user_id',$user->id)->where('round_id',$round->id)->first();
        if($submission){
            // If yes: Delete all responses except files;
            $submission->status = $submissionStatus;
            $submission->updated_at = Carbon::now();
            $submission->lang = Lang::getLocale();
            $submission->responses()->where('file',0)->delete();
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
        $submissionDirectory = "uploads/public/{$submission->id}"; 
        foreach($files as $key => $file){
            $group = 0;
            if(is_array($file)){$group=1;}
            $question_id = intval(preg_replace("/q_/","",$key));
            Storage::deleteDirectory("{$submissionDirectory}/{$key}");
            $path = "{$submissionDirectory}/{$key}";
            $location = Storage::putFileAs($path, $file, $file->getClientOriginalName());
            $submission->responses()->where('question_id',$question_id)->delete();
            Response::create([
                "question_id" => $question_id,
                "submission_id" => $submission->id,
                "file" => 1,
                "text" => ["file" => $location],
                "group" => $group,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
        foreach($inputs as $key => $input){
            // If input is not empty create a record and add it to a general collection
            $group = 0;
            if(isset($input['group'])){$group=1;}
            Response::create([
                "question_id" => intval(preg_replace("/q_/","",$key)),
                "submission_id" => $submission->id,
                "text" => $input,
                "file" => 0,
                "group" => $group,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }

        //Condition to determine where the user should be redirected after filling the application
        if($submissionStatus == 1){
            // Return to the dashboard
            Flash::success(Lang::get('hmones.membership::lang.messages.applicationSubmitted',[],$this->page['activeLocale']));
            return Redirect::to('account/dashboard');
        }else{
            // Return to application page
            Flash::success(Lang::get('hmones.membership::lang.messages.applicationSaved',[],$this->page['activeLocale']));
            return Redirect::to(URL::previous() . "&t=1" . $prevLocation);
        }
        
    }
}

?>