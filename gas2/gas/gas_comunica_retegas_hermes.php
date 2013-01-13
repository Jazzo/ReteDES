<?php

   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");

include_once ("gas_renderer.php");



// controlla se l'user ha effettuato il login oppure no
if (is_logged_in($user)){

	// estraggo dal cookie le informazioni su chi ? che sta vedendo la pagina
	$cookie_read     =explode("|", base64_decode($user));
	$id_user  = $cookie_read[0];
	$permission =  $cookie_read[6]; 
	
	// Costruisco i menu 
	$mio_menu = des_menu_completo($id_user);

	
	// scopro come si chiama
	$usr = fullname_from_id($id_user);
	// e poi scopro di che gas ? l'user
	$gas = id_gas_user($id_user);
	
}else{
	pussa_via();
	exit;     
}    

//Controllo di essere il referente del mio gas
 if((id_proprio_referente_retegas($gas)<>$id_user) OR (!($permission & perm::puo_vedere_retegas))){
    pussa_via();
    exit;      
}


	
if($do=="send"){
		
		if(empty($data_6)){
			$msg = "Messaggio vuoto";
			unset($do);
			include ("gas_comunica_gas_hermes.php");
			die();
		}
		
		
		//include_once ("../Swift-4.0.6/mailer.php");
		
		// IMPOSTO DA CHI PARTE LA MAIL
		$da_chi = fullname_from_id($id_user);
		$mail_da_chi = id_user_mail($id_user);

		
		$qry=" SELECT
		maaking_users.fullname,
		maaking_users.email,
		maaking_users.user_site_option
		FROM
		maaking_users";
		
		$result = $db->sql_query($qry); 
		while ($row = mysql_fetch_array($result)){
		// NON ESEGUO LA VERIFICA SULLE OPZIONI
			
				$verso_chi[] = $row[0] ;
				$mail_verso_chi[] = $row[1] ;
				$destinatari++; 
			
		}

		  $soggetto = "[Referente Retegas.AP] ". sanitize($data_2);
		  $data_6 = sanitize($data_6);
		
		  manda_mail_multipla_istantanea($da_chi,$mail_da_chi,$verso_chi,$mail_verso_chi,$soggetto,strip_tags($data_6),"MAN",0,$id_user,$data_6);
			
		  $msg="Mail inviata a : <br>$destinatari destinatari.";
		  unset($do);
		  
		  header("Location: ".$RG_addr["sommario"]."?q=11");
		  exit;	 
				
	}
	
	 
	// ISTANZIO un nuovo oggetto "retegas"
	// Prender? come variabile globale $user, nel caso di user loggato
	// allora visualizza la barra info ed il menu verticale,
	// nel caso di user non loggato visualizza la pagina con "benvenuto" e
	//nel men? verticale i campi per il login
	$retegas = new sito; 
	 
	// assegno la posizione che sar? indicata nella barra info 
	$retegas->posizione = "Comunicazione (mod. HERMES) al tutta RETEGAS.AP";
	  
	// Dico a retegas come sar? composta la pagina, cio? da che sezioni ? composta.
	// Queste sono contenute in un array che ho chiamato HTML standard
	
	$retegas->sezioni = $retegas->html_standard;
	  
	// Il menu' orizzontale ? pronto ma ? vuoto. Con questa istruzione lo riempio con un elemento
	$retegas->menu_sito = $mio_menu;
 
	// dico a retegas quali sono i fogli di stile che dovr? usare
	// uso quelli standard per la maggior parte delle occasioni
	$retegas->css = $retegas->css_standard;
	  
	  
	// dico a retegas quali file esterni dovr? caricare
	$retegas->java_headers = array("rg",   // menu a scomparsa orizzontale
									 "ckeditor");  // menu a scomparsa verticale
		  
	  // creo  gli scripts per la gestione dei menu

	  $retegas->java_scripts_header[]=java_accordion(null, menu_lat::gas); // laterale    
	  $retegas->java_scripts_header[]=java_superfish();
		  // orizzontale                         

	  // assegno l'eventuale messaggio da proporre
	  if(isset($msg)){ 
		$retegas->messaggio=$msg;
	  }
	  
		  // qui ci va la pagina vera e proria  
	  //$retegas->content  =  gas_render_scheda($gas)."<br>";
	  $retegas->content =  '<div class="ui-state-error padding_6px ui-corner-all" style="font-size:1.2em; margin:1em;"><b>ATTENZIONE :</b> in modalit? <a href="http://it.wikipedia.org/wiki/Ermes">HERMES</a> i messaggi arriveranno a tutti gli utenti iscritti al sito (DI TUTTI I GAS), scavalcando le loro impostazioni sulla privacy.<br>Questa modalit?
	  ? accessibile solo ai referenti Retegas.AP e ai partecipanti al PROGETTO DES. <strong>NON ABUSARNE !!!</strong></div>';
	  $retegas->content .=  gas_render_form_mail_retegas($gas);
	  
	  //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
	  $html = $retegas->sito_render();
	  // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
	  echo $html;
	  
	  
	  //distruggo retegas per recuperare risorse sul server
	  unset($retegas);	  
	  
	  
	  
?>          