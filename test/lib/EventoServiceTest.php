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
    return $this->createFlatXMLDataSet(dirname(__FILE__).'/../fixtures/eventi.xml');
  }

  public function setUp()
  {
    $this->pdo = new PDO('sqlite::memory:');
    $query = "CREATE TABLE evento (titolo VARCHAR(256) NOT NULL PRIMARY KEY, descrizione VARCHAR(512), data_inizio DATE, data_fine DATE)";
    $this->pdo->query($query);
    exec('rm -f /var/www/phpday2010/test/mail/*');
    parent::setUp();
  }

  public function testCreaNuovoEvento()
  {
    $data = array('titolo' => 'nuovo titolo',
                  'descrizione' => 'bla bla bla',
                  'data_inizio' => '15-10-2010',
                  'data_fine' => '18-10-2010');

    $es = new EventoService();
    $es->creaNuovoEvento($data, $this->pdo, false);

    $mail = file_get_contents('/var/www/phpday2010/test/mail/admin@example.com.1');
    $this->assertRegExp('/From: webmaster@example.com/', $mail);
    $this->assertRegExp('/To: admin@example.com/', $mail);
    $this->assertRegExp('/Subject: nuovo evento: nuovo titolo/', $mail);
    $this->assertRegExp('/stato pubblicato un nuovo evento/', $mail);
  }

  public function testRetrieveEventi()
  {
    $es = new EventoService();
    $eventi = $es->retrieveEventi($this->pdo);

    $this->assertEquals(3, count($eventi));
    $this->assertEquals('Primo evento!', $eventi[0]['titolo']);
    $this->assertEquals('Secondo evento!', $eventi[1]['titolo']);
    $this->assertEquals('Terzo evento!', $eventi[2]['titolo']);
  }

  protected function tearDown()
  {
    $this->pdo = null;
    parent::tearDown();
  }
}

?>