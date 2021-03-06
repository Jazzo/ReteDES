<?php


//Funzioni di rendering
function cassa_render_user_panel($id_utente){
    global $RG_addr;
    
    
    $title="Riepilogo Cassa di ".fullname_from_id($id_utente);
    $h .= "<h2>Saldo: "._nf(cassa_saldo_utente_totale($id_utente))." Eu.</h2>
           <h3>Di cui "._nf(cassa_saldo_utente_non_confermato($id_utente))." Eu. non confermati</h3>
           ";
           
    
    return rg_toggable($title,"cassa_user_panel",$h,true);       
    
    
}


//SALDO UTENTE  ($id_user) TUTTI I MOVIMENTI
function cassa_saldo_utente_totale($id_user){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}

//SALDO UTENTE EFFETTIVO  ($id_user) SOLO MOVIMENTI REGISTRATI
function cassa_saldo_utente_registrato($id_user){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+' AND registrato='si'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-' AND registrato='si'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}
function cassa_saldo_utente_registrato_ordine($id_user,$id_ordine){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+' AND registrato='si' AND id_ordine='$id_ordine'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-' AND registrato='si' AND id_ordine='$id_ordine'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}

//SALDO UTENTE PER DETTAGLIO ORDINI
function cassa_saldo_utente_inserito_ordine($id_user,$id_ordine,$id_tipo){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+'  AND id_ordine='$id_ordine' AND tipo_movimento='$id_tipo'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-'  AND id_ordine='$id_ordine' AND tipo_movimento='$id_tipo'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}
function cassa_utente_saldo_ordine($id_user,$id_ordine){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+'  AND id_ordine='$id_ordine' ),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-'  AND id_ordine='$id_ordine' ),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}

//SALDO UTENTE  ($id_user) SOLO MOVIMENTI CONTABILIZZATI
function cassa_saldo_utente_contabilizzata($id_user){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+' AND contabilizzato='si'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-' AND contabilizzato='si'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}

//SALDO UTENTE  ($id_user) SOLO MOVIMENTI ANCORA DA REGISTRARE
function cassa_saldo_utente_non_confermato($id_user){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+' AND registrato='no'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-' AND registrato='no'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}
function cassa_saldo_utente_in_attesa($id_user){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+' AND registrato='no'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-' AND registrato='no'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}
function cassa_utente_tutti_movimenti($id_user){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='+' ),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_utente='$id_user' AND segno='-' ),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}
function cassa_saldo_ordine_in_attesa($id_ordine){
    global $db;
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_ordine='$id_ordine' AND segno='+' AND registrato='no'),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_ordine='$id_ordine' AND segno='-' AND registrato='no'),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}

function  cassa_delete_user_ordine($id_ordine,$id_utente,$id_tipo){
    
    global $db;
    $query = "DELETE FROM retegas_cassa_utenti WHERE id_ordine='$id_ordine' AND id_utente='$id_utente' AND tipo_movimento='$id_tipo';";
    $res = $db->sql_query($query);
    return $db->sql_numrows($res);
    
}

//SALDO GAS REGISTRATO ($id_gas) SOLO MOVIMENTI REGISTRATI
function cassa_saldo_gas_registrato($id_gas){
    global $db;
    //AND escludi_gas='0'
    
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_gas='$id_gas' AND segno='+' AND registrato='si' ),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_gas='$id_gas' AND segno='-' AND registrato='si' ),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}

//SALDO GAS REGISTRATO ($id_gas) SOLO MOVIMENTI REGISTRATI
function cassa_saldo_gas_contabilizzato($id_gas){
    global $db;
    //AND escludi_gas='0'
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_gas='$id_gas' AND segno='+' AND contabilizzato='si' ),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_gas='$id_gas' AND segno='-' AND contabilizzato='si' ),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}

//SALDO GAS TOTALE ($id_gas) TUTTII
function cassa_saldo_gas_totale($id_gas){
    global $db;
    
    //AND escludi_gas='0'
    $query = "SELECT  (
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_gas='$id_gas' AND segno='+' ),0)
                -
                COALESCE((SELECT SUM(importo) FROM retegas_cassa_utenti WHERE id_gas='$id_gas' AND segno='-' ),0)
                )  As risultato";
    $result = $db->sql_query($query);
    $row = $db->sql_fetchrow($result);
    
    return (float)round($row["risultato"],4);
    
}


