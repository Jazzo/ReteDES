<?php
function puliscistringa($stringa){
$stringa = str_replace("à", "a", $stringa);
$stringa = str_replace("è", "e", $stringa);
$stringa = str_replace("é", "e", $stringa);
$stringa = str_replace("ì", "i", $stringa);
$stringa = str_replace("ù", "u", $stringa);
$stringa = ereg_replace("[^A-Za-z0-9.,:;() ]", "", $stringa );
return $stringa;
}
function urlcorretta($url) { 
 return preg_match('|^[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url); 
}
function checkmail($email){
/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/

   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;

}
function is_empty($var, $allow_false = false, $allow_ws = false) {
    if (!isset($var) || is_null($var) || ($allow_ws == false && trim($var) == "" && !is_bool($var)) || ($allow_false === false && is_bool($var) && $var === false) || (is_array($var) && empty($var))) {    
        return true;
    } else {
        return false;
    }
}
function crc16($string) { 
  $crc = 0xFFFF; 
  for ($x = 0; $x < strlen ($string); $x++) { 
    $crc = $crc ^ ord($string[$x]); 
    for ($y = 0; $y < 8; $y++) { 
      if (($crc & 0x0001) == 0x0001) { 
        $crc = (($crc >> 1) ^ 0xA001); 
      } else { $crc = $crc >> 1; } 
    } 
  } 
  return $crc; 
}
function controllodataora($data){
   //echo "check : $data<br>";
     
    if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4} [0-9]{2}:[0-9]{2}$", $data)){
        //echo "NON Passato EREG : $data<br>"; 
        return false;
    }else{
        //echo "Passato EREG : $data<br>";
        //$arrayData = explode("/", $data);
        $Giorno = substr($data, 0, 2);
        $Mese = substr($data, 3, 2); 
        $Anno = substr($data, 6, 4);
        $Ora = substr($data, 11, 2);
        $Minuti = substr($data, 14, 2);
        //echo "Conversione: : G $Giorno, M $Mese, A $Anno, O $Ora, M $Minuti<br>";   
        if(!checkdate($Mese, $Giorno, $Anno)){
            //echo "NON PASSATO CHKdate : $Giorno, $Mese, $Anno, $Ora, $Minuti<br>"; 
            return false;
        }else{
            //echo "PASSATO CHKdate : $Giorno, $Mese, $Anno, $Ora, $Minuti<br>"; 
            if ($Ora > -1 && $Ora < 24 && $Minuti > -1 && $Minuti < 60) { 
                //echo "PASSATO CHKTIME : $Giorno, $Mese, $Anno, $Ora, $Minuti<br>";     
                return true; 
            }else{return false;}
        }
    }
} 
function controllodata($data){
    if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$", $data)){
        return false;
    }else{
        //$arrayData = explode("/", $data);
        $Giorno = substr($data, 0, 2);
        $Mese = substr($data, 3, 2); 
        $Anno = substr($data, 6, 4);
        
        //echo $Giorno."<br>";
        //echo $Mese."<br>";
        //echo $Anno."<br>";
        
         
        if(!checkdate($Mese, $Giorno, $Anno)){
            
            
            return false;
        }else{
            return true;
        }
    }
}
function conv_date_from_db ($data){
  //list ($y, $m, $d) = explode ("-", $data);
  //return "$d/$m/$y";   YYYY-MM-DD
  $y=substr($data, 0, 4);
  $m=substr($data, 5, 2); 
  $d=substr($data, 8, 2);
  $h=substr($data, 11, 2); 
  $min=substr($data, 14, 2); 
  $sec=substr($data, 17, 2);   
  
  if(empty($h)){$h="00";}
  if(empty($min)){$min="00";} 
  if(empty($sec)){$sec="00";}
  
    
  return "$d/$m/$y $h:$min";//":$sec";
  
  
  
  
}
function conv_only_date_from_db ($data){
  //list ($y, $m, $d) = explode ("-", $data);
  //return "$d/$m/$y";   YYYY-MM-DD
  $y=substr($data, 0, 4);
  $m=substr($data, 5, 2); 
  $d=substr($data, 8, 2);
  $h=substr($data, 11, 2); 
  $min=substr($data, 14, 2); 
  $sec=substr($data, 17, 2);   
  
  if(empty($h)){$h="00";}
  if(empty($min)){$min="00";} 
  if(empty($sec)){$sec="00";}
  
    
  return "$d/$m/$y";//":$sec";
  
  
  
  
}
function conv_datetime_from_db ($data){
  //list ($y, $m, $d) = explode ("-", $data);
  //return "$d/$m/$y";   YYYY-MM-DD
  $y=substr($data, 0, 4);
  $m=substr($data, 5, 2); 
  $d=substr($data, 8, 2);
  $h=substr($data, 11, 2); 
  $min=substr($data, 14, 2); 
  $sec=substr($data, 17, 2);   
  
  if(empty($h)){$h="00";}
  if(empty($min)){$min="00";} 
  if(empty($sec)){$sec="00";}
  
    
  return "$d/$m/$y $h:$min";//":$sec";
  
  
  
  
}
function conv_date_to_db ($data){
  //list ($d, $m, $y) = explode ("/", $data);
  $d=substr($data, 0, 2);
  $m=substr($data, 3, 2); 
  $y=substr($data, 6, 4);
  $h=substr($data, 11, 2); 
  $min=substr($data, 14, 2); 
  $sec=substr($data, 17, 2);
  
  if(empty($h)){$h="00";}   
  if(empty($min)){$min="00";}
  if(empty($sec)){$sec="00";}
   
  return "$y-$m-$d $h:$min:$sec";
}
function conv_datetime_to_javascript($mydatetime){
    
    $m = CAST_TO_INT(substr($mydatetime, 5, 2));
    $m = $m - 1;
    
    $mytimestamp = strtotime($mydatetime);
    
    $dj =  date("Y, m, d, H, i, s", $mytimestamp);
    
    
    if($m>9){ $dj2 =  substr_replace($dj, ($m.",") , 6,3);}else
            { $dj2 =  substr_replace($dj, ("0".$m.",") , 6,3);}
   
    //echo $dj.", $m  ---> $dj2<br>"; 
    return $dj2;
    
}
function conv_date_to_javascript($mydatetime){
    
    $m = CAST_TO_INT(substr($mydatetime, 5, 2));
    $m = $m - 1;
    
    $mytimestamp = strtotime($mydatetime);
    
    $dj =  date("Y, m, d", $mytimestamp);
    
    
    if($m>9){ $dj2 =  substr_replace($dj, ($m) , 6,2);}else
            { $dj2 =  substr_replace($dj, ("0".$m) , 6,2);}
   
    //echo $dj.", $m  ---> $dj2<br>"; 
    return $dj2;
    
}

