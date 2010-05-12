<?php
class ConnectionManager
{
  public static function getConnection()
  {
    $conn = new PDO('mysql:dbname=phpday2010;host=localhost', 'dbtest', 'test');
    return $conn;
  }
}
?>
