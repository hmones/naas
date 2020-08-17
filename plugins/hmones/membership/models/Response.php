<?php namespace Hmones\Membership\Models;

use Model;
use Hmones\Membership\Classes\Constants;

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

    public function getDisplayThemeAttribute(){
        return Question::find($this->question_id)->theme->theme;
    }
    public function ResolveOption($jsonArray){
        $result = "";
        foreach($jsonArray['options'] as $option){
            $record = Option::find($option);
            if($record){
                $record = $record->option;           
            }else{
                if(array_key_exists("other",$jsonArray)){
                    if($result == ""){
                        $result = "other: {$jsonArray['other']}";
                    }else{
                        $result = "{$result} , other: {$jsonArray['other']}";
                    }
                    
                }
            }
            if($result == ""){
                $result = "{$record}";
            }else{
                $result = "{$result}, {$record}";
            }
            
        }
        return $result;
    }
    public function FormattedQuestion($jsonArray, $questionType){
        $result = "";
        switch ($questionType) {
            case 2:
                $result = $this->ResolveOption($jsonArray);
                break;
            case 3:
                $result = $this->ResolveOption($jsonArray);
                break;
            case 5:
                $result = "http://localhost:8000/storage/app/ {$jsonArray['file']}";
                break;
            case 7:
                $result = Constants::COUNTRIES_EN[$jsonArray['content']];
                break;
            case 8:
                if(isset($jsonArray['phone']['code']) && isset($jsonArray['phone']['number'])){
                    $result = "+( {$jsonArray['phone']['code']} ) - {$jsonArray['phone']['number']}";
                }
                break;
            case 9:
                if(isset($jsonArray['language']['name']) && isset($jsonArray['language']['percentage'])) {
                    $result = "{$jsonArray['language']['name']} : {$jsonArray['language']['percentage']}%";
                }
                break;
            default:
                $result = $jsonArray['content'];
                break;
        }
        return $result;
    }
    public function getAnswerAttribute(){
        $result = "";
        $questionType = Question::find($this->question_id);
        if ($questionType) {
            $questionType = $questionType->type;
            if (array_key_exists("group",$this->text)){
                foreach ($this->text['group'] as $answer) {
                    if($result == ""){
                        $result = $this->FormattedQuestion($answer,$questionType);
                    }else{
                        $result = "{$result} , {$this->FormattedQuestion($answer,$questionType)}";
                    }
                    
                }
            }else{
                $result = $this->FormattedQuestion($this->text, $questionType);
            }
        }
        return $result;
    }

    
    

}
