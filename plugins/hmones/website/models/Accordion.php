<?php namespace Hmones\Website\Models;

use Model;

/**
 * Model
 */
class Accordion extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hmones_website_accordions';

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

<<<<<<< HEAD
    public $translatable = ['title', 'content'];
=======
    public $translatable = ['title, content'];
>>>>>>> 41abf6a1c72d6fb6f3007eab788a323cb06f8c1e

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
