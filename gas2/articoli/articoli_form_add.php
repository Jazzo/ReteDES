<?php

   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");

include_once ("articoli_renderer.php");

//Ricevo come GET id = id_ordine
// Lo obbligo ad essere un intero
(int)$id;

// controlla se l'user ha effettuato il login oppure no
if (is_logged_in($user)){

	// estraggo dal cookie le informazioni su chi � che sta vedendo la pagina
	$cookie_read     =explode("|", base64_decode($user));
	$id_user  =  $cookie_read[0];
	$usr =       $cookie_read[1]; 
	$permission = $cookie_read[6];
										
	// e poi scopro di che gas � l'user
	$gas = id_gas_user($id_user);
	
}else{
	pussa_via();
	exit;     
}    

	//COntrollo permessi
	if(!($permission & perm::puo_creare_listini)){
		unset($do);
		$msg = "Non hai i permessi necessari per eseguire operazioni sui listini.";
		include "../index.php";
		
	}

	if($do=="add"){
			
			$msg = 	articoli_render_do_add($user,$id);
			if($msg=="OK"){$msg="Articolo aggiunto correttamente";
						   include("../listini/listini_form.php");
						   exit;}
	}
		 
	// ISTANZIO un nuovo oggetto "retegas"
	// Prender� come variabile globale $user, nel caso di user loggato
	// allora visualizza la barra info ed il menu verticale,
	// nel caso di user non loggato visualizza la pagina con "benvenuto" e
	//nel men� verticale i campi per il login
	$retegas = new sito; 
	 
	// assegno la posizione che sar� indicata nella barra info 
	$retegas->posizione = "Crea nuovo articolo";
	  
	// Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
	// Queste sono contenute in un array che ho chiamato HTML standard
	
	$retegas->sezioni = $retegas->html_standard;
	  
	// Il menu' orizzontale � pronto ma � vuoto. Con questa istruzione lo riempio con un elemento
	//$retegas->menu_sito = ordini_menu_completo($user);
 
	// dico a retegas quali sono i fogli di stile che dovr� usare
	// uso quelli standard per la maggior parte delle occasioni
	$retegas->css = $retegas->css_standard;
	 
	  
	// dico a retegas quali file esterni dovr� caricare
	$retegas->java_headers = array("rg","ckeditor");  // editor di testo
	
		  
	  // creo  gli scripts per la gestione dei menu
	  
	  $retegas->java_scripts_header[] = java_accordion("",menu_lat::anagrafiche); // laterale    
	  $retegas->java_scripts_header[] = java_superfish();
	  $retegas->java_scripts_bottom_body[] = java_qtip(".retegas_form h5[title]");

				 


	   
	  // assegno l'eventuale messaggio da proporre
	  if(isset($msg)){ 
		$retegas->messaggio=$msg;
	  }
	  
			// QUa butto fuori chi usa EXPLORER !!!
	  $h = articoli_render_add($id);
	  
	  
		  // qui ci va la pagina vera e proria  
	  $retegas->content  =  $h;
	  
	  
	  //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
	  $html = $retegas->sito_render();
	  // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
	  echo $html;
	  
	  
	  //distruggo retegas per recuperare risorse sul server
	  unset($retegas);	