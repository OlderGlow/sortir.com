<?php


namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Form\SortieType;
use App\Form\VillesType;
use App\Repository\EtatsRepository;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function __construct(EntityManagerInterface $em, EtatsRepository $etatsRepository)
    {
        $this->em = $em;
        $this->etatsRepository = $etatsRepository;
    }

    /**
     * @Route("/", name="home")
     * @param ParticipantsRepository $repository
     * @return RedirectResponse|Response
     */
    public function index(ParticipantsRepository $repository)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('user_login');
        }


        // Récupération de la liste des sorties
        $sortieRepos = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortieRepos->findAll();
        return $this->render('home/index.html.twig', [
            'sorties'=>$sortie,
        ]);

    }

    /**
     * @Route("/sortie/add", name="sortie.add")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function add(Request $request)
    {
        $sortie = new Sorties();
        $etat = $this->etatsRepository->find(1);
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setOrganisateur($this->getUser());
            $sortie->setEtats($etat);
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

    /*
     * Gestion des API - Json pour sortie.add
     */

    /**
     * @Route("/api/getlocations/like/{lieuxApi}", name="api_ajax_locations_like");
     * @param EntityManagerInterface $entityManager
     * @param $lieuxApi
     * @return JsonResponse
     */
    public function getLocation(EntityManagerInterface $entityManager, $lieuxApi)
   {
        //Find all locations matching location_pattern
        $locationsMatching = $entityManager->getRepository(Lieux::class)->findbyLieuxApi($lieuxApi);

       $response = array();

       for($i = 0 ; $i !== count($locationsMatching); $i++){
            $jsonLocation = array (
                'id' => $locationsMatching[$i]->getId(),
                'name' => $locationsMatching[$i]->getNomLieu(),
                'ville' => $locationsMatching[$i]->getVille()->getNomVille(),
                'street' =>  $locationsMatching[$i]->getRue(),
                'lat' => $locationsMatching[$i]->getLatitude(),
                'long' => $locationsMatching[$i]->getLongitude(),
                'zipCode' => $locationsMatching[$i]->getVille()->getCodePostal()
            );
            $response[] = $jsonLocation;
        }

        return new JsonResponse( $response );
    }
}