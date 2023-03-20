<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Require ROLE_ADMIN for this actions
 */ 
#[IsGranted('ROLE_ADMIN')]
#[Route('/admin')]
class AdminController extends AbstractController
{
    /** Show main admin view */  
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /** Show serch dish view */
    #[Route('/search', name: 'app_admin_search')]
    public function dishSearchView(): Response
    {
        return $this->render('admin/dish_search_main_view.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
