<?php namespace Hmones\Membership\Models;

use Model;
use Carbon\Carbon;
use Hmones\Membership\Models\Submission;

/**
 * Model
 *
 * @property int $active
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $end
 * @property int $id
 * @property string $start
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $year
 * @property-read mixed $accepted
 * @property-read mixed $draft
 * @property-read mixed $rejected
 * @property-read mixed $submitted
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round inactive()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Round newModelQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Round newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round published()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Round query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Round whereYear($value)
 * @mixin \Eloquent
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
