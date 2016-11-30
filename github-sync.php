<?php

`git pull`;

$dateObj = new DateTime();
$date = $dateObj->format('d/m/Y H:i:s');

mail('dylantemboucti@gmail.com, mouletfabien@gmail.com', 'Un Push sur Shiawa.fr', 'Envoyé le '.$date);

?>