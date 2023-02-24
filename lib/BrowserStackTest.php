<?php
require_once('vendor/autoload.php');
require_once('lib/globals.php');

use Facebook\WebDriver\Remote\RemoteWebDriver;

class BrowserStackTest extends PHPUnit\Framework\TestCase {
    protected static $driver;
    protected static $bs_local;

    public static function setUpBeforeClass(): void {
        $CONFIG = $GLOBALS['CONFIG'];
        $task_id = getenv('TASK_ID') ? getenv('TASK_ID') : 0;

        $url = "https://{$GLOBALS['BROWSERSTACK_USERNAME']}:{$GLOBALS['BROWSERSTACK_ACCESS_KEY']}@hub.browserstack.com/wd/hub";
        $caps = $CONFIG['capabilities'][$task_id];

        if(array_key_exists("local", $caps["bstack:options"]) && $caps["bstack:options"])
        {
            $bs_local_args = array("key" => $GLOBALS['BROWSERSTACK_ACCESS_KEY']);
            self::$bs_local = new BrowserStack\Local();
            print("Starting Local Binary...\n");
            self::$bs_local->start($bs_local_args);
            if (self::$bs_local->isRunning()) {
                print("Local binary successfuly started!\n");
            }
        }

        self::$driver = RemoteWebDriver::create($url, $caps);
    }

    public static function tearDownAfterClass(): void {
        self::$driver->quit();
        if(self::$bs_local) {
            print("Stopping local binary..\n");
            self::$bs_local->stop();
        }
    }
}
?>
