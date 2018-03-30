<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Config;
use AppBundle\Entity\Category;

class DashController extends Controller
{
    /**
     * @Route("/dash/", name="dash_home")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository("AppBundle:Config")->findAll();
        
        return $this->render('AppBundle:Dash:index.html.twig', array(
            'config'=>$config,
            'page'=>"home",
        ));
    }

    /**
     * @Route("/dash/comida", name="dash_comida_index")
     */
    public function comidaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tapas = $em->getRepository("AppBundle:Tapa")->findAll();
        $daily = $em->getRepository("AppBundle:Daily")->findAll();
        
        return $this->render('AppBundle:Dash:comida.html.twig', array(
            'tapas'=>$tapas,
            'daily'=>$daily,
            'page'=>"comida",
        ));
    }

    /**
     * @Route("/dash/init/", name="dash_init_config")
     */
    public function initAction()
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository("AppBundle:Config")->findAll();
        $msg = null;
        var_dump($config);
      //  if(!$config)//No existe confg previa... inicializar
      //  {

            $entities =[
                new Config("header.title", "Bienvenidos al Restaurante-Bar Elizalde"),
                new Config("drinks.text", "Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts."),
                new Config("we.history", "Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", "HISTORIA EN INGLES"),
                new Config("contact.email", "info@restauranteelizaldehabana.com", "info@restauranteelizaldehabana.com"),
                new Config("contact.horario", "12pm-12am"),
                //new Config("hashtags", "ElizaldeHabana"),
                new Category("Vinos", "Wine"),
                new Category("Ron", "Rum"),
                new Category("Jugos", "Juice"),
                new Category("Cocteles", "Cocktail"),

                ];

            foreach ($entities as $value) {
                $em->persist($value);
            }
            $em->flush();
            $msg = "Parece que todo fué bien";

     //   }
     //   else{
     //       $msg = "Ya la configuración fue inicializada previamente. Nada que hacer por aquí :)";
     //   }
        return $this->render('AppBundle:Dash:init.html.twig', array(
            "message" => $msg,
            // ...
        ));
    }

}
