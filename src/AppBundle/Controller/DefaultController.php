<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Opinion as Opinion;
use AppBundle\Entity\Imagen as Imagen;
use AppBundle\Entity\Reserva as Reserva;
use AppBundle\Entity\Suscripcion as Suscripcion;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;

class DefaultController extends Controller
{
    private $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: web@restauranteelizaldehabana.com\r\nReply-To: elizaldebarrestaurante@gmail.com\r\n";
    /**
     * @Route("/{_locale}", defaults={"_locale": "es"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="homepage")
     */
    public function indexAction(Request $request, $_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $carteles = $em->getRepository('AppBundle:Cartel')
        ->createQueryBuilder("c")
        ->orderBy("c.id", "DESC")
        ->getQuery()->getResult();
        
        $tapas = $em->getRepository('AppBundle:Tapa')->findAll();
        $personas = $em->getRepository('AppBundle:Persona')->findAll();
        $daily = $em->getRepository('AppBundle:Daily')->findAll();
        $images = $em->getRepository('AppBundle:Imagen')->findByActive(true);
        $allQuestions = $em->getRepository('AppBundle:Pregunta')
            ->createQueryBuilder("c")->orderBy("c.id", "ASC")
            ->getQuery()->getResult();
        $pregunta = $allQuestions[rand(0, count($allQuestions)-1)];
        $drinkscat = $em->getRepository('AppBundle:Category')
        ->createQueryBuilder('k')
        ->orderBy('k.position', 'ASC')
        ->getQuery()->getResult();

        $config_ = $em->getRepository('AppBundle:Config')->findAll();
        
        $config = [];
        foreach ($config_ as $key => $value) {
            $config[$value->getName()]['es'] = $value->getValueEs();
            $config[$value->getName()]['en'] = $value->getValueEn();
        }
        return $this->render('default/home.html.twig', [
            "carteles"=>$carteles,
            "tapas"=>$tapas,
            "config" => $config,
            "categories" => $drinkscat,
            "personas"=>$personas,
            'daily'=>$daily,
            'images'=>$images,
            'pregunta'=>$pregunta,
            "locale" => $_locale,
            'inputhidden' => [uniqid(), date("Ymd")]
            ]);
    }

    /**
     * @Route("/alternate/{_locale}", defaults={"_locale": "es"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="homepage_")
     */
    public function _indexAction(Request $request, $_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $carteles = $em->getRepository('AppBundle:Cartel')
            ->createQueryBuilder("c")
            ->orderBy("c.id", "DESC")
            ->getQuery()->getResult();

        $tapas = $em->getRepository('AppBundle:Tapa')->findAll();
        $personas = $em->getRepository('AppBundle:Persona')->findAll();
        $daily = $em->getRepository('AppBundle:Daily')->findAll();
        $images = $em->getRepository('AppBundle:Imagen')->findByActive(true);
        $allQuestions = $em->getRepository('AppBundle:Pregunta')
            ->createQueryBuilder("c")->orderBy("c.id", "ASC")
            ->getQuery()->getResult();
        $pregunta = $allQuestions[rand(0, count($allQuestions)-1)];
        $drinkscat = $em->getRepository('AppBundle:Category')
            ->createQueryBuilder('k')
            ->orderBy('k.position', 'ASC')
            ->getQuery()->getResult();

        $config_ = $em->getRepository('AppBundle:Config')->findAll();

        $config = [];
        foreach ($config_ as $key => $value) {
            $config[$value->getName()]['es'] = $value->getValueEs();
            $config[$value->getName()]['en'] = $value->getValueEn();
        }

        $bookingsDays = array();

        for ($i=0; $i<6; $i++){
            $date = new \DateTime("today + $i days");
            $bookingsDays[] = ['label' => $date->format('d/M'),
                            'value' => $date->format('d/M/Y')];
        }
        return $this->render('@App/Front/index.html.twig', [
            "carteles"=>$carteles,
            "tapas"=>$tapas,
            "config" => $config,
            "categories" => $drinkscat,
            "personas"=>$personas,
            'daily'=>$daily,
            'images'=>$images,
            'pregunta'=>$pregunta,
            "locale" => $_locale,
            'inputhidden' => [uniqid(), date("Ymd")],
            'bookingsDays' => $bookingsDays
        ]);
    }

