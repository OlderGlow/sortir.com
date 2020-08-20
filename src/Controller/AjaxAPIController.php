<?php

namespace App\Controller;

use App\Entity\Lieux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AjaxAPIController extends AbstractController
{
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

        for ($i = 0; $i !== count($locationsMatching); $i++) {
            $jsonLocation = array(
                'id' => $locationsMatching[$i]->getId(),
                'name' => $locationsMatching[$i]->getNomLieu(),
                'ville' => $locationsMatching[$i]->getVille()->getNomVille(),
                'street' => $locationsMatching[$i]->getRue(),
                'lat' => $locationsMatching[$i]->getLatitude(),
                'long' => $locationsMatching[$i]->getLongitude(),
                'zipCode' => $locationsMatching[$i]->getVille()->getCodePostal()
            );
            $response[] = $jsonLocation;
        }

        return new JsonResponse($response);
    }
}
