<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminContactController extends Controller
{
    /**
     * show contact list
     * @Route("/admin/contact/list",name="admin.contact.list")
     */
    public function listAction()
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        dump($contacts);
        return $this->render('admin/contact/list.html.twig',compact('contacts'));
    }

    /** 
     * @Route("admin/contact/show/{id}",name="admin.contact.show")
    */
    public function showAction($id)
    {
        if(is_numeric($id))
        {
            $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

            return $this->render('admin/contact/show.html.twig',compact('contact'));
        }
    }
    /** 
     * @Route("admin/contact/delete",name="admin.contact.delete")
    */
    public function deleteAction(Request $request,ObjectManager $entityManager)
    {
        $id = $request->get('id');
        if(is_numeric($id))
        {
            $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
            if($contact)
            {
                $entityManager->remove($contact);
                $entityManager->flush();

                $this->addFlash('success',"Le message a été supprimé");
                return $this->redirectToRoute('admin.contact.list');
            }
        }
    }
}