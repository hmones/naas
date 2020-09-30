<?php namespace Hmones\Website\Models;

use Model;

/**
 * Model
 */
class Topic extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_website_topics';

<<<<<<< HEAD
    /**
     * date fields
     * @var [type]
     */
    protected $dates = ['published_at'];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['title', 'content', 'img_credits'];

    public function getTopicCategoryAttribute(){
        switch($this->category){
            case 0:
                return "News";
            case 1: 
                return "Programs";
            case 2:
                return "Research";
            default:
                return "Unspecified";
        }
    }
=======
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['title, content, img_credits'];
>>>>>>> 41abf6a1c72d6fb6f3007eab788a323cb06f8c1e

    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'image' => 'image|max:2000|dimensions:min_width=100,min_height=100'
    ];

}
