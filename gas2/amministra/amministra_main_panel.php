<?php
   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
     pussa_via(); 
}    

if (!(_USER_PERMISSIONS & perm::puo_gestire_retegas)){
     pussa_via();
}

if($do=="m_ON"){write_option_text(0,"MAILER","ON");};
if($do=="m_OFF"){write_option_text(0,"MAILER","OFF");};
//if($do=="geocode"){$last_geocoding = geocode_users_table("SELECT * FROM maaking_users WHERE (user_gc_lat = 0);"); }
if($do=="d_ON"){write_option_text(0,"DEBUG","ON");};
if($do=="d_OFF"){write_option_text(0,"DEBUG","OFF");};

//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del men� verticale dovr� essere aperta
$r->voce_mv_attiva = menu_lat::user;
//Assegno il titolo che compare nella barra delle info
$r->title = "Stranezze utenti";


//Messaggio popup;
//$r->messaggio = "Pagina di test"; 
//Dico quale men� orizzontale dovr� essere associato alla pagina.
$r->menu_orizzontale = amministra_menu_completo();

//Assegno le due tabelle a tablesorter
$r->javascripts[]=java_tablesorter("output_1");
$r->javascripts[]=java_tablesorter("output_2");

$r->messaggio = $msg;
//Creo la pagina dell'aggiunta

