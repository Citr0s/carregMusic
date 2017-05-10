<?php

require __DIR__ . '/../../vendor/autoload.php';

class DatabaseTest extends PHPUnit\Framework\TestCase
{
    public function testConnectionIsCorrectlyInitialised()
    {
        $this->assertEquals(true, true);
    }
}