    /**
     * @Route("/{_locale}/confirmreservation/{token}", defaults={"_locale": "es"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="confirmreservation")
     * @Method({"GET"})
     */

    public function confirmreservationAction(Request $request, $token,  $_locale){
        $em = $this->getDoctrine()->getManager();
        $reserva = $em->getRepository("AppBundle:Reserva")->findOneByToken($token);

        $reserva->setConfirmado(true);
        $em->persist($reserva);
        $em->flush();

        $fb = $em->getRepository('AppBundle:Config')->findByName("social.fb");
        $tripadv = $em->getRepository('AppBundle:Config')->findByName("social.tripadvisor");

        return $this->render("default/confirmreservation.html.twig", array(
            "fb" => $fb[0],
            "tripadv" => $tripadv[0],
            "locale" => $_locale
        ));
    }
    /**
     * @Route("/{_locale}/send_booking", defaults={"_locale": "es"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="send_booking")
     * @Method({"POST"})
     */
    public function bookingAction(Request $request, $_locale)
    {
        $form["name"] = $request->get("inputName");
        $form["email"] = $request->get("inputEmail");
        $form["inputDate"] = $request->get("inputDate");
        $form["inputTime"] = $request->get("inputTime");
        $form["inputComensales"] = $request->get("inputComensales");
        $form["inputMessage"] = $request->get("inputMessage");

        $questionId = $request->get("inputhidden");
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository("AppBundle:Pregunta")->find($questionId);

        if ($question->getTransAnswer($_locale) != $request->get("answer"))
            return $this->render("default/LogMessage.html.twig", array("message" => "No se pudo procesar su petición... Sabes, " . $question->getPregunta()));


        $reserva = new Reserva();
        $reserva->setNombre($form["name"])
            ->setEmail($form["email"])
            ->setDatereserva(new \DateTime($form["inputDate"] . " " . $form["inputTime"]))
            ->setPersonas($form["inputComensales"])
            ->setMensaje($form["inputMessage"]);
        $em->persist($reserva);
        $em->flush();

            //send mail to administration for make reservation
        mail("elizaldebarrestaurante@gmail.com",
            $reserva->getId(). "- Reservación mediante la Web ElizaldeHabana",
            $this->renderView("emails/ReservaNotificacion.txt.twig", array(
                "nombre" => $form["name"],
                "email" => $form["email"],
                "message" => $form["inputMessage"],
                "date" => $form["inputDate"],
                "time" => $form["inputTime"],
                    "comensales" => $form["inputComensales"],
                    "reserva" => $reserva)
            ),
           $this->headers.'CC: josmiguel92@gmail.com'
        );

        //send mail to client for confirm reservation
        $subject = $_locale == 'es' ? "Confirme su reservación en Restaurante Elizalde" : "Confirming reservation in ElizaldeHabana Restaurant";
        mail($form["email"], $subject, 
            $this->renderView("emails/ReservationClientNotification.html.twig", array(
                "subject" => $subject,
                "nombre" => $form["name"],
                "date" => $form["inputDate"],
                "time" => $form["inputTime"],
                "persons" => $form["inputComensales"],
                "reserva" => $reserva
                ))
            , $this->headers);


        $fb = $em->getRepository('AppBundle:Config')->findByName("social.fb");
        $tripadv = $em->getRepository('AppBundle:Config')->findByName("social.tripadvisor");
        return $this->render("default/booking.html.twig", array(
            "fb" => $fb[0],
            "tripadv" => $tripadv[0],
            "locale" => $_locale
        ));

    }


