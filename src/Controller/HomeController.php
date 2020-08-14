<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Repository\ParticipantsRepository;
use App\Repository\SortieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param SortieRepository $sortieRepository
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(ParticipantsRepository $repository)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('user_login');
        }

        $participant = $repository->find($this->getUser());
        dump($participant);

        // Récupération de la liste des sorties
        $sortieRepos = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortieRepos->findAll();
        return $this->render('home/index.html.twig', [
            'sorties'=>$sortie,
        ]);

    }
}
