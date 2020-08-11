<?php

namespace App\Controller\Admin;

use App\Entity\Campus;
use App\Entity\Participants;
use App\Entity\Villes;
use App\Form\CampusType;
use App\Form\ParticipantsType;
use App\Form\VillesType;
use App\Repository\CampusRepository;
use App\Repository\ParticipantsRepository;
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
     * @Route("/villes", name="admin.ville.home")
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
     * @Route("/villes/ajouter", name="admin.ville.add")
     */
    public function addVille(Request $request)
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
     * @Route("/villes/editer/{id}", name="admin.ville.edit")
     * @param Villes $villes
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editVille(Villes $villes, Request $request)
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
     * @Route("/villes/{id}", name="admin.ville.delete", methods="DELETE")
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

        return $this->redirectToRoute('admin.ville.home');
    }





    /*
     * <------------------------CAMPUS---------------------------------->
     */




    /**
     * @Route("/campus", name="admin.campus.home")
     */
    public function homeCampus(PaginatorInterface $paginator, Request $request, CampusRepository $campusRepository)
    {

        $user = $this->getUser();
        // Affichage de la liste
        $campus = $paginator->paginate(
            $campusRepository->findAll(),
            $request->query->get('page', 1),
            5
        );

        return $this->render('admin_dashboard/index.html.twig', [
            'campus' => $campus,
            'user' => $user
        ]);
    }

    /**
     * @Route("/campus/ajouter", name="admin.campus.add")
     */
    public function addCampus(Request $request)
    {
        $campus = new Campus();

        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($campus);
            $this->em->flush();
            $this->addFlash('success', 'Crée avec succès');
            return $this->redirectToRoute('admin.campus.home');
        }

        return $this->render('admin_dashboard/add.html.twig', [
            'campus' => $campus,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/campus/{id}", name="admin.campus.edit")
     * @param Campus $campus
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editCampus(Campus $campus, Request $request)
    {
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.ville.home');
        }

        return $this->render('admin_dashboard/edit.html.twig', [
            'campus' => $campus,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/campus/{id}", name="admin.campus.delete")
     * @param Campus $campus
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteCampus(Campus $campus, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $campus->getId(), $request->get('_token')))
        {
            $this->em->remove($campus);
            $this->em->flush();
            $this->addFlash('success', 'Supprimer avec succès');
        }

        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }

    /*
     * ------------------------------ PARTICIPANT-------------------------------
     */

    /**
     * @Route("/participants", name="admin.participants.home")
     */
    public function homeParticipant(PaginatorInterface $paginator, Request $request, ParticipantsRepository $participantsRepository)
    {

        $user = $this->getUser();
        // Affichage de la liste
        $participants = $paginator->paginate(
            $participantsRepository->findAll(),
            $request->query->get('page', 1),
            5
        );

        return $this->render('admin_dashboard/index.html.twig', [
            'participants' => $participants,
            'user' => $user
        ]);
    }

    /**
     * @Route("/participant/ajouter", name="admin.participant.add")
     */
    public function addParticipant(Request $request)
    {
        $participant = new Participants();

        $form = $this->createForm(ParticipantsType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($participant);
            $this->em->flush();
            $this->addFlash('success', 'Crée avec succès');
            return $this->redirectToRoute('admin.participants.home');
        }

        return $this->render('admin_dashboard/add.html.twig', [
            'campus' => $participant,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/participant/{id}", name="admin.participant.edit")
     * @param Campus $campus
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editParticipant(Campus $campus, Request $request)
    {
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.ville.home');
        }

        return $this->render('admin_dashboard/edit.html.twig', [
            'campus' => $campus,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/participant/{id}", name="admin.participant.delete")
     * @param Participants $participants
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteParticipant(Participants $participants, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $participants->getId(), $request->get('_token')))
        {
            $this->em->remove($participants);
            $this->em->flush();
            $this->addFlash('success', 'Supprimer avec succès');
        }

        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
}
