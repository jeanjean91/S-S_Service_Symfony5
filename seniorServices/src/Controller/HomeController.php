<?php

namespace App\Controller;

use App\Entity\Categorys;
use App\Entity\Services;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ServicesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    //afficher une categorie

    /**
     * @Route("/base-{idCat}", name="baseParCat")
     */

    public function category(ServicesRepository $repository, \App\Repository\CategorysRepository $categoriesRepository, ObjectManager $manager, Request $request, PaginatorInterface $paginator, $idCat)
    {
        $query = $manager->createQuery(  "SELECT DISTINCT p FROM App\Entity\Services p
                                        JOIN p.categorys cn3 JOIN cn3.categorys cn2 JOIN cn2.categorys cn1
                                        WHERE cn3.id= :id3 OR  cn2.id= :id2 OR  cn1.id= :id1 ORDER BY p.titre ASC");
        $query->setParameters(array('id1' => $idCat, 'id2' => $idCat, 'id3' => $idCat));

        //$service = $this->get('knp_paginator');
        $service= $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            12
        );
        $Cat = $categoriesRepository-> findCatFirstLevel();
        dump($Cat);
        return $this->render('/base.html.twig ', [

            'Cat' => $Cat
        ]);
    }



}
