<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ServicesRepository;

use phpDocumentor\Reflection\DocBlock\Description;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ServiceFormTypee;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

use App\Entity\Commande;
use App\Entity\Detail;

use App\Entity\Services;

class ClientController extends AbstractController
{
    public function add($id, Request $request, ServicesRepository $repository, ObjectManager $manager)
    {
        $session = $request->getSession();
        if(!$session->get('panier'))
        {
            $panier = $session->set('panier', array());
        }
        $panier = $session->get('panier');

        if(isset($panier[$id]))
        {
            $panier[$id] += 1;
        }
        else
        {
            $panier[$id] = 1;
        }
        //$service = $repository->findArrayById( arrays_keys($panier) );
        $commande = new Commande();
        $client = $this->getUser();
        $commande->setClient($client);
        $commande->setDate(new \DateTime());
        foreach ( $panier as $key => $value)
        {
            $detail = new Detail();
            $service = $repository->findOneBy( ['id' => $key] );
            $detail->setCommande($commande);
            $detail->setService($service);
            $detail->setQte($value);
            $details[] = $detail;
        }
        $session->set('panier', $panier);
        /*dump($panier);*/
        return $this->render('panier/reservation.html.twig', [
            'details' => $details,
        ]);
    }
}
