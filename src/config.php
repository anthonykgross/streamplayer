<?php

define('GOOGLE_ANALYTIC', "
    <script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20778728-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>  
    ");

    define('EMAIL',                 'anthony_gross@kkuet.net');
    define('TITRE_SITE',            "Streamplayer.Kkuet.net - ");
    
    define('DEFAULT_THEME',         'default/');
    
    /**
     * On definit le module et la page par default
     */
    define('MODULE_DEFAULT',        'general');
    define('PAGE_DEFAULT',          'index');
    
    define('LANG_DEFAULT',          'fr');
    
    define('DB_PREFIX',             'mysql');
    define('DB_BASE',               'streamplayer');
    define('DB_USER',               'root');
    define('DB_MDP',                'root');
    define('DB_HOST',               'mysql'); //localhost without docker
    
    define('MODE_DEBUG',            true);
    
    define('MODELE',                "Modele/");
    define('FICHIER',               "Fichier/");
    define('APPLICATION',           "Application/");
    define('THEME',                 "Theme/");
    define('LANG',                  "Lang/");

    /***************************************************************************/
    define('ABSOLUTE_PATH',         dirname(__FILE__).'/');     
    define('RACINE_APPLICATION',    ABSOLUTE_PATH.APPLICATION);
    define('RACINE_MODELE',         ABSOLUTE_PATH.MODELE);
    define('RACINE_FICHIER',        ABSOLUTE_PATH.FICHIER);
    define('RACINE_LANG',           ABSOLUTE_PATH.LANG);
    
    define('THEME_CHOISI',          THEME.DEFAULT_THEME);
    define('RACINE_THEME_CHOISI',   ABSOLUTE_PATH.THEME_CHOISI);

    define('DB_DSN',                DB_PREFIX.':host='.DB_HOST.';dbname='.DB_BASE);

    set_include_path(get_include_path() . PATH_SEPARATOR . RACINE_MODELE);

    function __autoload($class_name) {
            $maChaine   = explode("_", $class_name);
            $path       = RACINE_MODELE;
            $path      .= str_replace('_','/',$class_name);
            $path      .= ".php";

            if(is_file($path)) {
                require_once $path;
            }
            elseif(MODE_DEBUG) {
                echo 'Invalide class name : <b>'.$class_name.'</b>';
            }
    }
    

    $page                           = (isset($_GET['pg']))?$_GET['pg']:PAGE_DEFAULT;
    define('PAGE',                  $page);

    $module                         = (isset($_GET['md']))?$_GET['md']:MODULE_DEFAULT;
    define('MODULE',                $module);

    $_SESSION['lang']               = (isset($_SESSION['lang']))?$_SESSION['lang']:LANG_DEFAULT;
    
    define('URL',                   str_replace('index.php', '', 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME']));
    define('URL_THEME_CHOISI',      URL.THEME_CHOISI);
    define('URL_APPLICATION',       URL.APPLICATION);
?>
