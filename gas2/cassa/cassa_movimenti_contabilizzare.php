<?php
 
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");

include_once ("cassa_renderer.php");



// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
    go("sommario");     
}    

    //COntrollo permessi
    if(!(_USER_PERMISSIONS & perm::puo_gestire_la_cassa)){
        unset($do);
        $msg = "Non hai i permessi necessari per eseguire operazioni sui crediti.";
        include "../index.php";
        
    }

    //REGISTRA
    if($do=="cont"){
          $ok=0; $err_db =0;
          while (list ($key,$val) = @each ($box_contabila)) {
                //Echo "box_id_op = KEY $key Id OP $val<br>";
          $sql = 'UPDATE `retegas_cassa_utenti` SET `id_cassiere` = \''._USER_ID.'\', `contabilizzato` = \'si\', `data_contabilizzato` = NOW() WHERE `retegas_cassa_utenti`.`id_cassa_utenti` = '.$val.' LIMIT 1;';      
          $res = $db->sql_query($sql);
          if(!is_null($res)){
              $ok++;
          }else{
              $err_db++;
          }
                
          }  
          $msg = "Contabilizzati n. <strong>$ok</strong> movimenti;<br>
                  n. $err_db errori database.";
        
        
        
    }
    
    
        
    // ISTANZIO un nuovo oggetto "retegas"
    // Prender� come variabile globale $user, nel caso di user loggato
    // allora visualizza la barra info ed il menu verticale,
    // nel caso di user non loggato visualizza la pagina con "benvenuto" e
    //nel men� verticale i campi per il login
    $retegas = new sito; 
     
    // assegno la posizione che sar� indicata nella barra info 
    $retegas->posizione = "Movimenti da Contabilizzare";
      
    // Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
    // Queste sono contenute in un array che ho chiamato HTML standard
    
    $retegas->sezioni = $retegas->html_standard;
      
    // Il menu' orizzontale � pronto ma � vuoto. Con questa istruzione lo riempio con un elemento
    $retegas->menu_sito[] = gas_menu_gestisci_cassa();
 
    // dico a retegas quali sono i fogli di stile che dovr� usare
    // uso quelli standard per la maggior parte delle occasioni
    $retegas->css = $retegas->css_standard;
     
      
    // dico a retegas quali file esterni dovr� caricare
    $retegas->java_headers = array("rg");  
    
          
      // creo  gli scripts per la gestione dei menu
      
      $retegas->java_scripts_header[] = java_accordion("",menu_lat::gas); // laterale    
      $retegas->java_scripts_header[] = java_superfish();
      $retegas->java_scripts_header[] = '<script type="text/javascript">                
                                                                $(document).ready(function() 
                                                                    {
                                                                        $("#output").tablesorter({widgets: [\'zebra\',\'saveSort\',\'filter\'],
                                                                                                cancelSelection : true,
                                                                                                dateFormat : \'ddmmyyyy\',                                                               
                                                                                                }); 
                                                                        } 
                                                                    );
                                        </script>';
      //$retegas->java_scripts_bottom_body[] = java_qtip(".retegas_form h5[title]");

                 


       
      // assegno l'eventuale messaggio da proporre
      if(isset($msg)){ 
        $retegas->messaggio=$msg;
      }
      
     
      
      
      
          // qui ci va la pagina vera e proria  
      $retegas->content  =  cassa_movimenti_contabilizzare(_USER_ID_GAS,$id_ordine);
      
      
      //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
      $html = $retegas->sito_render();
      // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
      echo $html;
      
      
      //distruggo retegas per recuperare risorse sul server
      unset($retegas);