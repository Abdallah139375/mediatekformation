<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ListeCategoriesController
 *
 * @author hocin
 */
class ListeCategoriesController extends AbstractController {


    private $categorirepository;

    function __construct(CategorieRepository $categorieRepository) {

        $this->categorierepository = $categorieRepository;
    }

    #[Route('/admin/categories', name: 'categories')]
    public function index(): Response{

        $categories = $this->categorierepository->findAll();

         return $this->render("LesCategories.html.twig", [
            'categories' => $categories,
        ]);
    }

     #[Route('/admin/categorie/suppr/{id}', name: 'categorie.suppr')]
     public function suppr(int $id):Response{
       $categorie = $this->categorierepository->find($id);
       $this ->categorierepository->remove ($categorie,true);
       return $this->redirectToRoute('categories');
   }

    #[Route('/admin/categorie/ajout', name: 'categorie.ajout')]
      public function ajout (Request $request): Response{
        $categorieNom = $request->get("nom");
        if (!$this->categorierepository->findOneBy(['name' => $categorieNom])){
        $categorie = new Categorie();
        $categorie->setName($categorieNom);
        $this->categorierepository->add($categorie);
        }
        return $this->redirectToRoute('categories');
      }

}