//Movimenti Utente Per Widget
function cassa_movimenti_utente_widget($id_user){

global $RG_addr,$db,$__movcas;

$query = "SELECT * FROM retegas_cassa_utenti WHERE id_utente='$id_user' ORDER BY data_movimento DESC;";
$result = $db->sql_query($query);

$h ='<div class="widget_cassa">';
$h.="<table class=\"small_size\">";
$h.='<thead>';
$h.='<th>&nbsp</th>';
$h.='<th>Data</th>';
$h.='<th>Causale</th>';
$h.='<th>Importo</th>';
//$h.='<th>Data</th>';

$h.='</thead>';   

while ($row = mysql_fetch_array($result)){
    
    
$opz='<a class="awesome small celeste" href="'.$RG_addr["cassa_movimento_sing_ut"].'?id_movimento='.$row["id_cassa_utenti"].'">V</a>';    
if($row["registrato"]=="si"){
    $pal = pallino("verde");
    
}else{
     
    $pal = pallino("grigio");
}
   
    
if($row["id_ordine"]<>0){
    $ord='(Ord. <a href="'.$RG_addr[""].'" '.rg_tooltip(descrizione_ordine_from_id_ordine($row["id_ordine"])).'><strong>'.$row["id_ordine"].'</strong></a>) ';
}else{
    $ord='';
}
    
$h .='<tr>';
    $h .='<td>'.$opz.'</td>';
    $h .='<td>'.conv_datetime_from_db($row["data_movimento"]).'</td>';
    $h .='<td>'.$pal.' '.$__movcas[$row["tipo_movimento"]]." ".$ord.'</td>';
    $h .='<td class="right">'.$row["segno"].' '._nf($row["importo"]).'</td>';
    
          
$h .='</tr>';    
}


$h.='<tfoot>';
$h.='<th>&nbsp</th>';
$h.='<th>&nbsp</th>';
$h.='<th>&nbsp</th>'; 
$h.='<th class="right">'._nf(cassa_saldo_utente_totale($id_user)).'</th>';

//$h.='<th>&nbsp</th>';
$h.='</tfoot>'; 

$attesa_registrazione = cassa_saldo_utente_in_attesa($id_user);
if($attesa_registrazione >0){
$h2 .="<br><div class=\"ui-state-error ui-corner-all padding_6px\">";
$h2 .='Nel database ci sono movimenti non ancora registrati da parte del cassiere per un valore totale di euro <strong>'.$attesa_registrazione.'</strong>';
$h2 .="</div>";    
}


$h .="</table>";
$h .= $h2;
$h .="</div>";
    
return $h;    
}
function cassa_mov_raggr_utente_widget($id_utente) {
     global $RG_addr,$db;
         $result = $db->sql_query("SELECT    id_ordine, 
                                        COUNT(`id_cassa_utenti`) as conto_mov,
                                        segno,
                                        MAX(data_movimento) as max_data,
                                        SUM(`importo`) as somma_mov 
                                        FROM `retegas_cassa_utenti` 
                                        WHERE id_utente = '$id_utente' 
                                        GROUP BY `id_ordine`
                                        ORDER BY max_data DESC; ");
    $totalrows = $db->sql_numrows($result);     
    $fullname = fullname_from_id($id_utente);

    $h ='<div class="widget_cassa">';
    $h .= " <table class=\"medium_size\">
            <thead>
                <tr>
                    
                    <th class=\"sinistra\">&nbsp;</th>
                    <th class=\"sinistra\">Data</th>
                    <th class=\"sinistra\">Descrizione</th>          
                    <th class=\"destra\">Debito</th>
                    <th class=\"destra\">Credito</th>
                    <th class=\"sinistra\">&nbsp;</th>
                </tr>
            </thead>
        <tbody>";

       $riga=0;  

         while ($row = $db->sql_fetchrow($result)){
         $riga++;
         
         
         
         $ordine_op = $row["id_ordine"];
         $importo_ordine = cassa_utente_saldo_ordine($id_utente,$ordine_op);
         
         if($ordine_op==0){
             $ordine_op="";
             $descrizione_op="Carico crediti (Raggruppato)";
         }else{
          $descrizione_op = "".$row["id_ordine"].", <a href=\"".$RG_addr["ordini_form"]."?id_ordine=".$row["id_ordine"]."\">".descrizione_ordine_from_id_ordine($row["id_ordine"])."</a>, di ".fullname_from_id(id_referente_ordine_globale($row["id_ordine"]));            
         }
         
         if($importo_ordine>0){
             //$somma_credito = $somma_credito + $row["somma_mov"];
             $somma_credito = $somma_credito + $importo_ordine;
             //$credito_op = _nf($row["somma_mov"]);
             $credito_op = _nf($importo_ordine);
             $debito_op = "&nbsp;";
         }else{
             //$somma_debito = $somma_debito + $row["somma_mov"];
             $somma_debito = $somma_debito + $importo_ordine;
             //$debito_op = _nf($row["somma_mov"]);
             $debito_op = _nf($importo_ordine);
             $credito_op = "&nbsp;";
         }
         
            $opz = "<a class=\"awesome silver small\" href=\"".$RG_addr["cassa_movimenti_ord_ut"]."?id_ordine=".$row["id_ordine"]."\">".$row["conto_mov"]."</a>";

         if(!is_printable_from_id_ord($row["id_ordine"])){
             //$REG = "SI<br><span class=\"small_link\">".conv_datetime_from_db($row["data_registrato"])."</span>";
             $pal = '<IMG SRC="'.$RG_addr["img_pallino_grigio"].'"  style="height:16px; width:16px;vertical_align:middle;border=0;">';
             $color= "#C0C0C0";
         }else{
             //$REG = "NO";
             $pal = '<IMG SRC="'.$RG_addr["img_pallino_verde"].'"  style="height:16px; width:16px;vertical_align:middle;border=0;">';
             $color= "#000000";
         }
         
         if($row["id_ordine"]==0){
            $pal = '<IMG SRC="'.$RG_addr["img_pallino_verde"].'"  style="height:16px; width:16px;vertical_align:middle;border=0;">';
            $color= "#000000";
         }
         
             
         if(is_integer($riga/2)){  
                $class= "class=\"odd\"";    // Colore Riga
         }else{
                $class= "";    
         }   
            $h.= "
            <tr style=\"color:$color;\" $class>        
                <td class=\"sinistra\">$opz</td>
                <td class=\"sinistra\"><span class=\"small_link\">".conv_datetime_from_db($row["max_data"])."</span></td>
                <td class=\"sinistra\" style=\"vertical-align:top\">$descrizione_op</td>
                <td class=\"destra\" style=\"font-size:1.3em\">$credito_op</td>
                <td class=\"destra\" style=\"font-size:1.3em\">$debito_op</td>
                <td class=\"sinistra\">$pal</td>
            </tr>";


         }//end while


         $h.= "
         </tbody>
         <tfoot>
             <tr class=\"subtotal\">
                <th>&nbsp;</th>
                <th>&nbsp;</th>         
                <th>Totale caricati</th>
                <th class=\"destra\" style=\"font-size:1.4em\">"._nf($somma_credito)."</th>
                <th class=\"destra\" style=\"font-size:1.4em\">&nbsp;</th>
                <th>&nbsp;</th> 
            </tr>
            <tr class=\"subtotal\">
                <th>&nbsp;</th>
                <th>&nbsp;</th>         
                <th>Totale spesi</th>
                <th class=\"destra\" style=\"font-size:1.4em\">&nbsp;</th>
                <th class=\"destra\" style=\"font-size:1.4em\">"._nf($somma_debito)."</th>
                <th>&nbsp;</th> 
            </tr>
            <tr class=\"total\">
                <th>&nbsp;</th>
                <th>&nbsp;</th>         
                <th>Disponibili</th>
                <th colspan=\"2\" class=\"centro\" style=\"font-size:1.5em\">"._nf($somma_credito + $somma_debito)."</th>
                <th>&nbsp;</th> 
            </tr>
         
         </tfoot>
         </table>
         </div>";
     
 return $h;   
}


function cassa_movimenti_ordine_micro($id_ordine, $id_gas){

global $RG_addr,$db,$__movcas;

$query = "SELECT * FROM retegas_cassa_utenti WHERE id_ordine='$id_ordine' AND id_gas='$id_gas';";
$result = $db->sql_query($query);

$h ='<div class="widget_cassa"><h3>Movimenti riferiti ord. '.$id_ordine.'</h3>';
$h.="<table id=\"micro_table\">";
$h.='<thead>';
$h.='<th>#</th>';
$h.='<th>Data</th>';
$h.='<th>Causale</th>';
$h.='<th>Importo</th>';
//$h.='<th>Data</th>';

$h.='</thead>';   

while ($row = mysql_fetch_array($result)){

$opz='<a class="awesome small celeste" href="'.$RG_addr["cassa_singolo_movimento"].'?id_movimento='.$row["id_cassa_utenti"].'">'.$row["id_cassa_utenti"].'</a>';    
$opz2='<a href="" class="awesome smallest celeste destra">
    <span class="ui-icon ui-icon-contct">    
    </span>
    </a>';
$opz2 = "&nbsp";    
    
if($row["id_utente"]<>0){
    $usr='<a href="'.$RG_addr[""].'">'.fullname_from_id($row["id_utente"]).'</a>';
}else{
    $usr='';
}
    
$h .='<tr>';
    $h .='<td>'.$opz.'</td>';
    $h .='<td>'.conv_datetime_from_db($row["data_movimento"]).'</td>';
    $h .='<td>'.$__movcas[$row["tipo_movimento"]].' ('.$usr.')</td>';
    $h .='<td class="right">'.$row["segno"].' '.number_format($row["importo"],2,",","").'</td>';
    
          
$h .='</tr>';    
}

 

$attesa_registrazione = round(cassa_saldo_gas_totale($id_gas),2) - round(cassa_saldo_gas_registrato($id_gas));
if($attesa_registrazione >0){
$h2 .="<br><div class=\"ui-state-error ui-corner-all padding_6px\">";
$h2 .='Nel database ci sono movimenti non ancora registrati per un valore totale di euro <strong>'.$attesa_registrazione.'</strong>';
$h2 .="</div>";    
}


$h .="</table>";
$h .= $h2;
$h .="</div>";
    
return $h;    
}
function cassa_movimenti_tipo_micro($tipo, $id_gas){

global $RG_addr,$db,$__movcas;

$query = "SELECT * FROM retegas_cassa_utenti WHERE tipo_movimento='$tipo' AND id_gas='$id_gas';";
$result = $db->sql_query($query);

$h ='<div class="widget_cassa"><h3>Movimenti di tipo "'.$__movcas[$tipo].'"</h3>';
$h.="<table id=\"micro_table\">";
$h.='<thead>';
$h.='<th>#</th>';
$h.='<th>Data</th>';
$h.='<th>Ordine</th>';
$h.='<th>Utente</th>';
$h.='<th>Importo</th>';
//$h.='<th>Data</th>';

$h.='</thead>';   

while ($row = mysql_fetch_array($result)){

$opz='<a class="awesome small celeste" href="'.$RG_addr["cassa_singolo_movimento"].'?id_movimento='.$row["id_cassa_utenti"].'">'.$row["id_cassa_utenti"].'</a>';    
$opz2='<a href="" class="awesome smallest celeste destra">
    <span class="ui-icon ui-icon-contct">    
    </span>
    </a>';
$opz2 = "&nbsp";    
    
    
$h .='<tr>';
    $h .='<td>'.$opz.'</td>';
    $h .='<td>'.conv_datetime_from_db($row["data_movimento"]).'</td>';
    $h .='<td>'.$row["id_ordine"].' ('.descrizione_ordine_from_id_ordine($row["id_ordine"]).')</td>';
    $h .='<td>'.$row["id_utente"].' ('.fullname_from_id($row["id_utente"]).')</td>';
    $h .='<td class="right">'.$row["segno"].' '.number_format($row["importo"],2,",","").'</td>';
      
$h .='</tr>';    
}

 

$attesa_registrazione = cassa_saldo_ordine_in_attesa($id_user);
if($attesa_registrazione >0){
$h2 .="<br><div class=\"ui-state-error ui-corner-all padding_6px\">";
$h2 .='Nel database ci sono movimenti non ancora registrati per un valore totale di euro <strong>'.$attesa_registrazione.'</strong>';
$h2 .="</div>";    
}


$h .="</table>";
$h .= $h2;
$h .="</div>";
    
return $h;    
}
function cassa_movimenti_utente_micro($utente, $id_gas){

global $RG_addr,$db,$__movcas;

$query = "SELECT * FROM retegas_cassa_utenti WHERE id_utente='$utente';";
$result = $db->sql_query($query);

$h ='<div class="widget_cassa"><h3>Movimenti dell\'utente '.fullname_from_id($utente).'</h3>';
$h.="<table id=\"micro_table\">";
$h.='<thead>';
$h.='<th>#</th>';
$h.='<th>Data</th>';
$h.='<th>Ordine</th>';
$h.='<th>Importo</th>';
//$h.='<th>Data</th>';

$h.='</thead>';   

while ($row = mysql_fetch_array($result)){

$opz='<a class="awesome small celeste" href="'.$RG_addr["cassa_singolo_movimento"].'?id_movimento='.$row["id_cassa_utenti"].'">'.$row["id_cassa_utenti"].'</a>';    
$opz2='<a href="" class="awesome smallest celeste destra">
    <span class="ui-icon ui-icon-contct">    
    </span>
    </a>';
$opz2 = "&nbsp";    
    
    
$h .='<tr>';
    $h .='<td>'.$opz.'</td>';
    $h .='<td>'.conv_datetime_from_db($row["data_movimento"]).'</td>';
    $h .='<td>'.$row["id_ordine"].' ('.descrizione_ordine_from_id_ordine($row["id_ordine"]).')</td>';
    $h .='<td class="right">'.$row["segno"].' '.number_format($row["importo"],2,",","").'</td>';
      
$h .='</tr>';    
}

 

$attesa_registrazione = cassa_saldo_ordine_in_attesa($id_user);
if($attesa_registrazione >0){
$h2 .="<br><div class=\"ui-state-error ui-corner-all padding_6px\">";
$h2 .='Nel database ci sono movimenti non ancora registrati per un valore totale di euro <strong>'.$attesa_registrazione.'</strong>';
$h2 .="</div>";    
}


$h .="</table>";
$h .= $h2;
$h .="</div>";
    
return $h;    
}


function cassa_movimenti_ordini_table($id_ordine,$id_gas){
global $db,$RG_addr,$__movcas;      

    $result = mysql_query("SELECT * FROM retegas_cassa_utenti WHERE id_ordine='$id_ordine' AND id_gas='$id_gas';");
    $totalrows = mysql_num_rows($result);     
    $fullname = fullname_from_id($id_user);


    $h .= " <div class=\"rg_widget rg_widget_helper\">
            <h3>Tutti i movimenti riferiti all'ordine  ".$id_ordine."</h3>
            <table id=\"output\">
         <thead>
         <tr>
        <th>&nbsp</th>          
        <th>#</th>
        <th>Utente</th>
        <th>Data</th>
        <th>Tipo</th>
        <th>Credito</th>
        <th>Debito</th>
        <th>Descrizione</th>
        <th>Cassiere</th>
        <th>REG</th>
        <th>CON</th> 
        </tr>
        </thead>
        <tbody>";

       $riga=0;  

         while ($row = mysql_fetch_array($result)){
         $riga++;

         $id_op = $row["id_cassa_utenti"];
         $data_op = conv_datetime_from_db($row["data_movimento"]);
         $tipo_op = $__movcas[$row["tipo_movimento"]];
         if($row["segno"]=="+"){
             $credito_op = _nf($row["importo"]);
             $debito_op = "&nbsp";
         }else{
             $debito_op = _nf($row["importo"]);
             $credito_op = "&nbsp";
         }
         $descrizione_op = $row["descrizione_movimento"];
         $ordine_op = $row["id_ordine"];
         $cassiere_op = fullname_from_id($row["id_cassiere"]);
         $ditta = $row["id_ditta"];
         $utente = fullname_from_id($row["id_utente"]);
         
         if($row["registrato"]=="si"){
             $REG = "SI<br><span class=\"small_link\">".conv_datetime_from_db($row["data_registrato"])."</span>";
             $pal = '<IMG SRC="'.$RG_addr["img_pallino_grigio"].'" ALT="" style="height:16px; width:16px;vertical_align:middle;border=0;">';
         }else{
             $REG = "NO";
             $pal = '<IMG SRC="'.$RG_addr["img_pallino_rosso"].'" ALT="" style="height:16px; width:16px;vertical_align:middle;border=0;">';
         }
         if($row["contabilizzato"]=="si"){
             $CON = "SI<br><span class=\"small_link\">".conv_datetime_from_db($row["data_contabilizzato"])."</span>";
             $pal = '<IMG SRC="'.$RG_addr["img_pallino_verde"].'" ALT="" style="height:16px; width:16px;vertical_align:middle;border=0;">';
         }else{
             $CON = "NO";
         }
         
         
            $h.= "
            <tr>
            <td class=\"sinistra\">$pal</td>
            <td class=\"sinistra\">$id_op</td>
            <td class=\"sinistra\">$utente</td> 
            <td class=\"sinistra\">$data_op</td>
            <td class=\"sinistra\">$tipo_op</td>
            <td class=\"destra\">$credito_op</td>
            <td class=\"destra\">$debito_op</td>
            <td class=\"sinistra\">$descrizione_op</td>
            <td class=\"sinistra\">$cassiere_op</td>
            <td class=\"sinistra\">$REG</td>
            <td class=\"sinistra\">$CON</td>   
            </tr>";

         }//end while


         $h.= "
         </tbody>
         </table>";
         return $h;    
    
    
}



function cassa_situazione_ordine_utenti($ref_table,$id_ordine,$id_gas){
         
        

      global $db,$RG_addr;
      
      
      $operazioni_extra = rg_toggable("OPERAZIONI AVANZATE di gestione crediti su questo ordine","ope_ava","<ul>
                            <li><a class=\"awesome red option\" href=\"".$RG_addr["cassa_ordini_sit_ut"]."?do=do_del_anticipo&id_ordine=$id_ordine\"><span class=\"ui-icon ui-icon-trash\"></span></a> Clicca qua per eliminare tutti i movimenti di anticipo copertura rifireti a questo ordine, di tutti gli utenti con la cassa del tuo GAS.</li>
                            </ul>",false);
      
      $h .= "   $operazioni_extra
                <div class=\"rg_widget rg_widget_helper\">
                <h3>Scala gli importi relativi a quest'ordine dai crediti degli utenti partecipanti</h3>
                
                <form class=\"retegas_form\" method=\"POST\" action=\"\">
                <table id=\"$ref_table\">
                    <thead>     
                        <tr> 
                            <th class=\"sinistra\">Utente</th>
                            <th class=\"destra\">Anticipo</th>
                            <th class=\"destra\">Netto</th>
                            <th class=\"destra\">Trasporto</th>
                            
                            <th><a title=\"(Costo % gestione)<br>scaricati dai crediti utenti partecipanti e caricati al credito dell'utente gestore\">Gestione</a></th>
                            <th>Costo GAS</th>
                            <th>% GAS</th>
                            <th><a title=\"(% GAS + Costo GAS)<br>Scaricati dai crediti utenti partecipanti e caricati sulla cassa GAS come 'finanziamento GAS'\">Totale al GAS</a></th>
                            <th>Mov</th>
                            <th>&nbsp</th>
                            <th>&nbsp</th> 
                        </tr>
                    <thead>
                    <tbody>";


       $col_5 = "style=\"text-align:right;\"";             
                    
       $result = $db->sql_query("SELECT
                                    Sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) as importo_totale,
                                    Sum(retegas_dettaglio_ordini.qta_arr) as somma_articoli,
                                    Count(retegas_dettaglio_ordini.id_articoli) as conto_articoli,
                                    maaking_users.fullname,
                                    maaking_users.userid,
                                    retegas_gas.id_gas,
                                    retegas_gas.descrizione_gas
                                    FROM
                                    retegas_dettaglio_ordini
                                    Inner Join maaking_users ON retegas_dettaglio_ordini.id_utenti = maaking_users.userid
                                    Inner Join retegas_articoli ON retegas_dettaglio_ordini.id_articoli = retegas_articoli.id_articoli
                                    Inner Join retegas_gas ON maaking_users.id_gas = retegas_gas.id_gas
                                    WHERE
                                    retegas_dettaglio_ordini.id_ordine =  '$id_ordine'
                                    AND
                                    retegas_gas.id_gas = '$id_gas'
                                    GROUP BY
                                    retegas_dettaglio_ordini.id_utenti
                                    ORDER BY Sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) DESC");


       $riga=0;  
         while ($row = $db->sql_fetchrow($result)){
         
              $riga++;

              $id_ut = $row["userid"];
              $nome_ut = $row['fullname'];
              $gas_app = $row['descrizione_gas'];
              $id_gas_app = $row['id_gas'];
              $conto_articoli = $row['conto_articoli'];
              $somma_articoli = $row['somma_articoli'];
              $importo_totale = $row["importo_totale"];
              
              
              $totalone = $totalone+ $importo_totale;
              $totalone_articoli = $totalone_articoli + $somma_articoli;
              
              
              $somma_articoli = (float)$somma_articoli;
              
              $costo_trasporto = round(valore_costo_trasporto_ordine_user($id_ordine,$id_ut),4);
              $costo_gestione = round(valore_costo_gestione_ordine_user($id_ordine,$id_ut),4);
              $costo_mio_gas = round(valore_costo_mio_gas($id_ordine,$id_ut),4);
              $costo_maggiorazione =round(valore_costo_maggiorazione_mio_gas($id_ordine,$id_ut),4);
              $costo_al_fornitore = round(($importo_totale + $costo_trasporto),4); 
              $tot_costi_gas= round(($costo_mio_gas+$costo_maggiorazione),4);
              $totale_lordo = round(($costo_trasporto +
                              $costo_gestione +
                              $costo_mio_gas +
                              $costo_maggiorazione +
                              $importo_totale),4);    
              
              
              $perc_anti = _GAS_COPERTURA_CASSA;
              $movimenti_anticipo = db_nr_q_3("id_utente",$id_ut,"id_ordine",$id_ordine,"tipo_movimento","11","retegas_cassa_utenti");
              if($movimenti_anticipo>0){
                $vis_anti = "<a class=\"awesome small yellow\" style=\"margin:1.5em\" href=\"".$RG_addr["cassa_movimenti_ord_ut_tipo"]."?id_ordine=".$id_ordine."&id_ut=".mimmo_encode($id_ut)."&id_tipo=11\">$movimenti_anticipo m.</a>";    
                $valore_anticipato = cassa_saldo_utente_inserito_ordine($id_ut,$id_ordine,11);
              }else{
                $vis_anti ='<input type="text" value="" size=3 DISABLED>';;            
                $valore_anticipato = 0;
              }
              
              
              
              $movimenti_cassa = db_nr_q_2("id_utente",$id_ut,"id_ordine",$id_ordine,"retegas_cassa_utenti");
              
              $movimenti_netto = db_nr_q_3("id_utente",$id_ut,"id_ordine",$id_ordine,"tipo_movimento",7,"retegas_cassa_utenti");
              $visualizza_checkbox = 0;
              if($movimenti_netto>0){
                $vis_netto ='<input type="hidden" value="0" name="box_netto[]"  size=4>
                             <a class="awesome small yellow" style="margin:1.5em" href="'.$RG_addr["cassa_movimenti_ord_ut_tipo"].'?id_ordine='.$id_ordine.'&id_ut='.mimmo_encode($id_ut).'&id_tipo=7">'.$movimenti_netto.' m.</a>';    
              }else{
                $vis_netto ='<input type="text" value="'.$importo_totale.'" name="box_netto[]" size=3>';            
                $visualizza_checkbox ++;
              }
              
              $movimenti_trasporto = db_nr_q_3("id_utente",$id_ut,"id_ordine",$id_ordine,"tipo_movimento",8,"retegas_cassa_utenti");
              if($movimenti_trasporto>0){
                $vis_trasp = "<input type=\"hidden\" value=\"$costo_trasporto\" name=\"box_trasporto[]\" size=3>
                              <a class=\"awesome small yellow\" style=\"margin:1.5em\" href=\"".$RG_addr["cassa_movimenti_ord_ut_tipo"]."?id_ordine=".$id_ordine."&id_ut=".mimmo_encode($id_ut)."&id_tipo=8\">$movimenti_trasporto m.</a>";    
              }else{
                $vis_trasp ='<input type="text" value="'.$costo_trasporto.'" name="box_trasporto[]" size=3>';            
                $visualizza_checkbox ++;
              }
              
              $movimenti_gestione = db_nr_q_3("id_utente",$id_ut,"id_ordine",$id_ordine,"tipo_movimento",9,"retegas_cassa_utenti");
              if($movimenti_gestione>0){
                $vis_gest = "<input type=\"hidden\" value=\"0\" name=\"box_gestione[]\" size=3>
                              <a class=\"awesome small yellow\" style=\"margin:1.5em\" href=\"".$RG_addr["cassa_movimenti_ord_ut_tipo"]."?id_ordine=".$id_ordine."&id_ut=".mimmo_encode($id_ut)."&id_tipo=9\">$movimenti_gestione m.</a>";    
              }else{
                $vis_gest ='<input type="text" value="'.$costo_gestione.'" name="box_gestione[]" size=3>';            
                $visualizza_checkbox ++;
              }              
 
              $movimenti_fingas = db_nr_q_3("id_utente",$id_ut,"id_ordine",$id_ordine,"tipo_movimento",10,"retegas_cassa_utenti");
              if($movimenti_fingas>0){
                $vis_gas = "<input type=\"hidden\" value=\"0\" name=\"box_costi_gas[]\" size=3>
                              <a class=\"awesome small yellow\" style=\"margin:1.5em\" href=\"".$RG_addr["cassa_movimenti_ord_ut_tipo"]."?id_ordine=".$id_ordine."&id_utente=".mimmo_encode($id_ut)."&id_tipo=10\">$movimenti_fingas m.</a>";    
              }else{
                $vis_gas ='<input type="text" value="'.$tot_costi_gas.'" name="box_costi_gas[]" size=3>';            
                $visualizza_checkbox ++;
              }             
              
              if($visualizza_checkbox>0){
                  $mov_cas =    '<input type="hidden" name="box_reg[]" value='.$id_ut.'>
                                <input type="hidden" name="box_id_ut[]" value='.$id_ut.'>';
                                    
              }else{
                  $mov_cas =   "<input type=\"hidden\" name=\"box_id_ut[]\" value=$id_ut>
                                <input type=\"hidden\" name=\"box_reg[]\" value=\"no\">"; 
                                    
              }
              if($visualizza_checkbox==4){
                $gia_reg =   "";
              }else{
                $gia_reg =  "<a class=\"awesome small green\" href=\"".$RG_addr["cassa_movimenti_ord_ut"]."?id_ordine=$id_ordine&id_ut=".mimmo_encode($id_ut)."\">Vis</a>";  
              }            
              
              
              $importo_totale = _nf($importo_totale);
              $totale_lordo = _nf($totale_lordo);
              $costo_al_fornitore = _nf($costo_al_fornitore);
              $costo_trasporto = _nf($costo_trasporto);
              $costo_gestione = _nf($costo_gestione);
              $costo_maggiorazione = _nf($costo_maggiorazione);
              $costo_mio_gas = _nf($costo_mio_gas);
              $tot_costi_gas = _nf($tot_costi_gas);
              $somma_articoli = _nf($somma_articoli);
              $valore_amticipato = _nf($valore_anticipato);
              
              
              if(read_option_text($row["userid"],"_USER_USA_CASSA")=="SI"){
              
              $h.= "<tr>";
  
                $h.= "<td $col_1>
                                <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">Da ordine</span></div>
                                <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">Già inserito</span></div>
                                $nome_ut</td>"; 
                $h.= "<td $col_5 style=\"vertical-align:top;\">
                                <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">$perc_anti % del netto</span></div>
                                <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">$valore_anticipato</span></div>
                                $vis_anti</td>";
                $h.= "<td $col_5><div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">$importo_totale</span></div>
                                 <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">".cassa_saldo_utente_inserito_ordine($id_ut,$id_ordine,7)."</span></div>
                                 $vis_netto</td>";
                $h.= "<td $col_5><div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">$costo_trasporto</span></div>
                                 <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">".cassa_saldo_utente_inserito_ordine($id_ut,$id_ordine,8)."</span></div>
                                 $vis_trasp</td>";
                
                $h.= "<td $col_5><div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">$costo_gestione</span></div>                                 
                                 <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">".cassa_saldo_utente_inserito_ordine($id_ut,$id_ordine,9)."</span></div>
                                 $vis_gest</td>";
                $h.= "<td $col_5>$costo_mio_gas</td>";
                $h.= "<td $col_5>$costo_maggiorazione</td>";
                $h.= "<td $col_5><div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">$tot_costi_ga</span></div>
                                 <div style=\"height:1.5em; padding:0; margin:0; border:0; text_align:center\"><span class=\"small_link\">".cassa_saldo_utente_inserito_ordine($id_ut,$id_ordine,10)."</span></div>
                                 $vis_gas</td>";
                $h.= "<td $col_5>$movimenti_cassa</td>";
                $h.= "<td $col_5>$gia_reg</td>";
                $h.= "<td $col_5>$mov_cas</td>";
              $h .="</tr>";
              }
         }//end while


         $totalone_articoli = _nf($totalone_articoli);
         $totalone = _nf($totalone);
         
         $h.= "</tbody>
               <tfoot>
                <tr>
                    <th><input type=\"submit\" value=\"Salva valori\"></th>
                    <th>&nbsp;</th>
                    <th>$totalone</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th></th>
                </tr>
               </tfoot>
               </table>
               <input type=\"hidden\" name=\"id_ordine\" value=$id_ordine>
               <input type=\"hidden\" name=\"do\" value=\"save\">
               </form>
               <h4><div class=\"ui-state-error ui-corner-all padding_6px\">ATTENZIONE : Salvando i nuovi valori, verranno eliminati automaticamente tutti gli \"ANTICIPI PER COPERTURA\" riferiti ad ogni utente del tuo GAS.</div></h4>
";

  return $h;

  }

//FUNZIONI DI UPDATE MASSIVO  
function cassa_update_ordine_utente($id,$id_user,$id_cassiere = 0){
    global $db;
    
   //SETTO ALTRE VARIABILI
   $gas = id_gas_user($id_user);
   $idd = ditta_id_from_listino(listino_ordine_from_id_ordine($id));
   $vo  = valore_totale_mio_ordine($id,$id_user); 
    
   //AGGIORNAMENTO CASSA
   
   //CANCELLO TUTTA LA CASSA PER USER
   // 7 = pagamento netto
   $quanti_cancellati = cassa_delete_user_ordine($id,$id_user,7);
   // 11 = anticipo per copertura
   $quanti_cancellati = cassa_delete_user_ordine($id,$id_user,11);
   //INSERISCO NUOVO IMPORTO TOTALE RIFERITO SOLO AL NETTO
   if($vo>0){
   $ris = db_insert_cassa_utenti($id_user,
                                $id,
                                $id_cassiere,
                                $gas,
                                $idd,
                                $vo,
                                "-",
                                7,
                                1,
                                "Pagamento netto al fornitore",
                                "",
                                "",
                                "no",
                                "no");
   $perc = ($vo / 100)* (_GAS_COPERTURA_CASSA);                             
   $ris = db_insert_cassa_utenti($id_user,
                                $id,
                                $id_cassiere,
                                $gas,
                                $idd,
                                $perc,
                                "-",
                                11,
                                1,
                                "Copertura eventuali spese",
                                "",
                                "",
                                "no",
                                "no");                             
   }
   //AGGIORNAMENTO CASSA
    
    
}  
function cassa_update_ordine_totale($id_ordine,$reg="no"){
   
   global $db; 
    
   if($reg<>"no"){$reg = "si";}else{$reg ="no";}
   
   //NON EFFETTUO CONTROLLI DI PERMESSI ECC
   //SONO GESTITI PRIMA
   // QUANDO UN ORDINE SI CONVALIDA
   
   //TROVO REFERENTE :
   $id_referente = id_referente_ordine_globale($id_ordine);
   $nome_referente = fullname_from_id($id_referente);
   $id_gas_referente = id_gas_user($id_referente);
   
   $id_ditta = ditta_id_from_listino(listino_ordine_from_id_ordine($id_ordine));
   $nome_ditta = ditta_nome($id_ditta);
   
$log .=<<<LLL
   Registra i movimenti : $reg<br>
   Ordine = $id_ordine<br> 
   Referente ordine = $id_referente  $nome_referente<br>
   id gas referente = $id_gas_referente<br>
   ------------------<br>
LLL;
   
   //CANCELLO TUTTI I MOVIMENTI RIFERITI DELL'ORDINE
   
   
   $query_del = "DELETE FROM retegas_cassa_utenti WHERE id_ordine='$id_ordine';";                                         
   $result_del = $db->sql_query($query_del);
   $nrows_deleted = $db->sql_affectedrows($result_del);

$log .=<<<LLL
   Query delete = $query_del<br>
   cancellati  = $nrows_deleted<br>
   ditta = $id_ditta $nome_ditta<br>
LLL;
      
   //PASSO LA LISTA DEI PARTECIPANTI ALL'ORDINE
   //ANCHE DI ALTRI GAS
          $q_ord = "SELECT
                    Sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) as importo_utente,
                    Sum(retegas_dettaglio_ordini.qta_arr) as somma_articoli,
                    Count(retegas_dettaglio_ordini.id_articoli) as conto_articoli,
                    maaking_users.fullname,
                    maaking_users.userid,
                    retegas_gas.id_gas,
                    retegas_gas.descrizione_gas
                    FROM
                    retegas_dettaglio_ordini
                    Inner Join maaking_users ON retegas_dettaglio_ordini.id_utenti = maaking_users.userid
                    Inner Join retegas_articoli ON retegas_dettaglio_ordini.id_articoli = retegas_articoli.id_articoli
                    Inner Join retegas_gas ON maaking_users.id_gas = retegas_gas.id_gas
                    WHERE
                    retegas_dettaglio_ordini.id_ordine =  '$id_ordine'
                    GROUP BY
                    retegas_dettaglio_ordini.id_utenti;";
          
          $result = $db->sql_query($q_ord);

       $log .= "Query ordine = <p>$q_ord</p>";
       
       $riga=0;  
         while ($row = $db->sql_fetchrow($result)){
         
              $riga++;

              $id_utente = $row["userid"];
              $nome_utente = $row['fullname'];
              $gas_descrizione = $row['descrizione_gas'];
              $id_gas_utente = $row['id_gas'];
              $conto_articoli = $row['conto_articoli'];
              $somma_articoli = $row['somma_articoli'];
              $importo_utente = $row["importo_utente"];
              
              $costo_trasporto = round(valore_costo_trasporto_ordine_user($id_ordine,$id_utente),4);
              $costo_gestione = round(valore_costo_gestione_ordine_user($id_ordine,$id_utente),4);
              $costo_mio_gas = round(valore_costo_mio_gas($id_ordine,$id_utente),4);
              $costo_maggiorazione =round(valore_costo_maggiorazione_mio_gas($id_ordine,$id_utente),4);
              $costo_al_fornitore = round(($importo_totale + $costo_trasporto),4); 
              $tot_costi_gas= round(($costo_mio_gas+$costo_maggiorazione),4);

              //SE IL GAS E' DIVERSO DA QUELLO DEL REFERENTE I MOVIMENTI SONO TUTTI DA REGISTRARE
              if($id_gas_utente<>$id_gas_referente){
                   $registrato = "no";
              }else{
                   $registrato = $reg;
              }
              //Controllo cassa su utente taget
              $utente_usa_cassa = read_option_text($id_utente,"_USER_USA_CASSA");
              
              
              
              
         $log .=<<<LLL
Utente : $id_utente $nome_utente, $gas_descrizione ($id_gas_utente)<br>
Utente usa cassa : $utente_usa_cassa<br>
Registrato = $registrato<br>
Importo : $importo_utente<br>
trasporto : $costo_trasporto<br>
gestione : $costo_gestione<br>
COSTO GAS ($gas_descrizione): $costo_mio_gas<br>
maggiorazione GAS ($gas_descrizione): $costo_maggiorazione<br>
TOT COSTI GAS ($gas_descrizione = $tot_costi_gas) 
LLL;
               //PER OGNI UTENTE
               //SE USA LA CASSA
              
               if($utente_usa_cassa=="SI"){
              
               //SCALO IL NETTO
               //SCARICA DAL CREDITO UTENTE  COME "PAGAMENTO AL FORNITORE"
                  if (db_insert_cassa_utenti($id_utente,
                                            $id_ordine,
                                            _USER_ID,
                                            $id_gas_utente,
                                            $id_ditta,
                                            $importo_utente,
                                            "-",
                                            movimento::scarico_per_pagamento_netto,
                                            1,
                                            "Pagamento fornitore",
                                            "",
                                            "",
                                            $registrato,
                                            "no")){
                    $ok++;
                 }else{
                    $err_db++;                               
                 }
               //SCALO SPESE TRASPORTO
               if (db_insert_cassa_utenti($id_utente,
                                            $id_ordine,
                                            _USER_ID,
                                            $id_gas_utente,
                                            $id_ditta,
                                            $costo_trasporto,
                                            "-",
                                            movimento::scarico_per_pagamento_trasporto,
                                            1,
                                            "Pagamento fornitore (Trasporto)",
                                            "",
                                            "",
                                            $registrato,
                                            "no")){
                    $ok++;
                 }else{
                    $err_db++;                               
                 }
               //SCALO GESTIONE
               if (db_insert_cassa_utenti($id_utente,
                                            $id_ordine,
                                            _USER_ID,
                                            $id_gas_utente,
                                            $id_ditta,
                                            $costo_gestione,
                                            "-",
                                            movimento::scarico_per_pagamento_gestione,
                                            1,
                                            "Pagamento Gestore ($nome_referente)",
                                            "",
                                            "",
                                            $registrato,
                                            "no")){
                    $ok++;
                 }else{
                    $err_db++;                               
                 }
               
               //CARICO GESTIONE SU REFERENTE
               //IL MOVIMENTO VIENE CARICATO CON IL GAS DEL DESTINATARIO
               //ANCHE SE E' DIVERSO DAL PROPRIO
               
               if (db_insert_cassa_utenti($id_referente,
                                            $id_ordine,
                                            _USER_ID,
                                            $id_gas_referente,
                                            $id_ditta,
                                            $costo_gestione,
                                            "+",
                                            movimento::carico_credito,
                                            1,
                                            "Carico per gestione da utente ($nome_referente)",
                                            "",
                                            "",
                                            $registrato,
                                            "no")){
                    $ok++;
               }else{
                    $err_db++;                               
               }
               
               
               //SCARICO SUO COSTO GAS
               if (db_insert_cassa_utenti($id_utente,
                                            $id_ordine,
                                            _USER_ID,
                                            $id_gas_utente,
                                            $id_ditta,
                                            $tot_costi_gas,
                                            "-",
                                            movimento::finanziamento_gas,
                                            1,
                                            "Finanziamento GAS (Fisso $costo_mio_gas + Magg. $costo_maggiorazione)",
                                            "",
                                            "",
                                            $registrato,
                                            "no")){
                    $ok++;
                 }else{
                    $err_db++;                               
                 }
                 
                 $log .= "-------------->>> OK = $ok, errDB = $err_db<br>";
   
               }else{//NON USA LA CASSA
                  $log .= "NON USA LA CASSA >>> SALTATO<br>"; 
               }
         }//PASSAGGIO LISTA UTENTI PARTECIPANTI
   
         $log .= "FINE  >>><br>";
   
         log_me($id_ordine,_USER_ID,"CAS","CON","Scarico automatico",$ok,$log);

         if ($err_db==0){
             return "OK";
         }else{
             return "$err_db ERRORI DB";
         }
    
}  