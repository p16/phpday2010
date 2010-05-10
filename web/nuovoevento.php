<html>
  <head>
    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.8.1.custom.min.js" type="text/javascript"></script>
    <script src="css/ui-lightness/jquery-ui-1.8.1.custom.css" type="text/css"></script>
  </head>
  <body>
    <script type="text/javascript">
      $(function() {
        $("#datepicker_1").datepicker();
        $("#datepicker_2").datepicker();
      });
    </script>
    <h1>Inserisci un nuovo evento</h1>
    <form action="creaevento.php" method="POST">
      <label for="titolo">Titolo: </label><input name="titolo" type="text" /><br/>
      <label for="titolo">Descrizione: </label><textarea name="descrizione" rows="10" cols="50"></textarea><br/>
      <label for="titolo">Data inizio: </label><input id="datepicker_1" type="text" name="data_inizio"><br/>
      <label for="titolo">Data fine: </label><input id="datepicker_2" type="text" name="data_fine"><br/>

      <input type="submit" name="crea_evento" value="Crea nuovo evento" />
    </form>
  </body>
</html>