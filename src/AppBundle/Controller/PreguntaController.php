<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Pregunta;
use AppBundle\Form\PreguntaType;

/**
 * Pregunta controller.
 *
 * @Route("/dash/pregunta")
 */
class PreguntaController extends Controller
{
    /**
     * Lists all Pregunta entities.
     *
     * @Route("/", name="dash_pregunta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $preguntas = $em->getRepository('AppBundle:Pregunta')->findAll();

        return $this->render('pregunta/index.html.twig', array(
            'preguntas' => $preguntas,
            'page'=>"preguntas",
        ));
    }

    /**
     * Creates a new Pregunta entity.
     *
     * @Route("/new", name="dash_pregunta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $preguntum = new Pregunta();
        $form = $this->createForm('AppBundle\Form\PreguntaType', $preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();

            return $this->redirectToRoute('dash_pregunta_show', array('id' => $preguntum->getId()));
        }

        return $this->render('pregunta/new.html.twig', array(
            'preguntum' => $preguntum,
            'form' => $form->createView(),
            'page'=>"preguntas",
        ));
    }

    /**
     * Finds and displays a Pregunta entity.
     *
     * @Route("/{id}", name="dash_pregunta_show")
     * @Method("GET")
     */
    public function showAction(Pregunta $preguntum)
    {
        $deleteForm = $this->createDeleteForm($preguntum);

        return $this->render('pregunta/show.html.twig', array(
            'preguntum' => $preguntum,
            'delete_form' => $deleteForm->createView(),
            'page'=>"preguntas",
        ));
    }

    /**
     * Displays a form to edit an existing Pregunta entity.
     *
     * @Route("/{id}/edit", name="dash_pregunta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pregunta $preguntum)
    {
        $deleteForm = $this->createDeleteForm($preguntum);
        $editForm = $this->createForm('AppBundle\Form\PreguntaType', $preguntum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();

            return $this->redirectToRoute('dash_pregunta_edit', array('id' => $preguntum->getId()));
        }

        return $this->render('pregunta/edit.html.twig', array(
            'preguntum' => $preguntum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"preguntas",
        ));
    }

    /**
     * Deletes a Pregunta entity.
     *
     * @Route("/{id}", name="dash_pregunta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pregunta $preguntum)
    {
        $form = $this->createDeleteForm($preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($preguntum);
            $em->flush();
        }

        return $this->redirectToRoute('dash_pregunta_index');
    }

    /**
     * Creates a form to delete a Pregunta entity.
     *
     * @param Pregunta $preguntum The Pregunta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pregunta $preguntum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_pregunta_delete', array('id' => $preguntum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
