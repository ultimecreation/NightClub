<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    /**
     * @Route("/register",name="register")
     */
    public function RegisterAction(Request $request,UserPasswordEncoderInterface $passwordEncoder,ObjectManager $entityManager)
    {
        //create the form
        $user = new User();
        $form = $this->createForm(UserType::class,$user);

        // handle the POST request
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // encode password
            $password = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);

            //save the user
            $entityManager->persist($user);
            $entityManager->flush();

            //set flash message and redirect
            $this->addFlash('success',"votre compte a été créé, vous pouvez vous connecter");
            return $this->redirectToRoute('login');
        }
        return $this->render('user/register.html.twig',array('form'=> $form->createView()));
    }

    /**
     * @Route("/login",name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get authentication error if any
        $error = $authenticationUtils->getLastAuthenticationError();

        // get the last entered login value entered
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig',array(
            'last_username'=> $lastUsername,
            'error' => $error
        ));
    }

    /** 
     * @Route("/logout",name="logout")
    */
    public function logout()
    {
        
    }
}