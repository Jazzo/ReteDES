<?php
if (eregi("functionmsg.php", $_SERVER['SCRIPT_NAME'])) {
    //Header("Location: index.php"); die();
}
  function message_mail_utente($username,$password,$messaggio_referente){ 
          
          $eol ="\r\n";
          $message = "$eol";
          $message .= "Grazie per la tua adesione al progetto ReteDes.it $eol";
          $message .= "$eol";
          $message .= "Conserva con cura questa mail perche' essa contiene i tuoi dati di registrazione. $eol";
          $message .= "$eol";
          $message .= "---------------------------- $eol";
          $message .= "USERNAME: $username  $eol" ;
          $message .= "PASSWORD: $password $eol";
          $message .= "Tuo messaggio : $messaggio_referente $eol"; 
          $message .= "---------------------------- $eol";
          $message .= "$eol" ;
          $message .= "Il tuo account attualmente NON e' attivo. $eol";
          $message .= "La validazione del tuo account avviene previa accettazione da parte $eol" ;
          $message .= "del referente GAS al quale ti sei iscritto. $eol" ;
          $message .= "Potresti essere contattato da lui telefonicamente per una verifica di identita'. $eol" ;   
          $message .= "$eol";
          $message .= "Non perdere la tua password, perchè in quel caso non c'è modo di recuperarla $eol";
          $message .= "$eol";
          $message .= "$eol";
          $message .= "---------------- $eol";
          $message .= "RETEDES.IT $eol";
          $message .= "SITO : "._SITE_NAME." $eol";
          $message .= "MAIL : "._SITE_MAIL_LOG." $eol"; 
          $message .= "$eol";
          $message .= "$eol";
          $message .= "Questa è una mail generata automaticamente.  $eol" ;
          
  
  return $message;
  }  
  function message_mail_admin_gas($username,$nomecompleto,$tel,$code,$messaggio_referente,$gasapp=null){ 
          global $RG_addr;
          
          $eol ="\r\n";
          $message .= "RETEDES. (Rete dei DES e dei GAS$eol";
          $message = "$eol";
          $message .= "L'utente $nomecompleto ha chiesto di far parte del tuo GAS $gasapp $eol";
          $message .= "$eol";
          $message .= "I dati che lui ha inserito sono :$eol";
          $message .= "------------------------------- :$eol";
          $message .= "Nome completo :$nomecompleto $eol";
          $message .= "Telefono : $tel $eol";
          $message .= "Suo messaggio : $messaggio_referente $eol";
          $message .= "------------------------------- :$eol";
          $message .= "$eol";
           
          $message .= "Se vuoi accettare la sua iscrizione, accedi al sito e naviga sino alla pagina apposita. $eol";
          $message .= "Troverai un Link nella tua HomePage, il quale sarà visibile anche agli altri utenti che sono abilitati a gestire le iscrizioni.";
          //$message .= "------------------------------- :$eol";
          //$message .= $RG_addr["pag_users"]."?q=Activate&code=$code $eol"; 
          $message .= "------------------------------- :$eol";
          $message .= "$eol"; 
          $message .= "$eol"; 
          $message .= "RETEDES. (Rete dei DES e dei GAS)$eol";
          $message .= "SITO : www.retedes.it$eol";
          $message .= "MAIL : "._SITE_MAIL_LOG." $eol"; 
          $message .= "$eol";
          $message .= "$eol";
          $message .= "Questa è una mail generata automaticamente.  $eol" ;
                                     
  
  return $message;
  }
  function message_mail_nuovo_utente(){ 
          
          $eol ="\r\n";
          $message .= "RETEDES.it (Rete dei DES e dei GAS)$eol";
          $message = "$eol";
          $message .= "Il tuo account e' stato attivato";
          $message .= "$eol";
          $message .= "Ora puoi accedere al sito tramite la tua Username/Password. $eol";
          $message .= "$eol"; 
          $message .= "$eol"; 
          $message .= "RETEDES (Rete dei GAS Alto Piemnote)$eol";
          $message .= "SITO : www.retedes.it$eol";
          $message .= "MAIL : "._SITE_MAIL_LOG." $eol"; 
          $message .= "$eol";
          $message .= "$eol";
          $message .= "Questa è una mail generata automaticamente.  $eol" ;
                                     
  
  return $message;
  }
  
  
