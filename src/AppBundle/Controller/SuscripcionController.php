<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Suscripcion;
use AppBundle\Form\SuscripcionType;

/**
 * Suscripcion controller.
 *
 * @Route("/dash/suscripcion")
 */
class SuscripcionController extends Controller
{
    /**
     * Lists all Suscripcion entities.
     *
     * @Route("/", name="dash_suscripcion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suscripcions = $em->getRepository('AppBundle:Suscripcion')->findAll();

        return $this->render('suscripcion/index.html.twig', array(
            'suscripcions' => $suscripcions,
            'page'=>"suscripcion",
        ));
    }

    /**
     * Creates a new Suscripcion entity.
     *
     * @Route("/new", name="dash_suscripcion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $suscripcion = new Suscripcion();
        $form = $this->createForm('AppBundle\Form\SuscripcionType', $suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suscripcion);
            $em->flush();

            return $this->redirectToRoute('dash_suscripcion_show', array('id' => $suscripcion->getId()));
        }

        return $this->render('suscripcion/new.html.twig', array(
            'suscripcion' => $suscripcion,
            'form' => $form->createView(),
            'page'=>"suscripcion",
        ));
    }

    /**
     * Finds and displays a Suscripcion entity.
     *
     * @Route("/{id}", name="dash_suscripcion_show")
     * @Method("GET")
     */
    public function showAction(Suscripcion $suscripcion)
    {
        $deleteForm = $this->createDeleteForm($suscripcion);

        return $this->render('suscripcion/show.html.twig', array(
            'suscripcion' => $suscripcion,
            'delete_form' => $deleteForm->createView(),
            'page'=>"suscripcion",
        ));
    }

    /**
     * Displays a form to edit an existing Suscripcion entity.
     *
     * @Route("/{id}/edit", name="dash_suscripcion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Suscripcion $suscripcion)
    {
        $deleteForm = $this->createDeleteForm($suscripcion);
        $editForm = $this->createForm('AppBundle\Form\SuscripcionType', $suscripcion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suscripcion);
            $em->flush();

            return $this->redirectToRoute('dash_suscripcion_edit', array('id' => $suscripcion->getId()));
        }

        return $this->render('suscripcion/edit.html.twig', array(
            'suscripcion' => $suscripcion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"suscripcion",
        ));
    }

    /**
     * Deletes a Suscripcion entity.
     *
     * @Route("/{id}", name="dash_suscripcion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Suscripcion $suscripcion)
    {
        $form = $this->createDeleteForm($suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($suscripcion);
            $em->flush();
        }

        return $this->redirectToRoute('dash_suscripcion_index');
    }

    /**
     * Creates a form to delete a Suscripcion entity.
     *
     * @param Suscripcion $suscripcion The Suscripcion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Suscripcion $suscripcion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_suscripcion_delete', array('id' => $suscripcion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
