<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Config;
use AppBundle\Form\ConfigType;

/**
 * Config controller.
 *
 * @Route("/dash/config")
 */
class ConfigController extends Controller
{
    /**
     * Lists all Config entities.
     *
     * @Route("/", name="dash_config_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $configs = $em->getRepository('AppBundle:Config')->findAll();

        return $this->render('config/index.html.twig', array(
            'configs' => $configs,
            'page'=>"config",
        ));
    }

    /**
     * Creates a new Config entity.
     *
     * @Route("/new", name="dash_config_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $config = new Config();
        $form = $this->createForm('AppBundle\Form\ConfigType', $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($config);
            $em->flush();

            return $this->redirectToRoute('dash_config_show', array('id' => $config->getId()));
        }

        return $this->render('config/new.html.twig', array(
            'config' => $config,
            'form' => $form->createView(),
            'page'=>"config",
        ));
    }

    /**
     * Finds and displays a Config entity.
     *
     * @Route("/{id}", name="dash_config_show")
     * @Method("GET")
     */
    public function showAction(Config $config)
    {
        $deleteForm = $this->createDeleteForm($config);

        return $this->render('config/show.html.twig', array(
            'config' => $config,
            'delete_form' => $deleteForm->createView(),
            'page'=>"config",
        ));
    }

    /**
     * Displays a form to edit an existing Config entity.
     *
     * @Route("/{id}/edit", name="dash_config_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Config $config)
    {
        $deleteForm = $this->createDeleteForm($config);
        $editForm = $this->createForm('AppBundle\Form\ConfigType', $config);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($config);
            $em->flush();

            return $this->redirectToRoute('dash_config_edit', array('id' => $config->getId()));
        }

        return $this->render('config/edit.html.twig', array(
            'config' => $config,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"config",
        ));
    }

    /**
     * Deletes a Config entity.
     *
     * @Route("/{id}", name="dash_config_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Config $config)
    {
        $form = $this->createDeleteForm($config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($config);
            $em->flush();
        }

        return $this->redirectToRoute('dash_config_index');
    }

    /**
     * Creates a form to delete a Config entity.
     *
     * @param Config $config The Config entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Config $config)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_config_delete', array('id' => $config->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
