<?php require_once dirname(__FILE__).'/../lib/EventoService.php'; ?>

<html>
  <head>
    <script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="./js/jquery-ui-1.8.1.custom.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="./css/ui-lightness/jquery-ui-1.8.1.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">
    <!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

  </head>
  <body>
    <div class="container showgrid">
      <?php $es = new EventoService(); ?>
      <?php $eventi = $es->retrieveEventi(ConnectionManager::getConnection()); ?>

      <?php foreach ($eventi as $evento) : ?>
        <div class="evento span-7">
          <h3><?php echo $evento['titolo']; ?></h3>
          <p>Descrizione: <?php echo $evento['descrizione']; ?></p>
          <p>Data inizio: <?php echo $evento['data_inizio']; ?></p>
          <p>Data fine: <?php echo $evento['data_fine']; ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </body>
</html>