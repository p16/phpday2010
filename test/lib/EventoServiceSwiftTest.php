<?php
require_once 'PHPUnit/Extensions/Database/TestCase.php';
require_once dirname(__FILE__) . '/../../lib/EventoService.php';

class EventoServiceSwiftTest extends PHPUnit_Extensions_Database_TestCase
{
  protected $pdo;

  protected function getConnection()
  {
    return $this->createDefaultDBConnection($this->pdo, 'sqlite');
  }

  protected function getDataSet()
  {
    return $this->createFlatXMLDataSet(dirname(__FILE__).'/../fixtures/eventi.xml');
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

  public function setUp()
  {
    $this->pdo = new PDO('sqlite::memory:');
    $query = "CREATE TABLE evento (titolo VARCHAR(256) NOT NULL PRIMARY KEY, descrizione VARCHAR(512), data_inizio DATE, data_fine DATE)";
    $this->pdo->query($query);

    $this->stopFakemail();
    $this->startFakemail();
    parent::setUp();
  }

  public function testCreaNuovoEvento()
  {
    $data = array('titolo' => 'nuovo titolo swift',
                  'descrizione' => 'bla bla bla',
                  'data_inizio' => '15-10-2010',
                  'data_fine' => '18-10-2010');

    $es = new EventoService();
    $es->creaNuovoEvento($data, $this->pdo);

    $mail = file_get_contents('/var/www/phpday2010/test/mail/admin@example.com.1');
    $this->assertRegExp('/From: webmaster@example.com/', $mail);
    $this->assertRegExp('/To: admin@example.com/', $mail);
    $this->assertRegExp('/Subject: nuovo evento: nuovo titolo swift/', $mail);
    $this->assertRegExp('/stato pubblicato un nuovo evento/', $mail);
  }

  protected function tearDown()
  {
    $this->pdo = null;
    $this->stopFakemail();
    parent::tearDown();
  }
}

?>