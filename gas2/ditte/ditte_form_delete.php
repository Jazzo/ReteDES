<?php
  
include_once ("../rend.php");

if (is_logged_in($user)){
		$cookie_read = explode("|", base64_decode($user));
		$id_user = $cookie_read[0];
		$username =$cookie_read[1];
		$gas = id_gas_user($id_user);
		$gas_name = gas_nome($gas);
	  
	  
	  //-------------------------------------------------DELETE
		if($do=="del"){
			
		// Controllare che non abbia 
		//ordini in sospeso
		//listini pendenti
		//che la ditta sia di propriet? di user
		
		//if(1){$msg="Questa ditta ha associati degli ordini.<br> Impossibile eliminarla";}
		if(ditta_user($id)<>$id_user){
			$msg="Questa ditta non ? stata inserita da te, oppure � gi� stata cancellata.<br> Impossibile eliminarla";
			include("ditte_table.php");    
			exit;
		}
		if(listini_ditte($id)<>0){
			$msg="Questa ditta ha associati dei listini.<br> Impossibile eliminarla";
			include("ditte_table.php");    
			exit;
		}
		
		$sql =  mysql_query("delete from retegas_ditte where retegas_ditte.id_ditte='$id' LIMIT 1;") or die ("Errore: ". mysql_error());    
				
		$msg = "Eliminazione riuscita";	
		include("ditte_table.php");	
		exit;    
		}
	  
	  
	  
	  //-------------------------------------------------------
	  
	  
	  

	  
	  // MENU APERTO
	  $menu_aperto=menu_lat::anagrafiche;
	  include("ditte_menu_core.php");
		
	  // QUERY
	  
	  $my_query="SELECT * FROM retegas_ditte WHERE (id_ditte='$id')  LIMIT 1";
	  
	  // SQL NOMI DEI CAMPI
	  $d1="id_ditte";
	  $d2="descrizione_ditte";
	  $d3="indirizzo";
	  $d4="website";
	  $d5="note_ditte"; 
	  
	  // TITOLO TABELLA
	  $titolo_tabella="Ditta cod. $id";
	  
	  // INTESTAZIONI CAMPI
	  $h1="ID";
	  $h2="Nome";
	  $h3="Indirizzo";
	  $h4="Sito Web";
	  $h5="Note";
	  
	  
	  // TOOLTIPS

	  
	  //  LARGHEZZA E CLASSI COLONNE
	  $col_1="";
	  $col_2=""; 
  
	  
	  // OPZIONI
	  
	  // COSTRUZIONE TABELLA  -----------------------------------------------------------------------
	  global $db;

	  $result = mysql_query($my_query);
	  $row = mysql_fetch_array($result);  
	  
	  //$h_table .= amici_menu_1();
	  
	  $h_table .= " 
					<div class=\"ui-state-error ui-corner-all padding_6px\" style=\"margin-bottom:20px\">
					<span class=\"ui-icon ui-icon-trash\" style=\"float:left; margin:0 7px 16px 0;\"></span>
					Stai per cancellare i dati di questa scheda : sei sicuro ?
					<a href=\"ditte_form_delete.php?id=$id&do=del\" class=\"medium red awesome\">SI</a> 
					<a href=\"ditte_form.php?id=$id\" class=\"medium green awesome\">NO</a>
					</div>
					
				<div class=\"ui-widget-header ui-corner-all padding_6px\">
					$titolo_tabella
					<br>			  
				<table>
				";
		 
		 // VALORI DELLE CELLE da DB---------------------
			  $c1 = $row["$d1"];
			  $c2 = $row["$d2"];
			  $c3 = $row["$d3"];
			  $c4 = $row["$d4"];
			  $c5 = $row["$d5"];
		// VALORI CELLE CALCOLATE ----------------------      
$h_table .=  "
		<tr class=\"odd\">
			<th $col_1>$h1</th>
			<td $col_2>$c1</td>
		</tr>
		<tr  class=\"odd\">
			<th $col_1>$h2</th>
			<td $col_2>$c2</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>$h3</th>
			<td $col_2>$c3</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>$h4</th>
			<td $col_2>$c4</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>$h5</th>
			<td $col_2>$c5</td>
		</tr>		
		</table>
		</div>";

	  // END TABELLA ----------------------------------------------------------------------------
 $posizione ="<b>Elimina una DITTA</b>";	  
 include ("ditte_main.php");
 
 
}else{
	c1_go_away("?q=no_permission");
}
?>
