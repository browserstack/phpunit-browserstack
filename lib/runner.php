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
    $bs_local_args = array("key" => $GLOBALS['BROWSERSTACK_ACCESS_KEY']);
    $bs_local = new BrowserStack\Local();
    print("\nStarting Local Binary...\n");
    $bs_local->start($bs_local_args);
    if ($bs_local->isRunning()) {
        print("Local binary successfuly started!\n\n");
    }
    foreach ($CONFIG['capabilities'] as $key => $value) {
        $cmd = "TASK_ID=$key vendor/bin/phpunit $test_file 2>&1\n";
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
} finally {
    if($bs_local) {
        print("\nStopping local binary..\n");
        $bs_local->stop();
    }
}

?>
