
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="google-site-verification" content="637SJ1Smi6Bi0BZnv9I1PPV3QzjjX1guf8uI57ScQiA" />
        <meta name="keywords" content="<?php echo $this->getMetaKeyword(); ?>" />
        <meta name="title" content="<?php echo $titre; ?>" />
        <meta name="description" content="<?php echo $this->getMetaDescription(); ?>" />
        
        <!-- BALISE POUR FACILITER LE PARTAGE SUR FACEBOOK -->
        <link rel="image_src" href="<?php echo $this->getImageSrc(); ?>" />
        <!--  -->
        
        <link rel="icon" href="<?php echo URL_THEME_CHOISI; ?>Images/favicon.ico" type="image/x-icon" />
        <link href='https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister|Cabin+Sketch:700' rel='stylesheet' type='text/css'>
        <link href="<?php echo URL_THEME_CHOISI; ?>CSS/styleSite.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL_THEME_CHOISI; ?>CSS/pascal.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL_THEME_CHOISI; ?>CSS/nivo-slider.css" rel="stylesheet" type="text/css" />
        <?php echo $this->genereCSS(); ?>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<!--        <script type="text/javascript" src="http://www.balafr3.net/Javascript/jquery.corner.js"></script> -->
        <script type="text/javascript" src="<?php echo URL_THEME_CHOISI. 'Javascript/swfobject.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo URL_THEME_CHOISI. 'Javascript/general.js'; ?>"></script>
        
        <?php echo $this->genereJavascript(); ?>
        
        <title><?php echo TITRE_SITE . $titre; ?></title>
    </head>
    <body>
        <div id="header"><?php include(RACINE_THEME_CHOISI . 'header.php'); ?></div>
        <div id="corps">
            <div id="menuHaut">
                <?php include(RACINE_THEME_CHOISI . 'menuHaut.php'); ?>
            </div>
            <div id="menuGauche"><?php include(RACINE_THEME_CHOISI . 'menuGauche.php'); ?></div>
            <div id="toolbar"><?php include(RACINE_THEME_CHOISI . 'toolbar.php'); ?></div>
            <div id="centrale">
                <div id="contenu">
                    <?php
                    if (is_file(RACINE_APPLICATION . $this->monControle->getModule() . '/' . $this->monControle->getPage() . '.phtml')) {
                        include RACINE_APPLICATION . $this->monControle->getModule() . '/' . $this->monControle->getPage() . '.phtml';
                    } else {
                        ?><b><?php echo "La page du Controle est introuvable : " . RACINE_APPLICATION . $this->monControle->getModule() . '/' . $this->monControle->getPage() . '.phtml'; ?></b><?php
                    }
                    ?>
                </div>
            </div>
            <div class="spacer"></div>
            <div id="footer">
                <?php include(RACINE_THEME_CHOISI . 'footer.php'); ?>
            </div>
        </div>
        <?php echo GOOGLE_ANALYTIC; ?>
    </body>
</html>	
