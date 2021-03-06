<?php
  
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
//
include_once ("ditte_renderer.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
	pussa_via();
	exit;     
}    
   // ISTANZIO un nuovo oggetto "retegas"

	$retegas = new sito;
	$retegas->posizione = "Tutte le ditte";
	$ref_table ="output";

  
	// Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
	// Queste sono contenute in un array che ho chiamato HTML standard
	
	$retegas->sezioni = $retegas->html_standard;
	  
	// Il menu' orizzontale � pronto ma � vuoto. Con questa istruzione lo riempio con un elemento
	

	$retegas->menu_sito = ditte_menu_completo();
	//$retegas->menu_sito[] = $h_menu;
	
    // dico a retegas quali sono i fogli di stile che dovr� usare
	// uso quelli standard per la maggior parte delle occasioni
	$retegas->css = $retegas->css_standard;
	//$retegas->css[]  = "datetimepicker"; 
	  
	// dico a retegas quali file esterni dovr� caricare
	$retegas->java_headers = array("rg");  // editor di testo
		  
	  // creo  gli scripts per la gestione dei menu
	  
	  $retegas->java_scripts_header[] = java_accordion(null,menu_lat::anagrafiche); // laterale    
	  $retegas->java_scripts_header[] = java_superfish(); 	  
      $retegas->java_scripts_bottom_body[] = java_list_filter();
	  // assegno l'eventuale messaggio da proporre
	  if(isset($msg)){ 
		$retegas->messaggio=$msg;
	  }
	  
	  
	  
			// qui ci va la pagina vera e proria  
	  $retegas->content  =  ditte_render_table_2($ref_table);
		
	  $html = $retegas->sito_render();
	  echo $html;
	  exit;

	  unset($retegas);