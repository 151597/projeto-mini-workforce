<?php  

namespace App\Http\Controllers;
use Artisan;

class ClearLogsController extends Controller {

    public function clear(){
        Artisan::command('logs:clear', function() {

            exec('rm ' . storage_path('logs/*.log'));
        
            $this->comment('Logs have been cleared!');
        
        })->describe('Clear log files');
    }

}

?>