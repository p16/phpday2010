<?php

require_once 'PHPUnit/Extensions/Database/TestCase.php';
require_once dirname(__FILE__) . '/../../lib/Evento.php';

class EventoTest extends PHPUnit_Extensions_Database_TestCase
{
  protected $pdo;

  protected function setUp()
  {
    $this->pdo = new PDO('sqlite::memory:');
    $query = "CREATE TABLE evento (titolo VARCHAR(256) NOT NULL PRIMARY KEY, descrizione VARCHAR(512), data_inizio DATE, data_fine DATE)";
    $this->pdo->query($query);
  }

  protected function getConnection()
  {
    return $this->createDefaultDBConnection($this->pdo, 'sqlite');
  }

  protected function getDataSet()
  {
    return $this->createFlatXMLDataSet(dirname(__FILE__).'/../fixtures/evento.xml');
  }

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

  public function testSave()
  {
    $data = array('titolo' => 'phpday2010!!!',
                  'descrizione' => 'questo è il talk per il phpday 2010!',
                  'data_inizio' => '2010-05-14',
                  'data_fine' => '2010-05-15');

    $evento = new Evento;
    $evento->fromArray($data);
    $evento->save($this->pdo);

    $xml_dataset = $this->createFlatXMLDataSet(dirname(__FILE__).'/../fixtures/evento.xml');
    $this->assertDataSetsEqual($xml_dataset, $this->getConnection()->createDataSet(array('evento')));
  }

  protected function tearDown()
  {
    $this->pdo = null;
  }
}

?>
