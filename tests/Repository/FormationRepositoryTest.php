<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author hocin
 */
class FormationRepositoryTest extends KernelTestCase {

    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;

    }

    public function testNbFormations(){
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]);
        $this->assertEquals(237, $nbFormations);
    }

    public function newFormation(): Formation {
        $formation = (new Formation())
                ->setTitle("formationtest")
                ->setPublishedAt(new DateTime("now"));
        return $formation;
    }

     public function testadd(){
        $repository = $this->recupRepository();
        $formation =$this->newformation();
        $nbFormation = $repository->count([]);
        $repository ->add($formation, true);
        $this->assertEquals($nbFormation +1 , $repository->count([]), "erreur lors de l'ajout ");
    }

    public function testremove (){
        $repository= $this->recupRepository();
        $formation=$this->newformation();
        $repository->add($formation,true);
        $nbFormation = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormation -1, $repository->count([]), "erreur lors de la suppression");
    }

    public function testfindByContainValue(){
        $repository = $this->recupRepository();
        $formation=$this->newformation();
        $repository->add($formation,true);
        $formation = $repository->findByContainValue("title", "formationtest");
        $nbFormation =count($formation);
        $this->assertEquals(1,$nbFormation);
        $this->assertEquals("formationtest", $formation[0]->getTitle());
    }

}
