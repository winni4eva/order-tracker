<?php
namespace App\Controller;

use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function index(Request $request)
    {
        $form = $this->createForm(OrderType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $orderFormData = $form->getData();
           dump($orderFormData);
           // do something interesting here
        }

        return $this->render('home/home.html.twig', [
            'our_form' => $form->createView(),
        ]);
    }

}
