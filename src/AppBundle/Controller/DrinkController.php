<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Drink;
use AppBundle\Form\DrinkType;

/**
 * Drink controller.
 *
 * @Route("/dash/drink")
 */
class DrinkController extends Controller
{
    /**
     * Lists all Drink entities.
     *
     * @Route("/", name="dash_drink_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $drinks = $em->getRepository('AppBundle:Drink')->findAll();

        return $this->render('drink/index.html.twig', array(
            'drinks' => $drinks,
            'page'=>"drink",
        ));
    }

    /**
     * Creates a new Drink entity.
     *
     * @Route("/new", name="dash_drink_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $drink = new Drink();
        $form = $this->createForm('AppBundle\Form\DrinkType', $drink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($drink);
            $em->flush();

            return $this->redirectToRoute('dash_drink_show', array('id' => $drink->getId()));
        }

        return $this->render('drink/new.html.twig', array(
            'drink' => $drink,
            'form' => $form->createView(),
            'page'=>"drink",
        ));
    }

    /**
     * Finds and displays a Drink entity.
     *
     * @Route("/{id}", name="dash_drink_show")
     * @Method("GET")
     */
    public function showAction(Drink $drink)
    {
        $deleteForm = $this->createDeleteForm($drink);

        return $this->render('drink/show.html.twig', array(
            'drink' => $drink,
            'delete_form' => $deleteForm->createView(),
            'page'=>"drink",
        ));
    }

    /**
     * Displays a form to edit an existing Drink entity.
     *
     * @Route("/{id}/edit", name="dash_drink_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Drink $drink)
    {
        $deleteForm = $this->createDeleteForm($drink);
        $editForm = $this->createForm('AppBundle\Form\DrinkType', $drink);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($drink);
            $em->flush();

            return $this->redirectToRoute('dash_drink_edit', array('id' => $drink->getId()));
        }

        return $this->render('drink/edit.html.twig', array(
            'drink' => $drink,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"drink",
        ));
    }

    /**
     * Deletes a Drink entity.
     *
     * @Route("/{id}", name="dash_drink_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Drink $drink)
    {
        $form = $this->createDeleteForm($drink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($drink);
            $em->flush();
        }

        return $this->redirectToRoute('dash_drink_index');
    }

    /**
     * Creates a form to delete a Drink entity.
     *
     * @param Drink $drink The Drink entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Drink $drink)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_drink_delete', array('id' => $drink->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
