<?php
require_once dirname(__FILE__).'/../../lib/vendor/PHPUnitWebBrowser/Extensions/WebBrowserTestCase.php';
require_once dirname(__FILE__).'/../../lib/ConnectionManager.php';
require_once dirname(__FILE__).'/../../config/ConfigManager.php';

class CreateEventoWBTest extends PHPUnit_Extensions_WebBrowserTestCase
{
  protected $connection;

  protected function emptyDatabaseTables()
  {
    $this->connection->exec('TRUNCATE evento');
  }
  
  private function startFakemail()
  {
    exec('rm -f /var/www/phpday2010/test/mail/*');
    
    $command = dirname(__FILE__).'/../fakemail/fakemail --background';
    $command .= ' --path='.ConfigManager::getMailFolderPath();
    $command .= ' --host=localhost';
    $command .= ' --port='.ConfigManager::getMailPort();

    shell_exec($command);
  }

  private function stopFakemail()
  {
    $pid = shell_exec("ps ax | grep fakemail | grep -v grep | awk ' { print $1 } '");
    if ($pid)
      shell_exec("kill -9 ".$pid);

    exec('rm -f /var/www/phpday2010/test/mail/*');
  }

  protected function setUp()
  {
    $this->connection = ConnectionManager::getConnection();
    $this->emptyDatabaseTables();
    $this->startFakemail();
  }

  public function testInserimentoEvento()
  {
    $this->get('http://localhost/phpday2010/web/nuovoevento.php');
    $this->setField("titolo", "pippo");
    $this->setField("descrizione", "descrizione");
    $this->setField("data_inizio", "2010-05-20");
    $this->setField("data_fine", "2010-05-27");

    $this->click("Crea nuovo evento");
    $this->checkResponseElement('.container .notice', '/Evento creato con successo/');
  }

  protected function tearDown()
  {
    $this->stopFakemail();
  }
}

?>