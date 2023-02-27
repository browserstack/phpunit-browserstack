<?php
require_once('vendor/autoload.php');

class LocalTest extends BrowserStackTest {

    public function testLocal() {
        self::$driver->get("http://bs-local.com:45454");
        $this->assertStringContainsString('BrowserStack Local', self::$driver->getTitle());
    }

}
?>
