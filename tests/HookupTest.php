<?php
namespace TreeCrawler;

class HookupTest extends \PHPUnit_Framework_TestCase {
    public function testSystemWorks() {
        $this->assertTrue(true);
    }

    public function testLibraryIsCalledByComposer() {
        $this->assertEquals('Hello world', (string)new Hookup());
    }
}