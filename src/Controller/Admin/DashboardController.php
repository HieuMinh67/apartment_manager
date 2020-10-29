<?php

namespace App\Controller\Admin;

use App\Entity\Apartment;
use App\Entity\Building;
use App\Entity\Citizen;
use App\Entity\Quotation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashboardController extends AbstractDashboardController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/page/dashboard.html.twig');
    }

    /**
     * @Route("/password/change", name="change_password", methods={"GET","POST"})
     */
    public function change_password(Request $request): Response
    {
        $user = $this->getUser();
        if ($request->isMethod('POST')) {
            $form = $request->request->all();
            if ($form['_new_password'] === $form['_retype_new_password'] && strcmp($this->encoder->encodePassword($user, $form['_old_password']), $user->getPassword())) {
                $this->getDoctrine()->getRepository(User::class)->upgradePassword($user, $this->encoder->encodePassword($user, 'admin'));
                return $this->redirectToRoute('app_logout');
            }
        }
        return $this->render('bundles/EasyAdminBundle/page/_change_password_form.html.twig');
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
        yield MenuItem::section("Building");
        yield MenuItem::linkToCrud('List building', 'fa fa-building', Building::class);
        yield MenuItem::linkToCrud('Add building', 'fa fa-plus', Building::class)->setAction('new');
        yield MenuItem::section("Quote request");
        yield MenuItem::linkToCrud('List quote', 'fa fa-envelope', Quotation::class);
    }
}
