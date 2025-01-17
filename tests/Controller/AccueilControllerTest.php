<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of AccueilControllerTest
 *
 * @author hocin
 */
class AccueilControllerTest extends WebTestCase{

     public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET', '/');//page d'accueil
        $this-> assertResponseIsSuccessful(Response::HTTP_OK);
     }


}
