<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Repository\ServicesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Services;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier-affiche-{id<\d+>}", name="panier.affiche")
     */
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
        //$produits = $repository->findArrayById( arrays_keys($panier) );
        $commande = new Commande();
        $client = $this->getUser();
        $commande->setClient($client);
        $commande->setDate(new \DateTime());
        foreach ( $panier as $key => $value)
        {
            $detail = new Detail();
            $service = $repository->findOneBy( ['id' => $key] );
            $idService =$service->getId();
            $detail->setCommande($commande);
            $detail->setService($idService);
            $detail->setQte($value);
            $details[] = $detail;
        }
        $session->set('panier', $panier);
        /*dump($panier);*/
        return $this->render('panier/affiche.html.twig', [
            'details' => $details,
        ]);
    }
    /**
     * @Route("/panier/produit/{id<\d+>}/delete", name="panier.produit.delete")
     */

    public function delete(Services $services, ObjectManager $manager )
    {
        //dump("suppression");
        $manager->remove($services);
        $manager->flush();
        $this->addFlash('success',"bien supprimé !");
        //return new Response("Suppression");
        return $this->redirectToRoute('panier.index');

    }
    /**
     * @Route("/panier", name="panier.index")
     */
    public function vue(){

        return $this->render("panier/index.html.twig");

    }
    /**
     * @Route("/panier/addIndex2/{id}", name="panier.addIndex2")
     */

    public function ajouter1($id, Request $request,ObjectManager $manager,ServicesRepository $repository)
    {
        $quantityTotal = 0;
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier', array());
        $panier = $session->get('panier');

        if (!isset($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id] += 1;
        }
        //$produits = $repository->findArrayById(array_keys($session->get('panier')));
        $client = $this->getUser();
        $commande = new Commande();
        $commande->setClient($client);
        $commande->setDate(new \DateTime());
        $details = [];
        foreach ($panier as $key => $value) {
            $detail = new Detail();
            $service = $repository->findOneById($key);
            dump($service);
            $detail->setCommande($commande);
            $detail->setProduit($service);
            $detail->setQte($value);
            $details[] = $detail;
        }
        $session->set('panier', $panier);
        dump($panier);
        $session->getFlashBag()->add('success', 'Article ajouté avec succès');
        dump($details);
        return $this->render('panier/panier1.html.twig', [
            'detail' => $details,
        ]);

    }
    /**
     * @Route("/panier/modif/{id}/Quantite/{quantite}", name="panier.modifQuantite")
     */
/*
    public function modifQuantite($id,$quantite, Request $request,ObjectManager $manager,ServicestRepository $repository)
    {
        $quantityTotal = 0;
        $session = $request->getSession();


        $panier = $session->get('panier');

        $panier[$id] = $quantite;



        //$produits = $repository->findArrayById(array_keys($session->get('panier')));
        $client = $this->getUser();
        $commande = new Commande();
        $commande->setClient($client);
        $commande->setDate(new \DateTime());
        $details = [];
        foreach ($panier as $key => $value) {
            $detail = new Detail();
            $service = $repository->findOneById($key);
            dump($service);
            $detail->setCommande($commande);
            $detail->setService($service);
            $detail->setQte($value);
            $details[] = $detail;
        }
        $session->set('panier', $panier);
        dump($panier);
        $session->getFlashBag()->add('success', 'Article ajouté avec succès');
        dump($details);
        return $this->render('panier/panier1.html.twig', [
            'details' => $details,
        ]);

    }*/


}

