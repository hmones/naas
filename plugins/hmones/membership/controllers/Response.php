<?php namespace Hmones\Membership\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Response extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Hmones.Membership', 'membership', 'resposes');
    }
}
