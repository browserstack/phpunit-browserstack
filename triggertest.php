<?php
// Check if an argument is provided for config_file
$testFileArg = $argv[1] ?? 'Test.php';
$testFile = "tests" . DIRECTORY_SEPARATOR . $testFileArg;
$configFile = "config" . DIRECTORY_SEPARATOR . "test.conf.json";
putenv("TEST_FILE=$testFile");
putenv("CONFIG_FILE=$configFile");
// Execute the PHP script with the dynamically retrieved value
require 'lib/runner.php';

?>
