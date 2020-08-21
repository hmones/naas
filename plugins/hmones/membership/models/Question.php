<?php namespace Hmones\Membership\Models;

use Model;
use DB;

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

    public $translatable = ['question', 'other_text', 'repeat_text'];

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
