<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Evento.php';

/**
 * Description of EventoService
 *
 * @author michele
 */
class EventoService
{
  public function creaNuovoEvento($data)
  {
    $evento = new Evento();
    $evento->fromArray($data);
    $evento->save();

    mail('admin@example.com',
         "nuovo evento: ".$evento->getTitolo(),
         "Ciao, \n è stato pubblicato un nuovo evento");
    }

}

?>
