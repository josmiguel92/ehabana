<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Imagen;
use AppBundle\Form\ImagenType;

/**
 * Imagen controller.
 *
 * @Route("/dash/imagen")
 */
class ImagenController extends Controller
{
    /**
     * Lists all Imagen entities.
     *
     * @Route("/", name="dash_imagen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imagens = $em->getRepository('AppBundle:Imagen')->findAll();

        return $this->render('imagen/index.html.twig', array(
            'imagens' => $imagens,
            'page'=>"galery",
        ));
    }

    /**
     * Creates a new Imagen entity.
     *
     * @Route("/new", name="dash_imagen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imagen = new Imagen();
        $form = $this->createForm('AppBundle\Form\ImagenType', $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagen);
            $em->flush();

            return $this->redirectToRoute('dash_imagen_show', array('id' => $imagen->getId()));
        }

        return $this->render('imagen/new.html.twig', array(
            'imagen' => $imagen,
            'form' => $form->createView(),
            'page'=>"galery",
        ));
    }

    /**
     * Finds and displays a Imagen entity.
     *
     * @Route("/{id}", name="dash_imagen_show")
     * @Method("GET")
     */
    public function showAction(Imagen $imagen)
    {
        $deleteForm = $this->createDeleteForm($imagen);

        return $this->render('imagen/show.html.twig', array(
            'imagen' => $imagen,
            'delete_form' => $deleteForm->createView(),
            'page'=>"galery",
        ));
    }

    /**
     * Displays a form to edit an existing Imagen entity.
     *
     * @Route("/{id}/edit", name="dash_imagen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Imagen $imagen)
    {
        $deleteForm = $this->createDeleteForm($imagen);
        $editForm = $this->createForm('AppBundle\Form\ImagenType', $imagen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagen);
            $em->flush();

            return $this->redirectToRoute('dash_imagen_edit', array('id' => $imagen->getId()));
        }

        $image = $editForm->getData()->getWebPath();
        //var_dump($editForm);
        return $this->render('imagen/edit.html.twig', array(
            'imagen' => $imagen,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page'=>"galery",
            'image'=> $image,
        ));
    }

    /**
     * Deletes a Imagen entity.
     *
     * @Route("/{id}/edit", name="dash_imagen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Imagen $imagen)
    {
        $form = $this->createDeleteForm($imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imagen);
            $em->flush();
        }

        return $this->redirectToRoute('dash_imagen_index');
    }

    /**
     * Creates a form to delete a Imagen entity.
     *
     * @param Imagen $imagen The Imagen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Imagen $imagen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_imagen_delete', array('id' => $imagen->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
