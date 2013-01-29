<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\TrenBundle\Util\Util;

/**
 * Mapi controller.
 *
 */
class MapiController extends Controller
{

    public function calendarAction($month = null, $year = null) {

      if(is_null($month)) $month = date('m');
      if(is_null($year)) $year = date('Y');
      
      $calendar = Util::myCalendar('mapi', $month, $year, null, null);
      
      return $this->render('BackendBundle:Mapi:calendar.html.twig', array(
        'month' => $month,
        'year' => $year,
        'month_name' => date('F', mktime(0, 0, 0, $month, 1, $year)),
        'actualizado' => Util::mapiEspacioActualizacion($month, $year),
        'calendar' => $calendar
      ));
    }
}
