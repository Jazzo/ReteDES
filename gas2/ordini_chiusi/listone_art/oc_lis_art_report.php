<?php


include_once ("../../rend.php");

if (is_logged_in($user)){
		$cookie_read = explode("|", base64_decode($user));
		$id_user = $cookie_read[0];
		$username =$cookie_read[1];
		$gas = id_gas_user($id_user);
		$gas_name = gas_nome($gas);
		$fullname = fullname_from_id($id_user);
	
	 
     //SE SONO IL PROPRIETARIO
     (int)$id;
     if($id_user<>id_referente_ordine_globale($id)){
        c1_go_away("?q=no_permission");  
        exit;    
      }
     // --->ID
	 // ---- h_table
	 // ---- msg
	 // --- menu aperto
	
	  // MENU APERTO
	  $menu_aperto=3;
	   
	  // Campi e intestazioni
	  include ("../ordini_chiusi_sql_core.php");
	  
	  // menu
	  $pdf_url = "oc_lis_art_pdf.php?id=$id&is_pdf=pdf";
	  $display_url = "oc_lis_art_pdf.php?id=$id&is_pdf=screen";
	  
	  include("../ordini_chiusi_menu_core.php");
	  
	  // inclusione scheda
	  // ID = ORDINE
	  
	  include ("../ordini_chiusi_form_scheda.php");
	  
	  //INCLUSIONE LISTA ARTICOLI
	  
	  // c2 = id listino
	  
	  include ("oc_lis_art.php"); 
	  // HEADER HTML
	  //$msg ="Pagina non ancora funzionante";
	  $posizione = "ORDINI CHIUSI -> Mia spesa -> <b>Dettaglio Articoli</b>";
	  include ("../ordini_chiusi_main.php");
 
}else{
	pussa_via();
} 
?>
