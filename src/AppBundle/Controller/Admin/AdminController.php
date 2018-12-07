<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin",name="admin")
     * 
     */
    public function IndexAction()
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $this->redirectToRoute('home');
        }

        return $this->render('admin/base.html.twig');
    }
}