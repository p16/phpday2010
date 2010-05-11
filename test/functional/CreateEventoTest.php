<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class CreateEventoTest extends PHPUnit_Extensions_SeleniumTestCase
{

  protected function setUp()
  {
    $this->setBrowser('*firefox');
    $this->setBrowserUrl('http://localhost/');
  }

  protected function waitForTextPresent($text, $time = 60)
  {
    for ($second = 0; ; $second++) {
        if ($second >= $time) $this->fail("timeout");
        try {
            if ($this->isTextPresent($text)) break;
        } catch (Exception $e) {}
        sleep(1);
    }
  }

  public function testInserimentoEvento()
  {
    $this->open("/phpday2010/web/nuovoevento.php");
    $this->type("titolo", "pippo");
    $this->type("descrizione", "descrizione");
    $this->click("//img[@alt='...']");
    $this->click("link=20");
    $this->click("//p[4]/img");
    $this->click("link=27");
    $this->click("crea_evento");

    $this->waitForTextPresent("Evento creato con successo!");
  }

  protected function tearDown()
  {
  }
}

?>