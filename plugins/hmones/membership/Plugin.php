<?php namespace Hmones\Membership;

use System\Classes\PluginBase;
use RainLab\User\Models\User;
use RainLab\User\Controllers\Users as UsersController;
use Hmones\Membership\Models\Profile;
use Event;

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    public function registerComponents()
    {
        return [
            'Hmones\Membership\Components\Countries' => 'Countries',
            'Hmones\Membership\Components\Application' => 'Application',
            'Hmones\Membership\Components\Dashboard' => 'Dashboard'
        ];
    }

    public function registerSettings()
    {
    }

    public function boot()
    {

        Event::listen('backend.list.overrideColumnValue', function ($listWidget, $record, $column, &$value) {
            if ($column->columnName == 'type'){
                switch ($value) {
                    case 0:
                        $value = 'Text';
                        break;
                    case 1:
                        $value = 'Text area';
                        break;
                    case 2:
                        $value = 'Checkbox';
                        break;
                    case 3:
                        $value = 'Radio';
                        break;
                    case 4:
                        $value = 'Dropdown';
                        break;
                    case 5:
                        $value = 'Attachment';
                        break;
                    case 6:
                        $value = 'City';
                        break;
                    case 7:
                        $value = 'Country';
                        break;
                    case 8:
                        $value = 'Phone';
                        break;
                    case 9:
                        $value = 'Language Percentage';
                        break;
                    default:
                        break;
                }
            }
            
        });

        UsersController::extendFormFields(function($form, $model, $context){

            if (!$model instanceof User)
                return;
            
            $form->addTabFields([
                'old_member' => [
                    'label' => 'Is the user a current member?',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'switch'
                ],

                'membership_type' => [
                    'label' => 'Membership type',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type' => 'dropdown',
                    'options' => [
                        0 => 'None',
                        1 => 'Core',
                        2 =>'Affiliate'
                    ],
                    'required' => 1
                ],
                
                'email_org' => [
                    'label' => 'Organizational Email',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'text',
                ],
                'website' => [
                    'label' => 'Website',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'text',
                ],
                'facebook' => [
                    'label' => 'Facebook',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'text',
                ],
                'twitter' => [
                    'label' => 'Twitter',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'text',
                ],
                'instagram' => [
                    'label' => 'Instagram',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'text',
                ],
                'youtube' => [
                    'label' => 'YouTube',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'text',
                ],
            ]);
        });
    }
}
