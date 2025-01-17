<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminPlaylistsController
 *
 * @author hocin
 */
class AdminPlaylistsController extends AbstractController {


    private $playlistRepository;

    function __construct(PlaylistRepository $playlistRepository,
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }

    #[Route('/admin/playlists', name: 'admin.playlists')]
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('name','DESC');
        return $this->render("admin/LesPlaylists.html.twig", [
            'playlists' => $playlists,
        ]);
    }

     #[Route('/admin/playlists/suppr/{id}', name: 'admin.playlists.suppr')]
    public function suppr(int $id): Response{
        $playlist = $this->playlistRepository->find($id);
        $this ->playlistRepository->remove($playlist,true);
        return $this->redirectToRoute('admin.playlists');
    }

     #[Route('/admin/playlists/edit/{id}', name: 'admin.playlists.edit')]
     public function edit (int $id,Request $request): Response{
         $playlist = $this->playlistRepository->find($id);
         $formPlaylist = $this->createForm(PlaylistType::class, $playlist);

         $formPlaylist->handleRequest($request);
         if($formPlaylist -> isSubmitted() && $formPlaylist ->isValid()){
             $this->playlistRepository->add($playlist,true);
             return $this->redirectToRoute('admin.playlists');
         }

         return $this->render("admin/Playlist.edit.html.twig", [
             'playlist' => $playlist,
             'formplaylist' => $formPlaylist ->createView()
             ]);
     }

    #[Route('/admin/playlists/sort/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response{
         $playlists = $this->playlistRepository->findAllOrderByName($champ, $ordre);
          return $this->render("admin/LesPlaylists.html.twig", [
            'playlists' => $playlists,
              ]);
    }

    #[Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        return $this->render("admin/LesPlaylists.html.twig", [
            'playlists' => $playlists,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }

     #[Route('/admin/playlists/ajout', name: 'admin.playlists.ajout')]
      public function ajout (Request $request): Response{
         $playlist = new Playlist();

         $formPlaylist = $this->createForm(PlaylistType::class,$playlist);

         $formPlaylist->handleRequest($request);
         if($formPlaylist -> isSubmitted() && $formPlaylist ->isValid()){
             $this->playlistRepository->add($playlist,true);
             return $this->redirectToRoute('admin.playlists');
         }
         return $this->render("admin/Playlists.ajout.html.twig", [
            'playlist' => $playlist,
            'formplaylist' => $formPlaylist->createview()
         ]);
     }
}
