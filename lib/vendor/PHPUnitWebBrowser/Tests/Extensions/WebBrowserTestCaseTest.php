<?php

/**
 * WebBrowserTestCase
 *
 * Copyright (c) 2009, Francesco Trucchia <francesco@cphp.it>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Francesco Trucchia <francesco@cphp.it>
 * @copyright  2009  Francesco Trucchia <francesco@cphp.it>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 */

set_include_path(get_include_path().':/var/www');

require_once dirname(__FILE__).'/../../Extensions/WebBrowserTestCase.php';

/**
 * Tests for PHPUnit_Extensions_WebBrowserTestCase.
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Francesco Trucchia <francesco@cphp.it>
 * @copyright  2009  Francesco Trucchia <francesco@cphp.it>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 */

$PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_HOST = 'localhost';
$PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_PORT = 80;

class Extensions_WebBrowserTestCaseTest extends PHPUNIT_Extensions_WebBrowserTestCase
{
  public function setUp()
  {
    $this->url = sprintf(
      'http://%s:%d/PHPUnit/Tests/Extensions/Html',
      $GLOBALS['PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_HOST'],
      $GLOBALS['PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_PORT']
    );
  }

  public function testGet() 
  {
    $this->get($this->url . '/test_get.html');
    $this->assertEquals('This is a test of the open command.', $this->getResponseText());
  }
  
  public function testPost() 
  {
    $this->post($this->url . '/test_post.php', array('test' => 'This is a test post'));
    $this->assertEquals('This is a test post', $this->getResponseText());
    
    $this->post($this->url . '/test_post.php', array('test' => 'This is a test post2'));
    $this->assertEquals('This is a test post2', $this->getResponseText());
  }
  
  public function testClick() 
  {
    $this->get($this->url . '/test_click.html');
    $this->click('Go');
    $this->assertEquals('This is a test to click', $this->getResponseText());
  }
  
  public function testBack() 
  {
    $this->get($this->url . '/test_click.html');
    $this->click('Go');
    $this->assertEquals('This is a test to click', $this->getResponseText());
    $this->back();
    $this->assertContains('Go', $this->getResponseText());
  }
  
  public function testSubmit() 
  {
    $this->get($this->url . '/test_submit.php');
    $this->setField('firstname', 'Foo');
    $this->setField('lastname', 'Bar');
    $this->click('Send');
    $this->assertEquals('Foo Bar', $this->getResponseText());
  }
  
  public function testCheckElementResponse()
  {
    $this->get($this->url . '/test_checkelement.html');
    $this->checkElementResponse('body');
    $this->checkElementResponse('body', 1);
    $this->checkElementResponse('body ul li', 5);
    $this->checkElementResponse('body ul li', 'Item 1');
    $this->checkElementResponse('body ul li', 'Item 2', array('position' => 1));
    $this->checkElementResponse('body p', '/Lorem ipsum/');
  }
  
  public function testResponseContains()
  {
    $this->get($this->url . '/test_checkelement.html');
    $this->responseContains('Lorem ipsum');
  }
  
  public function testIsStatusCode()
  {
    $this->get($this->url . '/test_checkelement.html');
    $this->assertEquals(200, $this->getResponseCode());
  }
}