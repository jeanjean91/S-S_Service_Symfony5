<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Services;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\UserRepository;
use App\Repository\ServicesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation-{id}-reserver", name="reservation.reserver")
     */
    public function  new($id, ServicesRepository $repository ,Request $request, ObjectManager $manager,\Swift_Mailer $mailer)
    {
        $service = $repository->findOneBy(['id' => $id]);
        $idService =$service->getId();


        $user = $this ->getUser();
        $reservation = new Reservation();

        $reservation->setUser($user);
        $reservation->setService($idService);
      /* dump($service);*/
        $form = $this->createForm(ReservationType::class,  $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {




        if ($request->isMethod('POST')) {

            $email = $user->getEmail();

            if ($email === null) {
                $this->addFlash('danger', 'Connectez ous !');
                return $this->redirectToRoute('app_login');
            }


            try {
                $manager->persist($reservation);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('home');
            }

        }

            $message = (new \Swift_Message('Comfirmation reservation'))
                ->setFrom(array('jeandesir84@gmail.com'=> 'Senior Services'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/confirmeReservation.html.twig',
                        [
                            'user'=>$user,

                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('success', 'Votre reservation a ete pris en comte, un email vous a aete envoyer!');

            return $this->redirectToRoute('home');
        }

        return $this->render('reservation/reserver.html.twig', [

            'ReservationType' => $form->createView(),
        ]);
    }
}
