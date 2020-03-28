<?php

namespace App\Controller;


use App\Entity\Categorys;
use App\Entity\Services;
use App\Form\CategoryFormType;
use App\Form\ServiceFormType;
use App\Form\UserformType;
use App\Repository\CategorysRepository;
use App\Repository\PrestataireRepository;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */

    public function index(UserRepository $repository)
    {
        /* $total ='user.id';*/
        $user =$repository->findByExampleField();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'user'=>$user
        ]);
    }


    /**
     * @Route("/admin-user", name="admin.user")
     */
    public function user( UserRepository $repository,
                          objectManager $manager,Request $request, PaginatorInterface $paginator)
    {




        $allusers = $repository->findAll();

        $users = $paginator->paginate(
        // Doctrine Query, not results
            $allusers,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            7
        );



        return $this->render('admin/user.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin-services", name="admin.services")
     */
    public function service( ServicesRepository $repository,
                          objectManager $manager,Request $request, PaginatorInterface $paginator)
    {




        $allusers = $repository->findAll();

        $services = $paginator->paginate(
        // Doctrine Query, not results
            $allusers,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            15
        );



        return $this->render('admin/services.html.twig', [
            'service' => $services
        ]);
    }
    /**
     * @Route("/admin-prestataire", name="admin.prestataire")
     */
    public function prestataire( PrestataireRepository $repository,
                             objectManager $manager,Request $request, PaginatorInterface $paginator)
    {




        $allprestataire = $repository->findAll();

        $prestataire = $paginator->paginate(
        // Doctrine Query, not results
            $allprestataire,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            15
        );



        return $this->render('admin/prestataire.html.twig', [
            'prestataire' => $prestataire
        ]);
    }



    /**
     * @Route("/admin-categorie", name="admin.categorie")
     */
    public function categorie( CategorysRepository $repository,
                             objectManager $manager,Request $request, PaginatorInterface $paginator)
    {




        $categorie = $repository->findAll();

        $cat = $paginator->paginate(
        // Doctrine Query, not results
            $categorie,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            7
        );



        return $this->render('admin/categorie.html.twig', [
            'cat' => $cat
        ]);
    }

    /**
     * @Route("/admin-{id}-roles", name="admin.roles")
     */
    public function roles($id, UserRepository $repository,Request $request, ObjectManager $manager)
    {




        $user = $repository->findOneBy(['id' => $id]);
        $user->getRoles();
        $user->setRoles(array('ROLE_ADMIN','ROLE_PRESTA'));
        $form = $this->createForm(UserformType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

/*
            $image = $form->get('image')->getData();

            $imageName = md5(uniqid()).'.'.$image->guessExtension();

            $user->setImage($imageName);

            $image->move(
                $this->getParameter('image_directory'), $imageName);
            $user->setImage($imageName);*/

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("admin.user");

    }

        return $this->render('admin/roles.html.twig', [
            'UserformType' => $form->createView()
        ]);

    }



    /**
     * @Route("/admin-addService", name="admin.addService")
     */


    public function  new(Request $request, ObjectManager $manager)
    {




        $service = new Services();
      ;


        $form = $this->createForm(ServiceFormType::class, $service );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($service );
            $manager->flush();
            $this->addFlash('success', "Service ajouter!");
            return $this->redirectToRoute("admin.service");


        }
        return $this->render('admin/addService.html.twig', [

            'ServiceFormType' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin-addCategorie", name="admin.addCategorie")
     */


    public function  Cat(CategorysRepository $repository,Request $request, ObjectManager $manager)
    {





        $category = new Categorys();




        $form = $this->createForm(CategoryFormType::class, $category );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category );
            $manager->flush();
            $this->addFlash('success', "Categorie ajouter!");
            return $this->redirectToRoute("admin.");


        }
        return $this->render('admin/addCategorie.html.twig', [

            'CategoryFormType' => $form->createView(),
        ]);
    }

}
