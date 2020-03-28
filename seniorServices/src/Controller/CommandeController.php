<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\This;
use App\Entity\Commande;
use App\Entity\Detail;
use App\Repository\CommandeRepository;
use App\Repository\DetailRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\ServicesRepository;

use App\Entity\Services;


class CommandeController extends AbstractController
{
    /**
     * @Route("/commande-validation", name="commande.validation")
     */
    public function index(Request $request,ServicesRepository $repository,ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $session = $request->getSession();
        $panier=$session->get('panier');

        $commande=new Commande();
        $commande->setDate(new \DateTime());
        $client=$this->getUser();
        $commande->setClient($client);
        $manager->persist($commande);

        foreach ($panier as $key=>$value){
            $detail =new Detail();
            $service = $repository->findOneBy(['id'=>$key]);
            $detail->setCommande($commande);
            $detail->setService($service);
            $detail->setqte($value);

            $manager->persist($detail);
            $manager->flush();

            $session->set('panier',array());
            return $this->render('commande/validation.html.twig')

                ;}
        return $this->render('panier/affiche.html.twig', [
            'controler_name'=>'commandeController',

        ]);

    }

    /**
     * @Route("/commande", name="commande")
     */

    public function commander(Request $request,ObjectManager $manager,ServicesRepository $repository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $session = $request->getSession();

        $panier = $session->get('panier');

        $client = $this->getUser();
        $commande = new Commande();
        $commande->setClient($client);
        $commande->setDate(new \DateTime());
        $details = [];
        foreach ($panier as $key => $value) {
            $detail = new Detail();
            $produit = $repository->findOneById($key);
            $detail->setCommande($commande);
            $detail->setProduit($produit);
            $detail->setQcom($value);
            //$manager->persist($commande);
            $manager->persist($detail);
            $manager->flush();
            $details[] = $detail;
        }
        //$session->remove('panier');
        dump($panier);
        $session->getFlashBag()->add('success', 'Article ajouté avec succès');
        return $this->render('commande/edit.html.twig', [
            'details' => $details,
        ]);

    }



    /**
     * @Route("/email", name="admin.email")
     */
   /* public function email(\Swift_Mailer $mailer)

    {
        $client= $this->getUser();
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('jeandesir73@gmail.com')
            ->setTo($client->getEmail)
            ->setBody(
                $this->renderView(
                // templates/email/registration.html.twig
                    'email/confirmCommande.html.twig',
                    ['client' => $client]
                ),
                'text/html'
            )*/
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'email/registration.txt.twig',
                    ['name' => $name]
                ),
                'text/plain'
            )
            */
       /* ;

        $mailer->send($message);

        return $this->render(...commandes/validation.html.twig);
    }*/


}
