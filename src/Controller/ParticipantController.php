<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantsType;
use App\Form\PhotoType;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Math;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\AbstractUnicodeString;

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
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function profileEdit(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
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
            'form' => $form->createView()
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

    /**
     * @Route("/participant/monprofil/maphoto", name="participant.my.detail.myphoto")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Participants $participants
     * @return Response
     * @throws \Exception
     */
    public function photoEdit(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /*
             * Si il y a une photo
             */
            $photo = $form->get('photo')->getData();
            if ($photo) {
                /*
                 * On modifie le nom du fichier pour avoir un nom unique random de type : Nom original + random + .extension
                 */
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $typeFichier = pathinfo($photo->getClientOriginalName(), PATHINFO_EXTENSION);
                $random = '';
                for ($i = 0; $i <= 10; $i++) {
                    $r = (string)random_int(0, 999)*random_int(0, 999);
                    $random = $random . $r;
                }
                $newFilename = $originalFilename . $random . '.' . $typeFichier;

                // On déplace la photo dans le dossier indiqué en paramètre dans service.yaml
                try {
                    $photo->move(
                        $this->getParameter('photo_participants'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', "Erreur lors de l'upload de l'image");
                    return $this->redirectToRoute('participant.my.profil');
                }

                // on inscrit le nom du fichier dans le participant
                $user->setPhoto($newFilename);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Image enregistrée !");
            return $this->redirectToRoute('participant.my.profil');
        }

        return $this->render('participant/photo.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
