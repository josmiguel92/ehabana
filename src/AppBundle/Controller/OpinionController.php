<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Opinion;

/**
 * Opinion controller.
 *
 * @Route("/dash/opinion")
 */
class OpinionController extends Controller
{
    /**
     * Lists all Opinion entities.
     *
     * @Route("/", name="dash_opinion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $opinions = $em->getRepository('AppBundle:Opinion')->findAll();

        return $this->render('opinion/index.html.twig', array(
            'opinions' => $opinions,
            'page'=>"opinion",
        ));
    }

    /**
     * Finds and displays a Opinion entity.
     *
     * @Route("/{id}", name="dash_opinion_show")
     * @Method("GET")
     */
    public function showAction(Opinion $opinion)
    {

        return $this->render('opinion/show.html.twig', array(
            'opinion' => $opinion,
            'page'=>"opinion",
        ));
    }
}
