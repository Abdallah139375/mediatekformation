<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author hocin
 */
class PlaylistRepositoryTest extends KernelTestCase {
    //recuperer le repository
    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;

    }
    public function newplaylist (): Playlist{
        $playlist = (new Playlist ())
                ->setName("playliststest");

        return $playlist;
    }
    
    //Récupérer le nombre d'enregistrements dans la table playlists
    public function testNbPlaylists(){
        $repository = $this->recupRepository();
        $nbPlaylists = $repository->count([]);
        $this->assertEquals(27, $nbPlaylists);
    }

    // Tester la methode add

     public function testadd(){
        $repository = $this->recupRepository();
        $playlists =$this->newplaylist();
        $nbplaylists = $repository->count([]);
        $repository ->add($playlists, true);
        $this->assertEquals($nbplaylists +1 , $repository->count([]), "erreur lors de l'ajout ");
    }
   }