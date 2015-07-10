<?php

abstract class kObject {

    /**
     * Recherche un attribut ou methode dans un objet et retourne son accessibilité (Public, Protected, Private
     * @param Object $class
     * @param String $attr : nom de l'attribut a rechercher
     * @return Array()
     */
    static function getAccess($class, $attr) {

        $obj    = new ReflectionClass($class);
        $find   = true;
        $tab    = array();

        if ($obj->hasMethod($attr)) {
            $tab['type']    = 'method';
            $obj            = $obj->getMethod($attr);
        } 
        elseif ($obj->hasProperty($attr)) {
            $tab['type']    = 'property';
            $obj            = $obj->getProperty($attr);
        } 
        elseif ($obj->hasConstant($attr)) {
            $tab['type']    = 'constant';
            $obj            = $obj->getContant($attr);
        } 
        else {
            $find = false;
        }

        if ($find) {
            $tab['private']     = $obj->isPrivate();
            $tab['protected']   = $obj->isProtected();
            $tab['public']      = $obj->isPublic();
            return $tab;
        } 
        else {
            return null;
        }
    }

    /**
     * Recupere toutes les informations necessaire sur un objet
     * @param Obejct $obj
     */
    static function getStructure($obj) {
        $obj = new ReflectionClass($obj);

        $tab = array();
        $tab['class']               = $obj->getName();
        $tab['parentClass']         = $obj->getParentClass();
        $tab['constants']           = $obj->getConstants();
        $tab['staticProperties']    = $obj->getStaticProperties();
        $tab['properties']          = $obj->getProperties();
        $tab['methods']             = $obj->getMethods();
        $tab['filename']            = $obj->getFileName();
        $tab['isAbstract']          = $obj->isAbstract();
        $tab['isFinal']             = $obj->isFinal();
        $tab['isIterateable']       = $obj->isIterateable();
        return $tab;
    }

}

?>