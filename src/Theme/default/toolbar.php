<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
    <a class="addthis_button_facebook"></a>
    <a class="addthis_button_twitter"></a>
    <a class="addthis_button_email"></a>
    <a class="addthis_button_favorites"></a>
    <a class="addthis_button_print"></a>
</div>

<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d04a80e7f7ba19e"></script>
<!-- AddThis Button END -->

<div id="search">
    <form method="post" action="<?php echo Fonctions::lienSite("general", "listeNews");?>" name="search">
        <img src='<?php echo URL_THEME_CHOISI.'Images/Icons/search.png'; ?>' title="Recherche" alt="search"/>
        <input type="text" name="search" value="<?php echo (isset($this->monControle->motCle))?$this->monControle->motCle:''; ?>" />
        <a href="#" title="Changer la taille de la police" class="font-size-up">A</a>
    </form>
</div>