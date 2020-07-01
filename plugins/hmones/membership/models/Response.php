<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 */
class Response extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    protected $jsonable = ['options_id'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_responses';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['text', 'text_other'];

    public $belongsTo = [
        'submission' => 'Hmones\Membership\Models\Submission',
        'theme' => 'Hmones\Membership\Models\Theme',
        'question' => 'Hmones\Membership\Models\Question',
        'option' => 'Hmones\Membership\Models\Option'
    ];

    public $attachMany = [
        'attachments' => 'System\Models\File'
    ];
}
