<?php 

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** 
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
*/
class Contact 
{
    /** 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /** 
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="le nom est requis")
     * 
    */
    private $name;

    /** 
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="l'email est requis")
     * @Assert\Email(message="l'email n'est pas valide")
    */
    private $email;

    /** 
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="le message ne peut être vide")
    */
    private $subject;

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of subject
     */ 
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     *
     * @return  self
     */ 
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}