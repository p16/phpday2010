<?php

class Evento
{
  private $titolo;
  private $descrizione;
  private $data_inizio;
  private $data_fine;

  public function fromArray(array $data)
  {
    $this->titolo = $data['titolo'];
    $this->descrizione = $data['descrizione'];
    $this->data_inizio = $data['data_inizio'];
    $this->data_fine = $data['data_fine'];
  }

    public function getTitolo()
  {
    return $this->titolo;
  }

  public function getDescrizione()
  {
    return $this->descrizione;
  }

  public function getDataInizio()
  {
    return $this->data_inizio;
  }

  public function getDataFine()
  {
    return $this->data_fine;
  }

  public function save($conn = null)
  {
    if (is_null($conn))
    {
      $conn = new PDO('mysql:dbname=phpday2010;host=localhost', 'dbtest', 'test');
    }

    $res = $conn->exec("INSERT INTO evento (titolo, descrizione, data_inizio, data_fine) VALUES ('".$this->titolo."', '".$this->descrizione."', '".$this->data_inizio."', '".$this->data_fine."')");
  }
}
?>
