<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validation;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
/**
 * Description of FormationValidationTest
 *
 * @author hocin
 */
class FormationValidationsTest extends KernelTestCase{

    public function getFormation(){
        return (new Formation ())

                ->setTitle("formation");
    }

    //teste dur la date
    public function testdate(){
        $formation =$this->getFormation();
        $formation->setPublishedAt(new \DateTime("2025-01-08"));
        $this->assertErrors($formation,0);
    }

    public function assertErrors (Formation $formation, int $nberreur){
        self::bootKernel();
        $validator= self ::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nberreur, $error);
    }

}


