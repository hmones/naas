<?php namespace Hmones\Website\Models;

use Model;

/**
 * Model
 */
class Statistic extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_website_statistics';

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
