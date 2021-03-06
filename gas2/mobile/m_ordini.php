<?php   $_FUNCTION_LOADER=array("mobile",
                                "ordini",
                                "ordini_valori",
                                "gas");

include_once ("../rend.php");
include_once ("../jqm.class.php");


//Controllo su login
if(!_USER_LOGGED_IN){   
    go("sommario_mobile");       
}



//----------------------------------CONTENUTO PAG 1
$l = new jqm_list();
$l->jqm_list_attrib[] = "data-inset=\"true\" ";
$my_query="SELECT retegas_ordini.id_ordini, 
            retegas_ordini.descrizione_ordini, 
            retegas_listini.descrizione_listini, 
            retegas_ditte.descrizione_ditte, 
            retegas_ordini.data_chiusura, 
            retegas_gas.descrizione_gas, 
            retegas_referenze.id_gas_referenze, 
            maaking_users.userid, 
            maaking_users.fullname,
            retegas_ordini.id_utente,
            retegas_ordini.id_listini,
            retegas_ditte.id_ditte,
            retegas_ordini.data_apertura
            FROM (((((retegas_ordini INNER JOIN retegas_referenze ON retegas_ordini.id_ordini = retegas_referenze.id_ordine_referenze) LEFT JOIN maaking_users ON retegas_referenze.id_utente_referenze = maaking_users.userid) INNER JOIN retegas_listini ON retegas_ordini.id_listini = retegas_listini.id_listini) INNER JOIN retegas_ditte ON retegas_listini.id_ditte = retegas_ditte.id_ditte) INNER JOIN maaking_users AS maaking_users_1 ON retegas_ordini.id_utente = maaking_users_1.userid) INNER JOIN retegas_gas ON maaking_users_1.id_gas = retegas_gas.id_gas
            WHERE (((retegas_ordini.data_chiusura)>NOW()) AND ((retegas_ordini.data_apertura)<NOW()) AND ((retegas_referenze.id_gas_referenze)="._USER_ID_GAS."))
            ORDER BY retegas_ordini.data_chiusura ASC ;";
$result = $db->sql_query($my_query);
$riga=0;
while ($row = mysql_fetch_array($result)){
         $riga++;
         
         //TEMPO ALLA CHIUSURA
         $inittime=time();
         $datexmas=strtotime($row["data_chiusura"]);
         $timediff = $datexmas - $inittime;
         $days=intval($timediff/86400);
         $remaining=$timediff%86400;
             
         $hours=intval($remaining/3600);
         $remaining=$remaining%3600;
             
         $mins=intval($remaining/60);
         $secs=$remaining%60;
         
            if ($days<2){
                $color = "style=\"color:red\"";
            }else{
                unset($color);
            }
         
            
         if(id_referente_ordine_proprio_gas($row["id_ordini"],_USER_ID_GAS)>0){
             $pal = '<IMG SRC="'.$RG_addr["icn_pallino_verde"].'" class="ui-li-icon">';
         }else{
             $pal = '<IMG SRC="'.$RG_addr["icn_pallino_marrone"].'" class="ui-li-icon">'; 
         }
         
        $l->jqm_list_items[].=  '<li>                                 
                                 <a href="'.$RG_addr["m_ordini_scheda"].'?id_ordine='.$row["id_ordini"].'" rel="external">
                                 '.$pal.'
                                 <h5>'.$row["descrizione_ordini"].'</h5>
                                 <p> di '.fullname_from_id($row["id_utente"]).' ('.gas_nome(id_gas_user($row["id_utente"])).')</p>  
                                 <p  '.$color.'>Chiude tra '.$days.' gg e '.$hours.' h.</p>
                                 </a>
                                 </li>
                                ';
         }//end while

        $c_pag_1 = $l->jqm_list_render();
        unset($l); 


//----------------------------------FINE CONTENUTO PAG 1

//----------------------------------CONT$ENUTO PAG 2
$l = new jqm_list();
$l->jqm_list_attrib = array("data-inset=\"true\"", 
                            "data-filter=\"true\" ");

        
