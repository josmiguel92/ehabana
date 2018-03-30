<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigRepository")
 */
class Config
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value_es", type="text", nullable=true)
     */
    private $valueEs;

    /**
     * @var string
     *
     * @ORM\Column(name="value_en", type="text", nullable=true)
     */
    private $valueEn;

    public function __construct($name=null, $valueEs = null, $valueEn = null){
        $this->name = $name;
        $this->valueEs = $valueEs;
        $this->valueEn = $valueEn;
        return $this;
    }


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
     * @return Config
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
     * Set valueEs
     *
     * @param string $valueEs
     *
     * @return Config
     */
    public function setValueEs($valueEs)
    {
        $this->valueEs = $valueEs;

        return $this;
    }

    /**
     * Get valueEs
     *
     * @return string
     */
    public function getValueEs()
    {
        return $this->valueEs;
    }

    /**
     * Set valueEn
     *
     * @param string $valueEn
     *
     * @return Config
     */
    public function setValueEn($valueEn)
    {
        $this->valueEn = $valueEn;

        return $this;
    }

    /**
     * Get valueEn
     *
     * @return string
     */
    public function getValueEn()
    {
        return $this->valueEn;
    }

    public function getTransValue($locale){
        switch (strtolower($locale)) {
            case 'en':
                return $this->valueEn;
                break;
            
            default:
                return $this->valueEs;
                break;
        }

      
    }
}
