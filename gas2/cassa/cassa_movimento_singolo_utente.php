<?php

   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
//
include_once ("cassa_renderer.php");



// controlla se l'user ha effettuato il login oppure no
if (is_logged_in($user)){

    // estraggo dal cookie le informazioni su chi ? che sta vedendo la pagina
    $cookie_read     =explode("|", base64_decode($user));
    $id_user  = $cookie_read[0];
    $permission = $cookie_read[6];
    $my_user_level = user_level($id_user);
    
    // Costruisco i menu 
    //$mio_menu = gas_menu_completo($user);
        
    // scopro come si chiama
    $usr = fullname_from_id($id_user);
    // e poi scopro di che gas ? l'user
    $id_gas = id_gas_user($id_user);
    
}else{
    pussa_via();
    exit;     
}    

//CONTROLLO CHE SOLTANTO I MOVIMENTI DI USER POSSANO ESSERE VISTI DA USER 
if(!isset($id_movimento)){
    pussa_via();
    exit;    
}

if(db_val_q("id_cassa_utenti",$id_movimento,"id_utente","retegas_cassa_utenti")<>$id_user){
     pussa_via();
    exit;    
}


    // ISTANZIO un nuovo oggetto "retegas"
    // Prender? come variabile globale $user, nel caso di user loggato
    // allora visualizza la barra info ed il menu verticale,
    // nel caso di user non loggato visualizza la pagina con "benvenuto" e
    //nel men? verticale i campi per il login
    $retegas = new sito; 
     
    // assegno la posizione che sar? indicata nella barra info 
    $retegas->posizione = "Scheda Singolo movimento Cassa";
      
    // Dico a retegas come sar? composta la pagina, cio? da che sezioni ? composta.
    // Queste sono contenute in un array che ho chiamato HTML standard
    
    $retegas->sezioni = $retegas->html_standard;
      
    // Il menu' orizzontale ? pronto ma ? vuoto. Con questa istruzione lo riempio con un elemento
    $retegas->menu_sito[] = gas_menu_gestisci_cassa($user);
 
    // dico a retegas quali sono i fogli di stile che dovr? usare
    // uso quelli standard per la maggior parte delle occasioni
    $retegas->css = $retegas->css_standard;
      
      
    // dico a retegas quali file esterni dovr? caricare
    $retegas->java_headers = array("rg");  // ordinatore di tabelle
          

       
      $retegas->java_scripts_header[]=java_accordion("#accordion",menu_lat::gas); // laterale    
      $retegas->java_scripts_header[]=java_superfish();
      
          // orizzontale                         

      // assegno l'eventuale messaggio da proporre
      if(isset($msg)){ 
        $retegas->messaggio=$msg;
      }
      
      // qui ci va la pagina vera e proria  
      
    $retegas->content  =  cassa_movimento_singolo_utente($id_movimento);
      
      
            
      //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
      $html = $retegas->sito_render();
      // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
      echo $html;
      
      
      //distruggo retegas per recuperare risorse sul server
      unset($retegas);      
      
      
      
?> 