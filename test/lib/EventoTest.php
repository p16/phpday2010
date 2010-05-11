<?php
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../lib/Evento.php';

class EventoTest extends PHPUnit_Framework_TestCase {


  public function testFromArray()
  {
    $data = array('titolo' => 'nuovo titolo',
                  'descrizione' => 'bla bla bla',
                  'data_inizio' => '15-10-2010',
                  'data_fine' => '18-10-2010');
    
    $evento = new Evento;
    $evento->fromArray($data);

    $this->assertEquals('nuovo titolo', $evento->getTitolo());
    $this->assertEquals('bla bla bla', $evento->getDescrizione());
    $this->assertEquals('15-10-2010', $evento->getDataInizio());
    $this->assertEquals('18-10-2010', $evento->getDataFine());


  }

  protected function tearDown()
  {
  }
}

?>
