<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //Une URL = une fonction !
    #[Route('/home', name: 'main_home')] //Attributs depuis l'arrivée de PHP 8
    #[Route('/accueil', name: 'main_accueil')] //On peut avoir plusieurs URL qui renvoient à une même page
    public function home(): Response
    {
        $username = "<h1>Emilie</h1>";
        $serie = ['title' => 'Community', 'year' => 'Ouf', 'plateform' => 'NBC'];

        //La clé devient le nom de la variable côté Twig
        return $this->render('main/home.html.twig', [
            "name"=>$username,
            "serie"=>$serie
        ]);
    }

    //Ce qui suit est un commentaire interprété = annotation -> beaucoup utilisé avant PHP 8
    /**
     * @Route("/test", name="main_test")
     */
    public function test(): Response
    {
        return $this->render('main/test.html.twig');
    }
}
