<?php namespace Hmones\Membership\Models;

use Model;
use DB;

/**
 * Model
 *
 * @property string|null $add_css
 * @property string|null $add_script
 * @property int|null $cond_option_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $description
 * @property int $display_order
 * @property int $file_multiple
 * @property string $file_type
 * @property int|null $group
 * @property string|null $header
 * @property int $id
 * @property int $new_member
 * @property int $old_member
 * @property int $other_active
 * @property string|null $other_text
 * @property int $prefill
 * @property int $published
 * @property string $question
 * @property int $repeat_active
 * @property string|null $repeat_text
 * @property int $required
 * @property string|null $subheader
 * @property int|null $theme_id
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $validation
 * @property-read mixed $question_type
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Question newModelQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Question newQuery()
 * @method static \October\Rain\Database\Builder|\Hmones\Membership\Models\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereAddCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereAddScript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereCondOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereFileMultiple($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereNewMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereOldMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereOtherActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereOtherText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question wherePrefill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereRepeatActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereRepeatText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereSubheader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hmones\Membership\Models\Question whereValidation($value)
 * @mixin \Eloquent
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

    public $translatable = ['question', 'other_text', 'repeat_text', 'description', 'header', 'subheader'];

    public $hasMany = [
        'options' => 'Hmones\Membership\Models\Option'
    ];

    public $belongsTo = [
        'theme' => 'Hmones\Membership\Models\Theme'
    ];

    public function getQuestionTypeAttribute(){
        $display_type = "";
        switch ($this->type) {
            case 1:
                $display_type = "Text area";
                break;
            case 2:
                $display_type = "Checkbox";
                break;
            case 3:
                $display_type = "Radio";
                break;
            case 4:
                $display_type = "Dropdown";
                break;
            case 5:
                $display_type = "Attachment";
                break;
            case 6:
                $display_type = "City";
                break;
            case 7:
                $display_type = "Country";
                break;
            case 8:
                $display_type = "Phone";
                break;
            case 9:
                $display_type = "Language Percentage";
                break;
            default:
                $display_type = "Text";
                break;
        }
        return $display_type;
    }

    public function beforeCreate()
    {
        Question::where('display_order','>=',$this->display_order)->update(
            ['display_order' => DB::raw('display_order + 1')]
        );
    }
    public function beforeDelete()
    {
        Question::where('display_order','>=',$this->display_order)->update(
            ['display_order' => DB::raw('display_order - 1')]
        );
    }
    public function beforeUpdate()
    {   
        $oldOrder = intval($this->original['display_order']);
        $newOrder = intval($this->display_order);

        if($newOrder > $oldOrder){
            Question::whereBetween('display_order',[$oldOrder,$newOrder])->update(
                ['display_order' => DB::raw('display_order - 1')]
        );
        }
        if($newOrder < $oldOrder)
        {
            Question::whereBetween('display_order',[$newOrder,$oldOrder])->update(
                    ['display_order' => DB::raw('display_order + 1')]
            );
        }
    }
}
