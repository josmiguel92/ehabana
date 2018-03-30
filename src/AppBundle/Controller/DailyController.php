<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Daily;
use AppBundle\Form\DailyType;

/**
 * Daily controller.
 *
 * @Route("/dash/daily")
 */
class DailyController extends Controller
{
    /**
     * Lists all Daily entities.
     *
     * @Route("/", name="dash_daily_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dailies = $em->getRepository('AppBundle:Daily')->findAll();

        return $this->render('daily/index.html.twig', array(
            'dailies' => $dailies,
            'page'=>"comida",
        ));
    }

    /**
     * Creates a new Daily entity.
     *
     * @Route("/new", name="dash_daily_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $daily = new Daily();
        $form = $this->createForm('AppBundle\Form\DailyType', $daily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($daily);
            $em->flush();

            return $this->redirectToRoute('dash_daily_show', array('id' => $daily->getId()));
        }

        return $this->render('daily/new.html.twig', array(
            'daily' => $daily,
            'form' => $form->createView(),
            'page'=>"comida",
        ));
    }

    /**
     * Finds and displays a Daily entity.
     *
     * @Route("/{id}", name="dash_daily_show")
     * @Method("GET")
     */
    public function showAction(Daily $daily)
    {
        $deleteForm = $this->createDeleteForm($daily);

        return $this->render('daily/show.html.twig', array(
            'daily' => $daily,
            'delete_form' => $deleteForm->createView(),
            'page'=>"comida",
        ));
    }

    /**
     * Displays a form to edit an existing Daily entity.
     *
     * @Route("/{id}/edit", name="dash_daily_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Daily $daily)
    {
        $deleteForm = $this->createDeleteForm($daily);
        $editForm = $this->createForm('AppBundle\Form\DailyType', $daily);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($daily);
            $em->flush();

            return $this->redirectToRoute('dash_daily_edit', array('id' => $daily->getId()));
        }

        return $this->render('daily/edit.html.twig', array(
            'daily' => $daily,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"comida",
        ));
    }

    /**
     * Deletes a Daily entity.
     *
     * @Route("/{id}", name="dash_daily_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Daily $daily)
    {
        $form = $this->createDeleteForm($daily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($daily);
            $em->flush();
        }

        return $this->redirectToRoute('dash_daily_index');
    }

    /**
     * Creates a form to delete a Daily entity.
     *
     * @param Daily $daily The Daily entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Daily $daily)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_daily_delete', array('id' => $daily->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
