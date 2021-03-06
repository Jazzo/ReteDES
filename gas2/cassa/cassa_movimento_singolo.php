<?php

   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
//
include_once ("cassa_renderer.php");



// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
    pussa_via();
    exit;     
}    

if(!(_USER_PERMISSIONS & perm::puo_gestire_la_cassa)){
    pussa_via();
    exit;    
    
}

if(!isset($id_movimento)){
    pussa_via();
    exit;    
}


if(_USER_ID_GAS <> db_val_q("id_cassa_utenti",(int)$id_movimento,"id_gas","retegas_cassa_utenti")){
    pussa_via();
    exit; 
} 

if($do=="do_rett"){
        $importo=sanitize($importo);
        if(valuta_valida($importo)){
            if($segno=="+"){$segno="+";}else{$segno="-";}
            $descrizione = "Rettifica op. # $id_movimento";
            $sql="INSERT INTO retegas_cassa_utenti  (id_utente, 
                                                        id_gas, 
                                                        id_ditta, 
                                                        importo, 
                                                        segno,
                                                        tipo_movimento,
                                                        escludi_gas,
                                                        descrizione_movimento,
                                                        note_movimento,
                                                        data_movimento,
                                                        numero_documento,
                                                        id_ordine,
                                                        id_cassiere)
                                                        SELECT  id_utente, 
                                                                id_gas, 
                                                                id_ditta, 
                                                                '$importo', 
                                                                '$segno',
                                                                '3',
                                                                escludi_gas,
                                                                '$descrizione',
                                                                note_movimento,
                                                                data_movimento,
                                                                numero_documento,
                                                                id_ordine,
                                                                '".$id_user."' 
                                                                    FROM retegas_cassa_utenti 
                                                                    WHERE id_cassa_utenti ='$id_movimento';";  
            
           $db->sql_query($sql);
            $msg = "Movimento di rettifica inserito"; 
            
        }else{
            $msg = "Importo non riconosciuto";
        }
        
    }
if($do=="do_del"){
    $sql ="DELETE FROM retegas_cassa_utenti WHERE id_cassa_utenti='$id_movimento' LIMIT 1;";
    log_me(0,_USER_ID,"CAS","DEL","E' avvenuta una cancellazione di movimento utente verso Ut. $id_utente",$id_movimento,$sql);
    
    $db->sql_query($sql);
    $msg = "Movimento Cancellato";
    
    go("movimenti_cassa_users",_USER_ID,"Movimento Eliminato","?id_utente=".$id_utente);
}    
   

    

     
    // ISTANZIO un nuovo oggetto "retegas"
    // Prender� come variabile globale $user, nel caso di user loggato
    // allora visualizza la barra info ed il menu verticale,
    // nel caso di user non loggato visualizza la pagina con "benvenuto" e
    //nel men� verticale i campi per il login
    $retegas = new sito; 
     
    // assegno la posizione che sar� indicata nella barra info 
    $retegas->posizione = "Scheda Singolo movimento Cassa";
      
    // Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
    // Queste sono contenute in un array che ho chiamato HTML standard
    
    $retegas->sezioni = $retegas->html_standard;
      
    // Il menu' orizzontale � pronto ma � vuoto. Con questa istruzione lo riempio con un elemento
    $retegas->menu_sito[] = gas_menu_gestisci_cassa($user);
 
    // dico a retegas quali sono i fogli di stile che dovr� usare
    // uso quelli standard per la maggior parte delle occasioni
    $retegas->css = $retegas->css_standard;
      
      
    // dico a retegas quali file esterni dovr� caricare
    $retegas->java_headers = array("rg");  // ordinatore di tabelle
          

       
      $retegas->java_scripts_header[]=java_accordion("#accordion",menu_lat::gas); // laterale    
      $retegas->java_scripts_header[]=java_superfish();
      
          // orizzontale                         

      // assegno l'eventuale messaggio da proporre
      if(isset($msg)){ 
        $retegas->messaggio=$msg;
      }
      
      // qui ci va la pagina vera e proria  
      $retegas->content  =  cassa_movimento_singolo($id_movimento);

      
            
      //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
      $html = $retegas->sito_render();
      // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
      echo $html;
      
      
      //distruggo retegas per recuperare risorse sul server
      unset($retegas);      
      
      
      
?> 