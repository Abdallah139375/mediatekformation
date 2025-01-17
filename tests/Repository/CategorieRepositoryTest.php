<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\CategorieRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;

/**
 * Description of CategorieRepositoryTest
 *
 * @author hocin
 */
class CategorieRepositoryTest extends KernelTestCase {

   // recuperer le repository formationrepository
     public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;

    }
    //recuperer le repsitory playlistrepository
      public function recupRepositoryP(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;

    }


    //creer une  categorie pour le test
    public function newcategorie (): Categorie{
        $categorie = (new Categorie ())
                ->setName("categorietest");

        return $categorie;
    }

    //test creation dune nouvelle formations
     public function newFormation(): Formation {
        $formation = (new Formation())
                ->setTitle("formationtest")
                ->setPublishedAt(new DateTime("now"));
        return $formation;
    }
    //cretaion d'une nouvelle playlist
    public function newplaylist (): Playlist{
        $playlist = (new Playlist ())
                ->setName("playliststest");


        return $playlist;
    }

    //ajouter la formation dans playlist

     public function testaddformation(){
        $repository = $this->recupRepositoryP();
        $playlists =$this->newplaylist();
        $nbplaylists = $repository->count([]);
        $playlists->addFormation($this->newFormation());
        $this->assertEquals($nbplaylists , $repository->count([]), "erreur lors de l'ajout ");
    }


    //tester la methode add


    public function testadd(){
        $repository = $this->recupRepository();
        $categorie =$this->newcategorie();
        $nbcategorie = $repository->count([]);
        $repository ->add($categorie, true);
        $this->assertEquals($nbcategorie +1 , $repository->count([]), "erreur lors de l'ajout ");
    }

    //tester la methode remove

    public function testremove (){
        $repository= $this->recupRepository();
        $categorie=$this->newcategorie();
        $repository->add($categorie,true);
        $nbcategorie = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbcategorie -1, $repository->count([]), "erreur lors de la suppression");


    }
}
