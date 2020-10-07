<?php namespace Hmones\Website\Models;

use Model;

/**
 * Model
 */
class Slider extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_website_slider';

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['title', 'subtitle', 'btn_txt'];

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
