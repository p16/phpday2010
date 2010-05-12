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

require_once 'PHPUnit/Framework/TestCase.php';
require_once dirname(__FILE__).'/WebBrowserTestCase/Vendor/sfWebBrowser/lib/sfCurlAdapter.class.php';
require_once dirname(__FILE__).'/WebBrowserTestCase/Vendor/util/sfDomCssSelector.class.php';
require_once dirname(__FILE__).'/WebBrowserTestCase/Vendor/util/sfToolkit.class.php';
require_once dirname(__FILE__).'/WebBrowserTestCase/Vendor/sfWebBrowser/lib/sfWebBrowser.class.php';

/**
 * PHPUnit_Extensions_WebBrowserTestCase.
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Francesco Trucchia <francesco@cphp.it>
 * @copyright  2009  Francesco Trucchia <francesco@cphp.it>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 */

class PHPUnit_Extensions_WebBrowserTestCase extends PHPUnit_Framework_TestCase
{
  protected $browser;
  protected $browser_adapter = null;
  protected $browser_adapter_options = array('cookies' => true, 'cookies_file' => 'cookies-browser.txt', 'cookies_dir' => '/tmp');
  protected $browser_class =  "sfWebBrowser";

  public function __construct()
  {
    parent::__construct();
    $this->initializeBrowser();
  }

  /**
   * Init method for Browser
   */
  protected function initializeBrowser()
  {
    $this->browser = new $this->browser_class(array(), $this->browser_adapter, $this->browser_adapter_options);
  }

  /**
   * Proxy method to sfWebBrowser class
   *
   * @param string $method
   * @param array $parameters
   * @return mixed
   */
  protected function __call($method, $parameters)
  {
    if(method_exists($this->browser, $method))
    {
      return call_user_func_array(array($this->browser, $method), $parameters);
    }
    return false;
  }

  /**
   * Proxy deprecated method to checkResponseElement
   *
   * @param <type> $selector
   * @param <type> $value
   * @param <type> $options
   * @deprecated
   * 
   */
  protected function checkElementResponse($selector, $value = true, $options = array())
  {
    $this->checkResponseElement($selector, $value, $options);
  }

  /**
   * Tests that the response matches a given CSS selector.
   *
   * @param  string $selector  The response selector or a sfDomCssSelector object
   * @param  mixed  $value     Flag for the selector
   * @param  array  $options   Options for the current test
   *
   */
  protected function checkResponseElement($selector, $value = 1, $options = array())
  {
    if (is_null($this->getResponseDom()))
    {
      throw new Exception('The DOM is not accessible because the browser response content type is not HTML.');
    }

    if (is_object($selector))
    {
      $values = $selector->getValues();
    }
    else
    {
      $values = $this->getResponseDomCssSelector()->matchAll($selector)->getValues();
    }

    if (false === $value)
    {
      $this->assertEquals(0, count($values), sprintf('response selector "%s" does not exist', $selector));
    }
    else if (true === $value)
    {
      $this->greaterThan(0, count($values), sprintf('response selector "%s" exists', $selector));
    }
    else if (is_int($value))
    {
      $this->assertEquals($value, count($values), sprintf('response selector "%s" matches "%s" times', $selector, $value));
    }
    else if (preg_match('/^(!)?([^a-zA-Z0-9\\\\]).+?\\2[ims]?$/', $value, $match))
    {
      $position = isset($options['position']) ? $options['position'] : 0;
      if ($match[1] == '!')
      {
        $this->assertNotEquals(substr($value, 1), @$values[$position], sprintf('response selector "%s" does not match regex "%s"', $selector, substr($value, 1)));
      }
      else
      {
        $this->assertRegExp($value, @$values[$position], sprintf('response selector "%s" matches regex "%s" in "%s"', $selector, $value, @$values[$position]));
      }
    }
    else
    {
      $position = isset($options['position']) ? $options['position'] : 0;
      $this->assertEquals( $value, @$values[$position], sprintf('response selector "%s" matches "%s"', $selector, $value));
    }

    if (isset($options['count']))
    {
      $this->assertEquals($options['count'], count($values), sprintf('response selector "%s" matches "%s" times', $selector, $options['count']));
    }
  }
  
  /**
   * Tests whether or not a given string is in the response.
   *
   * @param string Text to check
   *
   * @return sfTestFunctionalBase|sfTester
   */
  protected function responseContains($text)
  {
    $this->assertRegExp('/'.preg_quote($text, '/').'/', $this->getResponseText(), sprintf('response contains "%s"', substr($text, 0, 40)));   
  }

}