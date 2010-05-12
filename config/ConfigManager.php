<?php
class ConfigManager
{
  protected static $mail_folder_path = '/var/www/phpday2010/test/mail/';
  protected static $mail_port = 10025;
  protected static $mail_host = 'localhost';

  public static function getMailFolderPath()
  {
    return self::$mail_folder_path;
  }

  public static function getMailPort()
  {
    return self::$mail_port;
  }

  public static function getMailHost()
  {
    return self::$mail_host;
  }
}
?>