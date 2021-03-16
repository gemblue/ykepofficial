<?php 

namespace App\cli;

use App\modules\payment\libraries\MootaLib;

class Moota {

    private $mootalib;

    public function __construct()
    {
        ci()->output->enable_profiler(false);
        $this->mootalib = new MootaLib;
    }

    /**
     * Get Moota Log
     * 
     * Get Moota Log manually, rest api to their endpoint. Get latest credit transactions.
     * 
     * @return bool
     */
    public function getLogs()
    {
        $result = $this->mootalib->getLatestMutation();
        $total = 0;

        if ($result['status'] == 'success') {
            foreach ($result['logs'] as $log) {
                $this->mootalib->save($log);
                $total++;
            }
        }

        echo "Successfully get $total records from Moota \n";
    }

    /**
     * Scan
     * 
     * Scan and approve payment.
     * 
     * @return bool
     */
    public function scan()
    {
        ci()->output->enable_profiler(false);

        $scan = $this->mootalib->scan();
        
        if ($scan > 0) {
            echo "Successfully approve $scan payments \n";
        } else {
            echo "There is no payment to approve \n";
        }
    }

}