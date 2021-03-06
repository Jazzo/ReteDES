<?php
   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
     pussa_via(); 
}    

//controlla se l'utente ha i permessi necessari
if(!(_USER_PERMISSIONS & perm::puo_vedere_retegas)){
     //pussa_via();
}

//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del menù verticale dovrà essere aperta
$r->voce_mv_attiva = menu_lat::des;
//Assegno il titolo che compare nella barra delle info
$r->title = "Confronto Dimensioni GAS";
//Assegno anche la libreria HighCharts
$r->javascripts_header[]=java_head_highcharts();
//Messaggio popup;
//$r->messaggio = "Pagina di test"; 
//Dico quale menù orizzontale dovrà essere associato alla pagina.
$r->menu_orizzontale = des_menu_completo(_USER_ID);


//Calcolo i valori del grafico
$sql2 = "SELECT
            Count(maaking_users.userid) AS user_totali,
            retegas_gas.descrizione_gas,
            retegas_gas.id_gas
            FROM
            retegas_gas
            Inner Join maaking_users ON maaking_users.id_gas = retegas_gas.id_gas
            WHERE isactive='1'
            AND
            id_des ="._USER_ID_DES."
            GROUP BY
            retegas_gas.id_gas,
            retegas_gas.descrizione_gas";
      $res2 = $db->sql_query($sql2);
      
      
      while ($row = mysql_fetch_array($res2)){

            $gas_names .= "'".$row["descrizione_gas"]."',";

            $user_ordinanti =(int)$row["user_totali"];             
            $ut_gest .= $user_ordinanti.",";
            $ut_altri .= (int)amici_quanti_per_gas($row["id_gas"]).",";
            $ut_sospesi .= (int)numero_tipo_utenti_gas($row["id_gas"],2).",";
            $ut_eliminati .= (int)numero_tipo_utenti_gas($row["id_gas"],3).","; 
            $ut_attesa .= (int)numero_tipo_utenti_gas($row["id_gas"],0).",";
      }
      $gas_names = rtrim($gas_names,",");
      $ut_gest = rtrim($ut_gest,",");
      $ut_altri = rtrim($ut_altri,",");
      $ut_sospesi = rtrim($ut_sospesi,",");
      $ut_eliminati = rtrim($ut_eliminati,",");
      $ut_attesa = rtrim($ut_attesa,",");
      
      $serie = '{name : \'Utenti\',
                    data:['.$ut_gest.']},
                {name : \'Amici\',
                    data:['.$ut_altri.']},
                {name : \'Sospesi\',
                    data:['.$ut_sospesi.']},
                {name : \'Eliminati\',
                    data:['.$ut_eliminati.']},
                {name : \'In attesa\',
                    data:['.$ut_attesa.']}';


//Disegno il grafico
$r->javascripts[]="
          <script type=\"text/javascript\"> 
                          var chart;
                $(document).ready(function() {
                   chart = new Highcharts.Chart({
                      chart: {
                         renderTo: 'container_chart',
                         defaultSeriesType: 'column',
                         zoomType: 'x,y'
                      },
                      title: {
                         text: 'Dimensione dei GAS'
                      },
                      xAxis: {
                         categories: [$gas_names]
                      },
                      yAxis: {
                         min: 0,
                         title: {
                            text: 'Composizione Gas'
                         }
                      },
                      tooltip: {
                         formatter: function() {
                            return ''+
                                this.series.name +': '+ this.y +' ('+ Math.round(this.percentage) +'%)';
                         }
                      },
                      plotOptions: {
                         column: {
                            stacking: 'normal'
                         }
                      },
                           series: [$serie]
                   });
                   
                   
                });
          </script> 
      ";



//Questo è il contenuto della pagina
$r->contenuto = '<div style="position:relative; width: 100%; display:table;">
                             <div id="container_chart" style="width: 100%; height: 30em;   display:table-cell"></div>
                             </div>';
//Mando all'utente la sua pagina
echo $r->create_retegas();
//Distruggo l'oggetto r    
unset($r)   
?>