function gas_mktime($data){
  // 01 / 01 / 2010  15: 00: 00
  // 01 2 34 5 67891 123 456 78
  // 20 0 0- 1 0-31 
  $d=substr($data, 0, 2);
  $m=substr($data, 3, 2); 
  $y=substr($data, 6, 4);
  $h=substr($data, 11, 2); 
  $min=substr($data, 14, 2); 
  $sec=substr($data, 17, 2);   
  if(empty($h)){$h="00";}   
  if(empty($min)){$min="00";}
  if(empty($sec)){$sec="00";}    
    
    
  return  mktime($h, $min, $sec, $m, $d, $y);

} 
function valuta_valida($valu){
$valu=trim($valu);    
if (!is_empty($valu)){    
    if (is_numeric($valu)){
        if ($valu<0){
            return false;
            break;    
        }else{
            return true;
            break;    
        }   
           
    }
    return false;
    break;
}
  return false;  
}
function percentuale_valida($valu){
$valu=trim($valu);    
if (!is_empty($valu)){    
    if (is_numeric($valu)){
        if (($valu<0) | ($valu>100)){
            return false;
            break;    
        }else{
            return true;
            break;    
        }   
           
    }
    return false;
    break;
}
  return false;  
}
function is_multiplo($val,$bigval){

if(!is_numeric($val)){
    return false;
    break;
}
if(!is_numeric($bigval)){
    return false;
    break;
}
if($val==0){
    return false;
    break;
}
if($bigval==0){
    return false;
    break;
}

//$val=round($val,2);
//$bigval=round($bigval,2);    

//echo "VAL ->".$val."<br>";
//echo "BIGVAL ->".$bigval."<br>";

while ($bigval > 0) {
    $bigval=number_format($bigval-$val,8);        
}
if($bigval==0){
    //echo "VAL = MULTIPLO <br>";
    return true;
    break;    
}else{
    //echo "VAL = NOT MULTIPLO <br>";
    return false;
    break;
}
    
}
function convertiDataTime($dataTime) { 
    $data = date("d/m/Y", $dataTime); 
    $ora = date("H:i", $dataTime); 
    $ieri = date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"))); 
    $oggi = date("d/m/Y", mktime(0, 0, 0, date("m"), date("d"), date("Y"))); 
    if ($data == $ieri) $dataOk = "Ieri alle"; elseif ($data == $oggi) $dataOk = "Oggi alle"; else $dataOk = $data; return("$dataOk $ora"); }
