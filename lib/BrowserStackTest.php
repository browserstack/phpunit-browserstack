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

        self::$driver = RemoteWebDriver::create($url, $caps);
    }

    public static function tearDownAfterClass(): void {
        self::$driver->quit();
    }
}
?>
