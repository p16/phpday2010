<?php
require_once 'PHPUnit/Extensions/Database/TestCase.php';
require_once dirname(__FILE__) . '/../../lib/EventoService.php';

class EventoServiceTest extends PHPUnit_Extensions_Database_TestCase
{

  protected function getConnection()
  {
    return $this->createDefaultDBConnection($this->pdo, 'sqlite');
  }

  protected function getDataSet()
  {
    return $this->createFlatXMLDataSet(dirname(__FILE__).'/../fixtures/evento.xml');
  }

  public function setUp()
  {
    $dir = realpath(dirname(__FILE__) . '/../mail');

    $this->pdo = new PDO('sqlite::memory:');
    $query = "CREATE TABLE evento (titolo VARCHAR(256) NOT NULL PRIMARY KEY, descrizione VARCHAR(512), data_inizio DATE, data_fine DATE)";
    $this->pdo->query($query);
    exec('rm -f '.$dir.'/*');
  }

  public function testCreaNuovoEvento()
  {
   $data = array('titolo' => 'nuovo titolo',
                  'descrizione' => 'bla bla bla',
                  'data_inizio' => '15-10-2010',
                  'data_fine' => '18-10-2010');

   $es = new EventoService();
   $es->creaNuovoEvento($data, $this->pdo);
  }

  protected function tearDown()
  {
    $this->pdo = null;
  }
}

?>