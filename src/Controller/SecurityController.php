<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //Méthode qui renvoie l'instance de l'utilisateur en cours
        //Méthode accessible depuis tous les controller
        if ($this->getUser()) {
            return $this->redirectToRoute('serie_list');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        //Le code ici ne sera jamais exécuté. Symfony utilise cette méthode lorsqu'il intercepte la déconnexion.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
