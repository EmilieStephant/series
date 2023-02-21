<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Attribut de la classe directement, qui permet de mutualiser le début de l'URL et du nom
#[Route('/serie', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(): Response
    {
        //TODO Récupérer la liste des séries en BDD

        return $this->render('serie/list.html.twig');
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])] //id doit être égal à un entier d'au moins un chiffre
    public function show(int $id): Response
    {
        dump($id);

        //TODO Récupérer des infos de la série identifiée par id

        return $this->render('serie/show.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        //TODO Créer un formulaire d'ajout de série

        return $this->render('serie/add.html.twig');
    }


}
