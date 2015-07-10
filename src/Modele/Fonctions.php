<?php

class Fonctions {

    
    /**
     * Retourne le dico de mot selon la langue choisie
     * @return Array() : tableau de mot
     */
    static function getLang() {
       return parse_ini_file(RACINE_LANG.$_SESSION['lang'].'.ini', true);
    }
    
    /**
     * Fabrique l'URL à partir d'un module et d'une page passés en parametre
     * @param String $module
     * @param String $page
     * @param Array $params : ex : array('id' => 2) donnera &id=2
     * @return String : URL;
     */
    static function lienSite($module, $page, $params = array()) {
        //return "index-".$module."-".$page;
        $url = URL."index.php?md=" . $module . "&pg=" . $page;
        
        foreach($params as $key => $value){
            $url .= '&'.$key.'='.$value;
        }
        return $url;
    }


    /**
     * Encode le fichier en Data Scheme URI
     * @param type $file : path du fichier en encoder
     * @param type $mime : le type de fichier
     * @return type 
     */
    static function dataSchemeURI($file, $mime = "image/png") {
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return "data:$mime;base64,$base64";
    }

    /**
     * Repertorie l'ensemble d'un dossier recursivement et retourne le resultat sous forme de tableau
     * @param string $path : chemin du dossiers
     * @return Array() 
     */
    static function listeRepertoire($path) {
        $dir = opendir($path);

        $maListe = array();
        $i = 0;

        while ($f = readdir($dir)) {
            if (is_file($path . $f)) {
                $maListe[$i]['name'] = $f;
                $maListe[$i]['size'] = filesize($path . $f);
                $maListe[$i]['created'] = date("d/m/Y H:i:s", filectime($path . $f));
                $maListe[$i]['edited'] = date("d/m/Y H:i:s", filemtime($path . $f));
                $maListe[$i]['acces'] = date("d/m/Y H:i:s", fileatime($path . $f));

                $i++;
            }
        }

        closedir($dir);

        return $maListe;
    }

    /**
     * Evite les confirmations intempestives lors du rafraichissement d'un formulaire
     */
    static function sauvegardePost() {
        if(count($_POST) > 0){
            $_SESSION['sauvegardePost'] = $_POST;
            $fichierActuel = $_SERVER['PHP_SELF'];
            
            if (!empty($_SERVER['QUERY_STRING'])) {
                $fichierActuel .= '?' . $_SERVER['QUERY_STRING'];
            }
            header('Location: ' . $fichierActuel);
            exit();
        }
        elseif(isset($_SESSION['sauvegardePost'])){
            $_POST = $_SESSION['sauvegardePost'];
            unset($_SESSION['sauvegardePost']);
        }
        else{
            unset($_POST);
        }
    }

    /**
     * Retourne True si l'email est valide, sinon False
     * @param String $email
     * @return Boolean;
     */
    static function emailCorrect($email) {
        if (empty($email) || count(preg_split("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{2,}[.][a-zA-Z]{2,3}$/", $email, 0, PREG_SPLIT_NO_EMPTY)) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Recupere l'ID d'une video Youtube à partir de son lien
     * @param string $lien
     * @return string 
     */
    static function getIdYoutube($lien) {
        $maChaine = strpos($lien, "v=");


        if ($maChaine === false) {
            $maChaine = strpos($lien, ".be/");

            if ($maChaine === false) {
                return null;
            } else {
                $laFin = strpos($lien, "&");

                if ($laFin === false) {
                    return substr($lien, $maChaine + 4);
                } else {
                    return substr($lien, $maChaine + 4, ($laFin - ($maChaine + 4)));
                }
            }
        } else {
            $laFin = strpos($lien, "&");

            if ($laFin === false) {
                return substr($lien, $maChaine + 2);
            } else {
                return substr($lien, $maChaine + 2, ($laFin - ($maChaine + 2)));
            }
        }
    }
    
    /**
     * Genere un mot de passe selon la $longueur (defaut = 8) et un $niveau (default 'ALL') definit
     * 'NUM' ou 'num'   = numeric
     * 'alpha'          = chaine minuscule
     * 'ALPHA'          = chaine majuscule
     * 'alphanum'       = chaine + numeric minuscule
     * 'ALPHANUM'       = chaine + numeric majuscule
     * 'FULL'           = chaine (minuscule et majuscule) + numeric + caracteres speciaux
     * 'ALL'            = chaine (minuscule et majuscule) + numeric
     * @param type $longeur     : longueur du mot de passe souhaité
     * @param type $niv         : niveau de protection du passe
     * @return string           : le mot de passe generé
     */
    static function generateurPass($longeur = 8, $niv = "ALL"){
        $string = "";
        
        switch ($niv) {
            case "NUM":
            case "num":
                $chaine = "0123456789";
                break;
            case "alpha":
                $chaine = "abcdefghijklmnpqrstuvwxy";
                break;
            case "ALPHA":
                $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
            case "alphanum":
                $chaine = "abcdefghijklmnpqrstuvwxy0123456789";
                break;
            case "ALPHANUM":
                $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                break;
            case "FULL":
                $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!*@/:_&-#$%\;,.?";
                break;
            default:
                $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                break;
        }

        for($i=0; $i<$longeur; $i++) {
                $string .= $chaine[rand(1, strlen($chaine))%strlen($chaine)];
        }

        return $string;
    }
    
    /**
     * Retourne une date formatée selon nos souhait
     * Par defaut, converti une date FR en date EN
     * @param string $date : 01/01/1955
     * @param string $formatEntree : 'd/m/Y'
     * @param string $formatSortie : 'Y-m-d'
     * @return retourne la date en  $formatEntree en $formatSortie
     */
    static function dateToFormat($date, $formatEntree = 'd/m/Y', $formatSortie = 'Y-m-d'){
        return DateTime::createFromFormat($formatEntree,$date)->format($formatSortie);
    }
    
    /**
     * Permet de faire un VAR_DUMP de la variable VAR passé en parametre.
     * Le plus : presentation plus claire
     * @param Object $var : variable à dumper
     */
    static function dump($var){
        
        ob_start();
        var_dump($var);
        $ok= ob_get_contents();
        ob_end_clean();

        $ok = preg_replace('/:/', "<span style='color:black;'>$0</span>", $ok);
        $ok = preg_replace('/([(][0-9]{1,}[)])/', "<span style='color:blue;'>$0</span>", $ok);
        $ok = preg_replace('/(private|protected|public)/', "<span style='color:green;'>$0</span>", $ok);
        $ok = preg_replace('/(".*")/', "<span style='color:red;'>$0</span>", $ok);
        
        $ok = preg_replace('/\=\>/', "<span style='font-weight:bold;'>$0</span>", $ok);

        echo '<pre style="background-color: white; border: 1px solid red; padding: 5px 5px 5px 5px;">';
        echo $ok;
        echo '</pre>'; 
    }
}

?>
