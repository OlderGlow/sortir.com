<?php

namespace App\Controller\Admin;

use App\Entity\Villes;
use App\Form\VillesType;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/ville", name="admin.ville.home")
     */
    public function homeVille(PaginatorInterface $paginator, Request $request, VillesRepository $villesRepository)
    {

        $user = $this->getUser();
        // Affichage de la liste
        $villes = $paginator->paginate(
            $villesRepository->findAll(),
            $request->query->get('page', 1),
            5
        );

        return $this->render('admin_dashboard/index.html.twig', [
            'villes' => $villes,
            'user' => $user
        ]);
    }

    /**
     * @Route("/ville/ajouter", name="admin.ville.add")
     */
    public function add(Request $request)
    {
        $villes = new Villes();

        $form = $this->createForm(VillesType::class, $villes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($villes);
            $this->em->flush();
            $this->addFlash('success', 'Crée avec succès');
            return $this->redirectToRoute('admin.ville.home');
        }

        return $this->render('admin_dashboard/add.html.twig', [
            'villes' => $villes,
            'form' => $form->createView()
        ]);
    }

   /**
     * @Route("/ville/{id}", name="admin.ville.edit")
     * @param Villes $villes
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Villes $villes, Request $request)
    {
        $form = $this->createForm(VillesType::class, $villes);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.ville.home');
        }

        return $this->render('admin_dashboard/edit.html.twig', [
            'villes' => $villes,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/ville/delete", name="admin.ville")
     * @param Villes $villes
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteVille(Villes $villes, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $villes->getId(), $request->get('_token')))
        {
            $this->em->remove($villes);
            $this->em->flush();
            $this->addFlash('success', 'Supprimer avec succès');
        }

        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }





    /*
     * <------------------------SEPARATION PREMIERE ETAPE,
     *                                                      NE PAS REGARDER LA SUITE ---------------------------------->
     */




    /**
     * @Route("/campus", name="admin.campus")
     */
    public function index()
    {
        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }

    /**
     * @Route("/participants", name="admin.participants")
     */
    /*public function index()
    {
        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
    */
}
