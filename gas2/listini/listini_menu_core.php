<?php
  if (eregi("listini_menu_core.php", $_SERVER['SCRIPT_NAME'])) {
	Header("Location: ../index.php"); die();
}

// $h_table = Content
// $id_user = utente
// $id = ordine

$_parenDir_path = join(array_slice(split( "/" ,dirname($_SERVER['PHP_SELF'])),0,-1),"/").'/'; // returns the full path to the parent dir
$_parenDir =  basename ($_parenDir_path,"/"); // returns only the name of the pare

if($_parenDir=="ditte"){
	$pa = "../";
}else{
	$pa="";
}

if($_parenDir=="listini"){
	$pa = "../";
}else{
	$pa="";
}

$h_menu ='
<div style="padding-bottom:2em;">
<ul class="sf-menu">';  // INIZIO


if ($my_user_level>=0){       // SOLO SE E' un utente autorizzato
	
// NUOVA ORDINE
if (isset($nuovo_ordine)){
	if(listino_tipo($id)==0){
		if(articoli_n_in_listino($id)>0){
		 $h_menu .='<li><a class="medium blue awesome" href="../ordini/ordini_form_add.php?id='.$id.'"><b>Nuovo ordine !</b></a></li>';
		}
	}
}   
//NUOVO ORDINE

}


// ------------------------------------------------ARTICOLI

if ($my_user_level>=0){
	if (isset($nuovi_articoli)){
		if(listino_proprietario($id)==$id_user){        
			$h_menu .='<li><a class="medium orange awesome"><b>Aggiungi Articoli</b></a>'; 
			$h_menu .='<ul>';
				$h_menu .='<li><a class="medium orange awesome" href="../articoli/articoli_form_add.php?id='.$id.'" target="_self">Uno per volta</a></li>';
				$h_menu .='<li><a class="medium orange awesome" href="../articoli/articoli_form_add_maga.php?id='.$id.'" target="_self">Da un listino MAGAZZINO</a></li>';
				$h_menu .='<li><a class="medium orange awesome">Tutti assieme</a>';
					$h_menu .='<ul>';               
						$h_menu .='<li><a class="medium orange awesome" href="'.$pa.'listini_form_upload.php?id='.$id.'&tipo_file=XLS" target="_self">File MS EXCEL (.XLS)</a></li>';
						$h_menu .='<li><a class="medium orange awesome" href="'.$pa.'listini_form_upload.php?id='.$id.'&tipo_file=CSV" target="_self">File CSV (Tabella di testo)</a></li>';
						$h_menu .='<li><a class="medium orange awesome" href="'.$pa.'listini_form_upload.php?id='.$id.'&tipo_file=GOO" target="_self">OnLine (Google Docs)</a></li>';
					$h_menu .='</ul></li>';
			   
			$h_menu .='</ul>';
			$h_menu .='</li>';
		}
	}     
}
// ------------------------------------------------ARTICOLI


// ------------------------------------------------Operazioni

if ($my_user_level>=0){
	if (isset($operazioni_consentite)){
		 if(listino_proprietario($id)==$id_user){ 		
			$h_menu .='<li><a class="medium yellow awesome"><b>Operazioni</b></a>'; 
			$h_menu .='<ul>';
			$h_menu .='<li><a class="medium yellow awesome" href="'.$pa.'listini_form_clone.php?id='.$id.'" target="_self">Clona questo listino</a></li>';
				 // OPZIONI SCHEDA
				//$h_menu .='<li><a class="medium beige awesome" href="'.$pa.'listini_form_clone.php?id='.$id.'" target="_self">Clona questo listino</a></li>';
				//$opt1 .="<a class=\"small yellow awesome destra\" href=\"listini_form_edit.php?id=$id\">Modifica scheda</a>";
				$h_menu .='<li><a class="medium yellow awesome" href="'.$pa.'listini_form_edit.php?id='.$id.'" target="_self">Modifica questo listino</a></li>';
			 if(articoli_n_in_listino($id)==0){
				//$opt2 .="<a class=\"small awesome destra\" href=\"listini_form_delete.php?id=$id\">Elimina scheda</a>";
				$h_menu .='<li><a class="medium red awesome" href="'.$pa.'listini_form_delete.php?id_listino='.$id.'" target="_self">Elimina questo listino</a></li>';
						
			 }
			 if(quanti_ordini_per_questo_listino($id)==0){
				$h_menu .='<li><a class="medium yellow awesome" href="'.$pa.'listini_form_empty.php?id='.$id.'" target="_self">Svuota questo listino</a></li>';
			 }

			$h_menu .='</ul>';
			$h_menu .='</li>';
	}     
	}	 
}
// ------------------------------------------------Operazioni

 


$h_menu .=''; 
$h_menu .=''; 
$h_menu .='</ul>
		   </div>
		   <br />  
			';                // FINE





$h_table=$h_menu;


?>
