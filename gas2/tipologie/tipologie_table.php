<?php
   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
     pussa_via(); 
}    


//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del men� verticale dovr� essere aperta
$r->voce_mv_attiva = menu_lat::anagrafiche;
//Assegno il titolo che compare nella barra delle info
$r->title = "Tipologie merceologiche";


//Messaggio popup;
//$r->messaggio = "Pagina di test"; 
//Dico quale men� orizzontale dovr� essere associato alla pagina.
$r->menu_orizzontale = null;

//Assegno le due tabelle a tablesorter
$r->javascripts[]=java_tablesorter("output_1");


$r->messaggio = $msg;
//Creo la pagina dell'aggiunta


$query = "SELECT * FROM retegas_tipologia ORDER BY id_tipologia DESC";
$res = $db->sql_query($query);

$h .= "<div class=\"rg_widget rg_widget_helper\">";
$h .= "<h3>Tipologie merceologiche</h3>";
$h .= "<table id=\"output_1\">";
$h .= "<thead>";
    $h .="<tr>";
    $h .="<th>ID</td>";
    $h .="<th>Genere</td>";
    $h .="<th>Listini</td>";
    $h .="<th>Ordini Chiusi</td>";
    $h .="<th>Ordini Aperti</td>";
    $h .="</tr>";
$h .= "</thead>";
$h .= "<tbody>";
while ($row = mysql_fetch_array($res)){
    
    $c1 = $row["id_tipologia"];
    $c2 = $row["descrizione_tipologia"];
    $c3 = quanti_listini_per_questa_tipologia($c1);
    $c4 = quanti_ordini_chiusi_per_questa_tipologia($c1);
    $c5 = quanti_ordini_aperti_per_questa_tipologia($c1);
    
    $h .="<tr>";
    $h .="<td>$c1</td>";
    $h .="<td>$c2</td>";
    $h .="<td>$c3</td>";
    $h .="<td>$c4</td>";
    $h .="<td>$c5</td>";
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