$my_query = "SELECT retegas_ordini.id_ordini, 
            retegas_ordini.descrizione_ordini, 
            retegas_listini.descrizione_listini, 
            retegas_ditte.descrizione_ditte, 
            retegas_ordini.data_chiusura, 
            retegas_gas.descrizione_gas, 
            retegas_referenze.id_gas_referenze, 
            maaking_users.userid, 
            maaking_users.fullname,
            retegas_ordini.id_utente,
            retegas_ordini.id_listini,
            retegas_ditte.id_ditte,
            retegas_ordini.data_apertura
            FROM (((((retegas_ordini INNER JOIN retegas_referenze ON retegas_ordini.id_ordini = retegas_referenze.id_ordine_referenze) LEFT JOIN maaking_users ON retegas_referenze.id_utente_referenze = maaking_users.userid) INNER JOIN retegas_listini ON retegas_ordini.id_listini = retegas_listini.id_listini) INNER JOIN retegas_ditte ON retegas_listini.id_ditte = retegas_ditte.id_ditte) INNER JOIN maaking_users AS maaking_users_1 ON retegas_ordini.id_utente = maaking_users_1.userid) INNER JOIN retegas_gas ON maaking_users_1.id_gas = retegas_gas.id_gas
            WHERE (((retegas_ordini.data_chiusura)<NOW()) AND ((retegas_referenze.id_gas_referenze)="._USER_ID_GAS."))
            ORDER BY retegas_ordini.data_chiusura DESC
            LIMIT 100 ;";
      
      //echo $my_query;
      
      // COSTRUZIONE TABELLA  -----------------------------------------------------------------------
      global $db;
      global $RG_addr;
      
      $result = $db->sql_query($my_query);
        

  
        $riga=0;

          
         while ($row = mysql_fetch_array($result)){
         $riga++;
         if(is_printable_from_id_ord($row["id_ordini"])){
             $pal = '<IMG SRC="'.$RG_addr["icn_pallino_grigio"].'" class="ui-li-icon">';
         }else{
             $pal = '<IMG SRC="'.$RG_addr["icn_pallino_rosso"].'" class="ui-li-icon">'; 
         }    

         
        $l->jqm_list_items[]=  '<li>
                                    <a href="'.$RG_addr["m_ordini_scheda"].'?id_ordine='.$row["id_ordini"].'">
                                        '.$pal.'
                                        <h5>'.$row["descrizione_ordini"].'</h5>
                                        <p>di '.fullname_from_id($row["id_utente"]).' ('.gas_nome(id_gas_user($row["id_utente"])).')</p>
                                        <p>Tot. <strong>'.round(valore_totale_ordine($row["id_ordini"]),2) .' Eu.</strong> chiuso il '.conv_date_from_db($row["data_chiusura"]).'</p>
                                    </a>
                                </li>';
         }//end while
         
         $c_pag_2 = $l->jqm_list_render();
        unset($l);


//---------------------------------------------------------------------FINE CONTENUTO PAG 2       

//---------------------------------------------------------------------CONTENUTO PAG 3

$l = new jqm_list();
$l->jqm_list_attrib[] = "data-inset=\"true\"";      
$my_query="SELECT retegas_ordini.id_ordini, 
            retegas_ordini.descrizione_ordini, 
            retegas_listini.descrizione_listini, 
            retegas_ditte.descrizione_ditte, 
            retegas_ordini.data_chiusura, 
            retegas_gas.descrizione_gas, 
            retegas_referenze.id_gas_referenze, 
            maaking_users.userid, 
            maaking_users.fullname,
            retegas_ordini.id_utente,
            retegas_ordini.id_listini,
            retegas_ditte.id_ditte,
            retegas_ordini.data_apertura
            FROM (((((retegas_ordini INNER JOIN retegas_referenze ON retegas_ordini.id_ordini = retegas_referenze.id_ordine_referenze) LEFT JOIN maaking_users ON retegas_referenze.id_utente_referenze = maaking_users.userid) INNER JOIN retegas_listini ON retegas_ordini.id_listini = retegas_listini.id_listini) INNER JOIN retegas_ditte ON retegas_listini.id_ditte = retegas_ditte.id_ditte) INNER JOIN maaking_users AS maaking_users_1 ON retegas_ordini.id_utente = maaking_users_1.userid) INNER JOIN retegas_gas ON maaking_users_1.id_gas = retegas_gas.id_gas
            WHERE (((retegas_ordini.data_apertura)>NOW()) AND ((retegas_referenze.id_gas_referenze)="._USER_ID_GAS."))
            ORDER BY retegas_ordini.data_chiusura ASC ;";
      
      //echo $my_query;
      
      // COSTRUZIONE TABELLA  -----------------------------------------------------------------------
      global $db;
      global $RG_addr;
      $result = $db->sql_query($my_query);
        

  
        $riga=0;
         
        
          
         while ($row = mysql_fetch_array($result)){
         $riga++;
        
        $data_adesso = time();
        $data_apertura = gas_mktime(conv_datetime_from_db($row["data_apertura"]));
        $date_diff = $data_apertura - $data_adesso;
        $giorni_all_apertura = floor($date_diff/(60*60*24));
        
            
        $pal = '<IMG SRC="'.$RG_addr["icn_pallino_blu"].'" class="ui-li-icon">';
        
         
        $l->jqm_list_items[]= '<li>
        <a href="'.$RG_addr["m_ordini_scheda"].'?id_ordine='.$row["id_ordini"].'">
        '.$pal.'
        <h5>'.$row["descrizione_ordini"].'</h5>
        <p>di '.fullname_from_id($row["id_utente"]).'
        <span style="color:#808080">(apre tra '.$giorni_all_apertura.' giorni, il '.conv_only_date_from_db($row["data_apertura"]).')</span>
        </p>
        </a>
        </li>
        ';
         }//end while
         
         
       
       $c_pag_3 = $l->jqm_list_render();
        unset($l);


