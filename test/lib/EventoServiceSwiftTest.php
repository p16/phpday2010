<?php
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../lib/EventoService.php';

class EventoServiceTest extends PHPUnit_Framework_TestCase
{

  public function startFakemail($mail_dir)
  {
    shell_exec('fakemail.py --port=10025 --background --host=localhost --path='.$mail_dir);
    shell_exec('rm '.$mail_dir.'/*');
  }

  public function stopFakemail()
  {
    shell_exec('killall fakemail');
  }

  public function testCreaNuovoEvento()
  {
   $this->startFakemail(dirname(__FILE__) . '/../mail');

   $data = array('titolo' => 'nuovo titolo',
                  'descrizione' => 'bla bla bla',
                  'data_inizio' => '15-10-2010',
                  'data_fine' => '18-10-2010');

   $es = new EventoService();
   $es->creaNuovoEvento($data);


   $this->stopFakemail();
  }

  protected function tearDown()
  {
  }
}

?>