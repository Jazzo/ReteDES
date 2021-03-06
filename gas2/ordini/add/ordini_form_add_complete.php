<?php

   
// immette i file che contengono il motore del programma
include_once ("../../rend.php");
include_once ("../../retegas.class.php");

include_once ("../ordini_renderer.php");

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
	$mio_gas = $gas;
}else{
	pussa_via();
	exit;     
}    


//echo print_r($box);

	//COntrollo permessi
	if(!($permission & perm::puo_creare_ordini)){
		unset($do);
        $q="not_allowed";
        include "../../index.php";
        exit;
	}

	if($do=="add"){
			
			$msg = 	ordine_render_do_add_complete($id);
			if($msg=="OK"){$msg="Ordine partito correttamente";
						   include("../aperti/ordini_table_aperti.php");
						   exit;}
	}
		 
	// ISTANZIO un nuovo oggetto "retegas"
	// Prender� come variabile globale $user, nel caso di user loggato
	// allora visualizza la barra info ed il menu verticale,
	// nel caso di user non loggato visualizza la pagina con "benvenuto" e
	//nel men� verticale i campi per il login
	$retegas = new sito; 
	 
	// assegno la posizione che sar� indicata nella barra info 
	$retegas->posizione = "Crea nuovo ordine - Versione completa";
	  
	// Dico a retegas come sar� composta la pagina, cio� da che sezioni � composta.
	// Queste sono contenute in un array che ho chiamato HTML standard
	
	$retegas->sezioni = $retegas->html_standard;
	  
	// Il menu' orizzontale � pronto ma � vuoto. Con questa istruzione lo riempio con un elemento
	$retegas->menu_sito = ordini_menu_completo($user);
 
	// dico a retegas quali sono i fogli di stile che dovr� usare
	// uso quelli standard per la maggior parte delle occasioni
	$retegas->css = $retegas->css_standard;
	 
	  
	// dico a retegas quali file esterni dovr� caricare
	$retegas->java_headers = array("rg",
									 "datetimepicker",
									 "datepicker_loc",
									 "selectmenu",
									 "ckeditor"
									 );  // editor di testo
	
		  
	  // creo  gli scripts per la gestione dei menu
	  
	  $retegas->java_scripts_header[] = java_accordion("",3); // laterale    
	  $retegas->java_scripts_header[] = java_superfish();
	  
	  
	  
		  // orizzontale                         

	  $retegas->java_scripts_bottom_body[] = c1_ext_javascript_datetimepicker("#datetimepicker");
	  $retegas->java_scripts_bottom_body[] = c1_ext_javascript_datetimepicker("#datetimepicker2"); 
	  $retegas->java_scripts_bottom_body[] = java_qtip(".retegas_form h5[title]");
	  $retegas->java_scripts_top_body[]='
	  <script type="text/javascript">
	  $(function(){
		$("#selection").selectmenu({
			style:"popup", 
			width: "25em",
			format: addressFormatting,
			maxHeight : 200
		});
	  });
	  
	  //a custom format option callback
		var addressFormatting = function(text){
			var newText = text;
			//array of find replaces
			var findreps = [
				{find:/^([^\~]+) \~ /g, rep: \'<span class="ui-selectmenu-item-header">$1</span>\'},
				{find:/([^\|><]+) \| /g, rep: \'<span class="ui-selectmenu-item-content">$1</span>\'},
				{find:/([^\|><\(\)]+) (\()/g, rep: \'<span class="ui-selectmenu-item-content">$1</span>$2\'},
				{find:/([^\|><\(\)]+)$/g, rep: \'<span class="ui-selectmenu-item-content">$1</span>\'},
				{find:/(\([^\|><]+\))$/g, rep: \'<span class="ui-selectmenu-item-footer">$1</span>\'}
			];

			for(var i in findreps){
				newText = newText.replace(findreps[i].find, findreps[i].rep);
			}
			return newText;
		}
	  
	  </script>';
	  
			if(isset($id_listino)){
		  $id_ditta = ditta_id_from_listino($id_listino);
		  $add_query = '
		  $(document).ready(function(){
		  $.ajax({
			type: "POST",
			data: "data='.$id_ditta.'" + "&id_listino='.$id_listino.'" + "&gas='.$gas.'",
			url: "'.$RG_addr["ajax_listini"].'",
			success: function(msg){
				$("#result").html("");
				if (msg != ""){
					$("#selectionresult").html(msg);
				}
				else{
					$("#selectionresult").html("<option>Nessun Listino per questa ditta...</option>");            
				}
				$("#selectionresult").selectmenu({
					style:"popup", 
					width: "25em",
					format: addressFormatting,
					maxHeight : 400
				});    
			}
	});
});            
			 ';
	  }else{
		  $add_query = '';
		  
	  }
	  
	  

	  
	  $retegas->java_scripts_bottom_body[]='
<script type="text/javascript">
$(document).ready(function(){
	//$("#selectionresult").hide();
	$("#selectionresult").selectmenu({
					style:"popup", 
					width: "25em",
					format: addressFormatting,
					maxHeight : 200
	});
	
	
	'.$add_query.' 
	$("#selection").change( function() {
		$("#selectionresult").hide();
		$.ajax({
			type: "POST",
			data: "data=" + $(this).val() + "&gas='.$gas.'",
			url: "'.$RG_addr["ajax_listini"].'",
			success: function(msg){
				$("#result").html("");
				if (msg != ""){
					$("#selectionresult").html(msg);
				}
				else{
					$("#selectionresult").html("<option>Nessun Listino per questa ditta...</option>");			
				}
				$("#selectionresult").selectmenu({
					style:"popup", 
					width: "25em",
					format: addressFormatting,
					maxHeight : 200
				});    
			}
		});
	});
});
</script>
	  
	  ';
		   
	  // assegno l'eventuale messaggio da proporre
	  if(isset($msg)){ 
		$retegas->messaggio=$msg;
	  }
	  
	  
	  // QUa butto fuori chi usa EXPLORER !!!
	  $h =ordine_render_add_complete($id);
	  
	  
	  
	  
		  // qui ci va la pagina vera e proria  
	  $retegas->content  =  $h;
	  
	  
	  //  Adesso ho tutti gli elementi per poter costruire la pagina, che metto nella variabile "html"
	  $html = $retegas->sito_render();
	  // Butto fuori la variabile "html" e l'utente riceve la pagina sul suo browser"
	  echo $html;
	  
	  
	  //distruggo retegas per recuperare risorse sul server
	  unset($retegas);	  
	  
	  
	  
?>