function euro($num){
if(empty($num)){$num=0;};    
$num = number_format($num,2,",","");
//$num = str_pad($num,7," ",STR_PAD_LEFT);
$num .=" Eu.";
$num = str_replace(" ","&nbsp;",$num);
//$num = "Eu. ".$num;
return $num;
}
function sanitize($data){

// remove whitespaces (not a must though)

$data = trim($data);

// apply stripslashes if magic_quotes_gpc is enabled

if(get_magic_quotes_gpc())

{

$data = stripslashes($data);

}

// a mySQL connection is required before using this function

$data = mysql_real_escape_string($data);

return $data;

}

function calcola_avanzo($bigval,$val){

if(!is_numeric($val)){
    return false;
    break;
}

if(!is_numeric($bigval)){
    return false;
    break;
}

$bigval=round($bigval,4);
$val=round($val,4);



while (($bigval-$val) >= 0) {
    $bigval=round($bigval-$val,4);                
}

    //echo "VAL = NOT MULTIPLO <br>";
return round($bigval,4);

 
}


function utente_attivo_partecipa_ordine($id_ordine){
    //USER PRESO INTERNAMENTE
    global $db,$RG_addr;
    
    
    //ORDINE ESISTENTE
    if(ordine_inesistente($id_ordine)){
        go("sommario",_USER_ID,"ORDINE INESISTENTE");
    }
    
    //UTENTE NON PUO' PARTECIPARE AGLI ORDINI
    
    if(!(_USER_PERMISSIONS & perm::puo_partecipare_ordini)){
        return "Utente non abilitato a partecipare agli ordini";
    }
    
    
    //CONTROLLO SE  ESISTE REFERENTE  
    if(id_referente_ordine_globale($id_ordine)<>id_referente_ordine_proprio_gas($id_ordine,_USER_ID_GAS)){
        
        //CONTROLLO SE L'ORDINE E' PARTECIPABILE DAl mio gas
        if(!_GAS_PUO_PART_ORD_EST){
                return "Il tuo gas non può partecipare ad ordini esterni";
        }
        
        //CONTROLLO SE ESISTE UN REFERENTE
        if(id_referente_ordine_proprio_gas($id_ordine,_USER_ID_GAS)==0){
                return "Per questo ordine il tuo GAS non ha un referente";
                 
        }
        
        
    }
    
    //CONTROLLO SE E' SOLO PER CASSATI
    if(_GAS_USA_CASSA){
        if(ordini_field_value($id_ordine,"solo_cassati")=="SI"){   
            if(!_USER_USA_CASSA){
                return "Per questo ordine è necessaria la cassa attiva";
                die();
            }    
        }
    }
    
    
    
    //ORDINE APERTO CONTROLLO DATA E ORA
    if(ordine_partecipabile($id_ordine)){
        return "OK";
        die();
    }else{   
    //ORDINE NON APERTO, CONTROLLO STATO
        if(stato_from_id_ord($id_ordine)==3){
            //SE NON E' GIA' CONVALIDATO
            if(!is_printable_from_id_ord($id_ordine)){
                    //UTENTE GESTORE ORDINI
                    if(_USER_PERMISSIONS & perm::puo_vedere_tutti_ordini){
                         return "OK";
                         die();
                    }else{
                         
                        if(id_referente_ordine_globale($id_ordine)==_USER_ID){
                            //REFERENTE ORDINE
                            return "OK";
                            die();    
                        }else{
                            //UTENTE NORMALE
                            return "Ordine chiuso. Impossibile partecipare";
                            die();
                        } 
                    }
            }        
        }else{
            return "Ordine ancora da aprire. Impossibile partecipare";
            die();
        }
    }
    
} 