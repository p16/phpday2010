<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class CreateEventoTest extends PHPUnit_Extensions_SeleniumTestCase
{

  protected function setUp()
  {
    $this->setBrowser('*firefox');
    $this->setBrowserUrl('http://localhost/');
  }

  public function testInserimentoEvento()
  {
    $this->open('/phpday2010/web/nuovoevento.php');
    $this->type('titolo', 'Il phpday2010 è cominciato!!');
    $this->type('descrizione', 'State assistendo al talk testare l\'ignoto');
    $this->click('datepicker_1');
    $this->click('link=13');
    $this->click('datepicker_2');
    $this->click('link=15');
    $this->click('Crea nuovo evento');

    $this->waitForText('Evento creato con successo!');
  }

  protected function tearDown()
  {
  }
}

?>