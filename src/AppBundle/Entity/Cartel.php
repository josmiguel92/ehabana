<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cartel
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="cartel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartelRepository")
 */
class Cartel
{
    private $temp;
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
     * @ORM\Column(name="titulo", type="string")
     */
    private $titulo;
    /**
     * @var string
     *
     * @ORM\Column(name="titulo_en", type="string")
     */
    private $titulo_en;


    /**
     * @var string
     *
     * @ORM\Column(name="resumen", type="text")
     */
    private $resumen;

    /**
     * @var string
     *
     * @ORM\Column(name="resumen_en", type="text")
     */
    private $resumen_en;



    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Get Translated title
     *
     * @return string
     */
    public function getTransTitle($locale)
    {
        switch (strtolower($locale)) {
            case 'en':
                return $this->titulo_en;
                break;
            case 'es':
                return $this->titulo;
                break;
            
            default:
                return $this->titulo;
                break;
        }

    }

    /**
     * Get Translated Resumen
     *
     * @return string
     */
    public function getTransResumen($locale)
    {
        $text = null;
        switch (strtolower($locale)) {
            case 'en':
                $text = $this->resumen_en;
                break;
            case 'es':
                $text = $this->resumen;
                break;
            
            default:
                $text =  $this->resumen;
                break;
        }

        if(strlen($text) > 160)
        {
            $lastspc = strpos($text, " ",160);
            $text = substr($text,0,$lastspc)."...";
        }  

          return $text;
            
        
    }

    /**
     * Get Translated All Resumen 
     *
     * @return string
     */
    public function getTransAllResumen($locale)
    {
        $text = null;
        switch (strtolower($locale)) {
            case 'en':
                $text = $this->resumen_en;
                break;
            case 'es':
                $text = $this->resumen;
                break;
            
            default:
                $text =  $this->resumen;
                break;
        }

        return $text;
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Cartel
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set resumen
     *
     * @param string $resumen
     *
     * @return Cartel
     */
    public function setResumen($resumen)
    {
        $this->resumen = $resumen;

        return $this;
    }

    /**
     * Get resumen
     *
     * @return string
     */
    public function getResumen()
    {
        return $this->resumen;
    }

    

        public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    public function getAbsolutePath()
    {
        return null === $this->path
        ? null
        : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
        ? null
        : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads/cartel';
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            @unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // haz lo que quieras para generar un nombre único
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

     /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }

 /**
     * Set path
     *
     * @param string $path
     *
     * @return Tapa
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set tituloEn
     *
     * @param string $tituloEn
     *
     * @return Cartel
     */
    public function setTituloEn($tituloEn)
    {
        $this->titulo_en = $tituloEn;

        return $this;
    }

    /**
     * Get tituloEn
     *
     * @return string
     */
    public function getTituloEn()
    {
        return $this->titulo_en;
    }

    /**
     * Set resumenEn
     *
     * @param string $resumenEn
     *
     * @return Cartel
     */
    public function setResumenEn($resumenEn)
    {
        $this->resumen_en = $resumenEn;

        return $this;
    }

    /**
     * Get resumenEn
     *
     * @return string
     */
    public function getResumenEn()
    {
        return $this->resumen_en;
    }

    public function getMoreInfo($locale){
         
        $text  = null;
        if(strtolower($locale) == "es")
                $text = $this->resumen;
        if(strtolower($locale) == "en")
                $text = $this->resumen_en;
         
        if(strlen($text) > 160)
        {
            $lastspc = strpos($text, " ",160);
            $text = substr($text,$lastspc);
            

          return $text;
            
        }

        return null;
    }
}
