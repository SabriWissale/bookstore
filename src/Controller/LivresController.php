<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Auteur;
use Doctrine\Persistence\ManagerRegistry;

class LivresController extends AbstractController
{
    #[Route('/', name: 'livres')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Livre::class);
        $livres = $repo->findAll();

        $repo = $doctrine->getRepository(Genre::class);
        $genres = $repo->findAll();

        $repo = $doctrine->getRepository(Auteur::class);
        $auteurs = $repo->findAll();
        
        return $this->render("index.html.twig", ['livres' => $livres, 'genres' => $genres, 'auteurs' => $auteurs]);
    }

    #[Route('/showLivre/{id}', name: 'showLivre')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        
        $repo = $doctrine->getRepository(Livre::class);
        $livre = $repo->find($id);

        if(!$livre)
        {
            return $this->redirectToRoute("livres");
        }
        
        return $this->render("showLivre.html.twig", ['livre' => $livre]);
    }

    #[Route('/filter', name: 'filter')]
    public function indexFiltered(ManagerRegistry $doctrine, Request $request): Response
    {
        
        //pour filter par plusieurs criteres a la fois, les fonctions de filtrage retournent un array, je dois
        //le recuperer et le donner en parametre a la fonction de filtrage suivante, celle ci va verifier si null,
        //proceder au test avec doctrine, si non null filtrer sur les valeurs de l'array

        $repo = $doctrine->getRepository(Genre::class);
        $genres = $repo->findAll();

        $repo = $doctrine->getRepository(Auteur::class);
        $auteurs = $repo->findAll();

        $repo = $doctrine->getRepository(Livre::class);
        $livres = $repo->findAll();
       

        if($request->request->get('genres') != null)
        {
            $genre_id = $request->request->get('genres');
            $livres = $repo->findAllByGenre($genre_id, $livres);
            
        }

        if($request->request->get('auteurs') != null)
        {
            $auteur_id = $request->request->get('auteurs');
            $livres = $repo->findAllByAuteur($auteur_id, $livres);
            
        }
        

        if($request->request->get('grade') != null)
        {
            $grade = $request->request->get('grade');
            $livres = $repo->findAllByNote($grade, $livres);
            
        }
        
        if($request->request->get('pub_date') != null)
        {
            $date_de_parution = new \DateTime($request->request->get('pub_date'));
            $livres = $repo->findAllByDatePub($date_de_parution, $livres);
            
        }
       

    
        return $this->render("index.html.twig", ['livres' => $livres, 'genres' => $genres, 'auteurs' => $auteurs]);
        

        //$livres = $repo->findBy(array('date_de_parution' => $pub_date),array('note' => 'ASC'),1 ,0);
        
        
    }


    #[Route('/filterDate', name: 'filterDate')]
    public function indexFilteredByDateRange(ManagerRegistry $doctrine, Request $request): Response
    {
        
        //pour filter par plusieurs criteres a la fois, les fonctions de filtrage retournent un array, je dois
        //le recuperer et le donner en parametre a la fonction de filtrage suivante, celle ci va verifier si null,
        //proceder au test avec doctrine, si non null filtrer sur les valeurs de l'array

        $repo = $doctrine->getRepository(Genre::class);
        $genres = $repo->findAll();

        $repo = $doctrine->getRepository(Auteur::class);
        $auteurs = $repo->findAll();

        $repo = $doctrine->getRepository(Livre::class);
        
       
        
        if($request->request->get('pub_date1') != null AND $request->request->get('pub_date2') != null)
        {
            $date_de_parution1 = new \DateTime($request->request->get('pub_date1'));
            $date_de_parution2 = new \DateTime($request->request->get('pub_date2'));
            $livres = $repo->findAllByDatePubRange($date_de_parution1, $date_de_parution2);
            
        }
        else
        {
            $livres = $repo->findAll();
        }
       

    
        return $this->render("index.html.twig", ['livres' => $livres, 'genres' => $genres, 'auteurs' => $auteurs]);
        

        //$livres = $repo->findBy(array('date_de_parution' => $pub_date),array('note' => 'ASC'),1 ,0);
        
        
    }
}
