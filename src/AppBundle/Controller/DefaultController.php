<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use AppBundle\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Event;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request,ObjectManager $em,\Swift_Mailer $mailer)
    {
        // get events from db
        
        $events = $this->getDoctrine()->getRepository(Event::class)->findBy(array('displayEvent'=> 1),array('date'=>'ASC'));
        
        //create contact
        $contact = new Contact;
        $contactForm = $this->createForm(ContactType::class,$contact);
        $contactForm->handleRequest($request);

        if($contactForm->isSubmitted() && $contactForm->isValid())
        {
            // save contact in db
            $em->persist($contact);
            $em->flush();

            // send confirmation email
            $message = (new \Swift_Message('no reply'))
                ->setFrom('testlocalhost@free.fr')
                ->setTo($contact->getEmail())
                ->setBody($this->renderView('emails/contact.html.twig',array('contact'=>$contact)),'text/html');
        
            $mailer->send($message);

            //add flash message and redirect to home
            $this->addFlash('success',"Votre message a été envoyé");
            return $this->redirectToRoute('home');
        }
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig',array(
            'contactForm'=> $contactForm->createView(),
            'events'=> $events
        ));
    }
}
