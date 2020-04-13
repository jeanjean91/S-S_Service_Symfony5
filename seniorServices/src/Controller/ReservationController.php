<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Services;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\ServicesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints as Assert;
class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation-{id}-reserver", name="reservation.reserver")
     */
    public function  new($id, ServicesRepository $repository ,Request $request, ObjectManager $manager,\Swift_Mailer $mailer)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $session = $request->getSession();
        $service = $repository->findOneBy(['id' => $id]);
        dump( $service); 
        $panier = $session->get('panier');
        $user = $this ->getUser();
        $reservation = new Reservation();

        $reservation->setUser($user);
        $reservation->setService($service);
          

        
        $form = $this->createForm(ReservationType::class,  $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

           


        if ($request->isMethod('POST')) {

            $email = $user->getEmail();

            if ($email === null) {
                $this->addFlash('danger', 'Vous devez etre connecter pour faire une reservation!! ');
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

            $this->addFlash('success', 'Votre reservation a ete pris en comte, un email de comfirmation vous a aete envoyer!');

            return $this->redirectToRoute('home');
        }

        return $this->render('reservation/reserver.html.twig', [

            'ReservationType' => $form->createView(),
        ]);
    }

    /**
     * @Route("/prestatair-reservation", name="prestatair.reservation")
     */


    public function services(ReservationRepository$repository,
        /* objectManager $manager,*/Request $request, PaginatorInterface $paginator,\App\Repository\CategorysRepository $categorysRepository)
    {

        $allReservation = $repository->findAll();
        $reservation= $paginator->paginate(
        // Doctrine Query, not results
            $allReservation,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            20
        );
        /* $Cat = $categorysRepository-> findCatFirstLevel();*/

        return $this->render('prestatair/reservation.html.twig', [
            'reservation' => $reservation,

        ]);
    }
}
