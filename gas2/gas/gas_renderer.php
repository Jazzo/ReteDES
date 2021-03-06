<?php

  function gas_render_scheda($id_gas){


	  $my_query="SELECT * FROM retegas_gas WHERE  (id_gas='$id_gas') LIMIT 1";

	  // COSTRUZIONE TABELLA  -----------------------------------------------------------------------

	  global $db,$site_path;


	  $result = $db->sql_query($my_query);

	  $row = $db->sql_fetchrow($result);  
	 // VALORI DELLE CELLE da DB---------------------

			  $c1 = $row["id_gas"];
			  $c2 = $row["descrizione_gas"];
			  $c3 = $row["sede_gas"];
			  $c4 = $row["nome_gas"];
			  $c5 = $row["website_gas"];
			  $c6 = $row["mail_gas"];
			  $c7 = fullname_from_id($row["id_referente_gas"]);
			  $c8 = $row["id_tipo_gas"];

              
              
              
              $rss_code = mimmo_encode($c1);
              $rssc_ordini_aperti = $site_path."rss/feeder.php?auth=$rss_code&req=1";
              $rssc_ordini_chiusi = $site_path."rss/feeder.php?auth=$rss_code&req=2";
              // CREO UN INDIRIZZO CORTO GOOGLE
              //$googer = new GoogleURLAPI(GOOGLE_KEY);
              //$rssc_ordini_aperti = $googer->shorten($rssc_ordini_aperti);
                            
              
              
$h_table .= "

			 <div class=\"rg_widget rg_widget_helper\">
			 <h3>Il mio GAS</h3>
             
             <table>  
			 <tr style=\"vertical-align:top\">
			 <td>";         

$h_table .=  "<table class=\"sinistra\">
		<tr class=\"odd\">
			<th $col_1>#</th>
			<td $col_2>$c1</td>
		</tr>
		<tr  class=\"odd\">
			<th $col_1>GAS :</th>
			<td $col_2>$c2</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>Sede</th>
			<td $col_2>$c3</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>Ragione sociale:</th>
			<td $col_2>$c4</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>Sito</th>
			<td $col_2>$c5</td>

		</tr>

		<tr class=\"odd\">

			<th $col_1>Referente Retegas.AP</th>

			<td $col_2>$c7</td>

		</tr>

		<tr class=\"odd\">
			<th $col_1>Mail</th>
			<td $col_2>$c6</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>Comunicazione ai referenti :</th>
			<td $col_2>".$row["comunicazione_referenti"]."</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>Percentuale maggiorazione :</th>
			<td $col_2>".$row["maggiorazione_ordini"]."</td>
		</tr>
		<tr class=\"odd\">
			<th $col_1>Utenti iscritti (totali)</th>
			<td $col_2>".gas_n_user($c1)."</td>
		</tr>
        <tr class=\"odd\">
            <th $col_1>Utenti attivi</th>
            <td $col_2>".gas_n_user_act($c1)."</td>
        </tr>
        
        
                
		<tr class=\"odd\">
			<th $col_1>Utenti reggiungibili dal servizio \"Comunica a tutti\"</th>
			<td $col_2>".gas_n_user_comunica($c1)."</td>
		</tr>

		<tr class=\"odd\">
			<th $col_1>Utenti con geocoordinate valide</th>
			<td $col_2>".utenti_con_geocode_ok($c1)."</td>
		</tr>
        
        <tr class=\"odd\">
            <th $col_1>Utenti con abilitazione a controllare gli ordini</th>
            <td $col_2>".utenti_abilitazione_visione_ordini($c1)."</td>
        </tr>

        <tr class=\"odd\">
            <th $col_1>Utenti con abilitazione a gestire gli altri utenti</th>
            <td $col_2>".utenti_abilitazione_gestione_utenti($c1)."</td>
        </tr>

        <tr class=\"odd\">
            <th $col_1>Utenti con abilitazione a gestire il GAS su Retegas.ap</th>
            <td $col_2>".utenti_abilitazione_gestione_gas($c1)."</td>
        </tr>
        <tr class=\"odd\">
            <th $col_1>Utenti con abilitazione a gestire la cassa</th>
            <td $col_2>".utenti_abilitazione_gestione_cassa($c1)."</td>
        </tr>
        <tr class=\"odd\">
            <th $col_1>Utenti gestori progetto DES</th>
            <td $col_2>".utenti_gestori_des($c1)."</td>
        </tr>		
        <tr class=\"odd\">
            <th $col_1>HASHTAG per tweet generati dal tuo gas:</th>
            <td $col_2 style=\"font-size:1.5em;text-align:center\">".read_option_gas_text_new(_USER_ID_GAS,"_HASHTAG_GAS")."</td>
        </tr>
         
		</table>
		</td>
		<td style=\"vertical-align:top\">
        
		<table>        
		<tr class=\"odd\">
		    <td colspan=2>
		        <div id=\"map_canvas\" style=\"height:500px; margin:0;\"></div>
		    </td>
		</tr>
        <tr class=\"odd\">
            <th $col_1>Opzioni di questo GAS</th>
            <td $col_2>".gas_scheda_permessi($c1)."</td>
        </tr>
        <tr class=\"odd\">
            <th $col_1>URL per FEED RSS ordini aperti:</th>
            <td $col_2><textarea>".$rssc_ordini_aperti."</textarea></td>
        </tr>
        <tr class=\"odd\">
            <th $col_1>URL per FEED RSS ordini chiusi:</th>
            <td $col_2><textarea>".$rssc_ordini_chiusi."</textarea></td>
        </tr>

		</table>
		</td>
		</tr>
		</table>
		</div> ";



return $h_table;

	  // END TABELLAGAS -----------------------------------------------------------------------

  

	  

	  

	  

	  

	  

  }
  function gas_render_table($id_user=null){

	global $db;      

	$result = mysql_query("SELECT * FROM retegas_gas;");
	$totalrows = mysql_num_rows($result);	 

	$h .= " <div class=\"rg_widget rg_widget_helper\">
			<h3>Gas aderenti al progetto RETEGAS.AP</h3>

			<table class=\"medium_size\">
			 <tr>

		<th>N.</th>
		<th>Descrizione</th>
		<th>E-Mail</th>
		<th>Nome</th>
		<th>Sede</th> 
		<th>Sito web</th> 
		<th>Utenti</th> 
		 </tr>";


	   $riga=0;  

		 while ($row = mysql_fetch_array($result)){

		 $riga++;

			$d1 = "id_gas";

		 

			  $idgas = $row["$d1"];
			  $descrizionegas = $row['descrizione_gas'];
			  $sedegas = $row['sede_gas'];
			  $nomegas = $row['nome_gas'];
			  $websitegas = $row['website_gas'];
			  $mailgas = $row['mail_gas'];
			  $n_ute= gas_n_user($idgas);

		



			

					if(is_integer($riga/2)){  

						$h.= "<tr class=\"odd\">";    // Colore Riga

					}else{

						$h.= "<tr>";    

					}

					$h.= "<td $col_1>$idgas</td> 

					<td $col_2>$descrizionegas</td>";

		

	

			$h.="<td $col_3><a href=\"mailto:$mailgas\" a>$mailgas</td>

			<td $col_4>$nomegas</td>

			<td $col_5>$sedegas</td> 

			<td $col_6>$websitegas</td>

			<td $col_7>$n_ute</td>  

			</tr>";

		 }//end while



		 $h.= "</table>";

		 return $h;

  }
  function gas_render_user_activity($id_gas,$table_ref){

	global $db,$RG_addr;      

	

	$result = mysql_query("SELECT * FROM maaking_users WHERE id_gas='$id_gas';");

	$totalrows = mysql_num_rows($result);     

	$gas_name = gas_nome($id_gas);

	

	

	$h .= " <div class=\"rg_widget rg_widget_helper\">

			<h3>Attivit� utenti $gas_name</h3>

			<table id=\"$table_ref\">

		 <thead>

		 <tr>		 

		<th>#</th>

		<th>Nome</th>

		<th>E-Mail</th>

		<th>Ultimo accesso</th>

		<th>Ultima attivit�</th>

		<th>Geo</th> 

		 </tr>

		 </thead>

		 <tbody>";

	   //$o1 =   mysql_query("SELECT id_gas FROM maaking_users WHERE userid = ". $id_user );

	   //$outp = mysql_fetch_row($o1);  

	   $riga=0;  

		 while ($row = mysql_fetch_array($result)){

		 $riga++;

			$d1 = "id_gas";

		 

			$id_utente = $row["userid"];

			$fullname = $row["fullname"];

			$mail = $row["email"];

			$last_login = conv_datetime_from_db($row["lastlogin"]);

			$last_activity = conv_datetime_from_db($row["last_activity"]);

			if($row["user_gc_lat"]<>0){$geo="SI";}else{$geo="";};

			

			$h.= "

			<tr>

			<td $col_1>$id_utente</td> 

			<td $col_2><a href=\"".$RG_addr["pag_users_form"]."?id_utente=".mimmo_encode($id_utente)."\">$fullname</a></td>

			<td $col_3><a href=\"mailto:$mailgas\" a>$mail</td>

			<td $col_4>$last_login</td>

			<td $col_5>$last_activity</td>

			<td $col_5>$geo</td>   

			</tr>";

		 }//end while



		 $h.= "

		 </tbody>

		 </table>";

		 return $h;



 }
  function gas_render_user_activate($id_gas,$table_ref){

	global $db,$RG_addr;      

	

	$result = $db->sql_query("SELECT * FROM maaking_users WHERE id_gas='$id_gas' AND isactive='0';");
	$totalrows = mysql_num_rows($result);     
	$gas_name = gas_nome($id_gas);


	if($totalrows==0){

	$h .= " <div class=\"rg_widget rg_widget_helper\">
			<h3>Tutti gli utenti sono gi� attivi.</h3>
			</div>";    
	}else{

	$h .= " <div class=\"rg_widget rg_widget_helper\">
			<h3>Utenti $gas_name in attesa attivazione</h3>
			<table id=\"$table_ref\">
		 <thead>
		    <tr>         
		        <th>#</th>
		        <th>Nome</th>
		        <th>E-Mail</th>
		        <th>Telefono</th>
		        <th>Msg</th> 
                <th>Opz.</th>
		        </tr>
		 </thead>
		 <tbody>";

	   //$o1 =   mysql_query("SELECT id_gas FROM maaking_users WHERE userid = ". $id_user );

	   //$outp = mysql_fetch_row($o1);  

	   $riga=0;  

		 while ($row = mysql_fetch_array($result)){

		 $riga++;

			$d1 = "id_gas";
			$id_utente  = $row["userid"];
			$fullname   = $row["fullname"];
			$mail       = $row["email"];
			$tel        = $row["tel"];
            $msg        = $row["profile"];
			$op = '<a class="awesome red small" href="gas_user_activate.php?do=act&id_new_user='.$id_utente.'">ATTIVA</a>';

			$h.= "
			<tr>
			    <td $col_1>$id_utente</td> 
			    <td $col_2><a href=\"".$RG_addr["pag_users_form"]."?id_utente=".mimmo_encode($id_utente)."\">$fullname</a></td>
			    <td $col_3><a href=\"mailto:$mailgas\" a>$mail</td>
			    <td $col_4>$tel</td>
                <td $col_5>$msg</td>
			    <td $col_5>$op</td>   
			</tr>";

		 }//end while



		 $h.= "
		 </tbody>
		 </table>
         </div>";

	}	 


		 return $h;

 }


  function gas_render_user($id_gas,$table_ref){

	global $db,$RG_addr;      

	

	$result = mysql_query("SELECT * FROM maaking_users WHERE id_gas='$id_gas';");

	$totalrows = mysql_num_rows($result);     

	$gas_name = gas_nome($id_gas);

	

	

	$h .= " <div class=\"rg_widget rg_widget_helper\">

			<h3>Utenti $gas_name</h3>
            <div class=\" ui-state-highlight padding_6px ui-corner-all\">
                <p>Per inviare una mail ad uno qualsiasi degli utenti, cliccare sul suo nome, e utilizzare la sua scheda personale.</p>
                <p>GLi utenti con i permessi abilitati possono vedere anche gli utenti sospesi e cancellati</p>
                
                </div>

			<table id=\"$table_ref\">

		 <thead>

	     <tr class=\"sinistra\">         
		<th>Stato</th>
        <th>#</th>
		<th>Nome</th>
		<th>E-Mail</th>
		<th>Indirizzo</th>
		<th>Telefono</th>
        <th data-sorter=\"shortDate\">Registr.</th>
		<th>Ordini come referente</th>
		<th>Ordini come partecipante</th>
        <th>GG inattivit�</th>
        <th>Cassa</th> 
		</tr>

		 </thead>

		 <tbody>";



	   $riga=0;  

		 while ($row = mysql_fetch_array($result)){

		 $riga++;

			$d1 = "id_gas";
 
			$id_utente = $row["userid"];
			$fullname = $row["fullname"];
			$mail = $row["email"];
			$indirizzo = $row["country"]." - ".$row["city"];
			$tel = $row["tel"];
			$ref_ordine =ordini_user($id_utente);
			$part_ordine = ordini_user_partecipato($id_utente) ;
            $date2 = date("Y-m-d");
            $date1 = $row["last_activity"];
            $reg = conv_date_from_db($row["regdate"]);
            
            
            $diff = abs(strtotime($date2) - strtotime($date1));
            $gg_ina = _nf((int)floor($diff/(60*60*24)));
    
            if(read_option_text($id_utente,"_USER_USA_CASSA ")=="SI"){
                $pal_cas="SI";
            }else{
                $pal_cas="NO";
            }
    
    
            if($row["isactive"]==0){
                $pal = "IN ATTESA";
            }
            if($row["isactive"]==1){
                $pal = "ATTIVO";
            }
            if($row["isactive"]==2){
                $pal = "SOSPESO";
            }
            if($row["isactive"]==3){
                $pal = "ELIMINATO";
            }
    
    
            $a = "
            <tr>
            <td>$pal</td>
            <td>$id_utente</td> 
            <td><a href=\"".$RG_addr["pag_users_form"]."?id_utente=".mimmo_encode($id_utente)."\">$fullname</a></td>
            <td>$mail</td>
            <td>$indirizzo</td>
            <td>$tel</td>
            <td>$reg</td>
            <td>$ref_ordine</td>
            <td>$part_ordine</td>   
            <td>$gg_ina</td>
            <td>$pal_cas</td>
            </tr>";
    
            if ($row["isactive"]<>1){
			    if(_USER_PERMISSIONS & perm::puo_gestire_utenti){
                
                    $h .= $a;
                }
            }else{
                $h .= $a;
            }  
            
            

		 }//end while



		 $h.= "

		 </tbody>

		 </table>";

		 return $h;



 }
  function gas_render_user_suspended($id_gas,$table_ref){

    global $db,$RG_addr;      

    

    $result = mysql_query("SELECT * FROM maaking_users WHERE id_gas='$id_gas' AND isactive='2';");

    $totalrows = mysql_num_rows($result);     

    $gas_name = gas_nome($id_gas);

    

    

    $h .= " <div class=\"rg_widget rg_widget_helper\">

            <h3>Utenti $gas_name SOSPESI</h3>
            
            <table id=\"$table_ref\">

         <thead>

         <tr class=\"sinistra\">         
        <th>#</th>
        <th>Nome</th>
        <th>E-Mail</th>
        <th>Indirizzo</th>
        <th>Telefono</th>
        <th>Motivo:</th> 
        </tr>

         </thead>

         <tbody>";



       $riga=0;  

         while ($row = mysql_fetch_array($result)){

         $riga++;

            $d1 = "id_gas";
 
            $id_utente = $row["userid"];
            $fullname = $row["fullname"];
            $mail = $row["email"];
            $indirizzo = $row["country"]." - ".$row["city"];
            $tel = $row["tel"];

            $motivo = read_option_text($id_utente,"_NOTE_SUSPENDED");
            
            $h.= "

            <tr>
            <td>$id_utente</td> 
            <td><a href=\"".$RG_addr["pag_users_form"]."?id_utente=".mimmo_encode($id_utente)."\">$fullname</a></td>
            <td>$mail</td>
            <td>$indirizzo</td>
            <td>$tel</td>
            <td>$motivo</td>
            </tr>";

         }//end while



         $h.= "

         </tbody>

         </table>";

         return $h;



 } 
  function gas_render_user_deleted($id_gas,$table_ref){

    global $db,$RG_addr;      

    

    $result = mysql_query("SELECT * FROM maaking_users WHERE id_gas='$id_gas' AND isactive='3';");

    $totalrows = mysql_num_rows($result);     

    $gas_name = gas_nome($id_gas);

    

    

    $h .= " <div class=\"rg_widget rg_widget_helper\">

            <h3>Utenti $gas_name DISATTIVATI</h3>
            
            <table id=\"$table_ref\">

         <thead>

         <tr class=\"sinistra\">         
        <th>#</th>
        <th>Nome</th>
        <th>E-Mail</th>
        <th>Indirizzo</th>
        <th>Telefono</th>
        <th>Ordini come referente</th>
        <th>Ordini come partecipante</th>
        <th>GG inattivit�</th> 
        </tr>

         </thead>

         <tbody>";



       $riga=0;  

         while ($row = mysql_fetch_array($result)){

         $riga++;

            $d1 = "id_gas";
 
            $id_utente = $row["userid"];
            $fullname = $row["fullname"];
            $mail = $row["email"];
            $indirizzo = $row["country"]." - ".$row["city"];
            $tel = $row["tel"];
            $ref_ordine =ordini_user($id_utente);
            $part_ordine = ordini_user_partecipato($id_utente) ;
            $date2 = date("Y-m-d");
            $date1 = $row["last_activity"];
            
                $diff = abs(strtotime($date2) - strtotime($date1));
                $gg_ina = (int)floor($diff/(60*60*24));
    
            
            $h.= "

            <tr>
            <td>$id_utente</td> 
            <td><a href=\"".$RG_addr["pag_users_form"]."?id_utente=".mimmo_encode($id_utente)."\">$fullname</a></td>
            <td>$mail</td>
            <td>$indirizzo</td>
            <td>$tel</td>
            <td>$ref_ordine</td>
            <td>$part_ordine</td>   
            <td>$gg_ina</td>
            </tr>";

         }//end while



         $h.= "

         </tbody>

         </table>";

         return $h;



 } 
  
  function gas_render_scheda_edit($id_gas){

	  global $db;

	  global $gas_descrizione,

		   $gas_sede,

		   $gas_nome,

		   $gas_website,

		   $gas_mail,

		   $gas_comunicazione_referenti,

		   $gas_maggiorazione_percentuale;

	

	$query = "SELECT * FROM retegas_gas WHERE id_gas='$id_gas' LIMIT 1";

	$res = $db->sql_query($query);

	$row = $db->sql_fetchrow($res);

	

	if(!isset($gas_descrizione)){

		$gas_descrizione = $row["descrizione_gas"];

	}

	

	if(!isset($gas_sede)){

		$gas_sede = $row["sede_gas"];

	}

		   

	if(!isset($gas_nome)){

		$gas_nome = $row["nome_gas"];

	}	   

	

	if(!isset($gas_website)){

		$gas_website = $row["website_gas"];

	}

	

	if(!isset($gas_mail)){

		$gas_mail = $row["mail_gas"];

	}

			  

	if(!isset($gas_comunicazione_referenti)){

		$gas_comunicazione_referenti = $row["comunicazione_referenti"];

	}

	

	if(!isset($gas_maggiorazione_percentuale)){

		$gas_maggiorazione_percentuale = $row["maggiorazione_ordini"];

	}

	

	

		  // FORM -------------------------------------------

	  

	  $title_form = "<form name=\"modifica_dati_gas\" method=\"POST\" action=\"gas_form_edit.php\" style=\"margin-top:10px;\">";

	  $submit_form ="<input class = \"large awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Salva Modifiche\">";  

	  

	  // Campi

	  

	  $input_2 = "<input type=\"text\" name=\"gas_descrizione\" size=\"38\" value=\"$gas_descrizione\">";

	  $input_3 = "<input type=\"text\" name=\"gas_sede\" size=\"38\" value=\"$gas_sede\">";

	  $input_5 = "<input type=\"text\" name=\"gas_website\" size=\"38\" value=\"$gas_website\">";

	  $input_6 = "<input type=\"text\" name=\"gas_mail\" size=\"38\" value=\"$gas_mail\">";

	  $input_7 = "<input type=\"text\" name=\"gas_comunicazione_referenti\" size=\"38\" value=\"$gas_comunicazione_referenti\">";

	  $input_8 = "<input type=\"text\" name=\"gas_maggiorazione_percentuale\" size=\"38\" value=\"$gas_maggiorazione_percentuale\">";

	  $input_hidden = "<input type=\"hidden\" name=\"do\"  value=\"mod\">";

	  // COSTRUZIONE TABELLA  -----------------------------------------------------------------------

	

	$col_1 = " WIDTH=30% ";

	

	 $h_table = "   <div class=\"ui-widget-header ui-corner-all padding_6px\">

					Modifica i dati del tuo GAS.

					<br>

					

					

					$title_form

					<table>

					 

					";

	 

	 $h_table .=  "

					<tr class=\"odd\">

						<th $col_1>Nome</th>

						<td $col_2>$input_2</td>

					</tr>

					<tr class=\"odd\">

						<th $col_1>Sede (l'indirizzo se � valido verr� usato per le mappe)</th>

						<td $col_2>$input_3</td>

					</tr>

					<tr class=\"odd\">

						<th $col_1>Sito Web</th>

						<td $col_2>$input_5</td>

					</tr>

					<tr class=\"odd\">

						<th $col_1>Indirizzo Mail</th>

						<td $col_2>$input_6</td>

					</tr>

					<tr class=\"odd\">

						<th $col_1>Motivazione della percentuale di maggiorazione che verr� applicata ad ogni nuovo ordine aperto. (Rifierita solamente al vostro GAS)</th>

						<td $col_2>$input_7</td>

					</tr>

					<tr class=\"odd\">

						<th $col_1>Maggiorazione percentuale che verr� applicata solo ai vostri ordini.</th>

						<td $col_2>$input_8</td>

					</tr>

					 <tr class=\"odd\">

						<th $col_1>&nbsp</th>

						<td $col_2>$input_hidden</td>

					</tr>

					<tr>

						<th $col_1>&nbsp</th>

						<td $col_2>$submit_form </td>

					</tr>

					

					 

					</table>

					

					

					</form> 

					</div>

					";



	  // END TABELLA ----------------------------------------------------------------------------

	  

	

	

  return $h_table;	

	  

  }



  function gas_render_form_mail_gas($user){

	   global $data_2, $data_6;
	   global $RG_addr, $db; 
	  

	  if (empty($data_6) or $data_6==""){

		  $data_6 .="<br>

				  <br>

				  <img src=\"".$RG_addr["img_logo_retedes"]."\" border=\"0\" width=\"75\" height=\"75\">
				  <b><a href=\"http://www.retedes.it\">www.retedes.it</a></b><br />
				  ReteDes.it - La rete dei Des e dei GAS<br />
				  <br>

				  <hr>

				  ";}

	  

	  $cookie_read     =explode("|", base64_decode($user));
	  $permission = $cookie_read[6];

	  $titolo_tabella='<h3>Manda una mail agli utenti del tuo GAS</h3>';
	  $col_2=" style=\"text-align:left;\" ";
	 $title_form = "<form name=\"Aggiungi Messaggio\" method=\"POST\" action=\"gas_comunica_gas.php\" style=\"margin-top:10px;\">";
	 $submit_form ="<input class = \"large awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Invia\">";  


	 $input_2 = "<input type=\"text\" name=\"data_2\" size=\"70\" value=\"$data_2\" style=\"font-size:1.4em\">";  
	 $input_6 = "<textarea class=\"ckeditor\" name=\"data_6\" cols=\"28\">$data_6</textarea>";
	 $input_hidden = "<input type=\"hidden\" name=\"do\"  value=\"send\">";

	 $h_table = " <div class=\"ui-widget-content padding-6px ui-corner-all\">
					<h3><center> 
					$titolo_tabella
					</center>
					</h3>
					$title_form

					<table>

					<tr class=\"odd\">

						<th $col_1>Oggetto</th>

						<td $col_2>$input_2</td>

					</tr>

					";

	 

	 $h_table .=  " <tr class=\"odd\">
						<th $col_1>$submit_form</th>
						<td $col_2>$input_6 $input_hidden</td>
					</tr>
					<tr>
						<th $col_1>&nbsp</th>
						<td $col_2> </td>
					</tr>
					</table>
					</form> 
					</div>

					";



	  // END TABELLA ----------------------------------------------------------------------------

		  





  return $h_table;	  

	  

  }
  function gas_render_form_mail_retegas($user){

	  

	  global $data_2,$data_6,$RG_addr;

	  

	  if (empty($data_6) or $data_6==""){

		  $data_6 .="<br>

				  <br>

				  <img src=\"".$RG_addr["img_logo_retedes"]."\" border=\"0\" width=\"50\" height=\"75\">

				  <b><a href=\"http://www.retedes.it\">www.retedes.it</a></b><br />
                  ReteDes.it - La rete dei Des e dei GAS<br />
				  <br>

				  <hr>

				  ";

	  }

	  

	  $cookie_read     =explode("|", base64_decode($user));

	  $permission = $cookie_read[6];

		  

	  // TITOLO FORM_ADD

	  $titolo_tabella='<h3>Manda una mail a tutti gli utenti di ReteGas.AP</h3>';

	  

	  $col_2="style=\"text-align:left;\" ";



		  

	  // FORM -------------------------------------------

	  

	 $title_form = "<form name=\"Aggiungi Messaggio\" method=\"POST\" action=\"gas_comunica_retegas.php\" style=\"margin-top:10px;\">";

	 $submit_form ="<input class = \"large awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Invia\">";  

	  

	  // Campi

	 $input_2 = "<input type=\"text\" name=\"data_2\" size=\"70\" value=\"$data_2\" style=\"font-size:1.4em\">"; 

	 $input_6 = "<textarea class=\"ckeditor\" name=\"data_6\" cols=\"28\">$data_6</textarea>";

	 $input_hidden = "<input type=\"hidden\" name=\"do\"  value=\"send\">";

	  



	  

	  

	  

	  

	  // COSTRUZIONE TABELLA  -----------------------------------------------------------------------

	  

		

	  $h_table = " <div class=\"ui-widget-content padding-6px ui-corner-all\">

					<h3><center> 

					$titolo_tabella

					</center>

					</h3>

					$title_form

					<table>

					<tr class=\"odd\">

						<th $col_1>Oggetto:</th>

						<td $col_2>$input_2</td>

					</tr>

					

					

					";

	 

	 $h_table .=  " <tr class=\"odd\">

						<th $col_1>$submit_form</th>

						<td $col_2>$input_6 $input_hidden</td>

					</tr>

					<tr>

						<th $col_1>&nbsp</th>

						<td $col_2> </td>

					</tr>

					</table>

					</form> 

					</div>

					

					";



	  // END TABELLA ----------------------------------------------------------------------------

		  





  return $h_table;      

	  

  }
  function gas_render_form_progetto_des(){

      

      global $data_2,$data_6,$RG_addr,$db;

      

      if (empty($data_6) or $data_6==""){

          $data_6 .="<br>
                  <br>
                  <img src=\"".$RG_addr["img_logo_retedes"]."\" border=\"0\" width=\"50\" height=\"75\">
                  <b><a href=\"http://www.retedes.it\">www.retedes.it</a></b><br />
                  ReteDes.it - La rete dei Des e dei GAS<br />
                  <br>
                  <hr>
                  ";

      }


          

      // TITOLO FORM_ADD

      $titolo_tabella='<h3>Manda una mail a tutti gli utenti che partecipano al PROGETTO DES</h3>';
      $col_2="style=\"text-align:left;\" ";


      // FORM -------------------------------------------


     $title_form = "<form name=\"Aggiungi Messaggio\" method=\"POST\" action=\"gas_comunica_retegas.php\" style=\"margin-top:10px;\">";
     $submit_form ="<input class = \"large awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Invia\">";  

      

      // Campi
     $input_2 = "<input type=\"text\" name=\"data_2\" size=\"70\" value=\"$data_2\" style=\"font-size:1.4em\">"; 
     $input_6 = "<textarea class=\"ckeditor\" name=\"data_6\" cols=\"28\">$data_6</textarea>";
     $input_hidden = "<input type=\"hidden\" name=\"do\"  value=\"send\">";

       
      // COSTRUZIONE TABELLA  -----------------------------------------------------------------------

     $qry=" SELECT
        maaking_users.fullname,
        maaking_users.email,
        maaking_users.userid
        FROM
        maaking_users
        WHERE
        (maaking_users.user_permission & ".perm::puo_vedere_retegas.");";
        
        $result = $db->sql_query($qry); 
        while ($row = mysql_fetch_array($result)){
                $lista_destinatari .= $row[0].", ";
        } 
        $lista_destinatari = rtrim($lista_destinatari,", ").".";
        

      $h_table = " <div class=\"ui-widget-content padding-6px ui-corner-all\">
                    <h3>
                    $titolo_tabella
                    </h3>
                    $title_form
                    <table>
                    <tr class=\"odd\">
                        <th $col_1>Oggetto:</th>
                        <td $col_2>$input_2</td>
                    </tr>";

     

     $h_table .=  " <tr class=\"odd\">
                        <th $col_1>$submit_form</th>
                        <td $col_2>$input_6 $input_hidden</td>
                    </tr>
                    <tr>
                        <th $col_1>&nbsp</th>
                        <td $col_2>Questa mail raggiunger� $lista_destinatari</td>
                    </tr>
                    </table>
                    </form> 
                    </div>";



      // END TABELLA ----------------------------------------------------------------------------

          





  return $h_table;      

      

  }
  
  function gas_render_gas_table($user=null){

	 

	  $cookie_read = explode("|", base64_decode($user));

	  $id_user = $cookie_read[0];

	  

	  global $db;

	  $h .= " <div class=\"rg_widget rg_widget_helper\">
			    <div style=\"margin-bottom:16px;\">Gas aderenti al progetto RETEGAS.AP</div>
			    <table id=\"gas_table\">

		        <thead>	 

		        <tr> 
		        <th>Descrizione</th>
		        <th>Nome</th>
		        <th>Sede</th> 
		        <th>Sito web</th> 
		        <th>Utenti</th> 
                <th>Progetto DES</th>
		        </tr>

		         <thead>

		         <tbody>";

	   //$o1 =   $db->sql_query("SELECT id_gas FROM maaking_users WHERE userid = ". $id_user );

	   $result = $db->sql_query("SELECT * FROM retegas_gas WHERE id_des = "._USER_ID_DES.";");

		 

	   //$outp = mysql_fetch_row($o1);  

	   $riga=0;  

		 while ($row = $db->sql_fetchrow($result)){

		 $riga++;

			$d1 = "id_gas";

		 

			  $idgas = $row["$d1"];
			  $descrizionegas = $row['descrizione_gas'];
			  $sedegas = $row['sede_gas'];
			  $nomegas = $row['nome_gas'];
			  $websitegas = $row['website_gas'];
			  $mailgas = $row['mail_gas'];
			  $n_ute= gas_n_user($idgas);
              $utenti_des = utenti_gestori_des($idgas);
			  
              $h.= "<tr>";    
              $h.= "<td $col_2>$descrizionegas</td>";
                    $h.="<td $col_4>$nomegas</td>
			             <td $col_5>$sedegas</td> 
			             <td $col_6>$websitegas</td>
			             <td $col_7>$n_ute</td>
                         <td $col_7>$utenti_des</td>  
			             </tr>";

		    }//end while



		 $h.= "</tbody></table>";

  return $h;

  }
  function gas_render_new_user_form($user){

	 

	  

	  global $db;

	  

	  global $gas_nu_username,

			 $gas_nu_fullname,

			 $gas_nu_password1,

			 $gas_nu_password2,

			 $gas_nu_tel,

			 $gas_nu_mail,

			 $gas_nu_gasapp;

			 

			 

			 

	  $h='<div class="rg_widget rg_widget_helper">

		  <h3>Inserisci un nuovo utente</h3>

		  <div class="ui-state-error ui-corner-all padding_6px">

		  Inserendo un nuovo utente da questa scheda lo si rende attivo da subito.<br>

		  Se il nuovo utente non accede al sito entro 48 ore il suo account verr� eliminato automaticamente<br>

		  Verr� inviata contestualmente all\'iscrizione una mail per avvisarlo, che risulter� proveniente dall\'user che lo ha iscritto.<br>

		  <b>Chi inserisce un nuovo utente si assume la responsabilit� di accettare regole e disclaimer

		  per conto terzi</b><br>

		  Ogni operazione in questo senso � loggata e sar� visibile dall\'amministratore del sito e da chi esso

		  autorizzer� a farlo.<br>

		  In caso di dubbio contattare '._SITE_MAIL_LOG.'

		  </div>

		  <form name="Aggiungi Utente" method="POST" action="gas_utente_add.php" style="margin-top:10px;">

		  <table>

		  <tr class="odd" style="text-align:right;">

		  <th width="30%"><input type="text" name="gas_nu_username" value="'.$gas_nu_username.'"></th><td>Username</td>

		  </tr>

		  <tr class="odd" style="text-align:right;">

		  <th width="30%"><input type="text" name="gas_nu_fullname" value="'.$gas_nu_fullname.'"></th><td>Fullname</td>

		  </tr> 

		  <tr class="odd" style="text-align:right;">

		  <th width="30%"><input type="password" name="gas_nu_password1" value="'.$gas_nu_password1.'"></th><td>Password</td>

		  </tr> 

		  <tr class="odd" style="text-align:right;">

		  <th width="30%"><input type="password" name="gas_nu_password2" value="'.$gas_nu_password2.'"></th><td>Riscrivi Password</td>

		  </tr> 

		  <tr class="odd" style="text-align:right;">

		  <th width="30%"><input type="text" name="gas_nu_tel" value="'.$gas_nu_tel.'"></th><td>Telefono</td>

		  </tr> 

		  <tr class="odd" style="text-align:right;">

		  <th width="30%"><input type="text" name="gas_nu_mail" value="'.$gas_nu_mail.'"></th><td>Mail</td>

		  </tr> 

		  <tr class="odd" style="text-align:right;">

		  <th width="30%">

		  <input type="hidden" name="do" value="add">

		  <input type="hidden" name="gas_nu_gasapp" value="'.id_gas_user($id_user).'">

		  <input type="submit" name="submit" value="Inserisci">

		  </th>

		  <td>&nbsp</td> 

		  </tr> 

		  </table>															   

		  </form>

		  </div>';

	  

  return $h;

  }



  
  function build_address_list_total(){

	  global $db;

	  $qry = "SELECT * FROM maaking_users WHERE (city<>'') AND (user_gc_lat > 0) AND isactive=1;";

	  $res = $db->sql_query($qry);

	  while ($row = $db->sql_fetchrow($res)){

		  

	  //["Maroubra Beach", -33.950198, 151.259302, 1]     

      if(_USER_PERMISSIONS & perm::puo_gestire_retegas){
	    $out .='["#'.$row["userid"]." ".$row["fullname"].' del <strong>'.(gas_user($row["userid"])).'</strong>", '.$row["user_gc_lat"].', '.$row["user_gc_lng"].',1], '; 
      }else{
        $out .='["Utente del <strong>'.(gas_user($row["userid"])).'</strong>", '.$row["user_gc_lat"].', '.$row["user_gc_lng"].',1], '; 
      }
      
	  }

	  $out = rtrim($out,", ");

	  

  return $out;

  

  }
  
  function gas_permessi_default($user_permission,$address){
    // GESTIONE DEI PERMESSI ----------------------------------------------------
if($user_permission & perm::puo_creare_ordini){$checked_1=" CHECKED ";}
if($user_permission & perm::puo_partecipare_ordini){$checked_2=" CHECKED ";}
if($user_permission & perm::puo_creare_gas){$hidden_3=perm::puo_creare_gas;}      
if($user_permission & perm::puo_creare_ditte){$checked_4=" CHECKED ";}
if($user_permission & perm::puo_creare_listini){$checked_5=" CHECKED ";}
if($user_permission & perm::puo_mod_perm_user_gas){$hidden_6=perm::puo_mod_perm_user_gas;}
if($user_permission & perm::puo_avere_amici){$checked_7=" CHECKED ";}
if($user_permission & perm::puo_postare_messaggi){$checked_8=" CHECKED ";}
if($user_permission & perm::puo_eliminare_messaggi){$hidden_9=perm::puo_eliminare_messaggi;}      
if($user_permission & perm::puo_gestire_utenti){$hidden_10=perm::puo_gestire_utenti;}
if($user_permission & perm::puo_vedere_tutti_ordini){$hidden_11=perm::puo_vedere_tutti_ordini;}
if($user_permission & perm::puo_operare_con_crediti){$checked_12=" CHECKED ";}
if($user_permission & perm::puo_vedere_retegas){$hidden_13=perm::puo_vedere_retegas;}

$h_table .='
<div class="rg_widget rg_widget_helper">
<h3>Permessi di default dei nuovi utenti</h3>
<form  name="Modifica permessi" method="POST" action="'.$address.'">
<table>
    <tr class="odd">
        <th>Pu� creare ordini</th>
        <td><input '.$checked_1.'type="checkbox" name="p_c_o" value="'.perm::puo_creare_ordini.'"></td>
    </tr>
    <tr class="odd">
        <th >Pu� partecipare agli ordini</th>
        <td><input '.$checked_2.'type="checkbox" name="p_p_o" value="'.perm::puo_partecipare_ordini.'"></td>
    </tr>
        <tr class="odd">
        <th >Pu� creare nuove ditte</th>
        <td><input '.$checked_4.'type="checkbox" name="p_c_d" value="'.perm::puo_creare_ditte.'"></td>
    </tr>
    </tr>
        <tr class="odd">
        <th >Pu� creare nuovi listini</th>
        <td><input '.$checked_5.'type="checkbox" name="p_c_l" value="'.perm::puo_creare_listini.'"></td>
    </tr>
    </tr>
        <tr class="odd">
        <th >Pu� avere amici (...)</th>
        <td><input '.$checked_7.'type="checkbox" name="p_a_a" value="'.perm::puo_avere_amici.'"></td>
    </tr>
        </tr>
        <tr class="odd">
        <th >Pu� scrivere in bacheca</th>
        <td><input '.$checked_8.'type="checkbox" name="p_s_b" value="'.perm::puo_postare_messaggi.'"></td>
    </tr>
    </tr>
        <tr class="odd">
        <th >Pu� operare con i crediti di altri utenti</th>
        <td><input '.$checked_12.'type="checkbox" name="p_o_c" value="'.perm::puo_operare_con_crediti.'"></td>
    </tr>    
<table>


 
<input type="hidden" name="do"  value="change_default_permissions">
<input type="hidden" name="id_utente_permessi"  value="'.$c1.'">
<center>
<input class="large green awesome" style="margin:20px;" type="submit" value="Salva">
</center>
</form>
</div>
   
';
      
      
      
      //GESTIONE DEI PERMESSI ------------------------------------------------------
return $h_table;
}
  
  function gas_render_last_activity_data($gas=null){
  //{
  //         x: 161.2, 
  //         y: 51.6,
  //         marker: {
  //            radius: 15,
  //           fillColor: 'rgb(255, 0, 0)'
  //          }
  //      },        
  
  global $db;
  
  $sql = "SELECT
            sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) AS importo,
            min(retegas_dettaglio_ordini.data_inserimento) AS data_inserimento,
            min(retegas_dettaglio_ordini.id_ordine) AS id_ordine,
            min(maaking_users.id_gas) AS id_gas,
            min(retegas_dettaglio_ordini.id_dettaglio_ordini) AS id_dettaglio_ordini,
            count(retegas_dettaglio_ordini.id_articoli) AS id_articoli
            FROM
            retegas_dettaglio_ordini
            Inner Join retegas_articoli ON retegas_dettaglio_ordini.id_articoli = retegas_articoli.id_articoli
            Inner Join maaking_users ON retegas_dettaglio_ordini.id_utenti = maaking_users.userid
            GROUP BY 
            ( 60 * HOUR( retegas_dettaglio_ordini.data_inserimento ) + FLOOR( MINUTE( retegas_dettaglio_ordini.data_inserimento ) / 1 )) 
            ORDER BY
            retegas_dettaglio_ordini.id_dettaglio_ordini DESC
            LIMIT 35";
  $res = $db->sql_query($sql);
  
  for($s=0;$s<100;$s++){
        $colo[$s]=random_color_2();          
  }
  
  while ($row = $db->sql_fetchrow($res)){
      //(1970,  9, 27)
      //fillColor: \'rgba('.$colo[$row["id_gas"]].',0.4)\'
      //fillColor:\'-webkit-gradient(linear,1250 225,0 255,from(#E0E0E0),to(#FFFFFF))\'
                        
      
      $out .='{ 
                name : \''.addslashes(descrizione_ordine_from_id_ordine($row["id_ordine"])).' <br><b>Eu. '.number_format($row["importo"],2,",","").'</b>, '.$row["id_articoli"].' articoli\',
                x : Date.UTC('.conv_datetime_to_javascript($row["data_inserimento"]).'),
                y : '.$row["id_ordine"].',
                marker: {
                            radius : '.$row["importo"].',
                            fillColor: \'rgba('.$colo[$row["id_gas"]].',0.4)\',
                            lineColor: \'rgba('.$colo[$row["id_gas"]].',0.8)\',
                            lineWidth: '.$row["id_articoli"].' 
                        }
              },'; 

      }

      $out = rtrim($out,",");
  
      return $out;
  
  }
  function gas_render_last_activity_data_2($gas=null){
  //{
  //         x: 161.2, 
  //         y: 51.6,
  //         marker: {
  //            radius: 15,
  //           fillColor: 'rgb(255, 0, 0)'
  //          }
  //      },        
  
  global $db;
  
  $sql = "SELECT
            sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) AS importo,
            min(retegas_dettaglio_ordini.data_inserimento) AS data_inserimento,
            min(retegas_dettaglio_ordini.id_ordine) AS id_ordine,
            min(maaking_users.id_gas) AS id_gas,
            min(retegas_dettaglio_ordini.id_dettaglio_ordini) AS id_dettaglio_ordini,
            count(retegas_dettaglio_ordini.id_articoli) AS id_articoli
            FROM
            retegas_dettaglio_ordini
            Inner Join retegas_articoli ON retegas_dettaglio_ordini.id_articoli = retegas_articoli.id_articoli
            Inner Join maaking_users ON retegas_dettaglio_ordini.id_utenti = maaking_users.userid
            GROUP BY 
            ( 60 * HOUR( retegas_dettaglio_ordini.data_inserimento ) + FLOOR( MINUTE( retegas_dettaglio_ordini.data_inserimento ) / 1 )) 
            ORDER BY
            retegas_dettaglio_ordini.id_dettaglio_ordini DESC
            LIMIT 35";
  $res = $db->sql_query($sql);
  
  for($s=0;$s<50;$s++){
        $colo[$s]=random_color_2();          
  }
  
  while ($row = $db->sql_fetchrow($res)){
      //(1970,  9, 27)
      //fillColor: \'rgba('.$colo[$row["id_gas"]].',0.4)\'
      //fillColor:\'-webkit-gradient(linear,1250 225,0 255,from(#E0E0E0),to(#FFFFFF))\'
                        
      
      $out .='{ 
                name : \''.descrizione_ordine_from_id_ordine($row["id_ordine"]).' <br><b>� '.number_format($row["importo"],2,",","").'</b>, '.$row["id_articoli"].' articoli\',
                x : Date.UTC('.conv_datetime_to_javascript($row["data_inserimento"]).'),
                y : '.$row["id_ordine"].',
                marker: {
                            radius : '.$row["importo"].',
                            fillColor: \'rgba('.$colo[$row["id_gas"]].',0.4)\',
                            lineColor: \'rgba('.$colo[$row["id_gas"]].',0.8)\',
                            lineWidth: '.$row["id_articoli"].' 
                        }
              },'; 

      }

      $out = rtrim($out,",");
  
      return $out;
  
  }
  
 function gas_scheda_permessi($id_gas){
 global $RG_addr;   
$gas_permission = leggi_permessi_gas($id_gas);
// GESTIONE DEI PERMESSI ----------------------------------------------------
if(_GAS_USA_CASSA){$checked_1=$RG_addr["img_pallino_verde"];}else{$checked_1=$RG_addr["img_pallino_rosso"];}
if(_GAS_PUO_PART_ORD_EST){$checked_2=$RG_addr["img_pallino_verde"];}else{$checked_2=$RG_addr["img_pallino_rosso"];}     
if(_GAS_PUO_COND_ORD_EST){$checked_3=$RG_addr["img_pallino_verde"];}else{$checked_3=$RG_addr["img_pallino_rosso"];}
//if($gas_permission & gas_perm::consente_ordini_superprivati){$checked_4=$RG_addr["img_pallino_verde"];}else{$checked_4=$RG_addr["img_pallino_rosso"];}
return '
<div>
    
    <p>
    <img SRC="'.$checked_1.'" width=16 height=16> Usufruisce della CASSA Retegas.AP
    </p>
    <p>
    <img SRC="'.$checked_2.'" width=16 height=16> Pu� partecipare agli ordini proposti da altri gas
    </p>
    <p>
    <img SRC="'.$checked_3.'" width=16 height=16> Pu� condividere ordini con altri gas
    </p>

 <br>';

   
}
?>