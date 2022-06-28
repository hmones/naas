<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $email_txt
 * @property int $id
 * @property string $name
 * @property string|null $subject
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Email newModelQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Email newQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Email query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Email whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Email whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Email whereEmailTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Email whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Email whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Email whereUpdatedAt($value)
 * @mixin \Eloquent
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

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['email_txt', 'subject'];
}
