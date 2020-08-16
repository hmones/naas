<?php namespace Hmones\Membership\Models;

use Model;
use Carbon\Carbon;
use Hmones\Membership\Models\Submission;

/**
 * Model
 */
class Round extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_rounds';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['comment'];

    public $hasMany = [
        'submissions' => 'Hmones\Membership\Models\Submission'
    ];

    public function scopeActive($query){
        $today = Carbon::now();
        return $query->where('start','<=',$today)->where('end','>=',$today);
    }

    public function scopeInactive($query){
        $today = Carbon::now();
        return $query->where('start','>=',$today)->orWhere('end','<=',$today);
    }

    public function scopePublished($query){
        return $query->where('active',1);
    }

    public function getDraftAttribute(){
        return Submission::where('round_id', $this->id)->where('status','0')->count();
    }

    public function getSubmittedAttribute(){
        return Submission::where('round_id', $this->id)->where('status','1')->count();
    }

    public function getAcceptedAttribute(){
        return Submission::where('round_id', $this->id)->where('status','3')->count();
    }

    public function getRejectedAttribute(){
        return Submission::where('round_id', $this->id)->where('status','4')->count();
    }
}
