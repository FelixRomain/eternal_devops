<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Menu;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Color;
use App\Entity\Skill;
use App\Entity\Feature;
use App\Entity\Project;
use App\Entity\Category;
use App\Entity\Formation;
use App\Entity\Experience;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eternal Devops')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::subMenu('Administration', 'fa fa-bars')->setSubItems([
                MenuItem::linkToCrud('Features', 'fa fa-tags', Feature::class),
                MenuItem::linkToCrud('Couleurs', 'fa fa-droplet', Color::class),
                MenuItem::linkToCrud('Menu', 'fa fa-list', Menu::class),
            ]),
            MenuItem::subMenu('Utilisateur', 'fa fa-bars')->setSubItems([
                MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
                MenuItem::linkToCrud('Rôles', 'fa fa-users-viewfinder', Role::class),
            ]),
            MenuItem::subMenu('Curriculum Vitae', 'fa fa-bars')->setSubItems([
                MenuItem::linkToCrud('Expériences', 'fa fa-briefcase', Experience::class),
                MenuItem::linkToCrud('Formations', 'fa fa-book', Formation::class),
                MenuItem::linkToCrud('Compétences', 'fa fa-list', Skill::class),
            ]),
            MenuItem::subMenu('Projet', 'fa fa-bars')->setSubItems([
                MenuItem::linkToCrud('Projets', 'fa fa-user', Project::class),
                MenuItem::linkToCrud('Catégories', 'fa fa-list', Category::class),
                MenuItem::linkToCrud('Tags', 'fa fa-tag', Tag::class),
            ]),
        ];
    }
}
