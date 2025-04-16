<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class AppTest extends TestCase
{
    #[TestDox("Empty test")]
    public function test1()
    {
        $this->assertTrue(true);
    }
}
