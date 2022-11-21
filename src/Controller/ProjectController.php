<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'project')]
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

        return $this->render('eternal_devops/project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'title' => 'Mes projets',
            'menus' => $menus,
            'users' => $users,
        ]);
    }
}
