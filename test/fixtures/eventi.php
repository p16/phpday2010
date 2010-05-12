<?php
$fixtures = array(
                  array('titolo' => 'Primo evento!',
                        'descrizione' => 'Il primo evento del phpday2010',
                        'data_inizio' => date('Y-m-d', strtotime('-2 days GMT')),
                        'data_fine' => date('Y-m-d', strtotime('+2 days GMT'))),
                  array('titolo' => 'Secondo evento!',
                        'descrizione' => 'Il secondo evento del phpday2010',
                        'data_inizio' => date('Y-m-d', strtotime('-2 days GMT')),
                        'data_fine' => date('Y-m-d', strtotime('+3 days GMT'))),
                  array('titolo' => 'Terzo evento!',
                        'descrizione' => 'Il terzo evento del phpday2010',
                        'data_inizio' => date('Y-m-d', strtotime('-2 days GMT')),
                        'data_fine' => date('Y-m-d', strtotime('+4 days GMT'))),
                  array('titolo' => 'Quarto evento!',
                        'descrizione' => 'Il quarto evento del phpday2010',
                        'data_inizio' => date('Y-m-d', strtotime('-4 days GMT')),
                        'data_fine' => date('Y-m-d', strtotime('-1 day GMT')))
);
?>