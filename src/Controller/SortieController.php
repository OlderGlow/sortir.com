<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Form\SearchForm;
use App\Form\SortieType;
use App\Repository\EtatsRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\SortieRepository;
use App\Service\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var EtatsRepository
     */
    private $etatsRepository;
    /**
     * @var EventManager
     */
    private $eventManager;
    /**
     * @var ParticipantsRepository
     */
    private $participantsRepository;

    public function __construct(EntityManagerInterface $em, EtatsRepository $etatsRepository, EventManager $eventManager,
    ParticipantsRepository $participantsRepository)
    {
        $this->em = $em;
        $this->etatsRepository = $etatsRepository;
        $this->eventManager = $eventManager;
        $this->participantsRepository = $participantsRepository;
    }

    /**
     * @Route("/", name="home")
     * @param ParticipantsRepository $participantsRepository
     * @param SortieRepository $sortieRepository
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(ParticipantsRepository $participantsRepository, SortieRepository $sortieRepository, Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('user_login');
        }

        $participant = $this->participantsRepository->find($this->getUser());

        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $sortieRepos = $sortieRepository->findSearch($data, $participant);
        return $this->render('home/index.html.twig', [
            'sorties' => $sortieRepos,
            'participant' => $participant,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/sortie/add", name="sortie.add")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function add(Request $request)
    {
        $now = $this->eventManager->dateUpdate('+', 1, 'hours');

        $sortie = new Sorties();
        $sortie->setDatedebut($now);
        $sortie->setDatecloture($now);

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si les dates sont antérieur a maintenant on redirige avec erreur
            if ($sortie->getDatedebut() < $now && $sortie->getDatecloture() < $now ) {
                $this->addFlash('error', 'Merci de saisir une date future !');
                return $this->redirectToRoute('sortie.add');
            }
            // si la date de cloture est suppérieur a la date de début on redirige avec erreur
            if ($sortie->getDatecloture() > $sortie->getDatedebut()) {
                $this->addFlash('error', 'Merci de saisir une date de clôture supérieure à la date de début !');
                return $this->redirectToRoute('sortie.add');
            }

            $sortie->setOrganisateur($this->getUser());


            $nextAction = $form->get('publier')->isClicked()
                ?
                $this->etatsRepository->findOneBy(['libelle' => 'Ouverte'])
                :
                $this->etatsRepository->findOneBy(['libelle' => 'Créée']);

            $sortie->setEtats($nextAction);

            $lieu = $form->get('lieu')['nomLieu']->getData();
            $campus = $form->get('campus')['nomCampus']->getData();
            $sortie->setLieu($lieu);
            $sortie->setCampus($campus);

            $this->em->persist($sortie);
            $this->em->flush();
            $this->addFlash('success', 'La sortie a été ajoutée avec succès.');
            return $this->redirectToRoute('home');
        }

        return $this->render('home/add.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/sortie/edit/{id}", name="sortie.edit")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Sorties $sortie)
    {

        $now = $this->eventManager->dateUpdate(0,0,0);

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si les dates sont antérieur a maintenant on redirige avec erreur
            if ($form->get('datedebut')->getData() < $now) {
                $this->addFlash('error', 'Merci de saisir une date future !');
                return $this->redirectToRoute('sortie.add');
            }
            // si la date de cloture est suppérieur a la date de début on redirige avec erreur
            if ($form->get('datedebut')->getData() > $form->get('datecloture')->getData()) {
                $this->addFlash('error', 'Merci de saisir une date de clôture supérieure à la date de début !');
                return $this->redirectToRoute('sortie.add');
            }

            $sortie->setOrganisateur($this->getUser());


            $nextAction = $form->get('publier')->isClicked()
                ?
                $this->etatsRepository->findOneBy(['libelle' => 'Ouverte'])
                :
                $this->etatsRepository->findOneBy(['libelle' => 'Créée']);

            $sortie->setEtats($nextAction);

            $lieu = $form->get('lieu')['nomLieu']->getData();
            $campus = $form->get('campus')['nomCampus']->getData();
            $sortie->setLieu($lieu);
            $sortie->setCampus($campus);

            $this->em->persist($sortie);
            $this->em->flush();
            $this->addFlash('success', 'La sortie a été ajoutée avec succès.');
            return $this->redirectToRoute('home');
        }

        return $this->render('home/add.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/sortie/view/{id}", name="sortie.view")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function view(Sorties $sortieId, SortieRepository $sortieRepository)
    {
        $sortie = $sortieRepository->find($sortieId);
        return $this->render('home/view.html.twig', [
            'sortieId' => $sortie
        ]);
    }

    /**
     * @Route("/sortie/publier/{id}", name="sortie.publish")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function publish(Sorties $sortie)
    {
        $publish = $this->etatsRepository->findOneBy(['libelle' => 'Ouverte']);
        $sortie->setEtats($publish);
        $this->em->flush();
        $this->addFlash('success', 'Sortie publiée.');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/sortie/registration/{id}", name="sortie.registration")
     * @param Sorties $sortie
     * @param Participants $participants
     * @param SortieRepository $sortieRepository
     * @return RedirectResponse|Response
     */
    public function registration(Sorties $sortie)
    {
        $participants = $this->participantsRepository->find($this->getUser());
        $participants->addSorty($sortie);
        $this->em->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/sortie/unsubscribe/{id}", name="sortie.unsubscribe")
     * @param Sorties $sortie
     * @param Participants $participants
     * @param SortieRepository $sortieRepository
     * @return RedirectResponse|Response
     */
    public function unsubscribe(Sorties $sortie)
    {
        $participants = $this->participantsRepository->find($this->getUser());
        $participants->removeSorty($sortie);
        $this->em->flush();
        return $this->redirectToRoute('home');
    }



}
