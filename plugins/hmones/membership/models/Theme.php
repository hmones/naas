<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 */
class Theme extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_themes';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['theme'];

    public $hasMany = [
        'questions' => 'Hmones\Membership\Models\Question'
    ];
}
