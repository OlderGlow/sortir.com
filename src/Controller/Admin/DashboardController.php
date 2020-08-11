<?php

namespace App\Controller\Admin;

use App\Entity\Campus;
use App\Entity\Inscriptions;
use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Entity\Villes;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin")
     */
    public function index(): Response
    {

        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(CampusCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Gestion de la BDD'),
            MenuItem::linkToCrud('Categories', 'fa fa-file-text', Campus::class),
            MenuItem::linkToCrud('Participants', 'fa fa-file-text', Participants::class),
            MenuItem::linkToCrud('Inscription', 'fa fa-file-text', Inscriptions::class),
            MenuItem::linkToCrud('Lieux', 'fa fa-file-text', Lieux::class),
            MenuItem::linkToCrud('Sorties', 'fa fa-file-text', Sorties::class),
            MenuItem::linkToCrud('Villes', 'fa fa-file-text', Villes::class),
        ];
    }
}