function message_headers($site_name,$site_email){
 $eol ="\r\n";  
  $headers .= "From: ".$site_name."<".$site_email.">".$eol;
          $headers .= "Reply-To: ".$site_name."<".$site_email.">".$eol;
          $headers .= "Return-Path: ".$site_name."<".$site_email.">".$eol;
          $headers .= "Message-ID: <".time()."-".$site_email.">".$eol;
          $headers .= "X-Mailer: PHP v".phpversion().$eol;
          $headers .= 'MIME-Version: 1.0'.$eol;
          //TEST 09/12
          $headers .= "Content-Type: text; charset=\"utf-8\"".$eol.$eol;
          
  return $headers;
 }
function message_headers_html($site_name,$site_email){
 $eol ="\r\n";
            
           $headers .= "From: ".$site_name."<".$site_email.">".$eol;
          $headers .= "Reply-To: ".$site_name."<".$site_email.">".$eol;
          $headers .= "Return-Path: ".$site_name."<".$site_email.">".$eol;
          $headers .= "Message-ID: <".time()."-".$site_email.">".$eol;
          $headers .= "X-Mailer: PHP v".phpversion().$eol;
          $headers .= "MIME-Version: 1.0".$eol;   
          $headers .= "Content-Type: text/html; charset=\"utf-8\"".$eol;
          $headers .= "Content-Transfer-Encoding: 7bit".$eol.$eol;

  return $headers;
 } 
 
function message_mail_modifica_ordine($username, $ordine,$n_articoli,$gest_ord){ 
          
          $eol ="\r\n";
          $message = "$eol";
          $message .= "Gentile $username, $eol";
          $message .= "$eol";
          $message .= "L'ordine $ordine, al quale stai partecipando acquistando n. $n_articoli articoli,$eol";
          $message .= "è stato modificato dal suo gestore ($gest_ord) in qualche sua parte. $eol";  
          $message .= "$eol";
          $message .= "Potrebbe essere stata spostata la data di scadenza o modificati i costi di gestione,$eol";
          $message .= "Oppure potrebbe essere stata definita la data di arrivo merce.$eol";
          $message .= "Ti consigliamo di dare un'occhiata.$eol";
          $message .= "---------------------------- $eol";
          $message .= "$eol";
          $message .= "$eol";
          $message .= "$eol";
          $message .= "RETEGASAP. (Rete dei GAS Alto Piemonte)$eol";
          $message .= "SITO : www.retegas.info $eol";
          $message .= "MAIL : "._SITE_MAIL_LOG." $eol"; 
          $message .= "$eol";
          $message .= "$eol";
          $message .= "Questa è una mail generata automaticamente.  $eol" ;
          
  
  return $message;
  }   
function message_mail_nuovo_ordine($username, $p1,$p2,$p3,$p4,$p5){ 
    //P1 = Creatore ordine
    //P2 Titolo ordine
    //P3 = listino
    //P4 = ditta
    //P5 = tipologia      
    
    
          $eol ="\r\n";
          $message = "$eol";
          $message .= "Gentile $username, $eol";
          $message .= "$eol";
          $message .= "Sarai felice di sapere che $p1 ha fatto partire un nuovo ordine.$eol";
          $message .= "L'ha intitolato '$p2', $eol";
          $message .= "ed usa il listino '$p3' della ditta $p4 $eol";  
          $message .= "Si tratta di :$p5 $eol";
          $message .= "$eol";
          $message .= "Se ti interessa affrettati a partecipare !!.$eol";
          $message .= "";
          $message .= "---------------------------- $eol";
          $message .= "$eol";
          $message .= "$eol";
          $message .= "$eol";
          $message .= "RETEDESIT. (La Retedei DES e dei GAS)$eol";
          $message .= "SITO : www.retedes.it $eol";
          $message .= "MAIL : "._SITE_MAIL_LOG." $eol"; 
          $message .= "$eol";
          $message .= "$eol";
          $message .= "Questa è una mail generata automaticamente.  $eol" ;
          
  
  return $message;
  }  
