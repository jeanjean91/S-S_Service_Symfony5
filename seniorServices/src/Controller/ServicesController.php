<?php

namespace App\Controller;

use App\Repository\ServicesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\CategorysRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class ServicesController extends AbstractController
{
    /**
     * @Route("/services-service", name="services.service")
     */


    public function services(ServicesRepository$repository,
                            /* objectManager $manager,*/Request $request, PaginatorInterface $paginator,\App\Repository\CategorysRepository $categorysRepository)
    {
        /* $produit = $repository->findOneBy(array('id' => 1) );*/
        $allservices = $repository->findAll();
        $services= $paginator->paginate(
        // Doctrine Query, not results
            $allservices,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            9
        );
       /* $Cat = $categorysRepository-> findCatFirstLevel();*/

        return $this->render('services/service.html.twig', [
            'service' => $services,
            /*'Cat' => $Cat*/
        ]);
    }



    //afficher deatil du produit
    /**
     * @Route("/services-Show-{id}", name="services.Show")
     */
    public function show($id, ServicesRepository $repository)
    {
        $service = $repository->findOneBy(['id' => $id]);
        return $this->render('services/Show.html.twig', [
            'service' => $service
        ]);
    }

}
