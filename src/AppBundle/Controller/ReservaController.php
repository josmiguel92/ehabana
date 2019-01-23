<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Reserva;
use AppBundle\Form\ReservaType;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Reserva controller.
 *
 * @Route("/dash/reserva")
 */
class ReservaController extends Controller
{
    /**
     * Lists all Reserva entities.
     *
     * @Route("/", name="dash_reserva_index")
     * @Method("GET")
     */
    public function monthAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservas = $em->getRepository('AppBundle:Reserva')
            ->createQueryBuilder("b")
            ->where("b.datereserva > :yesterday")
            ->andWhere("b.datereserva < :nextmonth")
            ->setParameter("yesterday", new \DateTime('yesterday'))
            ->setParameter("nextmonth", new \DateTime('today + 1 month'))
            ->orderBy("b.datereserva", "ASC")
            ->getQuery()->getResult();

        return $this->render('reserva/month.html.twig', array(
            'reservas' => $reservas,
        ));
    }

    /**
     * Lists all Reserva entities.
     *
     * @Route("/all", name="dash_reserva_all")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservas = $em->getRepository('AppBundle:Reserva')->findAll();

        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
        ));
    }

    /**
     * Lists all Reserva entities.
     *
     * @Route("/pendientes", name="dash_reserva_pendientes")
     * @Method("GET")
     */
    public function pendientesAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$reservas = $em->getRepository('AppBundle:Reserva')->findByReservado(false);
//->findAll();//
        $query = $em->createQuery(
            "SELECT r FROM AppBundle:Reserva r WHERE
              r.datereserva > :ayer and r.reservado = FALSE
              ORDER BY r.datereserva ASC"
        )->setParameter('ayer', new \DateTime('yesterday'));

        $reservas = $query->getResult();
        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
        ));
    }


    /**
     * Lists all pasadas Reserva entities.
     *
     * @Route("/pasadas", name="dash_reserva_pasadas")
     * @Method("GET")
     */
    public function pasadasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT r FROM AppBundle:Reserva r WHERE
              r.datereserva < :hoy ORDER BY r.datereserva ASC"
        )->setParameter('hoy', new \DateTime('today'));

        $reservas = $query->getResult();
        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
        ));
    }

    /**
     * Creates a new Reserva entity.
     *
     * @Route("/new", name="dash_reserva_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reserva = new Reserva();
        $form = $this->createForm('AppBundle\Form\ReservaType', $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reserva);
            $em->flush();

            return $this->redirectToRoute('dash_reserva_show', array('id' => $reserva->getId()));
        }

        return $this->render('reserva/new.html.twig', array(
            'reserva' => $reserva,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reserva entity.
     *
     * @Route("/{id}", name="dash_reserva_show")
     * @Method("GET")
     */
    public function showAction(Reserva $reserva)
    {
        $deleteForm = $this->createDeleteForm($reserva);

        return $this->render('reserva/show.html.twig', array(
            'reserva' => $reserva,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Mark as reserved a reserve and displays a Reserva list
     *
     * @Route("/reserve/{id}", name="dash_reserva_reserve")
     * @Method("GET")
     */
    public function reservedAction(Reserva $reserva)
    {
        $reserva->setReservado(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($reserva);
        $em->flush();

        return new RedirectResponse($this->generateUrl('dash_reserva_index'));
    }



    /**
     * Displays a form to edit an existing Reserva entity.
     *
     * @Route("/{id}/edit", name="dash_reserva_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reserva $reserva)
    {
        $deleteForm = $this->createDeleteForm($reserva);
        $editForm = $this->createForm('AppBundle\Form\ReservaType', $reserva);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reserva);
            $em->flush();

            return $this->redirectToRoute('dash_reserva_edit', array('id' => $reserva->getId()));
        }

        return $this->render('reserva/edit.html.twig', array(
            'reserva' => $reserva,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Reserva entity.
     *
     * @Route("/{id}", name="dash_reserva_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reserva $reserva)
    {
        $form = $this->createDeleteForm($reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reserva);
            $em->flush();
        }

        return $this->redirectToRoute('dash_reserva_index');
    }

    /**
     * Creates a form to delete a Reserva entity.
     *
     * @param Reserva $reserva The Reserva entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reserva $reserva)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dash_reserva_delete', array('id' => $reserva->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
