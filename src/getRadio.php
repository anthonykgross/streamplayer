<?php

require_once 'config.php';

if (isset($_GET["radio"])) {

    $laRadio = Metier_Radio::getRadio($_GET["radio"]);

    if ($laRadio != null) {
        echo html_entity_decode($laRadio->getNom() . '|' . $laRadio->getLien() . '|' . $laRadio->getSite().'|/Theme/default/Images/radios/radio');
    } else {
        echo "NULL";
    }
}
?>