    /**
     * @Route("/{_locale}/send_opinion", defaults={"_locale": "es"}, requirements={
     * "_locale": "en|es|fr"
     * }, name="send_opinion")
     * @Method({"POST"})
     */
    public function opinionAction(Request $request, $_locale)
    {
        $form["name"] = $request->get("inputName");
        $form["email"] = $request->get("inputEmail");
        $form["inputDate"] = $request->get("inputDate");
        $form["inputTime"] = $request->get("inputTime");
        $form["inputMessage"] = $request->get("inputMessage");

        $questionId = $request->get("inputhidden");
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository("AppBundle:Pregunta")->find($questionId);

        if ($question->getTransAnswer($_locale) != $request->get("answer"))
            return $this->render("default/LogMessage.html.twig", array("message" => "No se pudo procesar su petición... Sabes, " . $question->getPregunta()));

        $uploadedFile = null;
        $_photo = null;
        if ($_FILES['inputPhoto']['size'] != 0 and Utils::isImage($_FILES['inputPhoto']['type'])) {
            $_photo = new Imagen();
            $uploadedFile = new \Symfony\Component\HttpFoundation\File\UploadedFile(
                $_FILES['inputPhoto']['tmp_name'],
                $_FILES['inputPhoto']['name']);

            $_photo = new Imagen();
            $_photo->setNombre("Imagen subida por un usuario")
                ->setNombreEn("User Photo on " . $form["inputDate"])
                ->setDetalles($form["inputMessage"])
                ->setDetallesEn($form["inputMessage"]);


            $_photo->setFile($uploadedFile);

        }

        //var_dump($uploadedFile);

        $opinion = new Opinion();
        $opinion->setName($form["name"])
        ->setEmail($form["email"])
        ->setInputDate($form["inputDate"])
        ->setInputTime($form["inputTime"])
        ->setInputMessage($form["inputMessage"]);
        $em = $this->getDoctrine()->getManager();

        if($opinion->getEmail() and $opinion->getInputMessage())
        {
            $em->persist($opinion);
            if ($_photo)
                $em->persist($_photo);
            $em->flush();

            mail("elizaldebarrestaurante@gmail.com",
                "Nueva Opinion en la Web ElizaldeHabana",
                $this->renderView("emails/OpinionNotificacion.txt.twig", array(
                    "nombre"=>$form["name"],
                    "email" => $form["email"],
                    "message"=>$form["inputMessage"],
                    "date"=>$form["inputDate"],
                    "time" => $form["inputTime"],
                    "photo" => $_photo))                
                );

            $fb = $em->getRepository('AppBundle:Config')->findByName("social.fb");
            $tripadv = $em->getRepository('AppBundle:Config')->findByName("social.tripadvisor");
            return $this->render("default/message.html.twig", array(
                "fb"=>$fb[0],
                "tripadv" => $tripadv[0],
                "locale"=>$_locale
                ));
        }
        else
            return new RedirectResponse("homepage");

    }

     /**
     * @Route("/getcontact", name="getcontact")
     * @Method({"POST"})
     */
     public function getContactAction(Request $request)
    {
        $form["name"] = $request->get("inputName");
        $form["email"] = $request->get("inputEmail");
        $hidden0 = $request->get("inputhidden0");
        $hidden1 = $request->get("inputhidden1");

        if ($hidden0 == $hidden1 and substr_count($hidden1, date("Ymd"))) {
            if ($form["email"] && $form["name"] && substr_count($form["email"], "@")) {
                $Suscripcion = new Suscripcion();
                $Suscripcion->setNombre($form["name"])
                    ->setEmail($form["email"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($Suscripcion);
                try {
                    $em->flush();
                } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                    return $this->render("default/LogMessage.html.twig", array("message" => "No se pudo procesar su petición, es probable que ya su email esté registrado."));
                }


                @mail("elizaldebarrestaurante@gmail.com",
                    "Nueva Suscripcion en la Web ElizaldeHabana",
                    $this->renderView("emails/SuscripcionNotificacion.txt.twig", array("nombre" => $form["name"],
                            "email" => $form["email"])
                    )
                );

                $fb = $em->getRepository('AppBundle:Config')->findByName("social.fb");
                $tripadv = $em->getRepository('AppBundle:Config')->findByName("social.tripadvisor");
                return $this->render("default/Suscripcion.html.twig", array("fb" => $fb[0], "tripadv" => $tripadv[0]));

            }

        }

        return new RedirectResponse("/");
        
   }

    /**
    * @Route("/tripadvisor", name="tripadvisor_redirect")
    * @Method({"GET"})
    */
    public function gotoTripadvisorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository('AppBundle:Config')->findOneByName("social.tripadvisor");

        return new RedirectResponse($config->getValueEs());
    }
}
