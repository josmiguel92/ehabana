<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tapa;
use AppBundle\Form\TapaType;

/**
 * Tapa controller.
 *
 * @Route("/dash/tapa")
 */
class TapaController extends Controller
{
    /**
     * Lists all Tapa entities.
     *
     * @Route("/", name="dash_tapa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tapas = $em->getRepository('AppBundle:Tapa')->findAll();

        return $this->render('tapa/index.html.twig', array(
            'tapas' => $tapas,
            'page'=>"comida",
        ));
    }

    /**
     * Creates a new Tapa entity.
     *
     * @Route("/new", name="dash_tapa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tapa = new Tapa();
        $form = $this->createForm('AppBundle\Form\TapaType', $tapa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tapa);
            $em->flush();

            return $this->redirectToRoute('dash_tapa_show', array('id' => $tapa->getId()));
        }

        return $this->render('tapa/new.html.twig', array(
            'tapa' => $tapa,
            'form' => $form->createView(),

            'page'=>"comida",
        ));
    }

    /**
     * Finds and displays a Tapa entity.
     *
     * @Route("/{id}", name="dash_tapa_show")
     * @Method("GET")
     */
    public function showAction(Tapa $tapa)
    {
        $deleteForm = $this->createDeleteForm($tapa);

        return $this->render('tapa/show.html.twig', array(
            'tapa' => $tapa,
            'delete_form' => $deleteForm->createView(),
            'page'=>"comida",
        ));
    }

    /**
     * Displays a form to edit an existing Tapa entity.
     *
     * @Route("/{id}/edit", name="dash_tapa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tapa $tapa)
    {
        $deleteForm = $this->createDeleteForm($tapa);
        $editForm = $this->createForm('AppBundle\Form\TapaType', $tapa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tapa);
            $em->flush();

            return $this->redirectToRoute('dash_tapa_edit', array('id' => $tapa->getId()));
        }

        return $this->render('tapa/edit.html.twig', array(
            'tapa' => $tapa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"comida",
        ));
    }

    /**
     * Deletes a Tapa entity.
     *
     * @Route("/{id}", name="dash_tapa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tapa $tapa)
    {
        $form = $this->createDeleteForm($tapa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tapa);
            $em->flush();
        }

        return $this->redirectToRoute('dash_tapa_index');
    }

    /**
     * Creates a form to delete a Tapa entity.
     *
     * @param Tapa $tapa The Tapa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tapa $tapa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_tapa_delete', array('id' => $tapa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
