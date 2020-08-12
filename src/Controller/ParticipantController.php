<?php

namespace App\Controller;

use App\Form\ParticipantsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

class ParticipantController extends AbstractController
{
        private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/participant/monprofil/", name="participant.my.profil")
     * @param Request $request
     * @param $em
     * @return Response
     */
    public function profileEdit(Request $request, EntityManagerInterface $em) : Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ParticipantsType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('participant/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }

}
