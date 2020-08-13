<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 */
class Response extends Model
{
    use \October\Rain\Database\Traits\Validation;

    //use \October\Rain\Database\Traits\Encryptable;

    protected $jsonable = ['text'];
    protected $fillable = ['created_at', 'updated_at', 'question_id', 'text', 'submission_id'];

    /** 
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_responses';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    //protected $encryptable = ['text'];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['text'];

    public $belongsTo = [
        'submission' => 'Hmones\Membership\Models\Submission',
        'question' => 'Hmones\Membership\Models\Question',
        'option' => 'Hmones\Membership\Models\Option'
    ];

}
