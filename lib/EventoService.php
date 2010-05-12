<?php
require_once 'Evento.php';
require_once dirname(__FILE__).'/../config/ConfigManager.php';
require_once dirname(__FILE__).'/vendor/Swift-4.0.6/lib/swift_required.php';

class EventoService
{
  public function creaNuovoEvento($data, $conn = null, $use_swift = true)
  {
    $evento = new Evento();
    $evento->fromArray($data);
    $evento->save($conn);
    $this->sendMail($evento, $use_swift);
  }

  public function retrieveEventi(PDO $conn, $offset = 0, $limit = 3)
  {
    $offset_string = ($offset == 0) ? '' : ' OFFSET '.$offset;
    $eventi = $conn->query('SELECT *
                            FROM evento
                            WHERE data_fine >= CURRENT_DATE AND data_inizio <= CURRENT_DATE
                            ORDER BY data_fine ASC'.$offset_string.' LIMIT '.$limit);
    $results = array();
    foreach ($eventi as $row)
    {
      $result[] = $row;
    }

    return $result;
  }

  private function sendMail(Evento $evento, $use_swift = true)
  {
    if ($use_swift)
    {
      $this->sendWithSwift('admin@example.com',
                           "nuovo evento: ".$evento->getTitolo(),
                           "Ciao, \n è stato pubblicato un nuovo evento",
                           'webmaster@example.com');
      return;
    }

    $this->sendMailDefault('admin@example.com',
         "nuovo evento: ".$evento->getTitolo(),
         "Ciao, \n è stato pubblicato un nuovo evento",
         'webmaster@example.com');
  }

  private function sendMailDefault($to, $subject, $message, $from)
  {
    mail($to, $subject, $message, 'From: '. $from . "\r\n");
  }

  private function sendWithSwift($to, $subject, $message, $from)
  {
    //mail($to, $subject, $message, $headers);
    $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom(array($from))
                ->setTo(array($to))
                ->setBody($message);

    $transport = Swift_SmtpTransport::newInstance(ConfigManager::getMailHost(), ConfigManager::getMailPort());
    $mailer = Swift_Mailer::newInstance($transport);
    $result = $mailer->send($message);    
  }
}

?>
