<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** 
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
*/
class Event
{
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /** 
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="Le titre est requis")
    */
    private $title;

    /** 
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="La date est requise")
    */
    private $date;
    /** 
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="La description est requise")
    */
    private $description;

    /** 
     * @ORM\Column(type="boolean",options={"default":0})
    */
    private $displayEvent;

    /** 
     * @ORM\Column(type="string")
     * @Assert\Regex(pattern="/^[a-zA-Z0-9\s.\-_']+$/",match=false,message="Le nom du fichier ne peut contenir que des chiffres et/ou lettres et/ou des underscores")
     * @Assert\File(maxSize = "2M")
    */
    private $image;
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of displayEvent
     */ 
    public function getDisplayEvent()
    {
        return $this->displayEvent;
    }

    /**
     * Set the value of displayEvent
     *
     * @return  self
     */ 
    public function setDisplayEvent($displayEvent)
    {
        $this->displayEvent = $displayEvent;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
}