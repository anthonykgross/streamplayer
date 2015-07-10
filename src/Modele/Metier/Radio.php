<?php

class Metier_Radio {

    private $idRadio;
    private $nom;
    private $lien;
    private $siteWeb;
    private $meta_title;
    private $meta_description;
    private $meta_keyword;
    private $url;
    public static $nbResultat = 0;

    public function __construct($idRadio, $nom, $lien, $siteWeb, $meta_title, $meta_description, $meta_keyword, $url) {
        $this->idRadio          = $idRadio;
        $this->nom              = $nom;
        $this->lien             = $lien;
        $this->siteWeb          = $siteWeb;
        $this->meta_title       = $meta_title;
        $this->meta_description = $meta_description;
        $this->meta_keyword     = $meta_keyword;
        $this->url              = $url;
    }

    public static function getListeRadio($champs = "nomRadio", $order="asc") {
        $pdo = Bdd::getConnect()->prepare("SELECT * ,
                                                        (SELECT count(*) 
                                                         FROM tab_radio) AS nbResultat 
                                           FROM tab_radio
                                           ORDER BY $champs $order");

        $pdo->execute();

        $listeRadio = array();

        while ($resultat = $pdo->fetch(PDO::FETCH_ASSOC)) {
            Metier_Radio::$nbResultat = $resultat['nbResultat'];
            $listeRadio[] = new Metier_Radio($resultat['idRadio'], $resultat['nomRadio'], $resultat['lien'], $resultat['siteWeb'], $resultat['meta_title'], $resultat['meta_description'], $resultat['meta_keyword'], $resultat['url']);
        }

        return $listeRadio;
    }

    public static function getRadio($idRadio) {
        $pdo = Bdd::getConnect()->prepare("SELECT * 
                                           FROM tab_radio
                                           WHERE idRadio= :idRadio");
        $pdo->bindValue(":idRadio", $idRadio, PDO::PARAM_INT);

        $pdo->execute();

        $maRadio = null;

        if ($pdo->rowCount() == 1) {
            $resultat = $pdo->fetch(PDO::FETCH_ASSOC);
            $maRadio = new Metier_Radio($resultat['idRadio'], $resultat['nomRadio'], $resultat['lien'], $resultat['siteWeb'], $resultat['meta_title'], $resultat['meta_description'], $resultat['meta_keyword'], $resultat['url']);
        }

        return $maRadio;
    }

    public static function rechercheRadio($recherche, $champs = "nomRadio", $order="asc") {
        $pdo = Bdd::getConnect()->prepare("SELECT *,
                                                        (SELECT count(*) 
                                                         FROM tab_radio
                                                         WHERE nomRadio LIKE :recherche) AS nbResultat 
                                           FROM tab_radio
                                           WHERE nomRadio LIKE :recherche 
                                           ORDER BY $champs $order");
        $pdo->bindValue(":recherche", '%' . $recherche . '%', PDO::PARAM_STR);
        $pdo->execute();

        $listeRadio = array();

        while ($resultat = $pdo->fetch(PDO::FETCH_ASSOC)) {
            Metier_Radio::$nbResultat = $resultat['nbResultat'];
            $listeRadio[] = new Metier_Radio($resultat['idRadio'], $resultat['nomRadio'], $resultat['lien'], $resultat['siteWeb'], $resultat['meta_title'], $resultat['meta_description'], $resultat['meta_keyword'], $resultat['url']);
        }

        return $listeRadio;
    }

    public function getIdRadio() {
        return $this->idRadio;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getLien() {
        return $this->lien;
    }

    public function getSite() {
        return $this->siteWeb;
    }
    
    public function getMetaDescription() {
        return $this->meta_description;
    }
    
    public function getMetaTitle() {
        return $this->meta_title;
    }
    
    public function getMetaKeyword() {
        return $this->meta_keyword;
    }
    
    public function getUrl() {
        return $this->url;
    }

}

?>