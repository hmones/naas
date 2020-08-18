<?php namespace Hmones\Membership\Models;

use Model;
use Lang;
use Auth;
use Config;
use Mail;
use Log;
use Rainlab\User\Models\User;

/**
 * Model
 */
class Submission extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_submissions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasMany = [
        'responses' => 'Hmones\Membership\Models\Response'
    ];

    public $belongsTo = [
        'round' => 'Hmones\Membership\Models\Round',
        'user' => 'Rainlab\User\Models\User'
    ];

    public function scopeYear($query,$year)
    {   $rounds = Round::where('year',$year)->lists('id');
        return $query->whereIn('round_id',$rounds);
    }

    public function beforeDelete()
    {
        Response::where('submission_id',$this->id)->delete();
    }

    public function afterCreate()
    {
        $this->sendEmail(
            $this->user_id, 
            $this->round_id,
            $this->status,
            $this->lang,
            'submission-created'
        );
    }
    public function afterUpdate()
    {
        if($this->status == 1 && $this->original['status'] == 0){
            $this->sendEmail(
                $this->user_id, 
                $this->round_id,
                $this->status,
                $this->lang,
                'submission-submitted'
            );
        }else{
            $this->sendEmail(
                $this->user_id, 
                $this->round_id,
                $this->status,
                $this->lang,
                'submission-status-changed'
            );
        }
        
    }

    public function sendEmail($userID, $roundID, $appStatus, $lang, $emailTemplate)
    {   
        $key = "hmones.membership::lang.ApplicationStatus.status_{$appStatus}";
        $status = Lang::get($key,[],$lang);
        $email = Email::where('name',$emailTemplate)->first();
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
            ];
            Mail::queue(['raw' => $email->lang($lang)->email_txt], $vars, function($message) use($vars) {
                $message->to($vars['email'], $vars['name']);
                $message->subject($vars['subject']);
            });
        }
    }

}
