<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PrestatairController extends AbstractController
{
    /**
     * @Route("/prestatair-dashboard", name="prestatair.dashboard")
     */

    public function prestatairLogin(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('prestatair/dashboard.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/prestatair-userPresta", name="prestatair.userPresta")
     */
    public function index()
    {
        return $this->render('prestatair/userPresta.html.twig', [
            'controller_name' => 'prestatairController',
        ]);
    }


    /**
     * @Route("/prestatair-prestaNotifi", name="prestatair.prestaNotifi")
     */
    public function notification()
    {
        return $this->render('prestatair/prestaNotifi.html.twig', [
            'controller_name' => 'prestatairController',
        ]);
    }

}