//--------------------------------------------CONTENUTO
      
      $u_n_a = user_non_attivati();
      if($u_n_a==0){          
        $user_non_attivi='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Tutti gli users sono attivi</div>';    
      }else{
        $user_non_attivi='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">Ci sono <b>'.$u_n_a.'</b> users non ancora attivi</div>';      
      }
      
      
      // Dettagli ordini senza ordine
      
      $d_o_s_o = db_dettagli_ordine_senza_ordine();
      if($d_o_s_o==0){          
        $dettagli_ordini_senza_ordine='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">DETTAGLI ORDINE -> ORDINE: <b>OK</b></div>';    
      }else{
        $dettagli_ordini_senza_ordine='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">DETTAGLI ORDINE -> ORDINE : Ci sono <b>'.$d_o_s_o.'</b> dettagli ordine senza ordine pap�. </div>';      
      }
      
      // Distribuzione senza dettagli
      $d_s_s_d_o = db_distribuzione_spesa_senza_dettagli_ordine();
      if($d_s_s_d_o==0){          
        $distribuzione_spesa_senza_dettagli_ordine='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">DISTRIBUZIONE SPESA -> DETTAGLI ORDINE : <b>OK</b></div>';    
      }else{
        $distribuzione_spesa_senza_dettagli_ordine='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">DISTRIBUZIONE SPESA -> DETTAGLI ORDINE : Ci sono <b>'.$d_s_s_d_o.'</b> distribuzioni spesa SENZA dettagli ordine.</div>';      
      } 
      
      // Amici senza referente
      $a_s_r = db_amici_senza_referente();
      if($a_s_r==0){          
        $amici_senza_referente='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">AMICI -> USER : <b>OK</b></div>';    
      }else{
        $amici_senza_referente='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">AMICI -> USER : Ci sono <b>'.$a_s_r.'</b> amici SENZA referente.</div>';      
      }
      
      // Articoli senza listino
      $a_s_l = db_articoli_senza_listino();
      if($a_s_l==0){          
        $articoli_senza_listino='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">ARTICOLI -> LISTINI : <b>OK</b></div>';    
      }else{
        $articoli_senza_listino='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">ARTICOLI -> LISTINI : Ci sono <b>'.$a_s_l.'</b> Articoli SENZA Listino.</div>';      
      }
      
      // Listini senza ditte
      $l_s_d = db_listini_senza_ditte();
      if($l_s_d==0){          
        $listini_senza_ditte='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">LISTINI -> DITTE : <b>OK</b></div>';    
      }else{
        $listini_senza_ditte='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">LISTINI -> DITTE : Ci sono <b>'.$l_s_d.'</b> Listini SENZA Ditte.</div>';      
      }  
      
      // Dettagli_ordini senza articoli
      $d_s_a = db_dettagli_senza_articoli();
      if($d_s_a==0){          
        $dettagli_senza_articoli='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">DETTAGLI -> ARTICOLI : <b>OK</b></div>';    
      }else{
        $dettagli_senza_articoli='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">DETTAGLI -> ARTICOLI: Ci sono <b>'.$d_s_a.'</b> Dettagli SENZA Articoli.</div>';      
      }
      
      
      // Referenze senza ordine
      $r_s_o = db_referenze_senza_ordine();
      if($r_s_o==0){          
        $referenze_senza_ordine='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">REFERENZE -> ORDINI: <b>OK</b></div>';    
      }else{
        $referenze_senza_ordine='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">REFERENZE -> ORDINI: : Ci sono <b>'.$r_s_o.'</b> Referenze SENZA Ordini.</div>';      
      }
      
            // Referenze senza ordine
      $o_s_l = db_ordini_senza_listino();
      if($o_s_l==0){          
        $ordini_senza_listino='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">ORDINI -> LISTINI: <b>OK</b></div>';    
      }else{
        $ordini_senza_listino='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">ORDINI -> LISTINI: : Ci sono <b>'.$o_s_l.'</b> Ordini SENZA Listini.</div>';      
      }
      
      // Ccda postino totale
      $coda_totale = quante_mail_coda_totale();
      if($coda_totale==0){          
        $coda_totale='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Coda Postino : <b>Vuota</b></div>';    
      }else{
        $coda_totale='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">Coda Postino : Ci sono in totale <b>'.$coda_totale.'</b> Messaggi non consegnati</div>';      
      }
      
      // Ccda postino effettiva
      $coda_effettiva = quante_mail_coda_effettiva();
      if($coda_effettiva==0){          
        $coda_effettiva='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Coda Postino : <b>Vuota</b></div>';    
      }else{
        $coda_effettiva='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">Coda Postino : Ci sono <b>'.$coda_effettiva.'</b> Messaggi non consegnati</div>';      
      }
      
      // Status Mailer
      
      $mailer_status = read_option_text(0,"MAILER");
      //echo read_option_text(0,"MAILER");
      if($mailer_status=="ON"){          
        $mailer_status='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Mailer  : <b>ON</b></div>';    
      }else{
        $mailer_status='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">Mailer : <b>OFF</b></div>';      
      }
      
      // Status Mailer
      $debug_status = read_option_text(0,"DEBUG");
      if($debug_status=="OFF"){          
        $debug_status='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Debug  : <b>OFF</b></div>';    
      }else{
        $debug_status='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">Debug : <b>ON</b></div>';      
      }
      
      // Status Mailer
      
      if(_TW_OFF){          
        $twitter_status='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_alert">Twitter  : <b>OFF</b></div>';    
      }else{
        $twitter_status='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Twitter : <b>ON</b></div>';      
      }
      
      // Grocode utenti
      $res = $db->sql_query("SELECT * FROM maaking_users");
      $quanti = mysql_numrows($res);
      $utenti_gc_valido = '<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Geocode Utenti Validi : <b>'.utenti_con_geocode_ok().'</b> / '.$quanti.'</div>';
      
      // Grocode ditte
      $res = $db->sql_query("SELECT * FROM retegas_ditte");
      $quante_ditte = mysql_numrows($res);
      $ditte_gc_valido = '<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Geocode Ditte Validi : <b>'.ditte_con_geocode_ok().'</b> / '.$quante_ditte.'</div>';
      
      // Grocode GAS
      $res = $db->sql_query("SELECT * FROM retegas_gas");
      $quante_gas = mysql_numrows($res);
      $gas_gc_valido = '<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Geocode Gas Validi : <b>'.gas_con_geocode_ok().'</b> / '.$quante_gas.'</div>';
   
      
      // Temi
      $res = $db->sql_query("SELECT * FROM retegas_options WHERE chiave='_USER_OPT_THEME'");
      $quanti_tema = mysql_numrows($res);
      $utenti_tema = '<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Stanno usando un tema : <b>'.$quanti_tema.'</b> / '.$quanti.'</div>';
    
      // widgets
      $res = $db->sql_query("SELECT * FROM retegas_options WHERE chiave='WGO'");
      $quanti_widget = mysql_numrows($res);
      $utenti_widget = '<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">Utenti con widget modificati : <b>'.$quanti_widget.'</b> / '.$quanti.'</div>';
    
      //Variabili sito
      $var_site .='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">';
      $var_site .='<ul>';
      $var_site .='<li>_GAS_CASSA_MIN_LEVEL : <b>'. _GAS_CASSA_MIN_LEVEL."</b></li>";
      $var_site .='<li>_GAS_COPERTURA_CASSA : <b>'. _GAS_COPERTURA_CASSA."</b></li>";
      $var_site .='<li>_GAS_PUO_COND_ORD_EST : <b>'. _GAS_PUO_COND_ORD_EST."</b></li>";
      $var_site .='<li>_GAS_PUO_PART_ORD_EST : <b>'. _GAS_PUO_PART_ORD_EST."</b></li>";
      $var_site .='<li>_GAS_SITE_LOGO : <b>'. _GAS_SITE_LOGO."</b></li>";
      $var_site .='<li>_GAS_USA_CASSA : <b>'. _GAS_USA_CASSA."</b></li>";
      $var_site .='<li>_GAS_CASSA_CHECK_MIN_LEVEL : <b>'._GAS_CASSA_CHECK_MIN_LEVEL."</b></li>";
      $var_site .='</ul>';
      $var_site .='</div>';
      
      
      //Variabili USER
      $var_user .='<div style="padding:6px;margin-bottom:2px;" class="ui-corner-all campo_ok">';
      $var_user .='<ul>';
      $var_user .='<li>_USER_CARATTERE_DECIMALE : <b>'. _USER_CARATTERE_DECIMALE."</b></li>";
      $var_user .='<li>_USER_FULLNAME : <b>'. _USER_FULLNAME."</b></li>";
      $var_user .='<li>_USER_HAVE_MSG : <b>'. _USER_HAVE_MSG."</b></li>";
      $var_user .='<li>_USER_ID : <b>'. _USER_ID."</b></li>";
      $var_user .='<li>_USER_ID_GAS : <b>'. _USER_ID_GAS."</b></li>";
      $var_user .='<li>_USER_LANGUAGE : <b>'. _USER_LANGUAGE."</b></li>";
      $var_user .='<li>_USER_LOGGED_IN : <b>'. _USER_LOGGED_IN."</b></li>";
      $var_user .='<li>_USER_MSG : <b>'. _USER_MSG."</b></li>";
      $var_user .='<li>_USER_OPT_DECIMALS : <b>'. _USER_OPT_DECIMALS."</b></li>";
      $var_user .='<li>_USER_OPT_NO_HEADER : <b>'. _USER_OPT_NO_HEADER."</b></li>";
      $var_user .='<li>_USER_OPT_NO_SITE_HEADER : <b>'. _USER_OPT_NO_SITE_HEADER."</b></li>";
      $var_user .='<li>_USER_OPT_SEND_MAIL : <b>'. _USER_OPT_SEND_MAIL."</b></li>";
      $var_user .='<li>_USER_OPT_THEME : <b>'. _USER_OPT_THEME."</b></li>";
      $var_user .='<li>_USER_OPTIONS : <b>'. _USER_OPTIONS."</b></li>";
      $var_user .='<li>_USER_PERMISSIONS : <b>'. _USER_PERMISSIONS."</b></li>";
      $var_user .='<li>_USER_SHOW_DEBUG : <b>'. _USER_OPT_SHOW_DEBUG."</b></li>";
      $var_user .='<li>_USER_USA_CASSA : <b>'. _USER_USA_CASSA."</b></li>";
      $var_user .='<li>_USERNAME : <b>'. _USERNAME."</b></li>";
      $var_user .='<li>_USER_CSV_DELIMITER : <b>'. _USER_CSV_DELIMITER."</b></li>";
      $var_user .='<li>_USER_CSV_SEPARATOR : <b>'. _USER_CSV_SEPARATOR."</b></li>";
      $var_user .='<li>_USER_CSV_EOL : <b>'. _USER_CSV_EOL."</b></li>";
      $var_user .='<li>_USER_CSV_ZERO : <b>'. _USER_CSV_ZERO."</b></li>";
      $var_user .='</ul>';
      $var_user .='</div>';
      
      
      
      // COSTRUZIONE TABELLA  -----------------------------------------------------------------------
      $h_table .= ' <div class="rg_widget rg_widget_helper">
                   <h3>Users :</h3>
                   '.$user_non_attivi.'
                   <hr>
                   
                   <table >
                   <tr>
                   <td width="50%" style="vertical-align:top">
                   <h3>Variabili GAS :</h3>
                   '.$var_site.'
                   <h3>Database e sito :</h3>
                   '.$dettagli_ordini_senza_ordine.'
                   '.$distribuzione_spesa_senza_dettagli_ordine.'
                   '.$amici_senza_referente.'
                   '.$articoli_senza_listino.'
                   '.$dettagli_senza_articoli.'
                   '.$listini_senza_ditte.'
                   '.$referenze_senza_ordine.'
                   '.$ordini_senza_listino.'
                   '.$utenti_tema.'
                   '.$utenti_widget.'
                   </td>
                   <td style="vertical-align:top">
                   <h3>Varie</h3>
                   '.$twitter_status.'
                   '.$debug_status.'
                   '.$mailer_status.'
                   '.$coda_totale.'
                   '.$coda_effettiva.'
                   <h3>Geocoding :</h3> 
                   '.$utenti_gc_valido.'
                   '.$ditte_gc_valido.' 
                   '.$gas_gc_valido.'
                   <h3>Variabili USER</h3>
                   '.$var_user.'   
                   </td>
                   </tr>
                   </table>
                   </hr>    
                    </div> 
                   ';



//-----------------------------------------------------


//Questo � il contenuto della pagina
$r->contenuto = $h_table;

//Mando all'utente la sua pagina
echo $r->create_retegas();
//Distruggo l'oggetto r    
unset($r)   
?>