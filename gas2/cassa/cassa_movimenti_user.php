<?php

   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");

include_once ("cassa_renderer.php");

if(_USER_HAVE_MSG){
    $r->messaggio = _USER_MSG;
    delete_option_text(_USER_ID,"MSG");
}


if(isset($id_utente)){
    (int)$id_utente = mimmo_decode($id_utente);
    if(!(_USER_PERMISSIONS & perm::puo_gestire_la_cassa)){
        unset($do);
        $msg = "Non hai i permessi necessari.";
        go("sommario",_USER_ID,$msg);
    }

}else{
    $id_utente=_USER_ID;
        //COntrollo permessi
    if(!(_USER_USA_CASSA)){
        unset($do);
        $msg = "Non hai abilitato la cassa.";
        go("sommario",_USER_ID,$msg);
    }


}

// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){

    pussa_via();
    exit;     
}    



        
    // ISTANZIO un nuovo oggetto "retegas"
    // Prender� come variabile globale $user, nel caso di user loggato
    // allora visualizza la barra info ed il menu verticale,
    // nel caso di user non loggato visualizza la pagina con "benvenuto" e
    //nel men� verticale i campi per il login
    $retegas = new sito; 
     
    // assegno la posizione che sar� indicata nella barra info 
    $retegas->posizione = "Miei movimenti cassa";
      
    // Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
    // Queste sono contenute in un array che ho chiamato HTML standard
    
    $retegas->sezioni = $retegas->html_standard;
      
    // Il menu' orizzontale � pronto ma � vuoto. Con questa istruzione lo riempio con un elemento
    $retegas->menu_sito[] = gas_menu_gestisci_cassa($user);
 
    // dico a retegas quali sono i fogli di stile che dovr� usare
    // uso quelli standard per la maggior parte delle occasioni
    $retegas->css = $retegas->css_standard;
     
      
    // dico a retegas quali file esterni dovr� caricare
    $retegas->java_headers = array("rg");  
    
          
      // creo  gli scripts per la gestione dei menu
      
      $retegas->java_scripts_header[] = java_accordion("",menu_lat::user); // laterale    
      $retegas->java_scripts_header[] = java_superfish();
      $retegas->java_scripts_header[]=java_tablesorter("output");
      //$retegas->java_scripts_bottom_body[] = java_qtip(".retegas_form h5[title]");

                 


       
      // assegno l'eventuale messaggio da proporre
      if(isset($msg)){ 
        $retegas->messaggio=$msg;
      }
      
     
     $retegas->has_bookmark="SI"; 
      
      
          // qui ci va la pagina vera e proria  
      $retegas->content  =  cassa_render_user_panel($id_utente).
                            cassa_movimenti_users_table($id_utente);
      
      
      //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
      $html = $retegas->sito_render();
      // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
      echo $html;
      
      
      //distruggo retegas per recuperare risorse sul server
      unset($retegas);    
                  