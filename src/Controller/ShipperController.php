<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShipperController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('admin/shippers/index.html.twig', [
            'controller_name' => 'ShipperController',
        ]);
    }
}
