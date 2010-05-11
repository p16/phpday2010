<?php

if (isset($_POST['crea_evento']))
{
// secondo caso:
//  $evento_service = new EventoService();
//  $evento->creaNuovoEvento($_POST);

// primo caso:
//    $evento = new Evento();
//    $evento->fromArray($data);
//    $evento->save();
//
//    mail('admin@example.com',
//         "nuovo evento: ".$evento->getTitolo(),
//         "Ciao, \n è stato pubblicato un nuovo evento");
}

header('Location: http://localhost/phpday2010/web/nuovoevento.php');
