<?php 
if(!isset($_COOKIE['lang']) || empty($_COOKIE['lang'])) {
    setcookie('lang', 'en', time() + 60*60*24*30);
}

switch(@$_COOKIE['lang']){
    case 'fr': 
        include_once 'assets/lang/fr.php';
        $lang = 'fr';
    break;
    case 'it': 
        include_once 'assets/lang/it.php';
        $lang = 'it';
    break;
    case 'es': 
        include_once 'assets/lang/es.php';
        $lang = 'es';
    break;
    case 'ru': 
        include_once 'assets/lang/ru.php';
        $lang = 'ru';
    break;
    case 'de': 
        include_once 'assets/lang/de.php';
        $lang = 'de';
    break;
    case 'id': 
        include_once 'assets/lang/id.php';
        $lang = 'id';
    break;
    case 'en': default: 
        include_once 'assets/lang/en.php';
        $lang = 'en';
    break;
}
?>