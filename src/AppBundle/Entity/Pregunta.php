<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pregunta
 *
 * @ORM\Table(name="pregunta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PreguntaRepository")
 */
class Pregunta
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
     * @ORM\Column(name="pregunta", type="string", length=300)
     */
    private $pregunta;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=300)
     */
    private $question;

    /**
     * @var array
     *
     * @ORM\Column(name="respuesta", type="string", length=300)
     */
    private $respuesta;

    /**
     * @var array
     *
     * @ORM\Column(name="otrasrespuestas", type="string", length=300)
     */
    private $otrasrespuestas;

    /**
     * @var array
     *
     * @ORM\Column(name="answer", type="string", length=300)
     */
    private $answer;

    /**
     * @var array
     *
     * @ORM\Column(name="otheranswers", type="string", length=300)
     */
    private $otheranswers;

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
     * Set pregunta
     *
     * @param string $pregunta
     *
     * @return Pregunta
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return Pregunta
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set respuestas
     *
     * @param string $respuestas
     *
     * @return Pregunta
     */
    public function setRespuesta($respuestas)
    {
        $this->respuesta = $respuestas;

        return $this;
    }

    /**
     * Get respuestas
     *
     * @return string
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set answer
     *
     * @param string $answers
     *
     * @return Pregunta
     */
    public function setAnswer($answers)
    {
        $this->answer = $answers;

        return $this;
    }

    public function getTransQuestion($locale)
    {
        switch (strtolower($locale)) {
            case 'en':
                return $this->question;
                break;
            case 'es':
                return $this->pregunta;
                break;

            default:
                return $this->pregunta;
                break;
        }

    }
    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }



    /**
     * @return array
     */
    public function getOtrasrespuestas()
    {
        return $this->otrasrespuestas;
    }

    /**
     * @param array $otrasrespuestas
     */
    public function setOtrasrespuestas($otrasrespuestas)
    {
        $this->otrasrespuestas = $otrasrespuestas;
    }

    /**
     * @return array
     */
    public function getOtheranswers()
    {
        return $this->otheranswers;
    }

    public function getListAnswers()
    {
        $ans = explode(";", $this->otheranswers);
        $ans[]=$this->answer;
        shuffle($ans);
        return $ans;
    }

    public function getListaRespuestas()
    {
        $ans = explode(";", $this->otrasrespuestas);
        $ans[]=$this->respuesta;
        shuffle($ans);
        return $ans;
    }

    /**
     * @param array $otheranswers
     */
    public function setOtheranswers($otheranswers)
    {
        $this->otheranswers = $otheranswers;
    }

    public function getTransListOptions($locale)
    {
        switch (strtolower($locale)) {
            case 'en':
                return $this->getListAnswers();
                break;
            case 'es':
                return $this->getListaRespuestas();
                break;

            default:
                return $this->getListaRespuestas();
                break;
        }

    }

    public function getTransAnswer($locale)
    {
        switch (strtolower($locale)) {
            case 'en':
                return $this->getAnswer();
                break;
            case 'es':
                return $this->getRespuesta();
                break;

            default:
                return $this->getRespuesta();
                break;
        }

    }
}

