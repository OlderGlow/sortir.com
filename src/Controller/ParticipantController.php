<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantsType;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @param EntityManagerInterface $em
     * @param Participants $participants
     * @return Response
     */
    public function profileEdit(Request $request, EntityManagerInterface $em,UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(ParticipantsType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newpwd = $form->get('motDePasse')['first']->getData();
            $newEncodedPassword = $encoder->encodePassword($user, $newpwd);
            $user->setPassword($newEncodedPassword);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('participant/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * Fonction au clic sur le nom d'un participant qui affiche son profil
     * @Route("/participant/detail/{id}", name="participant.detail")
     * @param Participants $participants
     * @return Response
     */
    public function detailParticipant(Participants $participants)
    {
        $user = $this->getUser();

        /*
         * SI l'id demandé est celui de l'utilisateur connecté on l'envoie vers la modification de son profil,
         */
        if ($user->getUsername() == $participants->getUsername()) {
            return $this->redirectToRoute('participant.my.profil', [
                'participant' => $participants,
            ]);

            /*
             * Sinon on lui affiche les informations de cet utilisateur
             */
        } else {
            return $this->render('participant/detail.html.twig', [
                'participant' => $participants,
            ]);
        }
    }

}
