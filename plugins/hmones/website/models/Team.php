<?php namespace Hmones\Website\Models;

use Model;

/**
 * Model
 */
class Team extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_website_teams';

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

<<<<<<< HEAD
    public $translatable = ['bio', 'name', 'img_credits', 'position'];
=======
    public $translatable = ['bio, name, img_credits, position'];
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

    public function getTeamCategoryAttribute(){
        switch($this->category){
            case 0:
                return "Core Team";
            case 1: 
                return "Steering Committee";
            case 2:
                return "Administrative Board";
            default:
                return "Unspecified";
        }
    }
}
