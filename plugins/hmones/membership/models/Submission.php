<?php namespace Hmones\Membership\Models;

use Model;
use Lang;
use Auth;
use Config;
use Mail;
use Log;
use Queue;
use Rainlab\User\Models\User;
use Hmones\Membership\Models\Response;

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
        Queue::push('Hmones\Membership\Classes\EmailEvents', [
            $this->id,
            $this->user_id, 
            $this->round_id,
            $this->status,
            $this->lang,
            'submission-created'
        ]);
    }
    public function afterUpdate()
    {
        if($this->status != $this->original['status'] && $this->status != 1){
            Queue::push('Hmones\Membership\Classes\EmailEvents', [
                $this->id,
                $this->user_id, 
                $this->round_id,
                $this->status,
                $this->lang,
                'submission-status-changed'
            ]);
        }
        
    }

}
