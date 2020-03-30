<?php

namespace App\Controller;

use App\Entity\Categorys;
use App\Entity\Services;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ServicesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\CategorysRepository;
use Psr\SimpleCache\CacheInterface;
use Pusher\Pusher;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        /*$visitorCount = $this->getVisitorCount();
        return $this->render('reservation.html.twig', [
            'pusherKey' => $this->getParameter('pusherKey'),
            'pusherCluster' => $this->getParameter('pusherCluster'),
            'visitorCount' => $visitorCount,
        ]);*/


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

  /*  public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }*/




  /*  public function webhook(Request $request, Pusher $pusher)
    {
        $events = json_decode($request->getContent(), true)['events'];
        $visitorCount = $this->getVisitorCount();
        foreach ($events as $event) {
            // ignore any events from our public channel--it's only for broadcasting
            if ($event['channel'] === 'visitor-updates') {
                continue;
            }
            $visitorCount += ($event['name'] === 'channel_occupied') ? 1 : -1;
        }
        // save new figure and notify all clients
        $this->saveVisitorCount($visitorCount);
        $pusher->trigger('visitor-updates', 'update', [
            'newCount' => $visitorCount,
        ]);
        return new Response();
    }

    private function getVisitorCount()
    {
        return $this->cache->get('visitorCount') ?: 0;
    }

    private function saveVisitorCount($visitorCount)
    {
        $this->cache->set('visitorCount', $visitorCount);
    }*/





    //afficher une categorie

    /**
     * @Route("/base-{idCat}.{format}", name="baseParCat",requirements={
     *
     *   "format" = "html|xml"
     * }, defaults={"format" = "html"}))))
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
