<?php

require_once dirname(__FILE__).'/Vendor/sfWebBrowser/lib/sfWebBrowser.class.php';

class idWebBrowser extends sfWebBrowser
{
  public function call($uri, $method = 'GET', $parameters = array(), $headers = array(), $changeStack = true)
  {
    $urlInfo = parse_url($uri);

    // Check headers
    $headers = $this->fixHeaders($headers);

    // check port
    if (isset($urlInfo['port']))
    {
      $this->urlInfo['port'] = $urlInfo['port'];
    }
    else if (!isset($this->urlInfo['port']))
    {
      $this->urlInfo['port'] = 80;
    }

    if(!isset($urlInfo['host']))
    {
      $uri = (!ereg("^/(.*)", $uri)) ? "/".$uri : $uri;
      $uri = $this->urlInfo['scheme'].'://'.$this->urlInfo['host'].':'.$this->urlInfo['port'].$uri;
    }
    else if($urlInfo['scheme'] != 'http' && $urlInfo['scheme'] != 'https')
    {
      throw new Exception('sfWebBrowser handles only http and https requests');
    }

    $this->urlInfo = parse_url($uri);
    $this->initializeResponse();

    if ($changeStack)
    {
      $this->addToStack($uri, $method, $parameters, $headers);
    }

    $browser = $this->adapter->call($this, $uri, $method, $parameters, $headers);

    // redirect support
    if ((in_array($browser->getResponseCode(), array(301, 307)) && in_array($method, array('GET', 'HEAD'))) || in_array($browser->getResponseCode(), array(302,303)))
    {
      $this->call($browser->getResponseHeader('Location'), 'GET', array(), $headers);
    }

    return $browser;
  }

  protected function fixHeaders($headers)
  {
    $fixed_headers = array();
    foreach ($headers as $name => $value)
    {
      if (!preg_match('/([a-z]*)(-[a-z]*)*/i', $name))
      {
        $msg = sprintf('Invalid header "%s"', $name);
        throw new Exception($msg);
      }
      $fixed_headers[$this->normalizeHeaderName($name)] = trim($value);
    }

    return $fixed_headers;
  }

  public function getFields()
  {
    return $this->fields;
  }
  
  public function getUrlInfo()
  {
    return $this->urlInfo;
  }
}