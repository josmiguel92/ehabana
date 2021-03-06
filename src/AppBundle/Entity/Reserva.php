<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Reserva
 *
 * @ORM\Table(name="reserva")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservaRepository")
 */
class Reserva
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
     * @var datetime $fechaalta
     *
     * @ORM\Column(name="fechaalta", type="datetime", nullable=false)
     */
    private $fechaalta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datereserva", type="datetimetz")
     */
    private $datereserva;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="interes", type="string", length=255)
     */
    private $interes;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     * @Assert\GreaterThanOrEqual(1)
     * @ORM\Column(name="personas", type="smallint")
     */
    private $personas;

    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=500, nullable=true)
     */
    private $mensaje;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmado", type="boolean", nullable=true)
     */
    private $confirmado;

    /**
     * @var bool
     *
     * @ORM\Column(name="reservado", type="boolean", nullable=true)
     */
    private $reservado;

    /**
     * @var bool
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable=true)
     */
    private $cancelado;

    /**
     * @return boolean
     */
    public function isCancelado()
    {
        return $this->cancelado;
    }

    /**
     * @param boolean $cancelado
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;
    }

    /**
     * @return boolean
     */
    public function isReservado()
    {
        return $this->reservado;
    }

    /**
     * @param boolean $reservado
     */
    public function setReservado($reservado)
    {
        $this->reservado = $reservado;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;


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
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     *
     * @return Reserva
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime
     */
    public function getFechaalta()
    {
        return $this->fechaalta;
    }

    /**
     * Set datereserva
     *
     * @param \DateTime $datereserva
     *
     * @return Reserva
     */
    public function setDatereserva($datereserva)
    {
        $this->datereserva = $datereserva;

        return $this;
    }

    /**
     * Get datereserva
     *
     * @return \DateTime
     */
    public function getDatereserva()
    {
        return $this->datereserva;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Reserva
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
     * Set personas
     *
     * @param integer $personas
     *
     * @return Reserva
     */
    public function setPersonas($personas)
    {
        $this->personas = $personas;

        return $this;
    }

    /**
     * Get personas
     *
     * @return int
     */
    public function getPersonas()
    {
        return $this->personas;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Reserva
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
     * Set mensaje
     *
     * @param string $mensaje
     *
     * @return Reserva
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     *
     * @return Reserva
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return bool
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return Reserva
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Reserva
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getInteres()
    {
        return $this->interes;
    }

    /**
     * @param string $interes
     * @return Reserva
     */
    public function setInteres($interes)
    {
        $this->interes = $interes;
        return $this;
    }

    public function __toString()
    {
        $name = $this->nombre;
        $fecha = $this->datereserva ?  $this->datereserva->format("Y-m-d H:i") : null;

        $personas = $this->personas;
        $id = $this->id;
        return "[$id] - $name, $personas personas ($fecha)";
    }


    function __construct()
    {
        $this->fechaalta = new \DateTime('now');
        $this->token = substr(uniqid(date("ymd")),0,11);

        $this->reservado = false;
        $this->confirmado = false;

    }
    function setDate($date)
    {
        if(!$this->datereserva)
            $this->datereserva = new \DateTime();
        else{
            $temp_date = new \DateTime($date);
            $year = $temp_date->format('Y');
            $month = $temp_date->format('m');
            $day = $temp_date->format('j');

            $this->datereserva->setDate($year,$month,$day);
        }
    }
    /**
     * @param string $time
     */
    function setTime($time){
        if(!$this->datereserva)
            $this->datereserva = new \DateTime();

        $this->datereserva->setTime($time, 0);
        $this->datereserva->setTimezone(new \DateTimeZone('America/Havana'));


    }

    /**
     * @return string
     */
    function getTime(){
        if($this->datereserva)
            return $this->datereserva->format('G');
        else null;
    }
    /**
     * @return string
     */
    function getDate(){
        if($this->datereserva)
            return $this->datereserva->format('m/d/Y');
        else null;
    }
}
