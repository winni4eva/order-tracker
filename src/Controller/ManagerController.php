<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ManagerController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('admin/managers/index.html.twig', [
            'controller_name' => 'ManagerController',
        ]);
    }
}
