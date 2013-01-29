<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\HotelBundle\Entity\HotelDisponibilidad;
use Andean\HotelBundle\Entity\HotelHabitacion;
use Andean\BackendBundle\Form\HotelDisponibilidadType;

use Andean\TrenBundle\Util\Util;

/**
 * HotelDisponibilidad controller.
 *
 */
class HotelDisponibilidadController extends Controller
{
    /**
     * Lists all HotelDisponibilidad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HotelBundle:HotelHabitacion')->findAll();

        return $this->render('BackendBundle:HotelDisponibilidad:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function calendarAction($id, $month = null, $year = null) {

      $em = $this->getDoctrine()->getManager();

      $entity = $em->getRepository('HotelBundle:HotelHabitacion')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('No se ha encontrado el calendario para esta habitación.');
      }

      if(is_null($month)) $month = date('m');
      if(is_null($year)) $year = date('Y');
      
      $calendar = Util::myCalendar('hotel', $month, $year, $entity, $em);
      
      $this->get('session')->setFlash('info',
        'Dale click a cada día del calendario para poder editar su disponibilidad.'
      );
      
      return $this->render('BackendBundle:HotelDisponibilidad:calendar.html.twig', array(
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
        
        $habitacion = $em->getRepository('HotelBundle:HotelHabitacion')->find($id);

        if (!$habitacion) {
            throw $this->createNotFoundException('No se pudo guardar debido a un error. Por favor intenta otra vez.');
        }
        
        $endb = $em->getRepository('HotelBundle:HotelDisponibilidad')->findDisponibilidad($habitacion, $fecha);
        if(is_null($endb)) {
          $disponibilidad = new HotelDisponibilidad();
          $disponibilidad->setHabitacion($habitacion);
          $disponibilidad->setFecha($fecha);
          $disponibilidad->setEspacios($espacios);
          $em->persist($disponibilidad);
          $em->flush();
        } else {
          $em->getRepository('HotelBundle:HotelDisponibilidad')->updateEspacios($habitacion, $fecha, $espacios);
        }      

        return $this->render('BackendBundle:HotelDisponibilidad:spaces.html.twig', array(
            'espacios' => $espacios
        ));
    }
}
