<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 */
class Email extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_membership_emails';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
