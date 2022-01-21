<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;

class GenresController extends AbstractController
{
    #[Route('/genres', name: 'genres')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Genre::class);
        $genres = $repo->findAll();
        
        return $this->render("genre.html.twig", ['genres' => $genres]);
    }

}
