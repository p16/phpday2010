<?php

require_once dirname(__FILE__).'/../../Extensions/WebBrowserTestCase/Vendor/sfWebBrowser/lib/sfWebBrowser.class.php';

class ExtendedSfWebBrowser extends sfWebBrowser
{
  public function getStack()
  {
    return $this->stack;
  }
}

class sfToolkit
{
  public static function arraydeepmerge($defaults)
  {
    return $defaults;
  }
}

class MockAdapter
{
  public function  __construct($options)
  {
    $this->options = $options;
  }

  public function call($browser)
  {
    $content = file_get_contents($this->options['test_file']);
    $browser->setResponseCode(200);
    $browser->setResponseHeaders(array('Content-Type: text/html'));
    $browser->setResponseText($content);
    return $browser;
  }
}

class sfWebBrowserTest extends PHPUnit_Framework_TestCase
{
  public function testClickLink()
  {
    $browser = new sfWebBrowser(array(), 'MockAdapter', array('test_file' => dirname(__FILE__).'/Html/test_click.html'));
    $browser->get('http://localhost');
    $browser->click('Go');
  }

  public function testClickForm()
  {
    $browser = new ExtendedSfWebBrowser(array(), 'MockAdapter', array('test_file' => dirname(__FILE__).'/Html/test_form.html'));
    $browser->get('http://localhost');
    $browser->click('Send');

    $stack = $browser->getStack();

    //print_r($stack);
    
    $this->assertTrue(is_array($stack[1]['parameters']['list_empty']));
    $this->assertEquals(1, count($stack[1]['parameters']['list_empty']));
    $this->assertEquals('2', $stack[1]['parameters']['list_empty'][0]);

    $this->assertTrue(is_array($stack[1]['parameters']['list_space']));
    $this->assertEquals('2', $stack[1]['parameters']['list_space'][0]);

    $this->assertTrue(is_array($stack[1]['parameters']['list_value']));
    $this->assertEquals('2', $stack[1]['parameters']['list_value']['inner_list']);
    
    $this->assertTrue(is_array($stack[1]['parameters']['list_array']));
    $this->assertEquals('2', $stack[1]['parameters']['list_array']['inner_array'][0]);

    $this->assertEquals('cannuccia', $stack[1]['parameters']['johnny']);
  }

}