//---------------------------------------------------------------------FINE P 3       

//---------------------------------------------------------------------CONTENUTO PAGINA 4
$limit=30;


$l = new jqm_list();
$l->jqm_list_attrib = array("data-inset=\"true\"", 
                            "data-filter=\"true\" ");

      
$my_query = "SELECT retegas_ordini.id_ordini, 
            retegas_ordini.descrizione_ordini, 
            retegas_listini.descrizione_listini, 
            retegas_ditte.descrizione_ditte, 
            retegas_ordini.data_chiusura, 
            retegas_gas.descrizione_gas, 
            retegas_referenze.id_gas_referenze, 
            maaking_users.userid, 
            maaking_users.fullname,
            retegas_ordini.id_utente,
            retegas_ordini.id_listini,
            retegas_ditte.id_ditte,
            retegas_ordini.data_apertura
            FROM (((((retegas_ordini INNER JOIN retegas_referenze ON retegas_ordini.id_ordini = retegas_referenze.id_ordine_referenze) LEFT JOIN maaking_users ON retegas_referenze.id_utente_referenze = maaking_users.userid) INNER JOIN retegas_listini ON retegas_ordini.id_listini = retegas_listini.id_listini) INNER JOIN retegas_ditte ON retegas_listini.id_ditte = retegas_ditte.id_ditte) INNER JOIN maaking_users AS maaking_users_1 ON retegas_ordini.id_utente = maaking_users_1.userid) INNER JOIN retegas_gas ON maaking_users_1.id_gas = retegas_gas.id_gas
            WHERE ((retegas_referenze.id_gas_referenze)="._USER_ID_GAS.")
            ORDER BY retegas_ordini.data_apertura DESC;";
      
      //echo $my_query;
      
      // COSTRUZIONE TABELLA  -----------------------------------------------------------------------

      
      $result = $db->sql_query($my_query);
      $riga=0;

          
         while ($row = mysql_fetch_array($result)){

         $io_cosa_sono = ordine_io_cosa_sono($row["id_ordini"],_USER_ID);
         //echo "IO = $io_cosa_sono<br>";
         switch($io_cosa_sono){
             case 1:$io_sono = "";break;
             case 2:$io_sono = "Partecipo";$riga++;break;
             case 3:$io_sono = "Gestisco per il mio GAS";$riga++;break;
             case 4:$io_sono = "Gestisco l'ordine";$riga++;break;  
         }
         
 

        if(($io_cosa_sono>1) AND ($riga<($limit+1))){
         
         if(gas_mktime(conv_datetime_from_db($row["data_apertura"]))>gas_mktime(date("d/m/Y H:i"))){
                $pal = '<IMG SRC="'.$RG_addr["icn_pallino_blu"].'" class="ui-li-icon">';   
         }else{
                if(gas_mktime(conv_datetime_from_db($row["data_chiusura"]))>gas_mktime(date("d/m/Y H:i"))){
                      if(id_referente_ordine_proprio_gas($row["id_ordini"],_USER_ID_GAS)>0){ 
                            $pal = '<IMG SRC="'.$RG_addr["icn_pallino_verde"].'" class="ui-li-icon">';
                      }else{
                            $pal = '<IMG SRC="'.$RG_addr["icn_pallino_marrone"].'" class="ui-li-icon">'; 
                      }    
                }else{
                      if(is_printable_from_id_ord($row["id_ordini"])){
                             $pal = '<IMG SRC="'.$RG_addr["icn_pallino_grigio"].'" class="ui-li-icon">';
                      }else{
                             $pal = '<IMG SRC="'.$RG_addr["icn_pallino_rosso"].'" class="ui-li-icon">'; 
                      }
                    
                
                }
         }            
            
            
            
 $l->jqm_list_items[]=  '<li>
                             <a href="'.$RG_addr["m_ordini_scheda"].'?id_ordine='.$row["id_ordini"].'">
                             '.$pal.'
                             <h5>'.$row["descrizione_ordini"].'</h5>                             
                             <p>io '.$io_sono.'</p>                             
                             </a>             
                         </li>
                        ';
            }           
        }//end while
       $c_pag_4 = $l->jqm_list_render();
       unset($l);

