<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Sorties;
use App\Form\SearchForm;
use App\Form\SortieType;
use App\Repository\ParticipantsRepository;
use App\Repository\SortieRepository;
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

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="home")
     * @param ParticipantsRepository $repository
     * @return RedirectResponse|Response
     */
    public function index(ParticipantsRepository $participantsRepository, SortieRepository $sortieRepository, Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('user_login');
        }

        $participant = $participantsRepository->find($this->getUser());

        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $sortieRepos = $sortieRepository->findSearch($data, $participant);
        return $this->render('home/index.html.twig', [
            'sorties'=>$sortieRepos,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/sortie/add", name="sortie.add")
     * @param ParticipantsRepository $repository
     * @return RedirectResponse|Response
     */
    public function add(Request $request)
    {
        $sortie = new Sorties();

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($sortie);
            $this->em->flush();
            $this->addFlash('success', 'La ville a été ajoutée avec succès.');
            return $this->redirectToRoute('admin.ville.home');
        }

        return $this->render('home/add.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView()
        ]);
    }
}
