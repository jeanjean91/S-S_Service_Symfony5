<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Services;
use App\Form\ReservationType;
use App\Repository\UserRepository;
use App\Repository\ServicesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation-{id}-reserver", name="reservation.reserver")
     */
    public function  new($id, ServicesRepository $repository,Request $request, ObjectManager $manager/*,EntityManagerInterface $manager*/)
    {
        $service = $repository->findOneBy(['id' => $id]);

        $user = $this->getUser();
        /*dump($user);
        dump($service);*/
        $reservation = new Reservation();
        $services=$service->getId();

        $reservation->setUser($user);
        dump($services);
        $reservation->setService($services);
        $form = $this->createForm(ReservationType::class,  $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($reservation);
            $manager->flush();
            $this->addFlash('success', "demande bien envoyer");
            return $this->redirectToRoute("home");


            return $this->redirectToRoute('home', ['id' => $user->getUser()]);//, ['id' => $produit->getId()]);
        }
        return $this->render('reservation/reserver.html.twig', [

            'ReservationType' => $form->createView(),
        ]);
    }
}
