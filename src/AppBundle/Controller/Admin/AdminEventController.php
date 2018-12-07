<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use AppBundle\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile; 

class AdminEventController extends Controller
{
    /** 
     * @Route("/admin/event/list",name="admin.event.list")
    */
    public function listAction()
    {
        // get events form db
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('admin/event/list.html.twig',compact('events'));
    }

    /** 
     * @Route("admin/event/create",name="admin.event.create")
    */
    public function createAction(Request $request,ObjectManager $entityManager)
    {
        // create an empty event object
        $event = new Event;

        //create event form and handle the request
        $form = $this->createForm(EventType::class,$event)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            
            if($event->getImage() === null)
            {
                $event->setImage('no_event_image.png');
            }
            else
            {
                $file = $event->getImage();
                $fileName = time().'_'.$file->getClientOriginalName();
                try 
                {
                    $file->move($this->getParameter('event_image_directory'),$fileName);
                } 
                catch (FileException $e) 
                {
                    
                }

                $event->setImage($fileName);
            }
            // save event to the db
            $entityManager->persist($event);
            $entityManager->flush();

            // add flash message and redirect to admin event list page
            $this->addFlash('success',"L'événement a été enregistré");
            return $this->redirectToRoute('admin.event.list');
        }
        return $this->render('admin/event/create.html.twig',array('form'=>$form->createView()));
    }

    /** 
     * @Route("admin/event/edit/{id}",name="admin.event.edit")
    */
    public function editAction(Request $request,ObjectManager $entityManager,$id)
    {
        // get event from db
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        $oldImage = $event->getImage();
        $form = $this->createForm(EventType::class,$event)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($event->getImage() !== null)
            {
                $file = $event->getImage();
                $fileName = time().'_'.$file->getClientOriginalName();
                try 
                {
                    if(file_exists($this->getParameter('event_image_directory').'/'.$oldImage && $oldImage !== 'no_event_image.png'))
                    {
                        unlink($this->getParameter('event_image_directory').'/'.$oldImage);
                    }
                    $file->move($this->getParameter('event_image_directory'),$fileName);
                } 
                catch (FileException $e) 
                {
                    
                }
                $event->setImage($fileName);
            }
            if($event->getImage() === null && $oldImage !== null)
            {
                $event->setImage($oldImage);
            }
            $entityManager->flush();
            $this->addFlash('success',"l'événement a été mise a jour");
            return $this->redirectToRoute('admin.event.list');
        }
        return $this->render('admin/event/edit.html.twig',array(
            'event'=>$event,
            'form'=>$form->createView()
        ));
    }

    /** 
     * @Route("admin/event/show/{id}",name="admin.event.show")
     * 
    */
    public function showAction($id)
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        return $this->render('admin/event/show.html.twig',compact('event'));
    }

    /** 
     * @Route("admin/event/delete",name="admin.event.delete")
    */
    public function deleteAction(Request $request,ObjectManager $entityManager)
    {
        $eventId = $request->get('id');
        if(is_numeric($eventId))
        {
            $event = $this->getDoctrine()->getRepository(Event::class)->find($eventId);
            if($event)
            {
                $entityManager->remove($event);
                $entityManager->flush();
                $this->addFlash('success',"L'événement a été supprimé");
                return $this->redirectToRoute('admin.event.list');
            }
        }
    }
}