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
 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $id
 * @property string $lang
 * @property int|null $round_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Submission newModelQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Submission newQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Submission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereRoundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Submission year($year)
 * @mixin \Eloquent
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
        if($this->status != $this->original['status']){
            if($this->status == 1){
                Queue::push('Hmones\Membership\Classes\EmailEvents', [
                    $this->id,
                    $this->user_id, 
                    $this->round_id,
                    $this->status,
                    $this->lang,
                    'submission-submitted'
                ]);
            }else{
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

}
