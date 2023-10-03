<?php

require_once('vendor/autoload.php');
require_once('lib/globals.php');

$CONFIG = $GLOBALS['CONFIG'];
$procs = array();

$test_file = getenv('TEST_FILE');
if (!$test_file) {
    $test_file = 'tests/Test.php';
}

try {
    // the following code starts local binary, comment out if local testing not needed
    // Local binary started with additional args "logfile" => "logs.txt", "v" => true to get the local not started logs for debugging. Please remove them if not needed and cleanup logs if becoming huge.
    $bs_local_args = array("key" => $GLOBALS['BROWSERSTACK_ACCESS_KEY'], "logfile" => "logs.txt", "v" => true);
    $bs_local = new BrowserStack\Local();
    $currentOS = strtoupper(substr(PHP_OS, 0, 3));
    print("\nStarting Local Binary...\n");
    $bs_local->start($bs_local_args);
    if ($bs_local->isRunning()) {
        print("Local binary successfuly started!\n\n");
    }
    foreach ($CONFIG['capabilities'] as $key => $value) {
        $cmd = "TASK_ID=$key vendor/bin/phpunit $test_file 2>&1\n";
        if ($currentOS == 'WIN') {
            $cmd = "set TASK_ID=$key && vendor\bin\phpunit $test_file 2>&1\n";
        }
        print_r($cmd);
    
        $procs[$key] = popen($cmd, "r");
    }  
    foreach ($procs as $key => $value) {
        while (!feof($value)) { 
            print fgets($value, 4096);
        }
        pclose($value);
    }
} catch (Exception $e) {
    echo $e->getMessage();
    echo "Exception Trace:\n" . $e->getTraceAsString() . "\n";
} finally {
    if($bs_local) {
        print("\nStopping local binary..\n");
        $bs_local->stop();
    }
}

?>
