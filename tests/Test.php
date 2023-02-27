<?php
require_once('vendor/autoload.php');

use Facebook\WebDriver\WebDriverBy;

class Test extends BrowserStackTest {

    public function testBrowserstackDemo() {
        self::$driver->get("https://bstackdemo.com");
        // store item to add to cart
        $item_to_add = self::$driver->findElement(WebDriverBy::xpath("//*[@id='1']/p"))->getDomProperty('innerText');
        // click on add to cart button
        self::$driver->findElement(WebDriverBy::xpath("//*[@id='1']/div[4]"))->click();
        // get the item from cart
        $item_in_cart = self::$driver->findElement(WebDriverBy::xpath("//*[@id='__next']/div/div/div[2]/div[2]/div[2]/div/div[3]/p[1]"))->getDomProperty('innerText');
        // assert item in cart is same as one that was added
        $this->assertEquals($item_to_add, $item_in_cart);
    }

}
?>
