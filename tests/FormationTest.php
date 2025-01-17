<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Formation;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author hocin
 */
class FormationTest extends TestCase {
    public function testgetPublishedAt(){
        $formation = new Formation();
        $formation->setPublishedAt(new \DateTime("2025-01-10"));
        $this->assertEquals("10-01-2025", $formation->getPublishedAt()->format('d-m-Y'));
    }
}
