<?php
$monControle = new Controle();  

$monControle->lstRadio = Metier_Radio::getListeRadio();

$design = new Design($monControle);

$titre = "";

if(isset($_GET['id'])){
    $monControle->idRadio = $_GET['id'];
    
    $radio = Metier_Radio::getRadio($_GET['id']);
    $design->addMetaDescription($radio->getMetaDescription());
    $design->addMetaKeyword($radio->getMetaKeyword());
    $design->addImageSrc(URL_THEME_CHOISI.'Images/radios/radio'.$_GET['id'].'.png');
    $titre = $radio->getMetaTitle();
}




echo $design->genere($titre);
?>