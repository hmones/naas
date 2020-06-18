<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 */
class Question extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_questions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['question', 'other_text'];

    public $hasMany = [
        'options' => 'Hmones\Membership\Models\Option'
    ];

    public $belongsTo = [
        'theme' => 'Hmones\Membership\Models\Theme'
    ];
}
