<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\TrenBundle\Entity\TrenDisponibilidad;
use Andean\TrenBundle\Entity\TrenHorario;
use Andean\BackendBundle\Form\TrenDisponibilidadType;

use Andean\TrenBundle\Util\Util;

/**
 * TrenDisponibilidad controller.
 *
 */
class TrenDisponibilidadController extends Controller
{
    /**
     * Lists all TrenDisponibilidad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TrenBundle:TrenHorario')->findAll();

        return $this->render('BackendBundle:TrenDisponibilidad:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function calendarAction($id, $month = null, $year = null) {

      $em = $this->getDoctrine()->getManager();

      $entity = $em->getRepository('TrenBundle:TrenHorario')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('No se ha encontrado el calendario para este horario.');
      }

      if(is_null($month)) $month = date('m');
      if(is_null($year)) $year = date('Y');
      
      $calendar = Util::myCalendar('tren', $month, $year, $entity, $em);
      
      $this->get('session')->setFlash('info',
        'Dale click a cada día del calendario para poder editar su disponibilidad.'
      );
      
      return $this->render('BackendBundle:TrenDisponibilidad:calendar.html.twig', array(
        'entity' => $entity,
        'month' => $month,
        'year' => $year,
        'month_name' => date('F', mktime(0, 0, 0, $month, 1, $year)),
        'calendar' => $calendar,
      ));
    }
    
    public function updateAction() {
      
        $em = $this->getDoctrine()->getManager();
        
        $peticion = $this->getRequest();
        
        $prop = $peticion->request->get('id');
        $espacios = $peticion->request->get('value');
        
        $prop = explode('_', $prop);
        
        $fecha = date('Y-m-d', strtotime($prop['1']));
        
        $id = $prop['2'];
        
        $horario = $em->getRepository('TrenBundle:TrenHorario')->find($id);

        if (!$horario) {
            throw $this->createNotFoundException('No se pudo guardar debido a un error. Por favor intenta otra vez.');
        }
        
        $endb = $em->getRepository('TrenBundle:TrenDisponibilidad')->findDisponibilidad($horario, $fecha);
        if(is_null($endb)) {
          $disponibilidad = new TrenDisponibilidad();
          $disponibilidad->setHorario($horario);
          $disponibilidad->setFecha($fecha);
          $disponibilidad->setEspacios($espacios);
          $em->persist($disponibilidad);
          $em->flush();
        } else {
          $em->getRepository('TrenBundle:TrenDisponibilidad')->updateEspacios($horario, $fecha, $espacios);
        }      

        return $this->render('BackendBundle:TrenDisponibilidad:spaces.html.twig', array(
            'espacios' => $espacios
        ));

    }
}
