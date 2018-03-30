<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Cartel;
use AppBundle\Form\CartelType;

/**
 * Cartel controller.
 *
 * @Route("/dash/cartel")
 */
class CartelController extends Controller
{
    /**
     * Lists all Cartel entities.
     *
     * @Route("/", name="dash_cartel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cartels = $em->getRepository('AppBundle:Cartel')->findAll();

        return $this->render('cartel/index.html.twig', array(
            'cartels' => $cartels,
            'page'=>"carteles",
        ));
    }

    /**
     * Creates a new Cartel entity.
     *
     * @Route("/new", name="dash_cartel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cartel = new Cartel();
        $form = $this->createForm('AppBundle\Form\CartelType', $cartel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cartel);
            $em->flush();

            return $this->redirectToRoute('dash_cartel_show', array('id' => $cartel->getId()));
        }

        return $this->render('cartel/new.html.twig', array(
            'cartel' => $cartel,
            'form' => $form->createView(),
            'page'=>"carteles",
        ));
    }

    /**
     * Finds and displays a Cartel entity.
     *
     * @Route("/{id}", name="dash_cartel_show")
     * @Method("GET")
     */
    public function showAction(Cartel $cartel)
    {
        $deleteForm = $this->createDeleteForm($cartel);

        return $this->render('cartel/show.html.twig', array(
            'cartel' => $cartel,
            'delete_form' => $deleteForm->createView(),
            'page'=>"carteles",
        ));
    }

    /**
     * Displays a form to edit an existing Cartel entity.
     *
     * @Route("/{id}/edit", name="dash_cartel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cartel $cartel)
    {
        $deleteForm = $this->createDeleteForm($cartel);
        $editForm = $this->createForm('AppBundle\Form\CartelType', $cartel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cartel);
            $em->flush();

            return $this->redirectToRoute('dash_cartel_edit', array('id' => $cartel->getId()));
        }

        $image = $editForm->getData()->getWebPath();
        //var_dump($editForm);
        return $this->render('cartel/edit.html.twig', array(
            'cartel' => $cartel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"carteles",
            'image'=>$image,
        ));
    }

    /**
     * Deletes a Cartel entity.
     *
     * @Route("/{id}", name="dash_cartel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cartel $cartel)
    {
        $form = $this->createDeleteForm($cartel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cartel);
            $em->flush();
        }

        return $this->redirectToRoute('dash_cartel_index');
    }

    /**
     * Creates a form to delete a Cartel entity.
     *
     * @param Cartel $cartel The Cartel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cartel $cartel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_cartel_delete', array('id' => $cartel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
