<?php

include_once ("../../rend.php");   

function ridistribuisci_quantita_amici($key,$nq,&$msg){
	//echo "---- Ridistribuisco $key con $nq <br>";
	
	global $db, $user,$a_hdr,$a_std,$a_alt; 
// Ho la lista degli amici riferita all'articolo KEY
$qry ="SELECT
retegas_distribuzione_spesa.id_distribuzione,
retegas_distribuzione_spesa.id_riga_dettaglio_ordine,
retegas_distribuzione_spesa.qta_ord,
retegas_distribuzione_spesa.qta_arr,
retegas_distribuzione_spesa.id_amico
FROM
retegas_distribuzione_spesa
WHERE
retegas_distribuzione_spesa.id_riga_dettaglio_ordine =  '$key'
ORDER BY
retegas_distribuzione_spesa.id_amico DESC";


// Adesso la popolo con la nuova quantit� partendo dall'ultima riga immessa;
// in realt� cancellando e ripopolando tutto ho sempre lo stesso utente penalizzato;    

	$result = $db->sql_query($qry);
	$totalrows = mysql_num_rows($result);
	$rimasto = $nq;
	$i = 0;
	while ($row = mysql_fetch_array($result)){
		
		$i++;
		//Echo "------------->Ciclo n.$i<br>";
		
		$a = $rimasto - $row['qta_ord'];
		$id_q = $row['id_distribuzione'];
		
		if($a>0){
			//Echo "------------->Rimasto - Qord > 0 <br>";
			$q_a = $row['qta_ord'];
			$rimasto=$a;
			
			// se � l'ultima riga allora aggiungo un po' di roba
			if($i==$totalrows){
				 
				 $q_a = $rimasto + $row['qta_ord'];
				 $rimasto=0;
				 //Echo "------------->Ultima riga; qa= (rimasto + qord) $q_a <br>";
			}
			
		}else{
			
			//Echo "------------->URimasto - Qord = 0 <br>";
			$q_a = $rimasto;
			$rimasto=0;
		}    
	
		
	//Echo "------------->INSERISCO $q_a in $id_q<br>";
	// update
	$result2 = mysql_query("UPDATE retegas_distribuzione_spesa 
							SET retegas_distribuzione_spesa.qta_arr = '$q_a', 
								retegas_distribuzione_spesa.data_ins = NOW()
							WHERE (retegas_distribuzione_spesa.id_distribuzione='$id_q');");
	

	
	// CICLO DI UPDATE
	}


	
} 
function do_mod1($id_user,$id_ord,$box_q_ord,$box_imp,$box_det_id,$box_prezzo){
	
   global $user, $db,$a_hdr,$a_std; 
	//echo "ORD = ".$id_ord." User:".$id_user."<br>";
	$r=0;
	$msg="";
	
	
	while (list ($key,$val) = @each ($box_det_id)) {		
	    (float)$box_q_arr[$key]=round($box_imp[$key]/$box_prezzo[$key],4);
	    //echo "KEY = $key, VAL = $val , Q_ARR = ".$box_q_arr[$key]." BOX importo = ".$box_imp[$key]." Box prezzo = ".$box_prezzo[$key]."<br>";	
	}    
	reset($box_det_id);
    
	
	while (list ($key,$val) = @each ($box_det_id)) { // PASSO LA LISTA DEGLI ARTICOLI
	
	//echo "KEY =".$key." VAL =".$val." Q.ORD =".$box_q_ord[$key]." Q.ARR =".$box_q_arr[$key]."<br>";	
	// update
	
	//FARE IL CONTROLLO SE E? NECESSARIO AGGIORNARE OPPURE NO
	
	
		//echo "ESEGUO AGGIORNAMENTO <br>";
		//echo "QUERY =<br>";
		
	
	$result2 = $db->sql_query("UPDATE retegas_dettaglio_ordini 
							SET retegas_dettaglio_ordini.qta_arr = '$box_q_arr[$key]', 
								retegas_dettaglio_ordini.data_convalida = NOW()
							WHERE (retegas_dettaglio_ordini.id_dettaglio_ordini='$val');");

	// RIPRISTINA ANCHE QUANTITA' INTERE                       
	 ridistribuisci_quantita_amici($val,$box_q_arr[$key],$msg);
	
	}

	//echo r_t_l2("OPERAZIONE CONCLUSA: TORNA INDIETRO",$a_hdr,"ordini_chiusi_dettaglio_codice.php?do=vis1&id_ord=$id_ord");     
	
	return "Modifiche effettuate";
	
}     // Modifica quantit� arrivata



function modifica_quantita_arrivate_form($ordine){
global $db,$v1,$v2,$v3,$v4,$v5;
	  global $a_hdr,$a_std,$a_tot,$a_nto,$a_cnt;
	  global $stili;
	  global $gas;

	  $valore = id_listino_from_id_ordine($ordine);
 
$qry="SELECT
retegas_dettaglio_ordini.id_articoli,
retegas_dettaglio_ordini.qta_ord,
retegas_articoli.codice,
retegas_articoli.descrizione_articoli,
retegas_dettaglio_ordini.qta_arr,
retegas_articoli.u_misura,
retegas_articoli.prezzo,
retegas_articoli.misura,
retegas_articoli.articoli_unico,
retegas_dettaglio_ordini.id_utenti,
retegas_dettaglio_ordini.id_dettaglio_ordini,
maaking_users.fullname,
retegas_gas.descrizione_gas,
retegas_gas.id_gas
FROM
retegas_dettaglio_ordini
Inner Join retegas_articoli ON retegas_dettaglio_ordini.id_articoli = retegas_articoli.id_articoli
Inner Join maaking_users ON retegas_dettaglio_ordini.id_utenti = maaking_users.userid
Inner Join retegas_gas ON maaking_users.id_gas = retegas_gas.id_gas
WHERE
				retegas_dettaglio_ordini.id_ordine =  '$ordine'
ORDER BY
				retegas_gas.descrizione_gas ASC,
				retegas_dettaglio_ordini.id_utenti ASC,
				retegas_articoli.codice ASC";    
		$result = $db->sql_query($qry);
		$totalrows = mysql_num_rows($result);
	 
		 

		//----------------nuovo form
	  
		
		$titolo_tabella="Conferma articoli ordinati - DETTAGLIO su importi";
		
		
		$output_html .= "   <div class=\"rg_widget rg_widget_helper\">
							<div style =\"margin-bottom:6px;\">$titolo_tabella</div>
							<form method=\"POST\" action=\"oc_modifica_imp_user.php\">
							<table>        

							<tr>
							<th>GAS</th>
							<th>UTENTE / REFERENTE</th>
							<th>Codice</th>
							<th>Descrizione</th>
							<th>Quantit� ordinata</th>
							<th>Importo Teorico</th>													
							<th>Importo Reale</th>
							<th>Nuovo importo reale</th>
											   
							</tr>";
   
		//$totale_ordine = valore_totale_ordine_qarr($ordine);  
		$riga=0;
		$somma_amico = 0;
	 
		 while ($row = mysql_fetch_array($result)){

		
					 
			  $c0 = $row[0]; 
			  $c1 = $row[1]; // ordinata
			  $c2 = $row[2]; // codice 
			  $c3 = $row[3]; // Descrizione
			  $c4 = number_format($row["qta_ord"] * $row["prezzo"] ,2,",",""); 
			  $c5 = round($row["qta_arr"] * $row["prezzo"] ,3);
			  //if ($row["id_gas"]<>$gas){
				//$nome_ref_gas = fullname_ref_gas_ordine($ordine,$row["id_gas"])." (REF.)";
			  //}else{
			  $nome_ref_gas =$row["fullname"];  
			  //}
			  
			  
			  $c_user = $row["id_utenti"];
			  
			  if($row["articoli_unico"]==1){
				  $codice = $row["codice"]." (".$row["id_dettaglio_ordini"].")";
			  }else{
				  $codice= $row["codice"];
			  }
			  
			  $misu = "(". $row['u_misura'] ." ". $row['misura'].")"; // misura
			  $c3.= "<I> $misu</I>"; // Descrizione + Peso 

			  
			  $tag_articoli ="";
			  $tag_field="<input type=\"text\" name=box_imp[] value=$c5 size=\"4\">
			  <input type=\"hidden\" name=box_det_id[] value=".$row["id_dettaglio_ordini"].">
			  <input type=\"hidden\" name=box_prezzo[] value=".$row["prezzo"].">
			  <input type=\"hidden\" name=box_q_ord[] value=$c1>";
			 //RIGA
			 
			  // RIEMPIO I CAMPI      
			   unset ($d);
			   $i=0;
			   $cm = $a_std;   // CLASSE MADRE = STANDARD

			   
				if(is_integer($riga/2)){  
					$output_html .= "<tr class=\"odd $extra\">";    // Colore Riga
				}else{
					$output_html .= "<tr class=\"$extra\">";    
				}

			$output_html .="
					<td width=\"10%\">".$row["descrizione_gas"]."</td>
					<td width=\"10%\">$nome_ref_gas</td>    
					<td width=\"20%\">$codice</td>
					<td>".$row["descrizione_articoli"]."</td>
					<td width=\"10%\">".$row["qta_ord"]." x ".$row["prezzo"]." Eu.</td>
					<td width=\"10%\">$c4</td>
					<td width=\"0\">".number_format($row["qta_arr"]*$row["prezzo"],2,",","")."</td>
					<td width=\"0\">$tag_field</td>
					 
				</tr>
			"; 
			 
			 
			 
			$somma_totalone = $somma_totalone+$c4;
				   
		  $riga++;  
		 }//end while
				   
		
		//TOTALONE
		unset ($d);
		$cm= $a_tot; // HEADER - CLASSE MADRE
		//$d[4][0]="TOTALE";                 
		$output_html .="<input type=\"hidden\" name=\"id\" value=\"$ordine\">  
			   <input type=\"hidden\" name=\"do\" value=\"do_mod\">
			   </table>
			   <center>
			   <input class=\"large green awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Salva le nuove quantita'\">
			   </center>
			   </form>
			   </div>
			";      

		  

		  
  return $output_html;      
	
}






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
	 if($do=="do_mod"){
		 $msg .= do_mod1($id_user,$id,$box_q_ord,$box_imp,$box_det_id,$box_prezzo);
		 
	 }
	
	
	  // MENU APERTO
	  $menu_aperto=3;
	   
	  // Campi e intestazioni
	  include ("../ordini_chiusi_sql_core.php");
	  
	  // menu      
	  include("../ordini_chiusi_menu_core.php");
	  
	  // inclusione scheda
	  // ID = ORDINE
	  
	  include ("../ordini_chiusi_form_scheda.php");
	  
	  //INCLUSIONE LISTA ARTICOLI
	  
	  $h_table .=  modifica_quantita_arrivate_form($id);
	  
	  // HEADER HTML
	  //$msg ="Pagina non ancora funzionante";
	  include ("../ordini_chiusi_main.php");
 
}else{
	pussa_via();
} 

?>