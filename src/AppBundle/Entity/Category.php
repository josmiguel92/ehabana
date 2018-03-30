<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     */
    private $nombre;

    /**
    * @ORM\OneToMany(targetEntity="Drink", mappedBy="category")
    */
    protected $drinks;
    public function __construct($nombre = null, $name = null)
    {
        $this->drinks = new ArrayCollection();
        $this->nombre = $nombre;
        $this->name = $name;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;


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
     * @return Category
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Category
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add drink
     *
     * @param \AppBundle\Entity\Drink $drink
     *
     * @return Category
     */
    public function addDrink(\AppBundle\Entity\Drink $drink)
    {
        $this->drinks[] = $drink;

        return $this;
    }

    /**
     * Remove drink
     *
     * @param \AppBundle\Entity\Drink $drink
     */
    public function removeDrink(\AppBundle\Entity\Drink $drink)
    {
        $this->drinks->removeElement($drink);
    }

    /**
     * Get drinks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDrinks()
    {
        return $this->drinks;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function getTransName($locale){
        switch (strtolower($locale)) {
            case 'en':
                return $this->name;
                break;
            
            default:
                return $this->nombre;
                break;
        }

      
    }

     /**
     * Set position
     *
     * @param string $position
     *
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }
}
