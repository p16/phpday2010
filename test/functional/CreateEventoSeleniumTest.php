<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once dirname(__FILE__).'/../../lib/ConnectionManager.php';
require_once dirname(__FILE__).'/../../config/ConfigManager.php';

class CreateEventoSeleniumTest extends PHPUnit_Extensions_SeleniumTestCase
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
    $this->stopFakemail();
  }
}

?>