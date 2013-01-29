<?php

namespace Andean\TrenBundle\Util;

class Util
{
    /**
     * Genera el slug de una cadena
     * @param string $cadena
     * @param string $separador
     * @return string
     */
    public static function getSlug($cadena, $separador = '-')
    {
      $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
      $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
      $slug = strtolower(trim($slug, $separador));
      $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);

      return $slug;
    }
    
  /**
   * Genera un calendario HTML.
   * Modificado de http://davidwalsh.name/php-calendar
   * @param string $type
   * @param int $month
   * @param int $year
   * @param Object $entity
   * @param type $em
   * @return string 
   */
  public static function myCalendar($type, $month, $year, $entity, $em = null) {
    
    if($type == "mapi")
      $data = Util::mapiEspacios($month, $year);    

    /* draw table */
    $calendar = '<table class="calendar">';
    $calendar .= '<thead>';

    /* table headings */
    $headings = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
    $calendar .= '<tr class="calendar-row"><th class="calendar-day-head">'.implode('</th><th class="calendar-day-head">',$headings).'</th></tr>';
    
    $calendar .= '</thead><tbody>';

    /* days and weeks vars now ... */
    $running_day = date('w',mktime(0,0,0,$month,1,$year));
    $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();

    /* row for week one */
    $calendar.= '<tr class="calendar-row">';

    /* print "blank" days until the first of the current week */
    for($x = 0; $x < $running_day; $x++):
      $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
      $days_in_this_week++;
    endfor;

    /* keep going with days.... */
    for($list_day = 1; $list_day <= $days_in_month; $list_day++):
      
      
      /*$fecha  = new \DateTime('now');
      $fecha->setDate($year, $month, $list_day);
      $fecha->setTime(0, 0, 0);*/
      
      $fecha = sprintf('%s-%s-%s', $year, $month, $list_day);
    
      switch($type) {
        case 'tren':
          $espacios = $em->getRepository('TrenBundle:TrenDisponibilidad')->findDisponibilidad($entity, $fecha);
          if(count($espacios) == 0)
            $espacios = 'Sin información';
          break;
        case 'hotel':
          $espacios = $em->getRepository('HotelBundle:HotelDisponibilidad')->findDisponibilidad($entity, $fecha);
          if(count($espacios) == 0)
            $espacios = 'Sin información';
          break;
        case 'mapi':
          $espacios = $data->fechas[$list_day];
          if(!$espacios)
            $espacios = 'Sin información';
          break;
        default:
      }
      
      $calendar.= '<td class="calendar-day">';
        /* add in the day number */
        $calendar.= '<div class="day-number">'.$list_day.'</div>';

        /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
        //$calendar.= str_repeat('<p>&nbsp;</p>',2);
        $calendar.= sprintf('<p class="editable" id="day_%s-%s-%s_%s">%s</p>',$list_day, $month, $year, $entity, $espacios);

      $calendar.= '</td>';
      if($running_day == 6):
        $calendar.= '</tr>';
        if(($day_counter+1) != $days_in_month):
          $calendar.= '<tr class="calendar-row">';
        endif;
        $running_day = -1;
        $days_in_this_week = 0;
      endif;
      $days_in_this_week++; $running_day++; $day_counter++;
    endfor;

    /* finish the rest of the days in the week */
    if($days_in_this_week < 8):
      for($x = 1; $x <= (8 - $days_in_this_week); $x++):
        $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
      endfor;
    endif;

    /* final row */
    $calendar.= '</tr></tbody>';

    /* end the table */
    $calendar.= '</table>';

    /* all done, return result */
    return $calendar;
  }
  
  public static function mapiEspacios($month, $year) {
    $url = sprintf('http://www.machupicchu.gob.pe/rpt/DisponibilidadPorMes.cfm?idLugar=1&mes=%s&ano=%s&formatoImpresion=xml', $month, $year);
    $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
    $data = new \stdClass();
    $data->actualizado = (string)$xml->page->text[2]->textContent;
    $data->fechas = array();
    
    for($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $i++) {
      $k = (2*$i)-1;
      $data->fechas[$i] = (string)$xml->page->text[(6 + $k)]->textContent;
    }
    
    return $data;
  }
  
  public static function mapiEspacioDia($day, $month, $year) {
    $data = Util::mapiEspacios($month, $year);
    return $data->fechas[$day];
  }
  
  public static function mapiEspacioActualizacion($month, $year) {
    $data = Util::mapiEspacios($month, $year);
    return $data->actualizado;
  }
}