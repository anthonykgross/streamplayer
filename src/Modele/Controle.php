<?php

/**
 * --------------------------------------------------------------------------------------
 * 
 * CETTE CLASSE PERMET DE CONTROLER TOUT CE QUI CONCERNE LA PAGE EN COURS DE CREATION
 * AFIN DE GENERER LA PAGE DANS DE BONNE CONDITION ET DE FACON LA PLUS OPTIMISEE POSSIBLE
 * CE CONTROLE VA VERIFIER LES SESSIONS
 * 
 * @author kkuet
 * 
 * ---------------------------------------------------------------------------------------
 */
class Controle extends kObject {

    private     $module;
    private     $page;
    private     $variables              = array();
    private     $connexionOk            = true;
    private     $errors                 = array();
    private     $lang;
    
    
    /* -- En cas de non session, on redirige vers le module general, page = noSession.php -- */
    private $moduleRedirectionSession   = 'general';
    private $pageRedirectionSession     = 'noSession';

    /**
     * Constructeur de la classe Controle.
     * Permet de creer un objet de type Controle
     * @param String $module = Le nom d'un module
     * @param String $page = Le nom de la page correspondant à un module (pas de ".php")
     * @param Array $sessionsRequises = Sessions requises pour accéder à cette page ou pas ? 
     */
    public function __construct($params = array()) {
        
        $this->lang                             = Fonctions::getLang();
        
        if(is_array($params)){
            if(isset($params['module'])){
                $this->module                   = $params['module'];
            }
            else{
                $this->module                   = MODULE;
            }
            
            $this->page                         = "index";
            if(isset($params['page'])){
                $this->page                     = $params['page'];
            }

            if(isset($params['moduleNoSession'])){
                $this->moduleRedirectionSession = $params['moduleNoSession'];
            }

            if(isset($params['pageNoSession'])){
                $this->pageRedirectionSession   = $params['pageNoSession'];
            }

            if(isset($params['sessionRequise'])){
                self::verifSession($params['sessionRequise']);
            }
            
        }
        else{
            $this->errors[] =  "Le parametre de la classe Controle doit etre un Array.";
        }
        
        if(MODE_DEBUG && $this->getErrors()){
            Fonctions::dump($this->errors);
        }
    }

    /**
     * Si une methode est appellée et est non defini, on retourne un message d'erreur
     * @throws Exception
     */
    public function __call($name, $arguments) {
        if(MODE_DEBUG){
            throw new Exception('Undefined method ' . $name);
        }
    }

    /**
     * Recupere la valeur ($value) de $variables d'index $name
     */
    public function __get($name) {
        return (array_key_exists($name, $this->variables)) 
                ?$this->variables[$name] 
                :false;
        
    }

    /**
     * Definie une valeur ($value) de $variables d'index $name
     */
    public function __set($name, $value) {
        return $this->variables[$name] = $value;
    }

    /**
     * Retourne un tableau complet de l'objet
     */
    public function __toString() {
        $resultat = var_export(kObject::getStructure($this), true);
        return '<pre>' . $resultat . '</pre>';
    }

    /**
     * Verifie si les sessions sont existantes ou pas.
     * Sinon, redirection vers la page et module definie en attributs de classe.
     * @param Array() $sessionsRequises
     */
    private function verifSession($sessionsRequises = array()) {
        /**
         * On verifie si une des sessions requises existe dans les $_SESSION
         */
        $this->connexionOk = (count(array_intersect($sessionsRequises, array_keys($_SESSION))) != 0);        
        
        if (!$this->connexionOk) {
            $this->module   = $this->moduleRedirectionSession;
            $this->page     = $this->pageRedirectionSession;
        }
    }

    /**
     * Retourne tous les messages d'erreurs
     * @return string[] 
     */
    public function getErrors(){
        return (count($this->errors)> 0) ? $this->errors : null;
    }
    
    /**
     * Recupere le module du Controle
     */
    public function getModule() {
        return $this->module;
    }

    /**
     * Recupere la page du Controle
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Retourne si la connexion est bonne ou pas.
     */
    public function getConnexion() {
        return $this->connexionOk;
    }

    /**
     * Retourne si le dictionnaire de la langue choisie
     */
    public function getLang() {
        return $this->lang;
    }

}

?>