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

require_once dirname(__FILE__).'/../../Extensions/WebBrowserTestCase/idWebBrowser.class.php';
require_once dirname(__FILE__).'/../../Extensions/WebBrowserTestCase/Vendor/sfWebBrowser/lib/sfCurlAdapter.class.php';

/**
 * Tests for PHPUnit_Extensions_idWebBrowserTestCase.
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Filippo De Santis <fd@ideato.it>
 * @author     Antonio Fallucchi <af@ideato.it>
 * @copyright  2009  Francesco Trucchia <francesco@cphp.it>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 */


class Extensions_idWebBrowserTestCaseTest extends PHPUnit_Framework_TestCase
{
  public function testCall()
  {
    $browser = new idWebBrowser(array(),null,array('cookies' => true, 'cookies_file' => 'cookies-browser.txt', 'cookies_dir' => '/tmp'));

    $browser->call("http://localhost/");
    $browser->call("/PHPUnit/Tests/Extensions/Html/");

    $urlInfo = $browser->getUrlInfo();

    $this->assertEquals('http', $urlInfo['scheme']);
    $this->assertEquals('localhost', $urlInfo['host']);
    $this->assertEquals('/PHPUnit/Tests/Extensions/Html/', $urlInfo['path']);
  }

}