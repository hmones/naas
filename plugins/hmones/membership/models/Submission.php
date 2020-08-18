<?php namespace Hmones\Membership\Models;

use Model;

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

}
