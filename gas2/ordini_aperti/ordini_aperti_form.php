<?php


include_once ("../rend.php");


if (is_logged_in($user)){
		$cookie_read = explode("|", base64_decode($user));
		$id_user = $cookie_read[0];
		$username =$cookie_read[1];
		$gas = id_gas_user($id_user);
		$gas_name = gas_nome($gas);
		$fullname = fullname_from_id($id_user);
	
if(ordine_io_cosa_sono($id,$id_user)==0){
		pussa_via();       
		exit;    
		}
		
if(stato_from_id_ord($id)<>2){
		pussa_via();         
		exit; 
		}
if(ordine_inesistente($id)){
		pussa_via();         
		exit;	
	
}

		
	 // --->ID
	 // ---- h_table
	 // ---- msg
	 // --- menu aperto
	
	  // MENU APERTO
	  $menu_aperto=3;
	   
	  // Campi e intestazioni
	  include ("ordini_aperti_sql_core.php");
	  
	  // menu	  
	  include("ordini_aperti_menu_core.php");
	  
	  // inclusione scheda
	  // ID = ORDINE
	  
	  include ("ordini_aperti_form_scheda.php");
	  
	  
	  
	  //INCLUSIONE LISTA ARTICOLI
	  
	  // c2 = id listino
	  //$ido=$id;
	  //$id=$c2;
	  //include ("../articoli/articoli_table_core.php");
	  
	  //$h_table .= show_log_ordine($ido,"ORD",20); 
	  // HEADER HTML
	  //$msg ="Pagina non ancora funzionante";
	  $posizione ="ORDINI APERTI -> <b>Scheda ordine</b>";
	  include ("ordini_aperti_main.php");
 
}else{
	pussa_via();
} 
?>