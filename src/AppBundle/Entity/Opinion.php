<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Opinion
 *
 * @ORM\Table(name="opinion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OpinionRepository")
 */
class Opinion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="inputDate", type="string", length=255, nullable=true)
     */
    private $inputDate;

    /**
     * @var string
     *
     * @ORM\Column(name="inputTime", type="string", length=255, nullable=true)
     */
    private $inputTime;

    /**
     * @var string
     *
     * @ORM\Column(name="inputMessage", type="text")
     */
    private $inputMessage;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Opinion
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Opinion
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set inputDate
     *
     * @param string $inputDate
     *
     * @return Opinion
     */
    public function setInputDate($inputDate)
    {
        $this->inputDate = $inputDate;

        return $this;
    }

    /**
     * Get inputDate
     *
     * @return string
     */
    public function getInputDate()
    {
        return $this->inputDate;
    }

    /**
     * Set inputTime
     *
     * @param string $inputTime
     *
     * @return Opinion
     */
    public function setInputTime($inputTime)
    {
        $this->inputTime = $inputTime;

        return $this;
    }

    /**
     * Get inputTime
     *
     * @return string
     */
    public function getInputTime()
    {
        return $this->inputTime;
    }

    /**
     * Set inputMessage
     *
     * @param string $inputMessage
     *
     * @return Opinion
     */
    public function setInputMessage($inputMessage)
    {
        $this->inputMessage = $inputMessage;

        return $this;
    }

    /**
     * Get inputMessage
     *
     * @return string
     */
    public function getInputMessage()
    {
        return $this->inputMessage;
    }
}

