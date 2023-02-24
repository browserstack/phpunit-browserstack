<?php
require_once('vendor/autoload.php');

use Facebook\WebDriver\WebDriverBy;

class SingleTest extends BrowserStackTest {

    public function testGoogle() {
        self::$driver->get("https://www.google.com/ncr");
        $element = self::$driver->findElement(WebDriverBy::name("q"));
        $element->sendKeys("BrowserStack");
        $element->submit();
        $this->assertEquals('BrowserStack - Google Search', self::$driver->getTitle());
    }
}
?>
