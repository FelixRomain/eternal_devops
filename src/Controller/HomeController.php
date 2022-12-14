<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupération des Menus non caché
        $repository = $em->getRepository(Menu::class);
        $menus = $repository->findBy(
            ['hidden' => '0'],
            ['ordered' => 'ASC'],
        );

        // Récupération de l'utilisateur Principal
        $repository = $em->getRepository(User::class);
        $users = $repository->findBy(
            ['front' => '1'],
        );    
          
        return $this->render('eternal_devops/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'Felix Romain',
            'menus' => $menus,
            'users' => $users,
        ]);
    }
}
