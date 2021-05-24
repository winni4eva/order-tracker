<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PickerController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('admin/pickers/index.html.twig', [
            'controller_name' => 'PickerController',
        ]);
    }
}
