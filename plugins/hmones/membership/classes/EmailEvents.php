<?php namespace Hmones\Membership\Classes;

use Lang;
use Mail;
use Rainlab\User\Models\User;
use Config;
use Hmones\Membership\Models\Response;
use Hmones\Membership\Models\Email;


class EmailEvents
{
    public function fire($job, $data)
    {
        $submissionID = $data[0];
        $userID = $data[1];
        $roundID = $data[2];
        $appStatus = $data[3];
        $lang = $data[4];
        $emailTemplate = $data[5];
        $key = "hmones.membership::lang.ApplicationStatus.status_{$appStatus}";
        $status = Lang::get($key,[],$lang);
        $email = Email::where('name',$emailTemplate)->first();
        if($lang == 'en'){
            $responses = Response::where('submission_id',$submissionID)->join('hmones_membership_questions','hmones_membership_questions.id','=','hmones_membership_responses.question_id')->selectRaw("hmones_membership_questions.display_order, hmones_membership_responses.*, hmones_membership_questions.question")->orderByRaw('hmones_membership_questions.display_order ASC')->get();
        }else{
            $responses = Response::where('submission_id',$submissionID)->join('hmones_membership_questions','hmones_membership_questions.id','=','hmones_membership_responses.question_id')->join("rainlab_translate_attributes", function ($join) use ($lang){
                $join->on('rainlab_translate_attributes.model_id', '=', 'hmones_membership_responses.question_id')->where('rainlab_translate_attributes.locale', '=', $lang)->where('rainlab_translate_attributes.model_type','=','Hmones\Membership\Models\Question');
            })->selectRaw("hmones_membership_questions.display_order, hmones_membership_responses.*, json_extract(rainlab_translate_attributes.attribute_data, '$.question') as question")->orderByRaw('hmones_membership_questions.display_order ASC')->get();
        }
        $user = User::find($userID);
        $baseURL = Config::get('app.url');
        $applicationLink = "{$baseURL}/{$lang}/account/application/round/{$roundID}";
        if($email && $user){
            $vars = [
                'name' => $user->name,
                'email' => $user->email,
                'subject' => $email->lang($lang)->subject,
                'ApplicationLink' => $applicationLink,
                'ApplicationStatus' => $status,
                'responses' => $responses,
                'lang' => $lang
            ];
            Mail::queue(['raw' => $email->lang($lang)->email_txt], $vars, function($message) use($vars) {
                $message->to($vars['email'], $vars['name']);
                $message->subject($vars['subject']);
            });
        }
    }
}

?>