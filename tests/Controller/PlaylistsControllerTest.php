<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author hocin
 */
class PlaylistsControllerTest extends WebTestCase{
    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET','/playlists');//page des playlists
        $this->assertResponseIsSuccessful(Response::HTTP_OK);
    }

    //Tester le tri
    public function testtriplaylist(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists');
        $this->assertSelectorTextContains('th', 'playlist');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5','Bases de la programmation (C#)');
    }

    public function testButton(){
    $client = static::createClient();
    $client->request('GET', '/playlists');
    // Vérification que le bouton "Voir detail" est présent
    $crawler = $client->getCrawler();
    $button = $crawler->filter('a.btn.btn-secondary:contains("Voir détail")');
    // Clic sur le bouton
    $client->click($button->link());
    // Récupération du résultat du clic
    $response = $client->getResponse();
    // Contrôle si le client existe
    $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    // Récupération de la route et contrôle qu'elle est correcte
    $uri = $client->getRequest()->server->get('REQUEST_URI');
    $this->assertEquals('/playlists/playlist/13', $uri);
}


    //tester la presence d'un element
    public function testcontenuplaylists(){
        $client = static::createClient();
        $client->request('GET','/playlists');
        $this->assertSelectorTextContains('th','playlist');
    }

    //Tester le filtre
    public function testfiltreplaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        // simulation de la soumission du formaulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Bases de la programmation (C#)'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la playlist correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');

    }


}
