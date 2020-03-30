<?php

namespace App\Controller;

use App\Repository\ServicesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\CategorysRepository;
use App\Entity\Categorys;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class ServicesController extends AbstractController
{
    /**
     * @Route("/services-service.{format}", name="services.service",requirements={
     *
     *   "format" = "html|xml"
     * }, defaults={"format" = "html"})))
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



    //afficher deatil du servicet
    /**
     * @Route("/services-Show-{id}.{format}", name="services.Show",requirements={
     *
     *   "format" = "html|xml"
     * }, defaults={"format" = "html"}))
     */
    public function show($id, ServicesRepository $repository,\App\Repository\CategorysRepository $categorieRepository )
    {
        $service = $repository->findOneBy(['id' => $id]);
        /*$Cat = $categorieRepository-> findCatFirstLevel();*/
       /* $cat=$service->getCategorys();*/
       /* dump($id);*/
      /* $service->setCategorys($Cat);*/

        return $this->render('services/Show.html.twig', [
            'service' => $service
        ]);

        dump($service );
    }

}
