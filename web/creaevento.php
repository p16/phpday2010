<?php

require_once '../lib/EventoService.php';

if (!isset($_POST['crea_evento']))
{
  header('Location: http://localhost/phpday2010/web/nuovoevento.php');
}
// secondo caso:
$evento_s = new EventoService();
$evento_s->creaNuovoEvento($_POST);
$_POST["message"] = "Evento creato con successo!";
header('Location: http://localhost/phpday2010/web/nuovoevento.php');

// primo caso:
//    $evento = new Evento();
//    $evento->fromArray($data);
//    $evento->save();
//
//    mail('admin@example.com',
//         "nuovo evento: ".$evento->getTitolo(),
//         "Ciao, \n è stato pubblicato un nuovo evento");


