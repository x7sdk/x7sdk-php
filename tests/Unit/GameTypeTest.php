<?php

namespace X7\Tests\Unit;

use PHPUnit\Framework\TestCase;
use X7\Constant\GameType;

class GameTypeTest extends TestCase
{
    public function testConstants()
    {
        $this->assertEquals('client', GameType::CLIENT);
        $this->assertEquals('h5', GameType::H5);
    }

    public function testAll()
    {
        $allTypes = GameType::all();
        $this->assertIsArray($allTypes);
        $this->assertContains(GameType::CLIENT, $allTypes);
        $this->assertContains(GameType::H5, $allTypes);
        $this->assertCount(2, $allTypes);
    }
}
