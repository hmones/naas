<?php namespace Hmones\Membership\Models;

use Model;

/**
 * Model
 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $description
 * @property int $display_order
 * @property string|null $icon
 * @property int $id
 * @property string $theme
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Theme newModelQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Theme newQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Theme query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Theme whereUpdatedAt($value)
 * @mixin \Eloquent
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
