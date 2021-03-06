<?php namespace Hmones\Membership\Classes;

use Lang;
use Mail;
use Rainlab\User\Models\User;
use Config;
use Hmones\Membership\Models\Response;
use Hmones\Membership\Models\Email;
use Log;


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
        $responses = Response::select('id', 'submission_id', 'question_id', 'text')->with('question:id,question,type,display_order')->where('submission_id',$submissionID)->get()->sortBy(function($response, $key){
            return intval($response->question->display_order);
        })->values()->toArray();
        $user = User::find($userID);
        $baseURL = Config::get('app.url');
        $applicationLink = "{$baseURL}/account/application/round/{$roundID}";
        if($email && $user){
            $vars = [
                'name' => $user->name,
                'email' => $user->email,
                'subject' => $email->lang($lang)->subject,
                'ApplicationLink' => $applicationLink,
                'ApplicationStatus' => $status,
                'responses' => $responses
            ];
            Mail::queue(['raw' => $email->lang($lang)->email_txt], $vars, function($message) use($vars) {
                $message->to($vars['email'], $vars['name']);
                $message->subject($vars['subject']);
            });
        }
    }
}

?>