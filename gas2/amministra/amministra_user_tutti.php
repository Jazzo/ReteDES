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



//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del men� verticale dovr� essere aperta
$r->voce_mv_attiva = menu_lat::user;
//Assegno il titolo che compare nella barra delle info
$r->title = "Temi usati";


//Messaggio popup;
//$r->messaggio = "Pagina di test"; 
//Dico quale men� orizzontale dovr� essere associato alla pagina.
$r->menu_orizzontale = amministra_menu_completo();

//Assegno le due tabelle a tablesorter
$r->javascripts[]='<script type="text/javascript">                
                        $(document).ready(function() 
                            {
                                $("#output_1").tablesorter({widgets: [\'zebra\',\'saveSort\',\'filter\'],
                                                        cancelSelection : true,
                                                        dateFormat : \'ddmmyyyy\',                                                               
                                                        }); 
                                } 
                            );
</script>';


if(_USER_HAVE_MSG){
    $r->messaggio = _USER_MSG;
    delete_option_text(_USER_ID,"MSG");
}
//Creo la pagina dell'aggiunta


$query = "SELECT * FROM maaking_users ORDER BY last_activity DESC;";
$res = $db->sql_query($query);

$h .= "<div class=\"rg_widget rg_widget_helper\">";
$h .= "<h3>Tutti gli utenti (in ordine di ultima attivit�)</h3>";
$h .= "<table id=\"output_1\">";
$h .= "<thead>";
    $h .="<tr>";
    $h .="<th>ID</th>";
    $h .="<th>Status</th>";
    $h .="<th>Nome & Mail</th>";
    $h .="<th>Gas</th>";
    $h .="<th >Reg Date</th>";
    $h .="<th >Last Login</th>";
    $h .="<th data-sorter=\"shortDate\">Last Activity</th>";
    $h .="<th>IP</th>";
    $h .="<th>OPT</th>";
    $h .="</tr>";
$h .= "</thead>";
$h .= "<tbody>";
while ($row = $db->sql_fetchrow($res)){
    
    $h .="<tr>";
    $h .="<td><a href=\"".$RG_addr["pag_users_form"]."?id_utente=".mimmo_encode($row["userid"])."\">".$row["userid"]."</a></td>";
    $h .="<td>".$row["isactive"]."</td>";    
    $h .="<td><a href=\"".$RG_addr["amministra_user_info"]."?id_utente=".mimmo_encode($row["userid"])."\">".($row["fullname"])."</a> - ".$row["email"]."</td>";
    $h .="<td>".gas_nome($row["id_gas"])."</td>";
    $h .="<td>".conv_datetime_from_db($row["regdate"])."</td>";
    $h .="<td>".conv_datetime_from_db($row["lastlogin"])."</td>";
    $h .="<td>".conv_datetime_from_db($row["last_activity"])."</td>";
    $h .="<td>".$row["ipaddress"]."</td>";
    $h .="<td>&nbsp</td>";
    //$h .="<td><a class=\"awesome option silver\" href=\"".$RG_addr["amministra_user_donate"]."?id_utente=".mimmo_encode($row["userid"])."&do=donate\">D</a></td>";
    //$h .="<td>".quante_assonanze($row["fullname"],75)."</td>";
    $h .="</tr>";
}
$h .="</tbody>";
$h .="</table>";
$h .="</div><br>";

//Questo � il contenuto della pagina
$r->contenuto = $h;

//Mando all'utente la sua pagina
echo $r->create_retegas();
//Distruggo l'oggetto r    
unset($r)   
?>