<?php namespace Hmones\Membership\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Input;
use Redirect;
use Storage;
use Hmones\Membership\Models\Submission as SubmissionModel;
use Hmones\Membership\Models\Question;
use Hmones\Membership\Classes\ExportExcel;


class Submission extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Hmones.Membership', 'membership', 'submissions');
    }

    public function onExport(){
        $checked = Input::post('checked'); 
        $filename = 'submissions.xls'; // The file name you want any resulting file to be called.
        $key = "uploads/public/{$filename}";
        if($checked){
            $submissions = SubmissionModel::whereIn('id',$checked)->with('responses')->get();
            #create an instance of the class
            $xls = new ExportExcel($filename);
            $header = ""; // Single first col text
            $xls->addHeader($header);
            $header = null; // Blank line
            $xls->addHeader($header);
            $header[] = "Theme";
            $header[] = "Header";
            $header[] = "Question";
            foreach ($submissions as $submission) {
                $header[] = $submission->user->name;
            }
            $xls->addHeader($header);
            //From here things go wrong
            $questions = Question::where('published',1)->orderBy('display_order', 'asc')->get();
            foreach ($questions as $question) {
                $row = array();
                $row[] = $question->theme->theme;
                $row[] = $question->header;
                $row[] = $question->question;
                foreach ($submissions as $submission) {
                    $record = $submission->responses()->where('question_id',$question->id)->get();
                    if($record->first()){
                        $row[] = $record->first()->answer;
                    }else{
                        $row[] = "No Answer Provided";
                    }
                }
                $xls->addRow($row);
            }
            
            # You can return the xls as a variable to use with;
                # $sheet = $xls->returnSheet();
                #$xls->sendFile()
                # OR
                #
                # You can send the sheet directly to the browser as a file 
                #
                Storage::delete($key);
                Storage::put($key, $xls->sendFile());
                return Redirect::to("storage/app/{$key}");
        }
    }
}
