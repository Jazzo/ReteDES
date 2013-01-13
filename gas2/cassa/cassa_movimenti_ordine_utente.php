<?php
   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
include_once ("cassa_renderer.php");




// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
     pussa_via(); 
}

if(is_empty($id_utente)){
    $id_utente = _USER_ID;
}else{
    $id_utente = mimmo_decode($id_utente);
}

if(_USER_ID<>$id_utente){
    if (!(_USER_PERMISSIONS & perm::puo_gestire_la_cassa)){
        pussa_via();
    }    
}






//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del menù verticale dovrà essere aperta
$r->voce_mv_attiva = menu_lat::gas;
//Assegno il titolo che compare nella barra delle info
$r->title = "Movimenti ordine utente";
$r->javascripts_header[]  =java_tablesorter("output");

//Messaggio popup;
//$r->messaggio = "Pagina di test"; 
//Dico quale menù orizzontale dovrà  essere associato alla pagina.
$r->menu_orizzontale[] = gas_menu_gestisci_cassa();

$r->messaggio = $msg;
//Creo la pagina dell'aggiunta

//--------------------------------------------CONTENUTO
     
      
//Uso cassa
$h = cassa_movimenti_ordine_utente($id_ordine,$id_utente);
     
//-----------------------------------------------------


//$r->contenuto = rg_toggable("Alcune novità","poio",$bla,false).$h;
$r->contenuto = $h;

//Mando all'utente la sua pagina
echo $r->create_retegas();
//Distruggo l'oggetto r    
unset($r)    
    
?>