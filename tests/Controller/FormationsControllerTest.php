<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationControllerTest
 *
 * @author hocin
 */
class FormationsControllerTest extends WebTestCase{

    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET','/formations');//page des formationss
        $this->assertResponseIsSuccessful(Response::HTTP_OK);
    }

    //Tester le tri
    public function testtriformation(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5','Eclipse n°8 : Déploiement');
    }


    //Tester le filtre
    public function testfiltreformation(){
        $client = static::createClient();
        $client->request('GET', '/formations');
        // simulation de la soumission du formaulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Eclipse n°8 : Déploiement'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la formation correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Eclipse n°8 : Déploiement');

    }

    public function testLink(){
    $client = static::createClient();
    $client->request('GET', '/formations');
    // Vérification que l'image est présente
    $crawler = $client->getCrawler();
    $image = $crawler->filter('img[alt="formation"]');
    // Clic sur le lien parent contenant l'image
    $link = $image->closest('a')->link();
    $client->click($link);  // Clique sur ce lien
    // Récupération du résultat du clic
    $response = $client->getResponse();
    // Contrôle si le client existe
    $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    // Récupération de la route et contrôle qu'elle est correcte
    $uri = $client->getRequest()->server->get('REQUEST_URI');
    $this->assertEquals('/formations/formation/1', $uri);
    }



}
