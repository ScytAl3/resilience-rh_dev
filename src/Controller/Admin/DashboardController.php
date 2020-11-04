<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\JobOffer;
use App\Entity\Partner;
use App\Entity\Solution;
use App\Entity\Training;
use App\Entity\Publication;
use App\Entity\Testimonial;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin_dashboard")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(PublicationCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Résilience-Rh')
            ->setFaviconPath('favicon/favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Dashboard', 'fa fa-table');

        // Section relative à la gestion des pages dynamiques
        yield MenuItem::linkToCrud('Publications', 'fas fa-thumbtack', Publication::class)
            ->setDefaultSort(['title' => 'ASC']);
        yield MenuItem::linkToCrud('Formations', 'fas fa-graduation-cap', Training::class)
            ->setDefaultSort(['title' => 'ASC']);
        yield MenuItem::linkToCrud('Solutions', 'fas fa-list-ol', Solution::class);
        yield MenuItem::linkToCrud('Témoignages', 'fas fa-comment-dots', Testimonial::class);
        yield MenuItem::linkToCrud('Offres d\'emploi', 'fas fa-user-tie', JobOffer::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-user-check', Client::class)
            ->setDefaultSort(['title' => 'ASC']);
        yield MenuItem::linkToCrud('Partenaires', 'far fa-handshake', Partner::class)
            ->setDefaultSort(['title' => 'ASC']);

        // Section relative aux utilisateurs
        yield MenuItem::section('Authorisation', 'fas fa-lock');
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);

        // Section relative à la navigation sur le site
        yield MenuItem::section('Navigation', 'fa fa-folder-open');
        yield MenuItem::linktoRoute('Homepage', 'fa fa-home', 'app_home', []);
    }
}
