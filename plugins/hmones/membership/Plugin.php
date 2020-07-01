<?php namespace Hmones\Membership;

use System\Classes\PluginBase;
use RainLab\User\Models\User;
use RainLab\User\Controllers\Users as UsersController;
use Hmones\Membership\Models\Profile;

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
    {

        UsersController::extendFormFields(function($form, $model, $context){

            if (!$model instanceof User)
                return;
            
            $form->addTabFields([
                'old_member' => [
                    'label' => 'Is the member a former member?',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'switch'
                ],
                'role' => [
                    'label' => 'Type of membership',
                    'tab' => 'Profile',
                    'span' => 'auto',
                    'type'=> 'dropdown',
                    'required' => 1,
                    'showSearch' => true,
                    'options' => [
                        'new',
                        'core',
                        'affiliate'
                    ]
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
