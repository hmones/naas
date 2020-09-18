<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 */
class Option extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_options';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['option'];

    public $belongsTo = [
        'question' => 'Hmones\Membership\Models\Question'
    ];
}
