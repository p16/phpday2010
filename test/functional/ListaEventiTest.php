<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once dirname(__FILE__).'/../../lib/ConnectionManager.php';

class ListaEventiTest extends PHPUnit_Extensions_SeleniumTestCase
{
  protected $connection;

  protected function emptyDatabaseTables()
  {
    $this->connection->exec('TRUNCATE evento');
  }

  protected function loadFixtures()
  {
    include_once dirname(__FILE__).'/../fixtures/eventi.php';
    foreach ($fixtures as $row)
    {
      $this->connection->exec("INSERT INTO evento (titolo, descrizione, data_inizio, data_fine) VALUES ('".$row['titolo']."', '".$row['descrizione']."', '".$row['data_inizio']."', '".$row['data_fine']."')");
    }
  }

  protected function setUp()
  {
    $this->connection = ConnectionManager::getConnection();
    $this->emptyDatabaseTables();
    $this->loadFixtures();

    $this->setBrowser('*firefox');
    $this->setBrowserUrl('http://localhost/');
  }

  public function testMassimoTreEventiInLista()
  {
    $this->open("/phpday2010/web/listaeventi.php");

    $this->assertEquals("Primo evento!", $this->getText("//html/body/div/div[1]/h3"));
    $this->assertEquals("Secondo evento!", $this->getText("//html/body/div/div[2]/h3"));
    $this->assertEquals("Terzo evento!", $this->getText("//html/body/div/div[3]/h3"));

    try
    {
      $this->assertFalse($this->isTextPresent("Quarto evento!"));
    }
    catch (PHPUnit_Framework_AssertionFailedError $e)
    {
      array_push($this->verificationErrors, $e->toString());
    }
  }

  protected function tearDown()
  {
  }
}

?>