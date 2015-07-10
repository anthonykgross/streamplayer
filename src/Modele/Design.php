<?php

/**
 * ---------------------------------------------------------------------------
 *
 * CETTE CLASSE PERMET DE GENERER RAPIDEMENT UN DESIGN DE SITE WEB
 * AINSI QUE D'INSERER LES DIFFERENTS ELEMENTS COMME JAVASCRIPT ET CSS
 * A LEUR ENDROIT RESPECTIF DANS LE CODE HTML
 * 
 * @author kkuet
 * 
 * ----------------------------------------------------------------------------
 */
class Design {

    private $monControle;
    private $css            = array();
    private $javascript     = array();
    private $meta           = array('keywords' => '', 'description' => '', 'image_src' => '');
    
    /**
     * Constructeur de la classe Design
     * Permet d'afficher un page du site à partir d'un Controle passé en parametre
     * @param Controle $monControle
     */
    public function __construct($monControle) {
        if ($monControle instanceof Controle) {
            $this->monControle = $monControle;
            $this->autoAddFile();
        } else {
            throw new Exception("L'objet en parametre de la classe Design n'est pas de type Controle");
        }
    }

    /**
     * Ajoute des mots clés à la page
     * @param string $string 
     */
    public function addMetaKeyword($string){
        $this->meta['keywords']     .= $string;
    }
    /**
     * Ajoute une description à la page
     * @param string $string 
     */
    public function addMetaDescription($string){
        $this->meta['description']  .= $string;
    }
    
    /**
     * Ajoute une image_src à la page, notamment essentiel pour facebook
     * @param string $string 
     */
    public function addImageSrc($string){
        $this->meta['image_src']  = $string;
    }
    /**
     * Retourne les metaKeywords
     * @return type 
     */
    public function getMetaKeyword(){
        return $this->meta['keywords'];
    }
    
    /**
     * Retourne la metaDescription
     * @return type 
     */
    public function getMetaDescription(){
        return $this->meta['description'];
    }
    
    /**
     * Retourne l'image_src, notamment essentiel pour facebook
     */
    public function getImageSrc(){
        return $this->meta['image_src'];
    }
    
    /**
     * Ajoute un fichier javascript au Controle
     * @param Array $fichier = Path du fichier
     */
    public function addJavascript($fichier) {
        if (is_array($fichier)) {
            foreach ($fichier as $javascript) {
                $this->javascript[] = $javascript;
            }
        } else {
            $this->javascript[] = $fichier;
        }
    }

    /**
     * Ajoute un feuille de style CSS au Controle
     * @param Array $fichier = Path du fichier
     */
    public function addCSS($fichier = array()) {
        if (is_array($fichier)) {
            foreach ($fichier as $css) {
                $this->css[] = $css;
            }
        } else {
            $this->css[] = $fichier;
        }
    }

    /**
     * Retourne le path du Fichier CSS à la position de l'index envoyé en parametre
     * @param Int $index = index (ou position) du fichier souhaité
     */
    public function getCSS($index=0) {
        return $this->css[$index];
    }

    /**
     * Retourne le nombre de fichier CSS à inserer dans le Controle
     * @return int;
     */
    public function getNbCSS() {
        return count($this->css);
    }

    /**
     * Retourne le path du Fichier Javascript à la position de l'index envoyé en parametre
     * @param Int $index = index (ou position) du fichier souhaité
     */
    public function getJavascript($index=0) {
        return $this->javascript[$index];
    }

    /**
     * Retourne le nombre de fichier Javascript à inserer dans le Controle
     * @return int;
     */
    public function getNbJavascript() {
        return count($this->javascript);
    }

    /**
     * Genere les balises CSS
     * @return String : l'ensemble des balises CSS
     */
    public function genereCSS() {
        return $this->genereBaliseHeader($this->css, '<link href="%s.css" rel="stylesheet" type="text/css" />');
    }

    /**
     * Genere les balises Javascript
     * @return String : l'ensemble des balises Javascript
     */
    public function genereJavascript() {
        return $this->genereBaliseHeader($this->javascript, '<script type="text/javascript" src="%s.js"></script>');
    }

    private function genereBaliseHeader($array, $balise){
        $resultat       = "";

        foreach ($array as $value) {
            
            $mod        = $this->monControle->getModule();
            if(isset($value['module'])){
                $mod    = $value['module'];
            }
            
            $page       = $this->monControle->getPage();
            if(isset($value['page'])){
                $page   = $value['page'];
            }
            
            $resultat .= sprintf($balise, URL_APPLICATION.$mod.'/'.$page);
        }
        return $resultat;
    }
    
    /**
     * Insert automatiquement les fichiers correspondants au module et à la page du Controle
     */
    public function autoAddFile() {
        if (file_exists(RACINE_APPLICATION.$this->monControle->getModule().'/'.$this->monControle->getPage().'.css')) {
            $this->addCSS(array(
                array('module' => $this->monControle->getModule(), 'page' => $this->monControle->getPage())
            ));
        }

        if (file_exists(RACINE_APPLICATION.$this->monControle->getModule().'/'.$this->monControle->getPage().'.js')) {
            $this->addJavascript(array(
                array('module' => $this->monControle->getModule(),'page' => $this->monControle->getPage())
            ));
        }
    }

    /**
     * Retourne une chaine de caracteres appartenant au dictionnaire de langue à partir de sa clé et de sa section. SI n'existe pas, retourne la clé.
     * @param string $section
     * @param string $key
     * @return string 
     */
    public function l($key, $section = ''){
        $lang = $this->monControle->getLang();
        return (isset($lang[$section][$key]))? $lang[$section][$key]: $key;
    }
    
    /**
     * Retourne la génération du fichier HTML
     * @param String $titre : Titre de la page
     * @return String : Retourne le code HTML de la page générée
     */
    public function genere($titre = "") {
        $titre = $this->l($titre);
        include(RACINE_THEME_CHOISI.'index.php');
    }

}
?>