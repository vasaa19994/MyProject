<?php

namespace Maincast\App\tests;

use Maincast\App\classes\formHandler;
use PHPUnit\Framework\TestCase;

class AdTest extends TestCase
{
    public function testNullValues(){
        $ad = new formHandler(null, null,null,null,null,null,null,null,null,null);
        $this->assertNotNull($ad->getTitle());
        $this->assertNotNull($ad->getCategory());
        $this->assertNotNull($ad->getStage());
        $this->assertNotNull($ad->getPool());
        $this->assertNotNull($ad->getLive()); //is null (zero - 0) - boolean
        $this->assertNotNull($ad->getBeginning());
        $this->assertNotNull($ad->getEnding());
        $this->assertNotNull($ad->getDecription());
        $this->assertNotNull($ad->getUrl());
        $this->assertNotNull($ad->getId());
    }
}