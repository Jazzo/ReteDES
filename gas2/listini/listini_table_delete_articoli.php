<?php


// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
//
include_once ("listini_renderer.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
    pussa_via();
    exit;     
}    
   // Controllo che il listino sia settato e mio
if(isset($id_listini)){
    if(listino_proprietario($id_listini)<>_USER_ID){
        go("sommario",_USER_ID,"Non puoi operare con un listino non tuo");
    }        
}else{
    pussa_via();
    exit;
}
   
   if($do=="do_del"){
          $ok=0; $err_db =0;
          while (list ($key,$val) = @each ($box_delete)) {
          
            if(articoli_in_ordine($val)==0){  
                $sql = "DELETE FROM retegas_articoli WHERE id_articoli='$val' LIMIT 1;";      
                $res = $db->sql_query($sql);
                if(!is_null($res)){
                      $ok++;
                }else{
                  $err_db++;
                }
            }     
          }  
          $msg = "Cancellati n. <strong>$ok</strong> articoli;";
        
        
        
    }
    
   
   
    $retegas = new sito;
    
    


    $retegas->posizione = "Cancella alcuni articoli";
    //$retegas->help_page = "https://sites.google.com/site/retegasapwiki/i-menu-del-sito-retegas-ap/pagine-del-sito/i-miei-listini";     

    $retegas->sezioni = $retegas->html_standard;
    $retegas->menu_sito[]=listini_menu($user,$id_listini); 

    $retegas->css = $retegas->css_standard;

    $retegas->java_headers = array("rg");  // editor di testo

      
      $retegas->java_scripts_header[] = java_accordion(null,menu_lat::anagrafiche); // laterale    
      $retegas->java_scripts_header[] = java_superfish();       
      $retegas->java_scripts_bottom_body[] = java_tablesorter("table_ref");
      
      if(isset($msg)){ 
        $retegas->messaggio=$msg;
      }
      
      
      
            // qui ci va la pagina vera e proria  
      $retegas->content  =  listini_render_delete_articoli($id_listini);
        
      $html = $retegas->sito_render();
      echo $html;
      exit;

      unset($retegas);      
      
      
      
?>