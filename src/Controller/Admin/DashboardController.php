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
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eternal Devops')
            ->renderContentMaximized();
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFullName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(false)
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false)
            // you can also pass an email address to use gravatar's service
            ->setGravatarEmail($user->getEmail())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('Aller sur le site', 'fa fa-home', 'home'),
                MenuItem::linkToRoute('Authentification', 'fa fa-key', 'app_login'),
            ]);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::subMenu('Administration', 'fa fa-lock')->setSubItems([
                MenuItem::linkToCrud('Back-office', 'fa fa-tags', Feature::class),
                MenuItem::linkToCrud('Couleurs', 'fa fa-droplet', Color::class),
                MenuItem::linkToCrud('Menu', 'fa fa-list', Menu::class),
            ]),
            MenuItem::subMenu('Utilisateur', 'fa fa-users')->setSubItems([
                MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
                MenuItem::linkToCrud('Rôles', 'fa fa-users-viewfinder', Role::class),
            ]),
            MenuItem::subMenu('Curriculum Vitae', 'fa fa-newspaper')->setSubItems([
                MenuItem::linkToCrud('Expériences', 'fa fa-briefcase', Experience::class),
                MenuItem::linkToCrud('Formations', 'fa fa-book', Formation::class),
                MenuItem::linkToCrud('Compétences', 'fa fa-bars-progress', Skill::class),
            ]),
            MenuItem::subMenu('Projet', 'fa fa-briefcase')->setSubItems([
                MenuItem::linkToCrud('Projets', 'fa fa-user', Project::class),
                MenuItem::linkToCrud('Catégories', 'fa fa-list', Category::class),
                MenuItem::linkToCrud('Tags', 'fa fa-tag', Tag::class),
            ]),
        ];
    }
}
