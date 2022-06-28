<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $id
 * @property string $option
 * @property int|null $question_id
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Option newModelQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Option newQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Option whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Option whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Option whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Option whereUpdatedAt($value)
 * @mixin \Eloquent
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
