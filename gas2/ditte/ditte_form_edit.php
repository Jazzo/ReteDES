<?php

   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");
//
include_once ("ditte_renderer.php");

//Ricevo come GET id = id_ordine
// Lo obbligo ad essere un intero
(int)$id;

// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
	pussa_via();
	exit;     
}    

	//COntrollo permessi
	if(!(_USER_PERMISSIONS & perm::puo_creare_ditte)){
		unset($do);
		$msg = "Non hai i permessi necessari per creare una nuova ditta.";
		include "../index.php";
		exit;
	}
    
    if(_USER_ID<>ditta_user($id)){
         $msg = "Ditta non inserita da te. Impossibile modificare";
         include "../index.php";
         exit;
     }
    
    
    
if ($do=="mod"){
      //echo "EVALUTATE <br>";
      
     
      
      $tag_ditte =          strip_tags(sanitize($tag_ditte));
      $descrizione_ditte =  strip_tags(sanitize($descrizione_ditte));
      $indirizzo =          strip_tags(sanitize($indirizzo));
      $website =            strip_tags(sanitize($website));
      $mail_ditte =         strip_tags(sanitize($mail_ditte));
      $note_ditte =                    sanitize($note_ditte);
      $telefono =                      sanitize($telefono); 
      
      if (empty($descrizione_ditte)){$msg.="Devi almeno inserire il nome della ditta<br>";$e_empty++;};
      if (empty($indirizzo)){$msg.="Se non conosci l'indirizzo almeno inserisci la citt�<br>";$e_empty++;};
      if (empty($mail_ditte)){$mail_ditte = id_user_mail(_USER_ID);};
      if (empty($website)){$website = "NON DEFINITO";};
      
   
      $msg.="<br>Verifica i dati immessi e riprova";
      
      
      $e_total = $e_empty + $e_logical + $e_numerical;
      
      if($e_total==0){
      //echo "ZERO ERRORI !!!";
        //DEBUG
      //echo "Data_1:(".$data_1.") ";
      //echo "Data_2:(".$data_2.") ";
      //echo "Data_3:(".$data_3.") <BR>";
      //echo "Data_4:(".$data_4.") ";
      //echo "Data_5:(".$data_5.") ";
      //echo "Data_6:(".$data_6.") <BR>";
      //DEBUG
        // QUERY EDIT
        $sql = "UPDATE retegas_ditte 
              SET 
              retegas_ditte.descrizione_ditte = '$descrizione_ditte',
              retegas_ditte.indirizzo = '$indirizzo',
              retegas_ditte.website = '$website',
              retegas_ditte.note_ditte = '$note_ditte',
              retegas_ditte.mail_ditte = '$mail_ditte',
              retegas_ditte.tag_ditte = '$tag_ditte',
              retegas_ditte.telefono ='$telefono' 
              WHERE 
              retegas_ditte.id_ditte = $id LIMIT 1;";
              
        $result = $db->sql_query($sql);
        //echo $result;
        //EDIT BEGIN ---------------------------------------------------------
         
         if (is_null($result)){
            $msg = "Errore nella modifica dei dati";
            include ("../index.php");
            exit;  
        }else{
            $res_geocode = geocode_ditte_table("SELECT * FROM retegas_ditte WHERE (id_ditte='$id')");

            $msg = "Dati modificati";
            include("ditte_table.php");
            exit;  
        };
        
        //EDIT END --------------------------------------------------------- 
        
        
        
        include("ditte_table.php");
        exit; 
          
      } // se non ci sono errori
      
}
		 
	// ISTANZIO un nuovo oggetto "retegas"
	// Prender� come variabile globale $user, nel caso di user loggato
	// allora visualizza la barra info ed il menu verticale,
	// nel caso di user non loggato visualizza la pagina con "benvenuto" e
	//nel men� verticale i campi per il login
	$retegas = new sito; 
	 
	// assegno la posizione che sar� indicata nella barra info 
	$retegas->posizione = "Modifica i dati della ditta";
	  
	// Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
	// Queste sono contenute in un array che ho chiamato HTML standard
	
	$retegas->sezioni = $retegas->html_standard;
	  
	// Il menu' orizzontale � pronto ma � vuoto. Con questa istruzione lo riempio con un elemento
	$retegas->menu_sito = ditte_menu_completo();
 
	// dico a retegas quali sono i fogli di stile che dovr� usare
	// uso quelli standard per la maggior parte delle occasioni
	$retegas->css = $retegas->css_standard;
	 
	  
	// dico a retegas quali file esterni dovr� caricare
	$retegas->java_headers = array( "rg",   // librerie universali
                                    "ckeditor");  // editor di testo
	
		  
	  // creo  gli scripts per la gestione dei menu
	  
	  $retegas->java_scripts_header[] = java_accordion(null,menu_lat::anagrafiche); // laterale    
	  $retegas->java_scripts_header[] = java_superfish();
	  $retegas->java_scripts_bottom_body[] = java_qtip(".retegas_form h5[title]");

		  // orizzontale                         

	  
		   
	  // assegno l'eventuale messaggio da proporre
	  if(isset($msg)){ 
		$retegas->messaggio=$msg;
	  }
	  
	  
	  // qui ci va la pagina vera e proria  
	  $retegas->content  =  ditte_render_form_edit($id);
	  
	  
	  //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
	  $html = $retegas->sito_render();
	  // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
	  echo $html;
	  
	  
	  //distruggo retegas per recuperare risorse sul server
	  unset($retegas);	  
