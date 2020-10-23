<?php

namespace App\Controller\Admin;

use App\Entity\Apartment;
use App\Entity\Citizen;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
//        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
//
//        return $this->redirect($routeBuilder->setController(ApartmentCrudController::class)->generateUrl());
//        return parent::index();
        return $this->render('bundles/EasyAdminBundle/page/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img class="w-25" src="images/long_logo.png">')
            ->setFaviconPath('images/favicon.jpg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-file-text');
        yield MenuItem::section("Employee");
        yield MenuItem::linkToCrud('List employee', 'fa fa-user', User::class);
        yield MenuItem::section("Citizen");
        yield MenuItem::linkToCrud('List citizen', 'fa fa-user', Citizen::class);
        yield MenuItem::linkToCrud('Add citizen', 'fa fa-plus', Citizen::class)->setAction('new');
        yield MenuItem::section("Apartment");
        yield MenuItem::linkToCrud('List apartment', 'fa fa-home', Apartment::class);
    }
}
