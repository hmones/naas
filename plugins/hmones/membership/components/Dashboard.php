<?php namespace Hmones\Membership\Components;

use Hmones\Membership\Models\Round;
use Hmones\Membership\Models\Submission;
use Auth;
use Redirect;

class Dashboard extends \Cms\Classes\ComponentBase
{
    public function componentDetails(){
        return [
            'name' => 'Dashboard Functions',
            'description' => 'Retrieves info about a user dashboard'
        ];
    }

    public function onRun(){
        if (!Auth::user()) {
            return Redirect::to('login');
        }
        $this->page['active_round'] = Round::active()->published()->first();
        $this->page['other_rounds'] = Round::inactive()->published()->orderBy('year','asc')->get();
        $this->page['user_submissions'] = Submission::where('user_id',Auth::user()->id)->get();
        $this->page['user_active_submission'] = Submission::where('user_id',Auth::user()->id)->where('round_id',$this->page['active_round']->id)->first();
    }
}

?>