<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Auteur;
use Doctrine\Persistence\ManagerRegistry;

class AuteursController extends AbstractController
{
    #[Route('/auteurs', name: 'auteurs')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Auteur::class);
        $auteurs = $repo->findAll();
        
        return $this->render("auteurs.html.twig", ['auteurs' => $auteurs]);
    }

    #[Route('/showAuteur/{id}', name: 'showAuteur')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        
        $repo = $doctrine->getRepository(Auteur::class);
        $auteur = $repo->find($id);

        if(!$auteur)
        {
            return $this->redirectToRoute("auteurs");
        }
        
        return $this->render("showAuteur.html.twig", ['auteur' => $auteur]);
    }
}