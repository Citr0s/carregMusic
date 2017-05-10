<?php

require __DIR__ . '/../../vendor/autoload.php';

class DatabaseTest extends PHPUnit\Framework\TestCase
{
    public function testConnectionIsCorrectlyInitialised()
    {
        $subject = new \CarregMusic\Database();

        $this->assertEquals($subject->connection, !isNull());
    }
}