//---------------------------------------------------------------------FINE CONTENUTO PAG 4
       
                
//Nuovo oggetto Jquery MObile
$j = new jqm(load_jqm_param());

//-------------------------------------------------------PAG 1                                
//Nuova pagina con relativi parametri
$p = new jqm_page(load_page_param());
//Negli attributi assegno un ID
$p->jqm_page_attrib="id=\"aperti\"";
$p->jqm_header_title = "ReteDes.it - Ordini";
$p->jqm_footer_hide= true;
//Assegno la navbar

$n = new jqm_navbar(load_ordini_navbar());
$n->jqm_navbar_set_item_attrib(0,"class=\"ui-btn-active ui-state-persist\"");

$p->jqm_header_navbar=$n->jqm_render_navbar();
//Assegno la sotto navbar
//$n_s = new jqm_navbar(load_ordini_navbar());
//$n_s->jqm_navbar_set_item_attrib(0,"class=\"ui-btn-active ui-state-persist\"");
//$p->jqm_header_navbar_sub=$n_s->jqm_render_navbar();
//Inserisco i contenuti
$p->jqm_page_content = "<h3>Ordini Aperti</h3>".$c_pag_1;
//Creo la pagina
$j->jqm_pages[]=$p->jqm_render_page();
unset($p);

//-------------------------------------------------------PAG 1

//-------------------------------------------------------PAG 2                                
//Nuova pagina con relativi parametri
$p = new jqm_page(load_page_param());
//Negli attributi assegno un ID
$p->jqm_header_title = "ReteGas.AP - Ordini";
$p->jqm_page_attrib="id=\"chiusi\"";
$p->jqm_footer_hide= true;
//Assegno la navbar

$n = new jqm_navbar(load_ordini_navbar());
$n->jqm_navbar_set_item_attrib(1,"class=\"ui-btn-active ui-state-persist\"");

$p->jqm_header_navbar=$n->jqm_render_navbar();
//Assegno la sotto navbar
//$n_s = new jqm_navbar(load_ordini_navbar());
//$n_s->jqm_navbar_set_item_attrib(1,"class=\"ui-btn-active ui-state-persist\"");
//$p->jqm_header_navbar_sub=$n_s->jqm_render_navbar();
//Inserisco i contenuti
$p->jqm_page_content ="<h3>Ordini chiusi</h3>".$c_pag_2;
//Creo la pagina
$j->jqm_pages[]=$p->jqm_render_page();
unset($p);
//-------------------------------------------------------PAG 2

//-------------------------------------------------------PAG 3                                
//Nuova pagina con relativi parametri
$p = new jqm_page(load_page_param());
//Negli attributi assegno un ID
$p->jqm_header_title = "ReteGas.AP - Ordini";
$p->jqm_page_attrib="id=\"futuri\"";
$p->jqm_footer_hide= true;
//Assegno la navbar

$n = new jqm_navbar(load_ordini_navbar());
$n->jqm_navbar_set_item_attrib(2,"class=\"ui-btn-active ui-state-persist\"");

$p->jqm_header_navbar=$n->jqm_render_navbar();

//Inserisco i contenuti
$p->jqm_page_content ="<h3>Ordini futuri</h3>".$c_pag_3;
//Creo la pagina
$j->jqm_pages[]=$p->jqm_render_page();
unset($p);
//-------------------------------------------------------PAG 3

//-------------------------------------------------------PAG 4                                
//Nuova pagina con relativi parametri
$p = new jqm_page(load_page_param());
//Negli attributi assegno un ID
$p->jqm_header_title = "ReteGas.AP - Ordini";
$p->jqm_page_attrib="id=\"miei\"";
$p->jqm_footer_hide= true;
//Assegno la navbar

$n = new jqm_navbar(load_ordini_navbar());
$n->jqm_navbar_set_item_attrib(3,"class=\"ui-btn-active ui-state-persist\"");

$p->jqm_header_navbar=$n->jqm_render_navbar();

//Inserisco i contenuti
$p->jqm_page_content ="<h3>Miei ordini</h3>".$c_pag_4;
//Creo la pagina
$j->jqm_pages[]=$p->jqm_render_page();
unset($p);
//-------------------------------------------------------PAG 4


//La visualizzo
echo $j->jqm_render();
unset($j);  
?>