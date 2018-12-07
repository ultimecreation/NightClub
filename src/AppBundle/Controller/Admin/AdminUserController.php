<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AdminUserController extends Controller
{
    /** 
     * @Route("/admin/user/list",name="admin.user.list")
    */
    public function listAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/user/list.html.twig',compact('users'));
    }

    /** 
     * @Route("/admin/user/edit/{id}",name="admin.user.edit")
    */
    public function editAction(Request $request, ObjectManager $entityManager,$id)
    {
        //get user from db
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        
        //create user form
        $form = $this->createForm(UserType::class,$user);
        $form->remove('password');
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // save changes in db
            $entityManager->Flush($user);

            //add flash message to redirect to user list
            $this->addFlash("success","mise à jour effectuée");
            return $this->redirectToRoute("admin.user.list");
        }
        return $this->render('admin/user/edit.html.twig',array('form'=> $form->createView()));
    }

    /** 
     * @Route("/admin/user/show/{id} ",name="admin.user.show")
    */
    public function showAction($id)
    {
        // get user from db
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        dump($user);

        return $this->render('admin/user/show.html.twig',compact('user'));
    }

    /** 
     * @Route("/admin/user/delete",name="admin.user.delete")
    */
    public function deleteAction(Request $request, ObjectManager $entityManager)
    {
        //get user id and check if is_numeric
        $userId = $request->get('id');
        if(is_numeric($userId))
        {
            // check if user exists in db
            $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            if($user)
            {
                // remove user from db
                $entityManager->remove($user);
                $entityManager->flush();

                // send user message and redirect to user list
                $this->addFlash('success','utilisateur supprimé');
                return $this->redirectToRoute('admin.user.list');
            }
        }
    }
}