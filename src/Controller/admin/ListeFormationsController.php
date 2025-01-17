<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ListeFormationsController
 *
 * @author hocin
 */
class ListeFormationsController extends AbstractController {
     /**
     *
     * @var FormationRepository
     */
    private $formationRepository;

    /**
     *
     * @var CategorieRepository
     */
    private $categorieRepository;


     function __construct(FormationRepository $formationRepository) {

        $this->formationRepository = $formationRepository;
    }


     #[Route('/admin', name: 'admin.formations')]
    public function index(): Response{

        $formations = $this->formationRepository->findAll();

         return $this->render("admin/lesFormations.html.twig", [
            'formations' => $formations,
        ]);
    }

    #[Route('/admin/suppr/{id}', name: 'admin.formations.suppr')]
    public function suppr(Formation $formation ,int $id): Response{
        $formation = $this->formationRepository->find($id);
        $this ->formationRepository->remove($formation,true);
        return $this->redirectToRoute('admin.formations');
    }

     #[Route('/admin/edit/{id}', name: 'admin.formations.edit')]
     public function edit (int $id,Request $request): Response{
         $formation = $this->formationRepository->find($id);
         $formformation = $this->createForm(FormationType::class,$formation);

         $formformation->handlerequest($request);
         if($formformation -> isSubmitted() && $formformation ->isValid()){
             $this->formationRepository->add($formation);
             return $this->redirectToRoute('admin.formations');
         }
         return $this->render("admin/formation.edit.html.twig", [
            'formation' => $formation,
            'formformation' => $formformation->createview()
         ]);
     }
     #[Route('/admin/ajout', name: 'admin.formations.ajout')]
      public function ajout (Request $request): Response{
         $formation = new Formation();

         $formformation = $this->createForm(FormationType::class,$formation);

         $formformation->handlerequest($request);
         if($formformation -> isSubmitted() && $formformation ->isValid()){
             $this->formationRepository->add($formation,true);
             return $this->redirectToRoute('admin.formations');
         }
         return $this->render("admin/formation.ajout.html.twig", [
            'formation' => $formation,
            'formformation' => $formformation->createview()
         ]);
     }

     #[Route('/amin/formations/recherche/{champ}/{table}', name: 'admin.formations.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        return $this->render("admin/lesFormations.html.twig", [
            'formations' => $formations,

        ]);
    }


}
