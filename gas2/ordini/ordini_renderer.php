<?php



    

    // ORDINE MODIFICA GENERICO 
    function ordine_render_modifica($id){
        // Ricevo le variabili globali
        global $o_descrizione,
        $o_data_apertura,
        $o_data_chiusura,
        $o_costo_trasporto,
        $o_costo_gestione,
        $o_note_ordine,
        $o_old_data_apertura,
        $o_old_data_chiusura;

        //titolo
        $titolo_tabella="Modifica l'ordine ID $id";


        //  LARGHEZZA E CLASSI COLONNE
        $col_1="width=\"20%\" style=\"text-align:right;\"";
        $col_2="width=\"*\" style=\"text-align:left;\""; 

        // OPZIONI
        //$o_data_apertura = conv_date_from_db($o_data_apertura);
        //$o_data_chiusura = conv_datetime_from_db($o_data_chiusura);

        // FORM -------------------------------------------

        $title_form = "<form name=\"Modifica ordine\" method=\"POST\" action=\"ordini_form_edit.php\">";
        $submit_form ="<input class=\"large green awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Salva le modifiche\">";  

        // Campi

        //descrizione
        $i_descrizione = "<input type=\"text\" name=\"o_descrizione\" size=\"28\" value=\"$o_descrizione\">"; //descrizione 
        $i_data_apertura = "<input type=\"text\" name=\"o_data_apertura\" size=\"28\" value=\"$o_data_apertura\" id=\"datetimepicker\">"; //descrizione 
        $i_data_chiusura = "<input type=\"text\" name=\"o_data_chiusura\" size=\"28\" value=\"$o_data_chiusura\" id=\"datetimepicker2\">"; //descrizione 
        $i_costo_trasporto = "<input type=\"text\" name=\"o_costo_trasporto\" size=\"28\" value=\"$o_costo_trasporto\">"; //descrizione 
        $i_costo_gestione = "<input type=\"text\" name=\"o_costo_gestione\" size=\"28\" value=\"$o_costo_gestione\">"; //descrizione 
        $i_note_ordine ='<textarea class="ckeditor" COLS="50"  name="o_note_ordine">'.$o_note_ordine.'</textarea>';
        $o_stato = stato_from_id_ord($id);


        $input_hidden =   "<input type=\"hidden\" name=\"do\"  value=\"mod\">";
        $input_hidden_2 = "<input type=\"hidden\" name=\"id\"  value=\"$id\">";
        $input_hidden_3 = "<input type=\"hidden\" name=\"o_old_data_apertura\"  value=\"$o_old_data_apertura\">";
        $input_hidden_4 = "<input type=\"hidden\" name=\"o_old_data_chiusura\"  value=\"$o_old_data_chiusura\">";
        //id_ditta
        // COSTRUZIONE TABELLA  -----------------------------------------------------------------------

        //$h_table .= ditte_menu_1();

        $h_table .= " <div class=\"ui-widget-header ui-corner-all padding_6px\"> 
        <div style=\"margin-bottom:16px;\"\">$titolo_tabella</div>
        $title_form
        <table>
        <thead>
        <tr class=\"odd\">
        <th $col_1>&nbsp</th>
        <td $col_2>Vecchi valori</td>
        <td $col_2>Modifiche</td>
        </tr>
        </thead>
        <tbody>
        <tr class=\"odd\">
        <th $col_1>Identificativo ordine</th>
        <td $col_2>&nbsp</td>
        <td $col_2>$id</td>
        </tr>
        <tr class=\"odd\">
        <th $col_1>Stato Attuale:</th>
        <td $col_2>&nbsp</td>
        <td $col_2>$o_stato</td>
        </tr>
        <tr class=\"odd\">
        <th $col_1>Descrizione</th>
        <td $col_2>&nbsp</td>
        <td $col_2>$i_descrizione</td>
        </tr>
        <tr class=\"odd\">
        <th $col_1>Data apertura</th>
        <td $col_2>$o_old_data_apertura</td>
        <td $col_2>$i_data_apertura</td>
        </tr>
        <tr class=\"odd\">
        <th $col_1>Data chiusura</th>
        <td $col_2>$o_old_data_chiusura</td>
        <td $col_2>$i_data_chiusura</td>
        </tr>
        <tr class=\"odd\">
        <th $col_1>Costo Gestione</th>
        <td $col_2>&nbsp</td>
        <td $col_2>$i_costo_gestione</td>
        </tr>
        <tr class=\"odd\">
        <th $col_1>Costo Trasporto</th>
        <td $col_2>&nbsp</td>
        <td $col_2>$i_costo_trasporto</td>
        </tr>
        <tr class=\"odd\">
        <th $col_1>Note ordine</th>
        <td $col_2 colspan=2>$i_note_ordine</td>
        </tr>
        <tbody>
        </table>
        $input_hidden $input_hidden_2
        $input_hidden_3 $input_hidden_4
        <center>
        $submit_form
        </center>
        </form>
        </div>";

        // END TABELLA         



        return $h_table;      


    }
    function ordine_check_data($id){
        global $o_descrizione,
        $o_data_apertura,
        $o_data_chiusura,
        $o_costo_trasporto,
        $o_costo_gestione,
        $o_note_ordine,
        $o_old_data_apertura,
        $o_old_data_chiusura;


        $msg ="";
        // VUOTI ------------------------------------------
        if(empty($o_descrizione) | $o_descrizione==""){
            $empty++;
            $msg .= "Descrizione mancante<br>";
        }
        if(empty($o_data_apertura) | $o_data_apertura==""){
            $empty++;
            $msg .= "Data apertura mancante<br>";
        }
        if(empty($o_data_chiusura) | $o_data_chiusura==""){
            $empty++;
            $msg .= "Data chiusura mancante<br>";
        }

        // MANCANTI -------------------------------------------             
        if(empty($o_costo_gestione) | $o_costo_gestione==""){
            $o_costo_gestione = 0;
        }
        if(empty($o_costo_trasporto) | $o_costo_trasporto==""){
            $o_costo_trasporto = 0;
        }

        // NON NUMERICI -------------------------------------------             
        if(!is_numeric($o_costo_gestione)){
            $o_costo_gestione = 0;
        }
        if(!is_numeric($o_costo_trasporto)){
            $o_costo_trasporto = 0;
        }

        // NEGATIVI -------------------------------------------             
        if($o_costo_gestione<0){
            $o_costo_gestione = 0;
        }
        if($o_costo_trasporto<0){
            $o_costo_trasporto = 0;
        }


        //NON DATA VALIDA -------------------------------------
        if(!controllodataora($o_data_apertura)){
            $data_valida++;
            $msg .= "Data apertura non valida<br>"; 
        }
        if(!controllodataora($o_data_chiusura)){
            $data_valida++;
            $msg .= "Data chiusura non valida<br>"; 
        }

        //DATA IMPOSSIBILE -------------------------------------

        if (gas_mktime($o_data_chiusura)<gas_mktime($o_data_apertura)){
            $msg .="Data di chiusura antecedente quella di apertura<br>";
            $data_valida++; 
        }

        if($o_data_apertura<>$o_old_data_apertura){
            if (gas_mktime($o_data_apertura)<=gas_mktime(date("d/m/Y H:i"))){
                if(stato_from_id_ord($id)==2){ 
                    $msg .="Impossibile modificare la data di apertura di un ordine aperto.<br>";
                    $data_valida++;
                }

                if(stato_from_id_ord($id)==3){ 
                    $msg .="Impossibile modificare la data di apertura di un ordine chiuso.<br>";
                    $data_valida++;
                } 
            } 
        }  
        if($o_data_chiusura<>$o_old_data_chiusura){ 
            //DATA CHIUSURA NEL PASSATO
            if(gas_mktime($o_data_chiusura)<=gas_mktime(date("d/m/Y H:i"))){
                $msg .="Impossibile modificare date di chiusura passate";
                $data_valida++; 
            }
        }        
        return $msg;
        exit;            
    }
    function ordine_do_mod($id){

        // Prendo le variabili globali      
        global $o_descrizione,
        $o_data_apertura,
        $o_data_chiusura,
        $o_costo_trasporto,
        $o_costo_gestione,
        $o_note_ordine,
        $o_old_data_apertura,
        $o_old_data_chiusura;

        global $db;

        //sistemo lo stato

        $s_a = stato_from_id_ord($id);
        $o_stato = $s_a;

        if($o_data_apertura<>$o_old_data_apertura){
            // DATA APERTURA NEL FUTURO
            if(gas_mktime($o_data_apertura)>gas_mktime(date("d/m/Y H:i"))){
                if($s_a==1){
                    $msg .= "Apertura spostata";
                    $o_stato = 1;
                }
                if($s_a==2){
                    $msg .= "Ordine sospeso";
                    $o_stato = 1;
                }
                if($s_a==3){
                    $msg .= "Io credo risorgeròooo";
                    $o_stato = 1;
                }

            }     

            //DATA APERTURA GIA' PASSATA 
            if(gas_mktime($o_data_apertura)<=gas_mktime(date("d/m/Y H:i"))){
                if($s_a==1){
                    $o_data_apertura = date("d/m/Y H:i");
                    $msg .= "Aperto subito !";
                    $o_stato = 2;
                }


            }
        }


        if($o_data_chiusura<>$o_old_data_chiusura){    
            //DATA CHIUSURA NEL FUTURO
            if(gas_mktime($o_data_chiusura)>gas_mktime(date("d/m/Y H:i"))){
                if($s_a==3){
                    $msg .= "Ordine riesumato !";
                    $o_stato = 2;
                }
                if($s_a==2){
                    $msg .= "Ordine allungato";
                    $o_stato = 2;
                }
                if($s_a==1){
                    $msg .= "Ordine spostato";
                    $o_stato = 1;
                }
            }
        }

        //tratto le variabili
        $o_data_apertura = conv_date_to_db($o_data_apertura);     
        $o_data_chiusura = conv_date_to_db($o_data_chiusura);
        $o_descrizione = strip_tags(sanitize($o_descrizione));
        $o_note_ordine = sanitize($o_note_ordine);

        // QUERY INSERT
        $my_query="UPDATE retegas_ordini 
        SET
        retegas_ordini.data_apertura = '$o_data_apertura', 
        retegas_ordini.data_chiusura = '$o_data_chiusura',
        retegas_ordini.costo_gestione = '$o_costo_gestione',
        retegas_ordini.costo_trasporto = '$o_costo_trasporto',
        retegas_ordini.id_stato = '$o_stato',
        retegas_ordini.note_ordini = '$o_note_ordine' 
        WHERE 
        retegas_ordini.id_ordini = '$id' LIMIT 1;";
        //echo $my_query;                                         

        //INSERT BEGIN ---------------------------------------------------------
        $result = $db->sql_query($my_query);

        //echo $msg;
        if (is_null($result)){
            return 0;
            exit;
        }else{
            return $o_stato;
            exit;
        }     


    }


    // ADD SIMPLE 
    function ordine_render_add_simple($id){

        global $db;     
        global 
        $data_chiusura,
        $costo_trasporto,
        $descrizione,
        $id_ditta,
        $id_listino;

        if(isset($id_listino)){
            $id_ditta = ditta_id_from_listino($id_listino);
            $script_listini='';
        }

        if(isset($data_chiusura)){
            $data_chiusura = CAST_TO_INT(gas_mktime($data_chiusura)-gas_mktime(date("d/m/Y"))/24/60/60,0,15);
        }
        
        $query_ditte = "SELECT *
        FROM
        retegas_ditte
        Inner Join retegas_listini ON retegas_ditte.id_ditte = retegas_listini.id_ditte
        WHERE
        retegas_listini.data_valido >  now()
        AND
        retegas_listini.tipo_listino = 0
        GROUP BY
        retegas_ditte.descrizione_ditte";
        $res_ditte = $db->sql_query($query_ditte);

        while ($row = $db->sql_fetchrow($res_ditte)){

            if(isset($id_ditta)){
                if($id_ditta==$row["id_ditte"]){$selected = " SELECTED ";}else{$selected="";}    
            }  
            $ditta_select .= '<option value="'.$row["id_ditte"].'" '.$selected.'>'.$row["descrizione_ditte"].' ~ di '.fullname_from_id($row["id_proponente"]).' (Listini validi : '.listini_ditte($row["id_ditte"]).')</option>\\n';     
        }

        $help_descrizione='Inserisci una descrizione chiara e concisa dell\'ordine che stai aprendo.';
        $help_ditta ='Seleziona una ditta tra quelle con listini disponibili';
        $help_listino ='Seleziona un listino associato alla ditta scelta in precedenza tra quelli disponibili';
        $help_data_chiusura='Scegli tra quanti giorni l\'ordine deve chiudersi;<br>Se lasciato vuoto, si chiuderà tra una settimana alle 22.00;<br>Gli ordini aperti con questa scheda possono durare massimo 15 giorni.';
        $help_partenza = 'Una volta che l\'ordine è partito, potrai modificare tutti i dati che hai immesso e/o aggiungerne altri.<br>
        Puoi anche annullarlo, ma soltanto se nessuno ha prenotato articoli.';


        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Crea un nuovo ordine : procedura veloce</h3>

        <form name="Nuovo ordine Veloce" method="POST" action="ordini_form_add_simple.php" class="retegas_form">

        <div>
        <h4>1</h4>
        <span>
        <label for="selection">Scegli la ditta...</label>
        <select id="selection" name="id_ditta">
        <option value="0">Nessuna ditta selezionata</OPTION>
        '.$ditta_select.'        
        </select>
        <h5 title="'.$help_ditta.'">Inf.</h5>
        </span>

        </div>

        <div>
        <h4>2</h4> 
        <label for="selectionresult">... e poi un suo listino: </label>
        <span id="result">&nbsp;</span>
        <select id="selectionresult" name="id_listino">
        <option value="0">Nessun listino selezionato</OPTION>       
        </select>
        <h5 title="'.$help_listino.'">Inf.</h5>
        </div>


        <div>
        <h4>3</h4>
        <label for="descrizione">poi dai un nome all\'ordine</label>
        <input type="text" name="descrizione" value="'.$descrizione.'" size="50"></input>
        <h5 title="'.$help_descrizione.'">Inf.</h5>
        </div>

        <div>
        <h4>4</h4>
        <label for="datetimepicker">...decidi tra quanti giorni chiude...</label>
        <input id="" type="text" name="data_chiusura" value="'.$data_chiusura.'" size="20"></input>
        <h5 title="'.$help_data_chiusura.'">Inf.</h5></div>

        <div>
        <h4>5</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Fai partire l\'ordine" align="center" >
        <input type="hidden" name="do" value="add">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div> 


        </form>
        <br>
        <div class="ui-state-error ui-corner-all" style="padding:1em">NB : Usando questa procedura "rapida" l\'ordine sarà disponibile da subito, e potranno parteciparvi solo gli utenti del tuo gas.<br>
        potrai cambiare le impostazione e/o aggiungere altre informazioni dal menù "modifica" che troverai nella scheda specifica, oppure se vuoi
        inserire un ordine più complesso, usa la procedura completa. (Vedi Help)<br>
        Potrai cancellare questo ordine finchè non vi è nessun articolo prenotato.
        </div>
        </div>';              


        return $h;      

    } 
    function ordine_render_do_add_simple($id){

        global $db,$id_user;     
        global $data_chiusura,
        $costo_trasporto,
        $descrizione,
        $id_ditta,
        $id_listino;

        // controllo tutti i dati
        if(empty($descrizione) | $descrizione==""){
            $empty++;
            $msg .= "Descrizione mancante<br>";
        }

        //if($data_chiusura>15){    
        //    $logical++;
        //    $msg .= "L'ordine non pu? rimanere aperto pi? di 2 settimane.<br>Se si vuole posticipare la partenza, usare la procedura completa.<br>";               
        //}
        

        //se manca la data di chiusura chiudo l'ordine tra una settimana alle 22:00;  
        if(empty($data_chiusura) | $data_chiusura==""){
            $data_chiusura=date("d/m/Y");
            //echo $data_chiusura."<br>";
            $data_chiusura = gas_mktime($data_chiusura) + (60*60*24*7);
            //echo $data_chiusura."<br>";
            $data_chiusura = date("d/m/Y",$data_chiusura);
            //echo $data_chiusura."<br>";
            $data_chiusura = $data_chiusura ." 22:00";
            //echo $data_chiusura;

        }else{            
           $data_chiusura=date("d/m/Y",gas_mktime(date("d/m/Y")) + (60 * 60 * 24 * $data_chiusura));
           $data_chiusura = $data_chiusura ." 22:00";  
        }    

        if(empty($id_listino) | $id_listino=="" | $id_listino ==0){
            $empty++;
            $msg .= "Listino mancante o non valido<br>";
        }    

        if(empty($costo_trasporto) | $costo_trasporto==""){
            $costo_trasporto = 0;
        }
        if(!valuta_valida(trim($costo_trasporto))){
            $logical++;
            $msg .= "Valore del costo di trasporto  non riconosciuto<br>"; 

        }
        //NON DATA VALIDA -------------------------------------
        if(!controllodataora($data_chiusura)){
            $logical++;
            $msg .= "Data chiusura non valida<br>"; 
        }

        //se l'ordine ? pi? lungo di 15 giorni do errore
        //if((gas_mktime($data_chiusura)-gas_mktime($data_apertura)) > (60*60*24*15)){
        //    $logical++;
        //    $msg .= "L'ordine non pu? rimanere aperto pi? di 2 settimane.<br>Se si vuole posticipare la partenza, usare la procedura completa.<br>";
        //}
        
        
        //-------------------------- PRESO DA ORDINI ADD
        $e_total = $empty + $logical;

        if($e_total==0){

            //echo "ZERO ERRORI !!!";
            $data_2 = (int)$id_listino;
            $data_4 = sanitize(trim($descrizione));
            
            //POSTICIPO DI DUEE ORE L'APERTURA
            $date_now  = date( "d/m/Y H:i" ); 
            $time_now  = time( $date_now ); 
            $time_next = $time_now + 2 * 60 * 60; 
            $date_next = date( "d/m/Y H:i", $time_next); 
            
            
            $data_7 = conv_date_to_db($date_next);
            $data_8 = conv_date_to_db($data_chiusura);
            $data_10 = 0;        // costo trasporto fisso
            $data_11=0;
            $data_13=0;
            $data_14=0;
            $data_15=0;
            $data_16=1; // STATO COMUNQUE FUTURO
            $data_17=0;  
            $data_18=1;
            $data_19="";
            
            // L'opzione SOLO CASSATI E' PRESA DAL DEFAULT DELLE OPZIONI CASSA
            $data_20=read_option_gas_text(_USER_ID_GAS,"_GAS_CASSA_DEFAULT_SOLO_CASSATI");

            // QUERY INSERT
            $my_query="INSERT INTO retegas_ordini 
            (id_listini, 
            id_utente, 
            descrizione_ordini, 
            data_chiusura, 
            costo_trasporto, 
            costo_gestione, 
            min_articoli, 
            min_scatola, 
            privato, 
            data_apertura,
            id_stato,
            senza_prezzo,
            mail_level,
            note_ordini,
            solo_cassati)
            VALUES
            ('$data_2',
            '$id_user',
            '$data_4',
            '$data_8',
            '$data_10',
            '$data_11',
            '$data_14',
            '$data_15',
            '$data_13',
            '$data_7',
            '$data_16',
            '$data_17',
            '$data_18',
            '$data_19',
            '$data_20');";

            //INSERT BEGIN ---------------------------------------------------------
            $result = $db->sql_query($my_query);
            if (is_null($result)){
                $msg .= "Errore nell'inserimento del record";
                include ("../index.php");
                exit;  
            }else{

                // se l'ordine ? stato inserito, allora inserisco anche le referenze
                $res = mysql_query("SELECT LAST_INSERT_ID();");
                $row = mysql_fetch_array($res);
                $ur=$row[0];
                $gr =id_gas_user($id_user);

                // recupero le informazioni dal mio gas
                $res_gas = $db->sql_query("SELECT * FROM retegas_gas WHERE id_gas='$gr'");
                $row_gas = $db->sql_fetchrow($res_gas);


                $result = $db->sql_query("INSERT INTO retegas_referenze (id_ordine_referenze,
                id_utente_referenze,
                id_gas_referenze,
                note_referenza,
                maggiorazione_referenza,
                maggiorazione_percentuale_referenza)
                VALUES 
                ('$ur',
                '$id_user',
                '$gr',
                '".$row_gas["comunicazione_referenti"]."',
                '0',
                '".$row_gas["maggiorazione_ordini"]."');");
                // e poi vado ad aggiungere anche i gas coinvolti, ma con nessun referente

                //$box=$_POST["box"];
                //while (list ($key,$val) = @each ($box)) { 
                //echo "$val,";
                //$result = $db->sql_query("INSERT INTO retegas_referenze (id_ordine_referenze, id_utente_referenze, id_gas_referenze) "
                //                       ." VALUES ('$ur', '0', '$val');");                        
                //}        
                // referenze
                $msg .= "Ordine $ur ($descrizione) PARTITO !!";
                $nome_ordine = descrizione_ordine_from_id_ordine($ur);
                $messa = "<b>L'utente $fullname ha creato l'ordine speedy $nome_ordine</b>";
                log_me($ur,$id_user,"ORD","MOD",$messa,0,$my_query);

                $msg="OK";
            }

        }else{

            unset($do);    
            $msg .= "Controlla i dati e riprova<br>";
        }
        //-------------------------- PRESO DA ORDINI ADD




        return $msg;    

    }

    //ADD COMPLETE
    function ordine_render_add_complete($id){

        global $db, $mio_gas, $box;     
        global $data_apertura,
        $data_chiusura,
        $costo_trasporto,
        $costo_gestione,
        $costo_mio_gas,
        $percentuale_mio_gas,
        $testo_percentuale_mio_gas,
        $descrizione,
        $id_ditta,
        $id_listino,
        $note_ordine,
        $quanto_comunica,
        $solo_cassati;


        if(isset($id_listino)){
            $id_ditta = ditta_id_from_listino($id_listino);
            $script_listini='';
        }

        $query_ditte = "SELECT *
        FROM
        retegas_ditte
        Inner Join retegas_listini ON retegas_ditte.id_ditte = retegas_listini.id_ditte
        WHERE
        retegas_listini.data_valido >  now()
        GROUP BY
        retegas_ditte.descrizione_ditte";
        $res_ditte = $db->sql_query($query_ditte);

        while ($row = $db->sql_fetchrow($res_ditte)){

            if(isset($id_ditta)){
                if($id_ditta==$row["id_ditte"]){$selected = " SELECTED ";}else{$selected="";}    
            }   

            $ditta_select .= '<option value="'.$row["id_ditte"].'" '.$selected.'>'.$row["descrizione_ditte"].' ~ di '.fullname_from_id($row["id_proponente"]).'</option>\\n';     
        }
        
        
        //select_listini
        $query_listini = "SELECT *
        FROM
        retegas_listini
        WHERE
        retegas_listini.data_valido >  now();";
        $res_listini = $db->sql_query($query_listini);

        while ($row = $db->sql_fetchrow($res_listini)){

            if(isset($id_listini)){
                if($id_listini==$row["id_listini"]){$selected = " SELECTED ";}else{$selected="";}    
            }   

            $listini_select .= '<option value="'.$row["id_listini"].'" '.$selected.'>'.$row["descrizione_listini"].' ~ Di '.fullname_from_id($row["id_utenti"]).', articoli : '.articoli_n_in_listino($row["id_listini"]).' (scadenza : '.conv_only_date_from_db($row["data_valido"]).')</option>\\n';     
        }

        //TABELLA GAS PARTECIPANTI

        while (list ($key,$val) = @each ($box)) { 
            // Per ogni GAS indicato nel Box associo la sua percentuale di maggiorazione
            if(isset($box[$key])){
                //echo "BOX = ".$box[$val]."<br>";
                $box_selected[$val]=" checked=\"yes\" ";
                //echo "BOXSELECTED = ".$box_selected[$val]."<br>";
            }

        }




        $h_table ="
        <table style=\"width:100%; display:block\" id=\"gas_partecipanti\" >
        ";

        $result = $db->sql_query("SELECT * FROM retegas_gas;");             
        while ($row = mysql_fetch_array($result)){
            $riga++;
            $gas = $row[1];
            $id_gas = $row[0];
            $ute = gas_n_user($id_gas);

            if ($mio_gas<>$id_gas){  
                //$gas_ext_perm = leggi_permessi_gas($id_gas);
                $gas_ext_perm = read_option_gas_text($id_gas,"_GAS_PUO_PART_ORD_EST");
                if($gas_ext_perm=="SI"){
                    $condizione = "<input type=\"checkbox\" name=box[] value=\"$id_gas\" ".$box_selected[$id_gas].">";
                }else{
                    $condizione = "Condivisione ordine non possibile";
                }
                    $h_table .="    <tr class=\"odd\">
                    <th style=\"width:70%\">
                    $gas
                    </th>
                    <td style=\"width:100%\">
                    Utenti : $ute
                    </td >
                    <td style=\"width:100%\">
                    $condizione 
                    </td>
                    </tr>
                    ";
                
            }
        }

        $h_table .="</table>
        "; 

        //CONTROLLO SE IL GAS PUO' PROPORRE ORDINI AGLI ALTRI
        $gas_perm = leggi_permessi_gas($mio_gas);
        if(!($gas_perm & gas_perm::puo_proporre_ordini_esterni)){
           $h_table = "<strong style=\"text-align:center;\">Il tuo GAS non può momentaneamente condividere ordini con gli altri</strong>"; 
        }
        

        // recupero le informazioni dal mio gas
        $res_gas = $db->sql_query("SELECT * FROM retegas_gas WHERE id_gas='$mio_gas'");
        $row_gas = $db->sql_fetchrow($res_gas);
        if (!isset($testo_percentuale_mio_gas)){
            $testo_percentuale_mio_gas = $row_gas["comunicazione_referenti"];    
        }
        if (!isset($percentuale_mio_gas)){
            $percentuale_mio_gas = $row_gas["maggiorazione_ordini"];    
        }  

        //Guarda se partecipano i solo cassati
        if(read_option_gas_text(_USER_ID_GAS,"_GAS_CASSA_DEFAULT_SOLO_CASSATI")=="SI"){
           $solo_cassati_checked="CHECKED"; 
        }else{
           $solo_cassati_checked=""; 
        }
        
        

        // HELPS
        $help_ditta = '<b>Scegli la ditta</b> : Viene proposto l\'intero elenco delle ditte disponibili, con almeno un listino valido. Quando si seleziona una delle ditte presenti nell\'elenco, viene popolata la casella di selezione del listino con i listini associati ad essa.';
        $help_listino ='<b>...e poi il suo listino...</b> : Viene proposto l\'elenco dei listini associati alla ditta selezionata in precedenza. Se a questa pagina si è arrivati dalla scheda di un particolare listino, i campi ditta e listino sono già popolati con i dati di quel listino.';
        $help_descrizione ='Questo è il nome che verrà poi usato per rappresentare l\'ordine';
        $help_data_apertura ='La data e l\'ora di apertura ordine<br><b>NB :</b>Se manca o è antecedente all\'ora attuale, verrà presa l\'ora attuale;';
        $help_data_chiusura ='La data e l\'ora di chiusura ordine<br><b>NB :</b>Se manca verrà considerato che l\'ordine chiude trascorse due settimane dalla sua apertura, alle ore 22.00;';
        $help_costo_trasporto ='Le spese di trasporto dell\'ordine. Questo valore si può modificare successivamente, sia ad ordine aperto che ad ordine chiuso.<br>Le spese di trasporto sono ripartizionate proporzionalmente alla spesa effettuata da ogni singolo utente. (di tutti i GAS).<br>Se viene lasciato vuoto si assume che siano 0;';
        $help_costo_gestione='Le spese di gestione dell\'ordine. Questo valore si può modificare successivamente, anche ad ordine chiuso. Anche le spese di gestione sono ripartizionate proporzionalmente alla spesa effettuata da ogni singolo utente. (di tutti i GAS). Se viene lasciato vuoto si assume che siano 0;';
        $help_note_ordine ='In questo piccolo editor è possibile scrivere delle note che verranno mostrate in calce alla scheda dell\'ordine. Se si fa il copia e incolla da un\'altrea pagina WEB, è possibile includere anche delle immagini';
        $help_costo_mio_gas ='In questo campo vegnono indicati i costi relativi SOLTANTO AL GAS DI APPARTENENZA di chi propone l\'ordine. Verranno ripartiti proporzionalmente in base alla spesa di ogni utente. Ogni GAS, tramite il referente GAS ha la possibilità di inserire dei costi personalizzati, personalizzabili per ogni ordine gestito.';  
        $help_percentuale_mio_gas =' Il responsabile del tuo GAS, ha indicato nella scheda relativa al tuo GAS una Maggiorazione percentuale che viene applicata su ogni ordine, (che coinvolge solo il proprio GAS). In questo campo viene già proposta questa cifra, ma è possibile modificarla a piacimento, previo accordo con il resto del proprio GAS. Qeesta maggiorazione sarà applicata al netto della merce acquistata di ogni singolo utente.';  
        $help_testo_percentuale ='Breve descrizione del motivo della maggiorazione percentuale sopra descritta, proposta dal responsabile del proprio gas ma qui liberamente modificabile.';
        $help_comunicazioni =' Il sito ReteGas è in grado di inviarti degli aggiornamenti tramite mail su quanto sta accadendo nel tuo ordine. In base al livello che selezioni potrai non essere disturbato affatto, ricevere solo gli avvisi importanti oppure essere aggiornato su ogni movimentazione avvenuta sull\'ordine che stai gestendo.';
        $help_gas_partecipanti ='In questa tabella sono presenti i gas iscritti a ReteGas.AP, con il numero dei relativi iscritti. Spuntando le caselle al loro fianco puoi decidere se dare la possibilità anche a loro di partecipare al tuo ordine. Per partecipare, gli altri GAS dovranno avere un referente GAS. Finchè un gas esterno non ha un referente GAS è possibile revocare la condivisione. Le condivisioni possono essere aggiunte anche in un secondo momento, anche ad ordine già aperto.';
        $help_solo_cassati ='Permetti agli utenti di partecipare solo se hanno credito disponibile.';


        //TABELLA GAS PARTECIPANTI




        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Crea un nuovo ordine : procedura completa</h3>

        <form name="Nuovo ordine Veloce" method="POST" action="ordini_form_add_complete.php" class="retegas_form">

        <div>
        <h4>1</h4>
        <label for="selection">Scegli la ditta...</label>
        <select id="selection" name="id_ditta">
        <option value="0">Nessuna ditta selezionata</OPTION>
        '.$ditta_select.'        
        </select>
        <h5 title="'.$help_ditta.'">Inf.</h5>    
        </div>

        <div>
        <h4>2</h4> 
        <label for="selectionresult">... e poi un suo listino:</label>
        <select id="selectionresult" name="id_listino">
        <option value="0">Nessun listino selezionato</OPTION>
        '.$listini_select.'       
        </select>
        <h5 title="'.$help_listino.'">Inf.</h5>    
        </div>


        <div class="form_box">
        <h4>3</h4>
        <label for="descrizione">poi dai un nome all\'ordine</label>
        <input type="text" name="descrizione" value="'.$descrizione.'" size="50"></input>
        <h5 title="'.$help_descrizione.'">Inf.</h5>
        </div>

        <div>
        <h4>4</h4>
        <label for="datetimepicker">...decidi quando apre...</label>
        <input id="datetimepicker" type="text" name="data_apertura" value="'.$data_apertura.'" size="20"></input>
        <h5 title="'.$help_data_apertura.'">Inf.</h5>
        </div>

        <div>
        <h4>5</h4>
        <label for="datetimepicker2">...decidi quando chiude...</label>
        <input id="datetimepicker2" type="text" name="data_chiusura" value="'.$data_chiusura.'" size="20"></input>
        <h5 title="'.$help_data_chiusura.'">Inf.</h5> 
        </div>

        <div>
        <h4>6</h4>
        <label for="costo_trasporto">Inserisci le spese di trasporto</label>
        <input style="text-align:right;" id="costo_trasporto" type="text" name="costo_trasporto" value="'.$costo_trasporto.'" size="10"></input>
        <h5 title="'.$help_costo_trasporto.'">Inf.</h5>
        </div>

        <div>
        <h4>7</h4>
        <label for="costo_gestione">...e quelle di gestione;</label>
        <input style="text-align:right;" id="costo_gestione" type="text" name="costo_gestione" value="'.$costo_gestione.'" size="10"></input>
        <h5 title="'.$help_costo_gestione.'">Inf.</h5>
        </div>


        <div>
        <h4>8</h4>
        <label for="costo_mio_gas">Qua inserisci i costi RELATIVI AL TUO GAS;</label>
        <input style="text-align:right;" id="costo_mio_gas" type="text" name="costo_mio_gas" value="'.$costo_mio_gas.'" size="10"></input>
        <h5 title="'.$help_costo_mio_gas.'">Inf.</h5>
        </div>

        <div>
        <h4>9</h4>
        <label for="percentuale_mio_gas">Il tuo Gas ha come maggiorazione questa percentuale :</label>
        <input style="text-align:right;" id="percentuale_mio_gas" type="text" name="percentuale_mio_gas" value="'.$percentuale_mio_gas.'" size="10"></input> %
        <h5 title="'.$help_percentuale_mio_gas.'">Inf.</h5>
        </div>

        <div>
        <h4>10</h4>
        <label for="testo_percentuale_mio_gas">Riferita a questa motivazione :</label>
        <input id="testo_percentuale_mio_gas" type="text" name="testo_percentuale_mio_gas" value="'.$testo_percentuale_mio_gas.'" size="50"></input>
        <h5 title="'.$help_testo_percentuale.'">Inf.</h5>
        </div>

        <div>
        <h4>11</h4>
        <h5 title="'.$help_note_ordine.'">Inf.</h5>
        <label for="note_ordine">Qua puoi mettere delle note che saranno visibili a tutti :</label>
        <textarea id="note_ordine" class ="ckeditor" name="note_ordine" cols="28" style="display:inline-block;">'.$note_ordine.'</textarea>
        </div>


        <div>
        <h4>12</h4>
        <label for="quanto_comunica">..e qua decidi quanto vuoi essere aggiornato sul tuo ordine</label>
        <select name="quanto_comunica" id= "quanto_comunica">
        <option value="1" SELECTED >Normale (Consigliato)</option>
        <option value="0" >Nessuna comunicazione automatica</option>
        <option value="2" >Avvisami su ogni cosa che succede</option>
        </select>        
        <h5 title="'.$help_comunicazioni.'">Inf.</h5>
        </div>

        <div>
        <h4>13</h4>
        <h5 title="'.$help_gas_partecipanti.'">Inf.</h5>
        <label for="gas_partecipanti">Seleziona gli altri GAS che vuoi far partecipare a questo ordine :</label>
        '.$h_table.'
        </div>

        <div>
        <h4>14</h4>
        <label for="solo_cassati">Permetti la partecipazione esclusivamente a chi ha sufficiente credito disponibile.</label>
        <input id="solo_cassati" type="checkbox" name="solo_cassati" value="si" '.$solo_cassati_checked.'></input>
        <h5 title="'.$help_solo_cassati.'">Inf.</h5>
        </div>

        <div>
        <h4>15</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Fai partire l\'ordine" align="center" >
        <input type="hidden" name="do" value="add">
        </div>
        </form>
        <br>

        </div>';              


        return $h;      

    }
    function ordine_render_do_add_complete($id){

        global $db,$id_user, $box;     
        global $data_apertura,
        $data_chiusura,
        $costo_trasporto,
        $costo_gestione,
        $costo_mio_gas,
        $percentuale_mio_gas,
        $testo_percentuale_mio_gas,
        $descrizione,
        $id_ditta,
        $id_listino,
        $note_ordine,
        $quanto_comunica,
        $solo_cassati;

        // controllo tutti i dati
        if(empty($descrizione) | $descrizione==""){
            $empty++;
            $msg .= "Descrizione mancante<br>";
        }


        //se manca la data di apertura apro l'ordine ora;
        if(empty($data_apertura) | $data_apertura==""){
            //$data_apertura=date("d/m/Y H:i");
            
            //POSTICIPO DI DUEE ORE L'APERTURA
            $date_now  = date( "d/m/Y H:i" ); 
            $time_now  = time( $date_now ); 
            $time_next = $time_now + 2 * 60 * 60; 
            $data_apertura = date( "d/m/Y H:i", $time_next);  
        }
        //se la data di apertura è passata la imposto come oggi
        if(gas_mktime($data_apertura)<gas_mktime(date("d/m/Y H:i"))){
            //$data_apertura=date("d/m/Y H:i");
            
            //POSTICIPO DI DUEE ORE L'APERTURA
            $date_now  = date( "d/m/Y H:i" ); 
            $time_now  = time( $date_now ); 
            $time_next = $time_now + 2 * 60 * 60; 
            $data_apertura = date( "d/m/Y H:i", $time_next);  
        }


        //se manca la data di chiusura la metto dopo due settimana quella di aperuta  

        if(empty($data_chiusura) | $data_chiusura==""){

            $data_chiusura=$data_apertura;
            //echo $data_chiusura."<br>";
            $data_chiusura = gas_mktime($data_chiusura) + (60*60*24*15);
            //echo $data_chiusura."<br>";
            $data_chiusura = date("d/m/Y",$data_chiusura);
            //echo $data_chiusura."<br>";
            $data_chiusura = $data_chiusura ." 22:00";
            //echo $data_chiusura;

        }    

        //se la data di apertura ? minore di quella di adesso do errore
        if(gas_mktime($data_apertura)<gas_mktime(date("d/m/Y H:i"))){
            $logical++;
            $msg .= "Data di chiusura ordine antecedente a quella di apertura<br>";
        } 

        //se l'ordine ? pi? lungo di 15 giorni do errore
        //if((gas_mktime($data_chiusura)-gas_mktime($data_apertura)) > (60*60*24*15)){
        //    $logical++;
        //    $msg .= "L'ordine non pu? rimanere aperto pi? di 2 settimane<br>";
        //}
        
        //se l'ordine ? pi? lungo di 15 giorni do errore
        if((gas_mktime($data_chiusura)<gas_mktime($data_apertura))){
            $logical++;
            $msg .= "La data di chiusura non può essere antecedente a quella di apertura. Strano, no ? <br>";
        } 


        //listino    
        if(empty($id_listino) | $id_listino=="" | $id_listino ==0){
            $empty++;
            $msg .= "Listino mancante o non valido<br>";
        }    

        // se manca il costo trasporto lo metto a zero 
        if(empty($costo_trasporto) | $costo_trasporto==""){
            $costo_trasporto = 0;
        }

        // se non ? riconosciuto do errore
        if(!valuta_valida(trim($costo_trasporto))){
            $logical++;
            $msg .= "Valore del costo di trasporto  non riconosciuto<br>";    
        }

        // se manca il costo gestione lo metto a zero 
        if(empty($costo_gestione) | $costo_gestione==""){
            $costo_gestione = 0;
        }

        if(!valuta_valida(trim($costo_gestione))){
            $logical++;
            $msg .= "Valore del costo di gestione  non riconosciuto<br>";    
        }

        // se manca il costo trasporto lo metto a zero 
        if(empty($costo_mio_gas) | $costo_mio_gas==""){
            $costo_mio_gas = 0;
        }

        // se non ? riconosciuto do errore
        if(!valuta_valida(trim($costo_mio_gas))){
            $logical++;
            $msg .= "Valore del costo del mio GAS non riconosciuto<br>";    
        }

        // se manca la percentuale lo metto a zero 
        if(empty($percentuale_mio_gas) | $percentuale_mio_gas==""){
            $percentuale_mio_gas = 0;
        }

        // se non ? riconosciuto do errore
        if(!percentuale_valida(trim($percentuale_mio_gas))){
            $logical++;
            $msg .= "Percentuale aggiuntiva del mio Gas non riconosciuta<br>";    
        }


        //NON DATA VALIDA -------------------------------------
        if(!controllodataora($data_chiusura)){
            $logical++;
            $msg .= "Data chiusura non valida<br>"; 
        }
        if(!controllodataora($data_apertura)){
            $logical++;
            $msg .= "Data apertura non valida<br>"; 
        }



        if($solo_cassati=="si"){
            $solo_cassati="si";
        }else{
            $solo_cassati="no";
        }




        //-------------------------- PRESO DA ORDINI ADD
        $e_total = $empty + $logical;

        if($e_total==0){

            //echo "ZERO ERRORI !!!";
            $data_2 = (int)$id_listino;
            $data_4 = sanitize(trim($descrizione));

            //POSTICIPO DI DUEE ORE L'APERTURA
            $date_now  = date( "d/m/Y H:i" );
            //echo "Date_now $date_now  <br>";  
            
            $time_now  = time($date_now);
            //echo "Time_now $time_now  <br>";
            
            //echo "Date_apertura $data_apertura  <br>";
            
            $time_apertura = time($data_apertura);
            //echo "Time_apertura $time_apertura  <br>";
            
            if((($time_apertura - $time_now)) < (2*60*60)){
                //echo "Time_apertura diff (".($time_apertura - $time_now).")  <br>";
                $time_next = $time_now + 2 * 60 * 60;
    
                //echo "Time_next $time_next  <br>";    
            }else{
                $time_next = $time_apertura;
            } 
             
            $date_next = date($data_apertura, $time_next);
            //echo "date_next $date_next  <br>";
            
            $data_7 = conv_date_to_db($date_next);
            
            
            $data_8 = conv_date_to_db($data_chiusura);
            $data_10 = $costo_trasporto;        // costo trasporto fisso
            $data_11 = $costo_gestione;
            $data_13=0;
            $data_14=0;
            $data_15=0;
            $data_16=1; // STATO COMUNQUE FUTURO
            $data_17=0;  
            $data_18=(int)$quanto_comunica;
            $data_19=sanitize($note_ordine);
            // QUERY INSERT
            $my_query="INSERT INTO retegas_ordini 
            (id_listini, 
            id_utente, 
            descrizione_ordini, 
            data_chiusura, 
            costo_trasporto, 
            costo_gestione, 
            min_articoli, 
            min_scatola, 
            privato, 
            data_apertura,
            id_stato,
            senza_prezzo,
            mail_level,
            note_ordini,
            solo_cassati)
            VALUES
            ('$data_2',
            '$id_user',
            '$data_4',
            '$data_8',
            '$data_10',
            '$data_11',
            '$data_14',
            '$data_15',
            '$data_13',
            '$data_7',
            '$data_16',
            '$data_17',
            '$data_18',
            '$data_19',
            '$solo_cassati');";

            //INSERT BEGIN ---------------------------------------------------------
            $result = $db->sql_query($my_query);
            if (is_null($result)){
                $msg .= "Errore nell'inserimento del record";
                include ("../index.php");
                exit;  
            }else{

                // se l'ordine ? stato inserito, allora inserisco anche le referenze
                $res = mysql_query("SELECT LAST_INSERT_ID();");
                $row = mysql_fetch_array($res);
                $ur=$row[0];
                $gr =id_gas_user($id_user);

                // recupero le informazioni dal mio gas
                //$res_gas = $db->sql_query("SELECT * FROM retegas_gas WHERE id_gas='$gr'");
                //$row_gas = $db->sql_fetchrow($res_gas);


                $result = $db->sql_query("INSERT INTO retegas_referenze (id_ordine_referenze,
                id_utente_referenze,
                id_gas_referenze,
                note_referenza,
                maggiorazione_referenza,
                maggiorazione_percentuale_referenza)
                VALUES 
                ('$ur',
                '$id_user',
                '$gr',
                '".$testo_percentuale_mio_gas."',
                '".$costo_mio_gas."',
                '".$percentuale_mio_gas."');");
                // e poi vado ad aggiungere anche i gas coinvolti, ma con nessun referente


                while (list ($key,$val) = @each ($box)) { 
                    // Per ogni GAS indicato nel Box associo la sua percentuale di maggiorazione
                    $res_gas = $db->sql_query("SELECT * FROM retegas_gas WHERE id_gas='$val'");
                    $row_gas = $db->sql_fetchrow($res_gas);

                    $result = $db->sql_query("INSERT INTO retegas_referenze (id_ordine_referenze, id_utente_referenze, id_gas_referenze, note_referenza, maggiorazione_percentuale_referenza) "
                    ." VALUES ('$ur', '0', '$val', '".$row_gas["comunicazione_referenti"]."', '".$row_gas["maggiorazione_ordini"]."');");                        

                }        
                // referenze
                $msg .= "Ordine $ur ($descrizione) PARTITO !!";
                $nome_ordine = descrizione_ordine_from_id_ordine($ur);
                $messa = "<b>L'utente $fullname ha creato l'ordine complete $nome_ordine</b>";
                log_me($ur,$id_user,"ORD","MOD",$messa,0,$my_query);

                $msg="OK";
            }

        }else{

            unset($do);    
            $msg .= "Controlla i dati e riprova<br>";
        }
        //-------------------------- PRESO DA ORDINI ADD

        return $msg;    

    }  
    
    
    //EDIT ORDINE SPESE MIO GAS
    function ordine_render_edit_gas_spese($id_ordine,$id_gas){
        global $db;     
        global  $costo_mio_gas,
                $percentuale_mio_gas,
                $testo_percentuale_mio_gas;

        (int)$id_ordine;
        (int)$id_gas;
                
        $help_costo_mio_gas ='In questo campo vegnono indicati i costi relativi SOLTANTO AL GAS DI APPARTENENZA di chi propone l\'ordine. Verranno ripartiti proporzionalmente in base alla spesa di ogni utente. Ogni GAS, tramite il referente GAS ha la possibilità di inserire dei costi personalizzati, personalizzabili per ogni ordine gestito.';  
        $help_percentuale_mio_gas =' Il responsabile del tuo GAS, ha indicato nella scheda relativa al tuo GAS una Maggiorazione percentuale che viene applicata su ogni ordine, (che coinvolge solo il proprio GAS). In questo campo viene già proposta questa cifra, ma è possibile modificarla a piacimento, previo accordo con il resto del proprio GAS. Qeesta maggiorazione sarà applicata al netto della merce acquistata di ogni singolo utente.';  
        $help_testo_percentuale_mio_gas ='Breve descrizione del motivo della maggiorazione percentuale sopra descritta, proposta dal responsabile del proprio gas ma qui liberamente modificabile.';
        
        $query = "SELECT * FROM retegas_referenze WHERE id_ordine_referenze = '$id_ordine' AND id_gas_referenze = '$id_gas' LIMIT 1;";
        $result = $db->sql_query($query);
        $row = $db->sql_fetchrow($result);
        
        if(!isset($costo_mio_gas)){$costo_mio_gas=$row["maggiorazione_referenza"];}
        if(!isset($testo_percentuale_mio_gas)){$testo_percentuale_mio_gas=$row["note_referenza"];}
        if(!isset($percentuale_mio_gas)){$percentuale_mio_gas=$row["maggiorazione_percentuale_referenza"];}

        
        
        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Modifica i costi di questo ordine relativi al tuo gas</h3>
    
        <form class="retegas_form" name="Modifica Costi relativi al tuo GAS" method="POST" action="ordini_form_edit_gas_spese.php">
        
        <div>
        <h4>1</h4>
        <label for="costo_mio_gas">Qua inserisci i costi RELATIVI AL TUO GAS;</label>
        <input style="text-align:right;" id="costo_mio_gas" type="text" name="costo_mio_gas" value="'.$costo_mio_gas.'" size="10"></input> Euro
        <h5 title="'.$help_costo_mio_gas.'">Inf.</h5>
        </div>

        <div>
        <h4>2</h4>
        <label for="percentuale_mio_gas">Il tuo Gas ha come maggiorazione questa percentuale :</label>
        <input style="text-align:right;" id="percentuale_mio_gas" type="text" name="percentuale_mio_gas" value="'.$percentuale_mio_gas.'" size="10"></input> %
        <h5 title="'.$help_percentuale_mio_gas.'">Inf.</h5>
        </div>

        <div>
        <h4>3</h4>
        <label for="testo_percentuale_mio_gas">Riferita a questa motivazione :</label>
        <input id="testo_percentuale_mio_gas" type="text" name="testo_percentuale_mio_gas" value="'.$testo_percentuale_mio_gas.'" size="50"></input>
        <h5 title="'.$help_testo_percentuale.'">Inf.</h5>
        </div>
  
        <div>
        <h4>5</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Salva le modifiche" align="center" >
        <input type="hidden" name="id_ordine" value="'.$id_ordine.'">
        <input type="hidden" name="do" value="mod">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div>
  

        </form>

        </div>';              


        return $h;      

    } 
    function ordine_render_do_edit_gas_spese($id_ordine,$id_gas){

        global $db,$id_user, $box;     
        global $data_apertura,
        $data_chiusura,
        $costo_trasporto,
        $costo_gestione,
        $costo_mio_gas,
        $percentuale_mio_gas,
        $testo_percentuale_mio_gas,
        $descrizione,
        $id_ditta,
        $id_listino,
        $note_ordine,
        $quanto_comunica;

        // controllo tutti i dati



        // se manca il costo trasporto lo metto a zero 
        if(empty($costo_mio_gas) | $costo_mio_gas==""){
            $costo_mio_gas = 0;
        }

        // se non ? riconosciuto do errore
        if(!valuta_valida(trim($costo_mio_gas))){
            $logical++;
            $msg .= "Valore del costo del mio GAS non riconosciuto<br>";    
        }

        // se manca la percentuale lo metto a zero 
        if(empty($percentuale_mio_gas) | $percentuale_mio_gas==""){
            $percentuale_mio_gas = 0;
        }

        // se non ? riconosciuto do errore
        if(!percentuale_valida(trim($percentuale_mio_gas))){
            $logical++;
            $msg .= "Percentuale aggiuntiva del mio Gas non riconosciuta<br>";    
        }


  

        //-------------------------- PRESO DA ORDINI ADD
        $e_total = $empty + $logical;

        if($e_total==0){
             $testo_percentuale_mio_gas = sanitize($testo_percentuale_mio_gas);
             (int)$id_ordine;
             (int)$id_gas;
             
             $query = "UPDATE retegas_referenze SET 
                                note_referenza='$testo_percentuale_mio_gas',
                                maggiorazione_referenza = '$costo_mio_gas',
                                maggiorazione_percentuale_referenza = '$percentuale_mio_gas'                        
                                WHERE id_ordine_referenze='$id_ordine'
                                AND id_gas_referenze='$id_gas'
                                LIMIT 1;";
             $result = $db->sql_query($query);
             if($result){$msg="OK";}else{$msg="ERRORE QUERY";}                    

        }else{

            unset($do);    
            $msg .= "Controlla i dati e riprova<br>";
        }
        //-------------------------- PRESO DA ORDINI ADD

        return $msg;    

    }
    
    //EDIT ORDINE DATE 
    function ordine_render_edit_date($id_ordine){
        global $db;     
        global  $data_apertura,
                $data_chiusura;

        (int)$id_ordine;

        //echo "id ordine = $id_ordine";
                
   
        $query = "SELECT * FROM retegas_ordini WHERE id_ordini='$id_ordine' LIMIT 1;";
        $result = $db->sql_query($query);
        $row = $db->sql_fetchrow($result);
        
        if(!isset($data_apertura)){$data_apertura=conv_datetime_from_db($row["data_apertura"]);}
        if(!isset($data_chiusura)){$data_chiusura=conv_datetime_from_db($row["data_chiusura"]);}
        
        $help_data_apertura ='La data e l\'ora di apertura ordine<br><b>NB :</b>Se manca o è antecedente all\'ora attuale, verrà presa l\'ora attuale;';
        $help_data_chiusura ='La data e l\'ora di chiusura ordine<br><b>NB :</b>Se manca verrà considerato che l\'ordine chiude trascorse due settimane dalla sua apertura, alle ore 22.00;';
        
        
        
        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Modifica le date di scadenza dell\'ordine</h3>
        
        <div class="ui-state-error ui-corner-all padding_6px">ATTENZIONE : anticipando la data di apertura, potrebbe succedere che l\'ordine si apra senza che venga inviata la mail di avviso a tutti i potenziali partecipanti.</div>
        <form class="retegas_form" name="Modifica scadenze" method="POST" action="ordini_form_edit_date.php">
        
        <div>
        <h4>1</h4>
        <label for="datetimepicker">Modifica la data di apertura</label>
        <input id="datetimepicker" type="text" name="data_apertura" value="'.$data_apertura.'" size="20"></input>
        <h5 title="'.$help_data_apertura.'">Inf.</h5>
        </div>

        <div>
        <h4>2</h4>
        <label for="datetimepicker2">oppure quella di chiusura</label>
        <input id="datetimepicker2" type="text" name="data_chiusura" value="'.$data_chiusura.'" size="20"></input>
        <h5 title="'.$help_data_chiusura.'">Inf.</h5> 
        </div>
  
        <div>
        <h4>3</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Salva le modifiche" align="center" >
        <input type="hidden" name="id_ordine" value="'.$id_ordine.'">
        <input type="hidden" name="do" value="mod">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div>
  

        </form>

        </div>';              


        return $h;      

    } 
    function ordine_render_do_edit_date($id_ordine){

              
        global $class_debug;
        global $db,$id_user, $box;     
        global $data_apertura,
        $old_data_apertura,
        $data_chiusura,
        $old_data_chiusura,
        $costo_trasporto,
        $costo_gestione,
        $costo_mio_gas,
        $percentuale_mio_gas,
        $testo_percentuale_mio_gas,
        $descrizione,
        $id_ditta,
        $id_listino,
        $note_ordine,
        $quanto_comunica;

        $class_debug->debug_msg[]="<b>Do Edit :</b> Data Apertura = $data_apertura, Data chiusura = $data_chiusura";
        

        
        // controllo tutti i dati

        if(empty($data_apertura) | $data_apertura==""){
            $empty++;
            $msg .= "Data apertura mancante<br>";
        }
        if(empty($data_chiusura) | $data_chiusura==""){
            $empty++;
            $msg .= "Data chiusura mancante<br>";
        }
        //NON DATA VALIDA -------------------------------------
        if(!controllodataora($data_apertura)){
            $data_valida++;
            $msg .= "Data apertura non valida<br>"; 
        }
        if(!controllodataora($data_chiusura)){
            $data_valida++;
            $msg .= "Data chiusura non valida<br>"; 
        }
        
        if($data_apertura<>$old_data_apertura){
            
            if(stato_from_id_ord($id_ordine)==1){
                if (gas_mktime($data_apertura)<=gas_mktime(date("d/m/Y H:i"))){
                    $data_apertura=date("d/m/Y H:i");
                    $stato_ordine=2;
                }       
            }else{
                $msg .="Impossibile modificare la data di apertura di un ordine che è già stato aperto.<br>";
                $data_valida++;
                
            }
    
        }
        
          
        if($data_chiusura<>$old_data_chiusura){ 
        //DATA CHIUSURA NEL PASSATO
            if(gas_mktime($data_chiusura)<=gas_mktime(date("d/m/Y H:i"))){
                $msg .="Impossibile modificare date di chiusura passate<br>";
                $data_valida++; 
            }
        }

        //DATA IMPOSSIBILE -------------------------------------

        if (gas_mktime($data_chiusura)<gas_mktime($data_apertura)){
            $msg .="Data di chiusura antecedente quella di apertura<br>";
            $data_valida++; 
        }
        


    //STATO Dell'ordine
            if(gas_mktime($data_chiusura)<=gas_mktime(date("d/m/Y H:i"))){
                $stato_ordine=3; 
            }else{
                $stato_ordine=2; 
            }
  

        //-------------------------- PRESO DA ORDINI ADD
        $e_total = $empty + $data_valida;

        if($e_total==0){
            
             $data_apertura=conv_date_to_db($data_apertura);
             $data_chiusura=conv_date_to_db($data_chiusura);
             
             (int)$id_ordine;
             
             
             $query = "UPDATE retegas_ordini SET 
                                data_apertura='$data_apertura',
                                data_chiusura = '$data_chiusura',
                                id_stato = '$stato_ordine'
                                WHERE id_ordini='$id_ordine'
                                LIMIT 1;";
             
             $result = $db->sql_query($query);
             if($result){$msg="OK";}else{$msg="ERRORE QUERY";}                    

        }else{

            unset($do);    
            $msg .= "Controlla i dati e riprova<br>";
        }
        //-------------------------- PRESO DA ORDINI ADD

        return $msg;    

    }
    
    //EDIT ORDINE COSTI 
    function ordine_render_edit_costi($id_ordine){
        global $db;     
        global  $costo_gestione,
                $costo_trasporto;

        (int)$id_ordine;

        $help_costo_trasporto ='Le spese di trasporto dell\'ordine. Questo valore si può modificare successivamente, sia ad ordine aperto che ad ordine chiuso.<br>Le spese di trasporto sono ripartizionate proporzionalmente alla spesa effettuata da ogni singolo utente. (di tutti i GAS).<br>Se viene lasciato vuoto si assume che siano 0;';
        $help_costo_gestione='Le spese di gestione dell\'ordine. Questo valore si può modificare successivamente, anche ad ordine chiuso. Anche le spese di gestione sono ripartizionate proporzionalmente alla spesa effettuata da ogni singolo utente. (di tutti i GAS). Se viene lasciato vuoto si assume che siano 0;';
        

        
        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Modifica i costi generici di questo ordine</h3>
    
        <form class="retegas_form" name="Modifica costi" method="POST" action="ordini_form_edit_costi.php">
        
         <div>
        <h4>1</h4>
        <label for="costo_trasporto">Inserisci le spese di trasporto</label>
        <input style="text-align:right;" id="costo_trasporto" type="text" name="costo_trasporto" value="'.$costo_trasporto.'" size="10"></input>
        <h5 title="'.$help_costo_trasporto.'">Inf.</h5>
        </div>

        <div>
        <h4>2</h4>
        <label for="costo_gestione">...e quelle di gestione;</label>
        <input style="text-align:right;" id="costo_gestione" type="text" name="costo_gestione" value="'.$costo_gestione.'" size="10"></input>
        <h5 title="'.$help_costo_gestione.'">Inf.</h5>
        </div>
  
        <div>
        <h4>3</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Salva le modifiche" align="center" >
        <input type="hidden" name="id_ordine" value="'.$id_ordine.'">
        <input type="hidden" name="do" value="mod">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div>
  

        </form>

        </div>';              


        return $h;      

    } 
    function ordine_render_do_edit_costi($id_ordine){

              
        global $class_debug;
        global $db,$id_user, $box;     
        global $data_apertura,
        $data_chiusura,
        $costo_trasporto,
        $costo_gestione,
        $costo_mio_gas,
        $percentuale_mio_gas,
        $testo_percentuale_mio_gas,
        $descrizione,
        $id_ditta,
        $id_listino,
        $note_ordine,
        $quanto_comunica;

        $class_debug->debug_msg[]="<b>Do Edit :</b> Costo gestione = $costo_gestione, Costo Trasporto = $costo_trasporto";
        

        
        // controllo tutti i dati
        // MANCANTI -------------------------------------------             
        if(empty($costo_gestione) | $costo_gestione==""){
            $costo_gestione = 0;
        }
        if(empty($costo_trasporto) | $costo_trasporto==""){
            $costo_trasporto = 0;
        }

        // NON NUMERICI -------------------------------------------             
        if(!valuta_valida($costo_gestione)){
            $valuta_valida++;
            $msg.="costo gestione non riconosciuto";
        }
        if(!valuta_valida($costo_trasporto)){
            $valuta_valida++;
            $msg.="costo trasporto non riconosciuto";
        }
       

  

        //-------------------------- PRESO DA ORDINI ADD
        $e_total = $empty + $valuta_valida;

        if($e_total==0){

             
             (int)$id_ordine;
             
             
             $query = "UPDATE retegas_ordini SET 
                                costo_gestione='$costo_gestione',
                                costo_trasporto='$costo_trasporto'
                                WHERE id_ordini='$id_ordine'
                                LIMIT 1;";
             
             $result = $db->sql_query($query);
             
             if($result){$msg="OK";}else{$msg="ERRORE QUERY";}                    
             log_me($id_ordine,_USER_ID,"ORD","MOD","Modificati costi : $costo_gestione e $costo_trasporto",0,$query);
        
        }else{

            unset($do);    
            $msg .= "Controlla i dati e riprova<br>";
        }
        //-------------------------- PRESO DA ORDINI ADD

        return $msg;    

    }

    //EDIT ORDINE DESCRIZIONE
    function ordine_render_edit_descrizione($id_ordine){
        global $db;     
        global  $descrizione,
                $note_ordine;
        
        (int)$id_ordine;
                
        $query = "SELECT * FROM retegas_ordini WHERE id_ordini='$id_ordine' LIMIT 1;";
        $result = $db->sql_query($query);
        $row = $db->sql_fetchrow($result);
        
        if(!isset($descrizione)){$descrizione=$row["descrizione_ordini"];}
        if(!isset($note_ordine)){$note_ordine=$row["note_ordini"];}
 
                
        

        $help_descrizione ='Questo è il nome che verrà poi usato per rappresentare l\'ordine';
        $help_note_ordine ='In questo piccolo editor è possibile scrivere delle note che verranno mostrate in calce alla scheda dell\'ordine. Se si fa il copia e incolla da un\'altrea pagina WEB, è possibile includere anche delle immagini';
        

        
        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Modifica le note di questo ordine</h3>
    
        <form class="retegas_form" name="Modifica descrizione" method="POST" action="ordini_form_edit_descrizione.php">
        
        <div class="form_box">
        <h4>1</h4>
        <label for="descrizione">Dai un nuovo nome all\'ordine</label>
        <input type="text" name="descrizione" value="'.$descrizione.'" size="50"></input>
        <h5 title="'.$help_descrizione.'">Inf.</h5>
        </div>
        
        <div>
        <h4>2</h4>
        <h5 title="'.$help_note_ordine.'">Inf.</h5>
        <label for="note_ordine">Qua puoi mettere delle note che saranno visibili a tutti :</label>
        <textarea id="note_ordine" class ="ckeditor" name="note_ordine" cols="28" style="display:inline-block;">'.$note_ordine.'</textarea>
        </div>
  
        <div>
        <h4>3</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Salva le modifiche" align="center" >
        <input type="hidden" name="id_ordine" value="'.$id_ordine.'">
        <input type="hidden" name="do" value="mod">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div>
  

        </form>

        </div>';              


        return $h;      

    } 
    function ordine_render_do_edit_descrizione($id_ordine){

              
        global $class_debug;
        global $db,$id_user, $box;     
        global $data_apertura,
        $data_chiusura,
        $costo_trasporto,
        $costo_gestione,
        $costo_mio_gas,
        $percentuale_mio_gas,
        $testo_percentuale_mio_gas,
        $descrizione,
        $id_ditta,
        $id_listino,
        $note_ordine,
        $quanto_comunica;

        $class_debug->debug_msg[]="<b>Do Descr :</b> Costo gestione = $descrizione, Costo Trasporto = $note_ordine";
        

        
        // controllo tutti i dati

        if(empty($descrizione) | $descrizione==""){
            $empty++;
            $msg .= "Descrizione mancante<br>";
        }

  

        //-------------------------- PRESO DA ORDINI ADD
        $e_total = $empty;

        if($e_total==0){

             $descrizione =sanitize($descrizione);
             $note_ordine = sanitize($note_ordine);
             
             (int)$id_ordine;
             
             
             $query = "UPDATE retegas_ordini SET 
                                descrizione_ordini='$descrizione',
                                note_ordini='$note_ordine'
                                WHERE id_ordini='$id_ordine'
                                LIMIT 1;";
             
             $result = $db->sql_query($query);
             
             if($result){$msg="OK";}else{$msg="ERRORE QUERY";}                    
             log_me($id_ordine,$id_user,"ORD","MOD","Modificati descrizioni : $descrizione e $note_ordine",0,$query);
        
        }else{

            unset($do);    
            $msg .= "Controlla i dati e riprova<br>";
        }
        //-------------------------- PRESO DA ORDINI ADD

        return $msg;    

    }
    
    //EDIT ORDINE PARTECIPAZIONE
    function ordine_render_edit_partecipazione($id_ordine,$id_gas){
        global $db;     
        global  $descrizione,
                $note_ordine,
                $box;
        
        (int)$id_ordine;
        
        if(!isset($box)){
            $query = "SELECT * FROM retegas_referenze WHERE id_ordine_rferenze='$id_ordine'";
            $res = $db->sql_query($query);
            
        }
        
        
        while (list ($key,$val) = @each ($box)) { 
            // Per ogni GAS indicato nel Box associo la sua percentuale di maggiorazione
            if(isset($box[$key])){
                //echo "BOX = ".$box[$val]."<br>";
                //$box_selected[$val]=" checked=\"yes\" ";
                //echo "BOXSELECTED = ".$box_selected[$val]."<br>";
                //if(gas_partecipa_ordine($id_ordine,$box[$val])){
                //   $box_selected[$val]=" checked=\"yes\" "; 
                //}
            }

        }
        
        $h_table ="
        <table style=\"display:inline-block; width:100%;\" id=\"gas_partecipanti\">
        ";

        $result = $db->sql_query("SELECT * FROM retegas_gas ORDER BY id_gas ASC;");             
        while ($row = mysql_fetch_array($result)){
            $riga++;
            $gas = $row[1];
            $id_gas_table = $row[0];
            $ute = gas_n_user($id_gas_table);
            
            $level_part = gas_partecipa_ordine($id_ordine,$id_gas_table);
            $hidden = " type = \"checkbox\" ";
            
            if($level_part>0){
               $box_selected = " checked=\"yes\" "; 
            }else{
               $box_selected = "";  
            }
            
            if($level_part>1){
               $box_imp = "NON MODIFICABILE";
               $hidden = " type = \"hidden\" "; 
            }else{
               $box_imp = "";  
            }
            
            //$gas_perm = leggi_permessi_gas($id_gas_table);
            $gas_perm = read_option_gas_text($id_gas_table,"_GAS_PUO_PART_ORD_EST");

            if($gas_perm=="SI"){
                $situazione = "<input $hidden name=box[] value=\"$id_gas_table\" ".$box_selected."> $box_imp";
            }else{
                $situazione = "Condivisione momentaneamente non possibile";
            }
            
            
            if ($id_gas<>$id_gas_table){  
                
                    $h_table .="    <tr class=\"odd\">
                    <th >
                    $gas
                    </th>
                    <td>
                    Utenti : $ute
                    </td>
                    <td>
                    $situazione 
                    </td>
                    </tr>
                    ";
                
            }
        }

        $h_table .="</table>
        ";

        
        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Modifica la partecipazione esterna a questo ordine</h3>
    
        <form class="retegas_form" name="Modifica descrizione" method="POST" action="ordini_form_edit_partecipazione.php">
        
        <div>
        <h4>1</h4>
        <h5 title="'.$help_gas_partecipanti.'">Inf.</h5>
        <label for="gas_partecipanti">Seleziona gli altri GAS che vuoi far partecipare a questo ordine :</label>
        '.$h_table.'
        </div>
  
        <div>
        <h4>2</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Salva le modifiche" align="center" >
        <input type="hidden" name="id_ordine" value="'.$id_ordine.'">
        <input type="hidden" name="do" value="mod">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div>
  

        </form>

        </div>';              


        return $h;      

    } 
    function ordine_render_do_edit_partecipazione($id_ordine,$id_gas){

              
        global $class_debug;
        global $db,$id_user,$box;     
        
        //echo print_r($box);
        //exit;
        
        // controllo tutti i dati
        if(!isset($box)){$e_total++;}
        

        if($e_total==0){

        //PASSO TUTTI I GAS
        $result = $db->sql_query("SELECT * FROM retegas_gas ORDER BY id_gas ASC;");             
         while ($row = mysql_fetch_array($result)){
        
             //capisco il suo livello all'interno dell'ordine
              $level = gas_partecipa_ordine($id_ordine,$row["id_gas"]);
              $val = $row["id_gas"];
              
               switch ($level){

                    
                    //0 = NON C'?
                        //se c'? nella lista BOX allora lo aggiungo
                   case "0":
                        if(in_array($val,$box)){
                              
                              $res_gas = $db->sql_query("SELECT * FROM retegas_gas WHERE id_gas='$val'");
                              $row_gas = $db->sql_fetchrow($res_gas);

                              $result_add = $db->sql_query("INSERT INTO retegas_referenze (id_ordine_referenze, id_utente_referenze, id_gas_referenze, note_referenza, maggiorazione_percentuale_referenza) "
                              ." VALUES ('$id_ordine', '0', '$val', '".$row_gas["comunicazione_referenti"]."', '".$row_gas["maggiorazione_ordini"]."');");                        
                              if(!$result_add){$err++;}
                        }
                        break;
                    
                    //1 = C'? gi?
                        //se manca nella lista box allora lo cancello
                    
                   case "1":
                        
                        if(!in_array($val,$box)){    
                             $result_delete = $db->sql_query("DELETE FROM retegas_referenze WHERE id_ordine_referenze='$id_ordine' AND id_gas_referenze ='$val' LIMIT 1;");
                             if(!$result_delete){$err++;}
                        }
                        break;
                       //2 = C'? gi? e ha gi? il referente
                       //nun se ne fa nulla 

                     }    //switch
            
         }//while
        

             
             if($err==0){$msg="OK";}else{$msg="ERRORE QUERY";}
                                 
             log_me($id_ordine,$id_user,"ORD","MOD","Modificati partecipazioni ",0,"");
        
        }else{

            unset($do);    
            $msg .= "Controlla i dati e riprova<br>";
        }
        //-------------------------- PRESO DA ORDINI ADD

        return $msg;    

    }
    
    //EDIT ORDINE DESCRIZIONE
    function ordine_render_edit_switch_listino($id_ordine){
        global $db;     
        global $id_listino;
        
        (int)$id_ordine;
        

        if(!isset($id_listino)){$id_listino = id_listino_from_id_ordine($id_ordine);}
        
        $id_ditta = ditta_id_from_listino($id_listino);
        
        $result = $db->sql_query("SELECT * FROM retegas_listini WHERE id_ditte='$id_ditta' AND data_valido > NOW()");
        $totalrows = mysql_num_rows($result);
        while ($rows = mysql_fetch_array($result)){
                $idtip = $rows[0];
                $descrizionetip = $rows[1];
                if ($idtip == $id_listino){
                    $input_6 .= "<option value=\"".$idtip ."\" selected=\"selected\" size=\"28\">".$descrizionetip ."  </option>";
                }else{
                    $input_6 .= "<option value=\"".$idtip ."\" size=\"28\">".$descrizionetip ."  </option>"; 
                }
         
        }//end while
 
        $help_listino = "Il listino è considerato compatibile con un altro se:<br>
                         1. Contiene lo stesso numero di articoli<br>
                         2. TUTTI gli articoli hanno lo stesso codice e sono disposti con lo stesso ordinamento.";
        $help_note_switch = "Il messaggio è vivamente consigliato per correttezza nei confronti degli utenti partecipanti";
        
        if(!isset($note_switch)){
            $note_switch ="<p>Gentile partecipante, è stato necessario intervenire sul listino di quest'ordine, cambiando alcuni dati, probabilmente anche i prezzi di alcuni articoli.</p>
            <p>Sei vivamente pregato di controllare sul sito l'importo attuale della tua spesa, in modo da poter decidere eventualmente di variare quanto già prenotato.</p>
            <p>Io, quale referente ordine, rimango a disposizione per ogni chiarimento.</p>
            <p><strong>"._USER_FULLNAME."</strong>, ".gas_nome(_USER_ID_GAS)." (".telefono_from_id(_USER_ID).")</p>
            ";
        }
        
                
        
 $h = '<div class="rg_widget rg_widget_helper">
        <h3>Cambia il listino riferito a questo ordine</h3>
    
        <form class="retegas_form" name="Modifica listino" method="POST" action="ordini_form_edit_switch_listino.php">
        
        <div>
        <h4>1</h4>
        <span>
        <label for="selection">Scegli un listino compatibile</label>
        <select id="selection" name="id_listino">
        '.$input_6.'        
        </select>
        </span>
        <h5 title="'.$help_listino.'">Inf.</h5>    
        </div>
   
        <div>
        <h4>2</h4>
        <h5 title="'.$help_note_switch.'">Inf.</h5>
        <label for="note_switch">Inserisci il messaggio che verrà inviato a chi sta già partecipando all\'ordine per avvisarlo del cambio di listino. <br> NB: la mail parte solo se l\'ordine è già aperto.</label>
        <textarea id="note_switch" class ="ckeditor" name="note_switch" cols="28" style="display:inline-block;">'.$note_switch.'</textarea>
        </div>
   
   
        <div>
        <h4>3</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Cambia il listino" align="center" >
        <input type="hidden" name="id_ordine" value="'.$id_ordine.'">
        <input type="hidden" name="do" value="mod">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div>
  

        </form>

        </div>';              


        return $h;      

    } 
    function ordine_render_do_edit_switch_listino($id_ordine){

              
        global $class_debug;
        global $db,$id_user, $box;     
        global $id_listino;
        

       (int)$id_listino;
       $log = "---------SWITCH LISTINO-------------<br>";
       
       
       $old_listino = id_listino_from_id_ordine($id_ordine) ;
       $log .="Listino VECCHIO =".$old_listino." Listino NUOVO = $id_listino, ID Ordine = $id_ordine<br>"; 
       
         
         if ($old_listino<>$id_listino){
         
         
         $riga=0;
         $qry = "SELECT retegas_articoli.codice,retegas_articoli.id_articoli FROM retegas_articoli WHERE retegas_articoli.id_listini = '$old_listino' ORDER BY retegas_articoli.id_articoli DESC;";
         $ret = $db->sql_query($qry);
         while ($row = mysql_fetch_array($ret)){
            $riga++;
            
            $corrispondenze["old"][$riga] = $row["id_articoli"];
            $corrispondenze["cod"][$riga] = $row["codice"];
            $pacco_old = $pacco_old . $row["codice"];
            //echo "corrispondenze[\"old\"][$riga] : ".$row["id_articoli"]."<br>";
            //echo "corrispondenze[\"cod\"][$riga] : ".$row["codice"]."<br>";    
         }
         $crc_old=crc16($pacco_old);   
         $log .= "CRC OLD: -".$crc_old."-<br>"; 
         
         
         $riga=0;         
         $qry = "SELECT retegas_articoli.codice,retegas_articoli.id_articoli FROM retegas_articoli WHERE retegas_articoli.id_listini = '$id_listino'  ORDER BY retegas_articoli.id_articoli DESC;";
         $ret = $db->sql_query($qry);
         while ($row = mysql_fetch_array($ret)){
            $riga++;
            $corrispondenze["new"][$riga] = $row["id_articoli"];
            $pacco_new = $pacco_new . $row["codice"];
            //echo "corrispondenze[\"new\"][$riga] : ".$row["id_articoli"]."<br>";     
         }
         $crc_new=crc16($pacco_new);
         $log .= "CRC new: -".$crc_new."-<br>";
      
        if ($crc_new==$crc_old){
            $log .= "CRC CHECK : OK <br>";
            //echo "OK CAMBIO -<br>";
            for ($i = 1; $i <= $riga; $i++){
            
            unset($query_new_list);
            unset($result);
                
              //per ogni articolo in OLD cambio TUTTE le referenze a dettaglio_ordini
            $new_articolo = $corrispondenze["new"][$i] ;
            $old_articolo = $corrispondenze["old"][$i] ;
            $log .= "<hr>ART ".$old_articolo."---> ".$new_articolo."<br>";
            
            // CAMBIO NELLA TABELLA ORDINI_DETTAGLIO   
            $query_new_list=("UPDATE retegas_dettaglio_ordini SET retegas_dettaglio_ordini.id_articoli = '$new_articolo' WHERE (retegas_dettaglio_ordini.id_ordine = '$id_ordine') AND (retegas_dettaglio_ordini.id_articoli = '$old_articolo');");    
                        
            $result = $db->sql_query($query_new_list);
            $log .= "Query : ".$query_new_list."<br> Result : ".$result. " - rows affected : ".$db->sql_affectedrows()."<br>";
            
            
            // CAMBIO NELLA TABELLA DISTRIBUZIONE SPESA   
            $query_new_distro=("UPDATE retegas_distribuzione_spesa SET retegas_distribuzione_spesa.id_articoli = '$new_articolo' WHERE (retegas_distribuzione_spesa.id_ordine = '$id_ordine') AND (retegas_distribuzione_spesa.id_articoli = '$old_articolo');");    
                        
            $result = $db->sql_query($query_new_distro);
            $log .= "Query ".$query_new_distro."<br> Result : ".$result. " - rows affected : ".$db->sql_affectedrows()."<br>";
            
            
            
            
            }//ciclo che passa tutti gli articoli
            $vonuovo = valore_totale_ordine_qarr($id_ordine);
            $log .= "<hr>VALORE TOTALE NUOVO : $vonuovo<br>";
            
            
            $res_ord = $db->sql_query("UPDATE retegas_ordini SET id_listini='$id_listino' WHERE id_ordini='$id_ordine' LIMIT 1;");    
            
            log_me($id_ordine,$id_user,"ORD","LIS","Mod. Lis. $id_listino, adesso vale $vonuovo",0,$log);
            //manda_mail("Logger","retegas@altervista.org","ReteGas","retegas.ap@gmail.com","[RETEGAS.AP] Switch listino su ORd. $id_ordine  ",$log);
            $msg ="OK";
            
        }else{
            
        $msg .= "Il listino che si vuole sostituire non e' compatibile con quello attualmente in uso<br> I listini scambiabili devono avere lo stesso numero di articoli e gli STESSI CODICI ARTICOLO FORNITORE, per poter essere scambiati.";
        $e_logical++;
        
            
        }// se i listini sono uguali
             
      
         
         
     }// se il listino e' cambiato 
     else{

            unset($do);    
            $msg .= "Il listino rimarrà lo stesso di prima<br>";
     }
        //-------------------------- PRESO DA ORDINI ADD

        return $msg;    

    }
    
    //INTESTAZIONE PER STAMPE
    function ordine_render_intestazione(){
       global $RG_addr;
        
      $h = "
        <table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
            <td width=\"50%\" align=\"left\">
                <a>
                <img align=\"left\" src=\"".$RG_addr["img_logo"]."\" border=\"0\" width=\"300\" height=\"75\" alt=\"ReteGas.AP\">
                </a>
                
            </td>
            <td style=\"padding-right:10px; text-align:right\">
                            <b>Rete dei GAS dell'Alto Piemonte</b><br>
                            <span>da un'idea ed un progetto
                            del GAS di Borgomanero</span><br> 
                            <span>"._SITE_MAIL_LOG."</span><br>
                            <span>Sviluppo :</span>ma.morez@tiscali.it<br />
            </td>
            </tr>
        </table>
        "; 

        return $h;   
    }
    function ordine_render_intestazione_pdf(){
      $h = "
        <table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
            <td width=\"50%\" align=\"left\">
                <a>
                <img align=\"left\" src=\"../../../gas2/images/rg.jpg\" border=\"0\" width=\"300\" height=\"75\" alt=\"ReteGas.AP\">
                </a>
                
            </td>
            <td style=\"padding-right:10px; text-align:right\">
                            <b>Rete dei GAS dell'Alto Piemonte</b><br>
                            <span>da un'idea ed un progetto
                            del GAS di Borgomanero</span><br> 
                            <span>retegas.ap@gmail.com</span><br>
                            <span>Sviluppo :</span>ma.morez@tiscali.it<br />
            </td>
            </tr>
        </table>
        
        <br>
        <br>
        
        "; 

        return $h;   
    }
    
    
    //VISUALIZZA ORDINI APERTI
    function ordine_render_visualizza_ordini_aperti($id_user,$output,$ref_table=null,$csv_mode=null){

    $gas = id_gas_user($id_user);
    global $db;    
        
    //$query = "SELECT * FROM retegas_ordini WHERE data_apertura<now() AND data_chiusura>now() AND id_stato='2' ORDER BY data_chiusura ASC";
    $query="SELECT retegas_ordini.id_ordini, 
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
            WHERE (((retegas_ordini.data_chiusura)>NOW())
            AND ((retegas_ordini.data_apertura)<NOW()) 
            AND ((retegas_referenze.id_gas_referenze)=$gas))
            ORDER BY retegas_ordini.data_chiusura ASC ;";
    
    $res = $db->sql_query($query);
    
    if($csv_mode=="ON"){
    while($row = mysql_fetch_array($res)) { 
    $content_file .= $row['id_ordini'] . ',' . $row['descrizione_ordini'] . ',' . $row['data_chiusura'] . "\r\n"; 
    } 
    return $content_file;
    exit;
        
    }
    
    
    $n_righe = $db->sql_numrows();
    
    while ($row = mysql_fetch_array($res))
    
     
    {
    $a_id_ordine[]          =$row["id_ordini"];
    if($row["id_ordini"]==188){
        $s_id_ordine[]          = ' class="rosso"';
        $s_proprietario[]          = ' class="big_font"';    
    }else{
        $s_id_ordine[]          = '';
        $s_proprietario[]          = '';
    }
    if($row["id_ordini"]==148){
        $s_row[]                = ' class="odd"';    
    }else{
        $s_row[]                = '';
    }
    $a_descrizione_ordine[] =$row["descrizione_ordini"];
    $a_proprietario[]       =fullname_from_id($row["id_utente"]);
    $a_data_chiusura[]      =conv_datetime_from_db($row["data_chiusura"]);
    
    }
    
    $h = '<h3>Ordini Aperti</h3>
          <table id="'.$ref_table.'">        
          <tbody>';
    
    for($i = 0; $i < $n_righe; $i++){
    $h .='
          <tr'.$s_row[$i].'>
            <td'.$s_id_ordine[$i].'><a href="#">'.$a_id_ordine[$i].'</a></td>
            <td>'.$a_descrizione_ordine[$i].'</td>
            <td '.$s_proprietario[$i].'>'.$a_proprietario[$i].'</td>
            <td>'.$a_data_chiusura[$i].'</td>
          </tr>';      
    }
    
    $h.='</tbody>
         </table>';
    
    return $h;    
        
    }
    function ordine_render_visualizza_ordini_aperti_full($ref_table){
      // TITOLO TABELLA
      global $gas,$id_user,$RG_addr;
      global $sparkline_rangemax;
      
      $titolo_tabella="Ordini aperti - <span class=\"small_link\">Le operazioni sugli ordini si possono effettuare dalle loro singole schede</span>";
      
       // Campi e intestazioni
            // SQL NOMI DEI CAMPI
      $d1="id_ordini";
      $d2="descrizione_ordini";
      $d3="descrizione_listini";
      $d4="descrizione_ditte";
      $d5="data_chiusura";
      $d6="descrizione_gas";
      $d7="id_gas_referenze";
      $d8="userid";
      $d9="fullname";
      $d10="id_utente";
        
      
      
       // INTESTAZIONI CAMPI
      $h1="id_articoli";
      $h2="Descrizione";
      $h3="Listino";
      $h4="Ditta";
      $h5="Aperto fino al";
      $h6="GAS";
      $h7="id_gas_referenze";
      $h8="Referente";
      $h9="Referente";
      $h10="id_utente";
      $h11="Opzioni";
      $h12="Valore totale";
      $h13="Mia spesa";
      
      
      //  LARGHEZZA E CLASSI COLONNE
      $col_1="width=\"5%\" class=\"gas_c1\"";
      $col_2="width=\"*\" class=\"gas_c1\"";
      $col_3="width=\"20%\" class=\"gas_c1\" style=\"text-align:left\"";
      $col_4="width=\"10%\" class=\"gas_c1\"";
      $col_5="width=\"15%\" class=\"gas_c1\"";
      $col_6="width=\"5%\" class=\"gas_c1\"";
      $col_7="width=\"10%\" class=\"gas_c1\"";
      $col_8="width=\"20%\" class=\"gas_c1\"";
      $col_9="width=\"5%\" class=\"gas_c1\"";
      $col_10="width=\"5%\" class=\"gas_c1\"";  
      $col_11="style=\"vertical-align:middle\" ";    //opzioni
      $col_12="width=\"5%\" class=\"gas_c1\"";
      $col_13="width=\"5%\" class=\"gas_c1\"";

      
      // QUERY
      
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
            WHERE (((retegas_ordini.data_chiusura)>NOW())
            AND ((retegas_ordini.data_apertura)<NOW()) 
            AND ((retegas_referenze.id_gas_referenze)=$gas))
            ORDER BY retegas_ordini.data_chiusura ASC ;";
      
      //echo $my_query;
      
      // COSTRUZIONE TABELLA  -----------------------------------------------------------------------
      global $db;

      $result = $db->sql_query($my_query);
      $numrows = $db->sql_numrows($result);
      
      //Echo "RIGHE _".$numrows."<br>";    
      
          
      $h_table .= "<div class=\"rg_widget rg_widget_helper\"> 
      <h3>$titolo_tabella</h3>
      <table id=\"$ref_table\" >        
      <thead>
        <tr>
            <th>$h9</th>        
            <th>$h2</th>
            <th>Info</th>
            <th>Chiude il</th>
            <th>$h6</th>
            
            <th>$h12</th>
            <th>$h13</th>
            <th>CASSA NECESSARIA</th>
            <th>OPZ</th>          
        </tr>
        </thead>
        <tbody>
        ";
  
        //scopro la data minima e massima e la cifra massima
        
        $min_data=date("d/m/Y");
        $max_valore = 0;
        $max_giorni =0;
        //echo gas_mktime($min_data)." - MIN DATA <br>";
        while ($row_stat = mysql_fetch_array($result)){ 
            //echo $row_stat[1]."<br>";
            $data_db = conv_date_from_db($row_stat["data_apertura"]);
            //echo $data_db."<br>";
            //echo gas_mktime($data_db)." - data mk <br>";
            //echo gas_mktime(date("d/m/Y"))." - OGGI <br>";
            //echo gas_mktime(date("d/m/Y"))-gas_mktime($data_db)." - DIFF <br>";
            //echo (gas_mktime(date("d/m/Y"))-gas_mktime($data_db))/(60*60*24)." - DIVISO 60*60*24 <br>";    
            
            $diff =  intval((gas_mktime(date("d/m/Y"))-gas_mktime($data_db))/(60*60*24));
            
            if($diff>$max_giorni){$max_giorni=$diff;}
            if(gas_mktime($data_db)<gas_mktime($min_data)){$min_data=$data_db;}
            $valore_questo_ordine = valore_totale_ordine($row_stat[0]);
            if($valore_questo_ordine>$max_valore){$max_valore=$valore_questo_ordine;}
        }
        $max_giorni++;
        
        
        //echo "Min data : ".$min_data."<br>";
        //echo "Giorni : ".$max_giorni."<br>";
        //echo "Max valore : ".$max_valore."<br>"; 
        //--------------------------------------------
       if($numrows>0){
            mysql_data_seek($result, 0);
       }
       $riga=0;  
         while ($row = mysql_fetch_array($result)){
         $riga++;
              $c1 = $row["$d1"];
              $c2 = $row["$d2"];
              $c3 = $row["$d3"];
              $c4 = $row["$d4"];
              $c5 = conv_datetime_from_db($row["$d5"]);
              $c6 = $row["$d6"];
              $c7 = $row["$d7"];
              $c8 = $row["$d8"];
              $c9 = $row["$d9"];
              $c10 = $row["$d10"];
              $c_listini = $row["id_listini"];
              $c_ditte = $row["id_ditte"];
              $c_tipologia = tipologia_nome_from_listino($c_listini);
              $c12 = _nf(valore_totale_ordine($c1));
              $c13 = _nf(valore_totale_mio_ordine($c1,$id_user));
              

              
              
        $blacklist ="";       
        
        if($c9=="Retegas.AP"){
            //echo "C9 = $c9<br>";
            
            //TODO sistemare questa cagata
            $c9 = " <br>
                    <a class=\"small awesome beige\" href=\"".$RG_addr["ordine_diventa_referente"]."?id_ordine=$c1\">
                    Diventa referente
                    </a>
                    <br>
                    ";
            if(_USER_PERMISSIONS & perm::puo_vedere_tutti_ordini){
                $blacklist = "<a class=\"awesome black option\" href=\"?do=bl&id_ordine=".mimmo_encode($c1)."\">N</a>";
            }        
        }
        
        if ($c10==$id_user) {
            $c9="<div class=\"campo_mio\">            
                    $c9                    
                 </div>";
            //$c15="<div class=\"campo_mio\">$c1</div>";        
             $c15=$c1; 
        }else{
            $c9="<a href=\"".$RG_addr["pag_users_form"]."?id_utente=".mimmo_encode($c10)."\">            
                    $c9                    
                 </a>";
             $c15=$c1; 
            //$c15=$c1;
        }
          
            
      //  if(is_integer($riga/2)){  
      //      $h_table.= "<tr class=\"odd $extra\">";    // Colore Riga
      //  }else{
            $h_table.= "<tr class=\"$extra\">";    
     //   }
        
        
        
       // $valori_sparkline = crea_grafico_sparkline($c1,$min_data,$max_giorni,$max_valore);
       // $range_max = $max_valore;
       // $sparkline_rangemax = $range_max;
        //echo "VAL ".$valori_sparkline."<br>";            
       // $sparkline_data="<span class='inlinesparkline'>".$valori_sparkline."</span>";            
        
        $info = "   <p>Ditta: <a href='".$RG_addr["form_ditta"]."?id_ditte=$c_ditte'>$c4</a><br>
                    Listino: <a href='".$RG_addr["listini_scheda"]."?id_listini=$c_listini'>$c3</a><br>
                    Tipologia: $c_tipologia</p>";
        
        $prog_value = (int)avanzamento_ordine_from_id_ordine($c1);            
        
        $data_prog = "{ Current: $prog_value, aBackground: '#F51010' }";
        
        if(($prog_value >= 0) AND ($prog_value < 20)){
            $data_prog = "{ Current: $prog_value, aBackground: '#29F213' }";    
        }
        if(($prog_value >= 20) AND ($prog_value < 40)){
            $data_prog = "{ Current: $prog_value, aBackground: '#D0F114' }";    
        }
        if(($prog_value >= 40) AND ($prog_value < 60)){
            $data_prog = "{ Current: $prog_value, aBackground: '#F3D112' }";    
        }
        if(($prog_value >= 60) AND ($prog_value < 80)){
            $data_prog = "{ Current: $prog_value, aBackground: '#F54910' }";    
        }
        
        $bacino_totale = ordine_bacino_utenti($c1);
        $bacino_partecipanti = ordine_bacino_utenti_part($c1);
        
       // $sparkline_data_pie ="<span class='sparkline_pie'>".$bacino_totale.",".$bacino_partecipanti."</span>";
        
        
        //SE l'ordine non è in blacklist lo visualizzo
        if(check_option_order_blacklist(_USER_ID_GAS,$c1)==0){
        
            $h_table.= "<td width=\"10%\">$c9</td>
                        
                        <td style=\"text-align:left;\"><a href=\"".$RG_addr["ordini_form"]."?id_ordine=$c1\">$c2 ($c15)</a></td>    
                        <td><a class=\"awesome celeste small\" title=\"$info\">Info</a></td>                
                        <td>$c5<div class=\"progressbar $data_prog\"></div></td>
                        <td width=\"15%\">$c6</td>
                        
                        <td width=\"5%\">$c12</td>
                        <td width=\"5%\">$c13</td>
                        <td width=\"5%\">".ordini_field_value($c1,"solo_cassati")."</td>  
                        <td width=\"5%\">$blacklist</td>  

                    </tr>
                ";
            }   
         }//end while  <td width=\"4%\" style=\"vertical-align:middle\">$sparkline_data_pie</td>    <td style=\"vertical-align:bottom;\">$sparkline_data</td>

         $h_table.="</tbody>
                    </table>
                    </div>
         ";
      // END TABELLA ----------------------------------------------------------------------------
    
        return $h_table;
    
}
    
    //PARTECIPAZIONE ORDINE
    function ordine_render_partecipazione($ref_table,$id_ordine){
         
        

      global $db;
      $h .= " <div class=\"rg_widget rg_widget_helper\">
                <h3>Lista partecipanti</h3>
                <table id=\"$ref_table\">
                    <thead>     
                        <tr class=\"destra\"> 
                            <th class=\"sinistra\">Utente</th>
                            <th class=\"sinistra\">Gas</th>
                            <th>Netto</th>
                            <th>Trasporto</th>
                            <th>Gestione</th>
                            <th>Lordo Pubblico</th>
                            <th>Costo GAS</th>
                            <th>% GAS</th>
                            <th>Lordo Privato</th> 
                        </tr>
                    <thead>
                    <tbody>";


       $col_5 = " class=\"destra\" ";             
                    
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
                                    GROUP BY
                                    retegas_dettaglio_ordini.id_utenti
                                    ORDER BY Sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) DESC");


       $riga=0;  
         while ($row = $db->sql_fetchrow($result)){
         


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
              
              $costo_trasporto = valore_costo_trasporto_ordine_user($id_ordine,$id_ut);
              $costo_gestione = valore_costo_gestione_ordine_user($id_ordine,$id_ut);
              $costo_mio_gas = valore_costo_mio_gas($id_ordine,$id_ut);
              $costo_maggiorazione = valore_costo_maggiorazione_mio_gas($id_ordine,$id_ut);
              $totale_lordo = $costo_trasporto +
                              $costo_gestione +
                              $costo_mio_gas +
                              $costo_maggiorazione +
                              $importo_totale;    
              $totale_pubblico = $importo_totale +
                                 $costo_gestione +
                                 $costo_trasporto;
                                 
              
              $importo_totale = _nf($importo_totale);
              $totale_lordo = _nf($totale_lordo);
              $totale_pubblico = _nf($totale_pubblico);
              $costo_trasporto = _nf($costo_trasporto);
              $costo_gestione = _nf($costo_gestione);
              $costo_maggiorazione = _nf($costo_maggiorazione);
              $costo_mio_gas = _nf($costo_mio_gas);
              $somma_articoli = round($somma_articoli,2);
              
              $h.= "<tr>";    
                $h.= "<td class=\"sinistra\">$nome_ut</td>"; 
                $h.= "<td class=\"sinistra\">$gas_app</td>";
                //$h.= "<td $col_5>$conto_articoli</td>";
                //$h.= "<td $col_5>$somma_articoli</td>";
                $h.= "<td $col_5>$importo_totale</td>";
                $h.= "<td $col_5>$costo_trasporto</td>";
                $h.= "<td $col_5>$costo_gestione</td>";
                $h.= "<td $col_5><b>$totale_pubblico</b></td>";
                $h.= "<td $col_5>$costo_mio_gas</td>";
                $h.= "<td $col_5>$costo_maggiorazione</td>";
                $h.= "<td $col_5><b>$totale_lordo</b></td>";
              $h .="</tr>";

         }//end while


         $totalone_articoli = number_format($totalone_articoli,2,",","");
         $totalone = number_format($totalone,2,",","");
         
         $h.= "</tbody>
               <tfoot>
                <tr class=\"total destra\">
                    <th>&nbsp;</th>
                    <th class=\"sinistra\">Somme:</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
               </tfoot>
               </table>";

  return $h;

  }    
    function ordine_render_cronologia($ref_table,$id_ordine){
         
        

      global $db;
      global $euro;
      
      $h .= " <div class=\"rg_widget rg_widget_helper\">
                <h3>Cronologia ordini (tutti i gas)</h3>

                <table id=\"$ref_table\">
                    <thead>     
                        <tr>
                            <th>Data e Ora</th> 
                            <th>Utente</th>
                            <th>Gas</th>
                            <th>Articolo</th>
                            <th>Descrizione</th>
                            <th>Quantità</th> 
                        </tr>
                    <thead>
                    <tbody>";


       $col_5 = "style=\"text-align:right;\"";             
                    
       $result = $db->sql_query("SELECT
                                retegas_dettaglio_ordini.data_inserimento,
                                maaking_users.userid,
                                maaking_users.fullname,
                                retegas_gas.descrizione_gas,
                                maaking_users.id_gas,
                                retegas_articoli.codice,
                                retegas_articoli.descrizione_articoli,
                                retegas_dettaglio_ordini.qta_ord,
                                retegas_articoli.u_misura,
                                retegas_articoli.misura,
                                retegas_articoli.prezzo
                                FROM
                                retegas_dettaglio_ordini
                                Inner Join retegas_articoli ON retegas_dettaglio_ordini.id_articoli = retegas_articoli.id_articoli
                                Inner Join maaking_users ON retegas_dettaglio_ordini.id_utenti = maaking_users.userid
                                Inner Join retegas_gas ON maaking_users.id_gas = retegas_gas.id_gas
                                WHERE
                                retegas_dettaglio_ordini.id_ordine =  '$id_ordine'
                                ORDER BY
                                retegas_dettaglio_ordini.data_inserimento DESC");


       $riga=0;  
         while ($row = $db->sql_fetchrow($result)){
         

              $dataora = conv_datetime_from_db($row["data_inserimento"]);
              $id_ut = $row["userid"];
              $nome_ut = $row['fullname'];
              $gas_app = $row['descrizione_gas'];
              $id_gas_app = $row['id_gas'];
              $codice = $row['codice'];
              $descrizione = $row['descrizione_articoli'];
              $q_ord = _nf($row["qta_ord"]);
              $u_mis = $row["u_misura"];
              $mis = $row["misura"];
              $prezzo = _nf($row["prezzo"]);

              
              $h.= "<tr>";
                $h.= "<td $col_1>$dataora</td>";  
                $h.= "<td $col_1>$nome_ut</td>"; 
                $h.= "<td $col_1>$gas_app</td>";
                $h.= "<td $col_1>$codice</td>";
                $h.= "<td $col_1>$descrizione<br><span class=\"small_link\">($u_mis $mis x $euro $prezzo)</span></td>";
                $h.= "<td $col_5>$q_ord</td>";
              $h .="</tr>";

         }//end while


         $totalone_articoli = number_format($totalone_articoli,2,",","");
         $totalone = number_format($totalone,2,",","");
         
         $h.= "</tbody>
               <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
               </tfoot>
               </table>
               </div>";

  return $h;

  }
    function ordine_render_tabella_gas_partecipanti($ref_table,$id_ordine){
         
        
      global $RG_addr;
      
      global $db,$euro;
      $h .= " <div class=\"rg_widget rg_widget_helper\">
                <div style=\"margin-bottom:16px;\">Lista GAS partecipanti</div>
                <table id=\"$ref_table\">
                    <thead>     
                        <tr>
                            <th class=\"sinistra\">&nbsp</th> 
                            <th class=\"sinistra\">Gas</th>
                            <th class=\"sinistra\">Condizione</th>
                            <th class=\"sinistra\">Referente</th>
                            <th class=\"sinistra\">Utenti Partecipanti</th>
                            <th class=\"destra\">Importo netto</th> 
                        </tr>
                    <thead>
                    <tbody>";


       $col_5 = "style=\"text-align:right;\"";             
                    
       $result = $db->sql_query("SELECT
                                    *
                                    FROM
                                    retegas_gas");


       $riga=0;  
         while ($row = $db->sql_fetchrow($result)){
         
             
             
             

              $gas = $row["descrizione_gas"];
              $stato = gas_partecipa_ordine($id_ordine,$row["id_gas"]);
              $referente = "";
              $parte = ""; 
              $netto = "";
              
              switch ($stato){
              case "0":
                            $stato_gas = "<cite>ESCLUSO</cite>";
                            $img = '<IMG SRC="'.$RG_addr["img_pallino_grigio"].'" ALT="Partecipa" style="height:16px; width:16px;vertical_align:middle;border=0;" >';
                            break;
                       case "1":
                            $stato_gas = "INVITATO";
                            $img = '<IMG SRC="'.$RG_addr["img_pallino_marrone"].'" ALT="Partecipa" style="height:16px; width:16px;vertical_align:middle;border=0;" >';
                            break;                            
                       case "2":
                            $stato_gas = "<strong>PARTECIPANTE</strong>";
                            $referente = fullname_referente_ordine_proprio_gas($id_ordine,$row["id_gas"]);
                            $id_referente =mimmo_encode(id_referente_ordine_proprio_gas($id_ordine,$row["id_gas"]));
                            $img = '<IMG SRC="'.$RG_addr["img_pallino_verde"].'" ALT="Partecipa" style="height:16px; width:16px;vertical_align:middle;border=0;" >';
                            $ut_part = ordine_bacino_utenti_part_gas($id_ordine,$row["id_gas"]);
                            $bacino = gas_n_user($row["id_gas"]);
                            $percent_part = round(($ut_part/$bacino)*100,2);
                            $netto = _nf(valore_totale_mio_gas($id_ordine,$row["id_gas"]))." ".$euro;
                            $parte = "<strong>$percent_part%</strong> ($ut_part utenti)";
                            break;
                }
              
              
              
              $h.= "<tr>";
                $h.= "<td $col_1>$img</td>";  
                $h.= "<td $col_1><a href=\"".$RG_addr["gas_ordine_riepilogo"]."?id_ordine=$id_ordine&id_gas=".$row["id_gas"]."\">$gas</a></td>"; 
                $h.= "<td $col_2>$stato_gas</td>";
                $h.= "<td $col_5><a href=\"".$RG_addr["user_form_public"]."?id_utente=$id_referente\">$referente</a></td>";
                $h.= "<td $col_5>$parte</td>";
                $h.= "<td $col_5>$netto</td>";
              $h .="</tr>";

         }//end while


         
         
         $h.= "</tbody>
               <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Somme:</th>
                    <th $col_5>&nbsp;</th>
                    <th $col_5>&nbsp;</th>
                    <th $col_5>&nbsp;</th>
                </tr>
               </tfoot>
               </table>";

  return $h;

  }
    
    
    //PARTECIPA All'ORDINE
    function ordine_render_partecipa($ref_table,$id,$id_user){
    $euro = "&#0128";
    global $RG_addr,$db;
    
         
         
         // table_sorter_name NOME DELLA TABELLA DA ORDINARE
         
         
         
         $valore = id_listino_from_id_ordine($id);
         $ordine = $id;
         $ord_query = "ORDER BY retegas_articoli.descrizione_articoli ASC,
                                retegas_articoli.articoli_opz_1 ASC,
                                retegas_articoli.articoli_opz_2 ASC,
                                retegas_articoli.articoli_opz_3 ASC";
         $cod_tag = "cod_desc";
         $cod_forn_tag = "cod_forn_asc";
         $descrizione_tag = "descrizione_asc";
         
         //SE ? presente SOLO UN ARTICOLO la tabella ? composta solo dall'articolo selezionato
         if(!empty($solo_un_articolo)){
             $solo_un_articolo = "AND (((retegas_listini.id_articoli)= '$solo_un_articolo'))";
         }
         

         
            $qry="SELECT retegas_articoli.id_articoli, 
            retegas_articoli.codice, 
            retegas_articoli.descrizione_articoli, 
            retegas_articoli.prezzo, 
            retegas_articoli.u_misura, 
            retegas_articoli.misura, 
            retegas_listini.id_listini,
             retegas_listini.descrizione_listini, 
             maaking_users.userid, 
             maaking_users.username, 
             retegas_tipologia.id_tipologia, 
             retegas_tipologia.descrizione_tipologia, 
             retegas_ditte.id_ditte, 
             retegas_ditte.descrizione_ditte, 
             retegas_articoli.qta_scatola, 
             retegas_articoli.qta_minima,
             retegas_articoli.articoli_note,
             retegas_articoli.articoli_unico,
             retegas_articoli.articoli_opz_1,
             retegas_articoli.articoli_opz_2,
             retegas_articoli.articoli_opz_3
                  FROM ((((retegas_articoli LEFT JOIN retegas_listini ON retegas_articoli.id_listini = retegas_listini.id_listini) LEFT JOIN maaking_users ON retegas_listini.id_utenti = maaking_users.userid) LEFT JOIN retegas_tipologia ON retegas_listini.id_tipologie = retegas_tipologia.id_tipologia) LEFT JOIN retegas_ditte ON retegas_listini.id_ditte = retegas_ditte.id_ditte) LEFT JOIN retegas_dettaglio_ordini ON retegas_articoli.id_articoli = retegas_dettaglio_ordini.id_articoli
                  GROUP BY retegas_articoli.id_articoli, retegas_articoli.codice, retegas_articoli.descrizione_articoli, retegas_articoli.prezzo, retegas_articoli.u_misura, retegas_articoli.misura, retegas_listini.id_listini, retegas_listini.descrizione_listini, maaking_users.userid, maaking_users.username, retegas_tipologia.id_tipologia, retegas_tipologia.descrizione_tipologia, retegas_ditte.id_ditte, retegas_ditte.descrizione_ditte, retegas_articoli.qta_scatola, retegas_articoli.qta_minima
                  HAVING (((retegas_listini.id_listini)=$valore))
                  $ord_query;";    
            $result = $db->sql_query($qry);
            $totalrows = mysql_num_rows($result);

        
 
      
        
        
        $output_html = $h. "         
        <div class=\"rg_widget rg_widget_helper\">
        <h3>Articoli ordinabili</h3>";

        $output_html .="<form method=\"POST\" action=\"\">"; 
        $output_html .= "<table id=\"$ref_table\">";
        $output_html .= "<thead>
                         <tr>";
        //    <th width=\"6%\"><a href=\"ordini_aperti_form_partecipa.php?id=$id&ordinamento=$cod_tag\">Cod. GASAP</a></th>
       //                     <th width=\"7%\"><a href=\"ordini_aperti_form_partecipa.php?id=$id&ordinamento=$cod_forn_tag\">Cod. Art. Fornitore</a></th>
       //                     <th><a href=\"ordini_aperti_form_partecipa.php?id=$id&ordinamento=$descrizione_tag\">Descrizione</a></th>             
    
        
                         
        $output_html .="    
                            <th width=\"7%\">Cod. Art. Fornitore</th>
                            <th>Descrizione</th>
                            
                            <th width=\"13%\">Prezzo x quantità</th>
                            <th width=\"5%\">Q.<br>Scat.</th>  
                            <th width=\"5%\">Q.<br>Min </th>  
                            
                            <th width=\"16%\" class=\"destra\">Ordinativi</th>
                            <th>T.Riga</th>
                         </tr>
                         </thead>
                         <tbody>
                         ";
         
 
       $riga=0;       // Contatore per pari e dispari e per id_riga
         
         while ($row = mysql_fetch_array($result)){
         $id_box++;
         
         
              $c0 = $row["id_articoli"]; //id_articoli
              $c1 = $row["codice"]; //codice
              $c2 = $row["descrizione_articoli"]; //descrizione_articolo
              $c3 = (float)$row[3]; //prezzo
              $c4 = $row[4]; //U_misura
              $c5 = $row[5]; //misura 
              $c6 = $row[6]; //id_listini
              $c7 = $row[7]; //descrizione_listini
              $c8 = $row[8]; //userid
              $c9 = $row[9]; //username
              $c10 = $row[10]; //id_tipologia
              $c11 = $row[11]; //descrizione_tipologia
              $c12 = $row[12]; //id_ditte
              $c13 = $row[13]; //descrizione_ditte
              $c14 = (float)round($row[14],2); //qta scatola  
              $c15 = (float)round($row[15],2); //qta minima
              $c17 = strip_tags($row[16]); //qta minima
              $c18 = $row["articoli_unico"];
        //---------------Controllo se articolo doppio
            $ar_dopp =$db->sql_query("SELECT Count(retegas_dettaglio_ordini.id_articoli) AS ConteggioDiid_articoli, 
                                      Sum(retegas_dettaglio_ordini.qta_ord) AS SommaDiqta_ord,
                                      retegas_dettaglio_ordini.id_utenti,
                                      retegas_dettaglio_ordini.id_amico,
                                      retegas_dettaglio_ordini.id_ordine,
                                      retegas_dettaglio_ordini.id_articoli                                      
                                      FROM retegas_dettaglio_ordini
                                      GROUP BY retegas_dettaglio_ordini.id_utenti, retegas_dettaglio_ordini.id_amico, retegas_dettaglio_ordini.id_ordine, retegas_dettaglio_ordini.id_articoli
                                      HAVING (((retegas_dettaglio_ordini.id_utenti)='$id_user') AND ((retegas_dettaglio_ordini.id_amico)='0') AND ((retegas_dettaglio_ordini.id_ordine)='$ordine') AND ((retegas_dettaglio_ordini.id_articoli)='$c0'));");
            
            $r_ar_dopp = mysql_fetch_row($ar_dopp);
            $c16 = $r_ar_dopp[1];
            $nascondi="";
            
            $scatole_intere = (int)q_scatole_intere_articolo_ordine($ordine,$c0);
            $avanzo_articolo = (float)round(q_articoli_avanzo_articolo_ordine($ordine,$c0),2);
            
            
            $per_completare_scatola ="";
            
            if($scatole_intere==0){
                //Se ? la prima scatola
                if($avanzo_articolo>0){
                    $per_completare_scatola = ($row["qta_scatola"] - $avanzo_articolo);
                    if($c16>0){
                        //Se sono io che ho ordinato
                        $colore = "campo_alert_red";
                        $per_completare_scatola = " <span style=\"color:rgba(255,0,10,1);\">(<strong>$per_completare_scatola</strong> per chiudere la prima scatola)</span>";
                    }else{
                        //Se sono altri che hanno ordinato
                        $colore = "campo_alert";
                        $per_completare_scatola = " <span style=\"color:rgba(255,0,10,1);\">(<strong>$per_completare_scatola</strong> per chiudere la prima scatola)</span>";
                    }
                }else{
                   // Nessun articolo ordinato da nessuno
                   $colore ="";    
                }                            
            }else{
                //Se ci sono gi? scatole
                if($avanzo_articolo>0){
                    $per_completare_scatola = ($row["qta_scatola"] - $avanzo_articolo);
                    if($c16>0){
                        //Se sono io che ho ordinato
                        $colore = "campo_alert_red";
                        $per_completare_scatola = " <span style=\"color:rgba(255,0,10,1);\">(<strong>$per_completare_scatola</strong> per chiudere un'altra scatola)</span>";
                        
                    }else{
                        //Se sono altri che hanno ordinato
                        $colore = "campo_alert";
                        $per_completare_scatola = " <span style=\"color:rgba(255,0,10,1);\">(<strong>$per_completare_scatola</strong> per chiudere un'altra scatola)</span>";

                    }
                }else{
                   // Nessun articolo ordinato da nessuno
                   $colore ="";     
                }
                
            }
            
            
            
            
            
            
      
            
            if(empty($r_ar_dopp[0])){
               // se non ? stato ancora ordinato nessun articolo
               //echo "ARTICOLO Doppio ".$r_ar_dopp[0]."<br>";
               // NUOVO PEZZO
               // CONTROLLO SE E' UN ARTICOLO COMPOSTO
               // SE E' COMPOSTO PER ORA LO NASCONDO
               
               
               if((!empty($row["articoli_opz_1"]))){
                   // Ci devono essere tutte le OPZ1 compilata, altrimenti non funczione
                   
                   if ($codice_attuale<>$row["descrizione_articoli"]){
                            $mostra_intestazione = "SI";
                   }else{
                            $mostra_intestazione = "NO";
                   }
                   
                   
                   $elemento_nascosto ++;
                   $nascondi = "ui-helper-hidden";
                   
                   $codice_attuale = $row["descrizione_articoli"];
                   // se cambia il codice articolo allora inserisco una riga riepilogativa
                   
           
               }else{
                   //$elemento_nascosto =0;
                   $nascondi = "";
                   $mostra_intestazione = "NO";
               }
               
               if ($mostra_intestazione=="SI"){
                
                   
                   
                   
                   //echo "Elemento nascosto = $elemento_nascosto, Cod.attuale = $codice_attuale, id_listini =".$row["id_listini"]."<br>";
                   //COSTRUISCO LA UL LI
                   $query_ul = "SELECT retegas_articoli.*
                                FROM retegas_articoli
                                WHERE retegas_articoli.descrizione_articoli='".$row["descrizione_articoli"]."'
                                AND retegas_articoli.id_listini='".$row["id_listini"]."'
                                ORDER BY
                                retegas_articoli.articoli_opz_1 ASC,
                                retegas_articoli.articoli_opz_2 ASC,
                                retegas_articoli.articoli_opz_3 ASC;";
                   $resu = $db->sql_query($query_ul);
                   
                   $sulli = "<a href=\"#\" id=\"selector_".$row["id_articoli"]."\">".$row["descrizione_articoli"]."</a>
                   <div id=\"content_".$row["id_articoli"]."\" class=\"ui-helper-hidden\">
                   <ul>
                   ";
                   
                   $nuova_riga=1;
                   $conto =0;
                   unset ($aulli_op1);
                   unset ($aulli_op2);
                   unset ($aulli_op3);
                   unset ($aulli_art);
                   
                   while ($row_ulli = mysql_fetch_array($resu)){     
                   $aulli_op1[]= $row_ulli["articoli_opz_1"];
                   $aulli_op2[]= $row_ulli["articoli_opz_2"]; 
                   $aulli_op3[]= $row_ulli["articoli_opz_3"];
                   $aulli_art[]= $row_ulli["id_articoli"];
                   $conto++; 
                   }
                   //echo  "OP 1: ".$row_ulli["articoli_opz_1"]." , op2:".$row_ulli["articoli_opz_2"]." , op3;".$row_ulli["articoli_opz_3"]."<br>";
                   for($i=0; $i<$conto ;$i++){
                   $op1=$aulli_op1[$i];
                   $op2=$aulli_op2[$i];
                   $op3=$aulli_op3[$i];
                   
                   $op1p=$aulli_op1[$i-1];
                   $op2p=$aulli_op2[$i-1];
                   $op3p=$aulli_op3[$i-1];
                   
                   $op1f=$aulli_op1[$i+1];
                   $op2f=$aulli_op2[$i+1];
                   $op3f=$aulli_op3[$i+1];       
                   
                   
                   if ($op1<>$op1p){
                   $sulli .="<li><a href=\"#\">$op1</a>   
                                <ul>
                   ";    
                   }
                   if ($op2<>$op2p){
                   $sulli .="<li><a href=\"#\">$op2</a>
                                <ul>
                   ";    
                   }
                   $sulli .= "<li><a href=\"".$aulli_art[$i]."\">$op3</a></li><! OP3 !>
                     ";   
                   if ($op2<>$op2f){
                   $sulli .="</ul>
                         </li>
                   ";
                   }
                   if ($op1<>$op1f){
                   $sulli .="</ul>
                         </li>
                   ";
                   }
                   
                   
                   
                   
                   }
                    
                   
                   
                   
                   $sulli .= "</ul>       
                   ";
                   $descri = $row["descrizione_articoli"];
                   $sulli .="
                            <script type=\"text/javascript\">
                            $(document).ready(function(){
                                                $('#selector_".$row["id_articoli"]."').menu({
                                                    content: $('#content_".$row["id_articoli"]."').html()
                                                            
                                                });
                                            });
                           </script>
                           </div>";
                   
                   
                   
                   unset($resu);
                   
                   $output_html .= '<tr class="raggruppato">
                                    
                                    <td>-----</td>
                                    <td style="text-align:left;">'.$sulli.' (n.'.$conto.' varianti)</td>
                                    
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>';
                                       
               }
               
               // NUOVO PEZZO
               
               $c_costo_hidden="<span id=\"soldi_art_$id_box\" style =\"display:none;\"></span>";
               
               
             
                $url_ass=$RG_addr["ordini_mod_ass_new"]."?id_articolo=$c0&id_ordine=$ordine"; //&n_riga=
                $ass= "<a class=\"option blue awesome assignment\" style=\"display:none\" href=\"$url_ass\"  onclick=\"is_edited=false;\">M</a>";

              
               
               $c20="
               $ass 
               <a href=\"#\" class=\"click_plus_$id_box small awesome transparent button\">+</a>
               <input type=\"text\" name=box_value[] value=\"0\" size=\"2\" id=\"textbox_$id_box\" class=\"now_ordered\" style=\"background-color: #FFFFFF; border:1px solid grey; font-weight:normal; text-align:center\">
               <a href=\"#\" class=\"click_minus_$id_box small awesome transparent button\">-</a>
               <input type=\"hidden\" name=box_id[] value=$c0>
               <input type=\"hidden\" name=box_price[] value=$c3>
               <input type=\"hidden\" name=box_q_att[] value=$c16>
               <input type=\"hidden\" name=box_q_min[] value=$c15>
               <input type=\"hidden\" name=box_q_uni[] value=$c18>
               ".$tb_plus_toglimi
               .$c_costo_hidden;
               $spesa_attuale=0;
               $c21="";
               
            }else{
                
               // if(_USER_PERMISSIONS & perm::puo_gestire_retegas){
                //    if($c18<>"1"){
                //        $url_ass=$RG_addr["ordini_mod_ass_new"]."?id_articolo=$c0&id_ordine=$ordine"; //&n_riga=
                //    }else{
                //        $url_ass=$RG_addr["ordini_mod_uni_new"]."?id_articolo=$c0&id_ordine=$ordine"; //&n_riga=   
                //    }
                //    $ass= "<a class=\"option blue awesome assignment\" style=\"display:none\" href=\"$url_ass\"  onclick=\"is_edited=false;\">M</a>";
               //
                //}
                
                $c_costo_hidden="<span class=\"soldi_art_$id_box\" style =\"display:none;\">$c21</span>";
                $quantita = round($c16,2);
                // da sistemare    
                $c20="
                <input type=\"text\" name=box_value[] value=\"$quantita\" size=\"2\" readonly=\"readonly\" style=\"background-color: #ACACAC; border:1px solid grey; margin-left: 0.6em; font-weight:bold; text-align:center\" >
                <input type=\"hidden\" name=box_id[] value=$c0>
                <input type=\"hidden\" name=box_price[] value=$c3>
                <input type=\"hidden\" name=box_q_att[] value=$c16>
                <input type=\"hidden\" name=box_q_min[] value=$c15>
                <input type=\"hidden\" name=box_q_uni[] value=$c18>";
                
                $spesa_attuale = round($c3 * $c16,2);
                
                
                
                if($c18<>"1"){
                    $url_mod=$RG_addr["ordini_ap_mod_q"]."?id=$c0&id_ordine=$ordine&q_min=$c15"; //&n_riga=
                    
                    //NUOVA URL
                    $url_mod=$RG_addr["ordini_mod_ass_new"]."?id_articolo=$c0&id_ordine=$ordine";
                    $color="yellow";
                    $url_add=$url_mod;
                }else{
                    $url_mod=$RG_addr["ordini_ap_mod_q"]."?id=$c0&id_ordine=$ordine&q_min=$c15&mode=uni"; //ARTICOLO UNICO              
                    
                    $url_mod=$RG_addr["ordini_mod_uni_new"]."?id_articolo=$c0&id_ordine=$ordine";
                    $color="orange";
                    $url_add=$url_mod;
                }
                $url_eli=$RG_addr["ordini_ap_mod_q"]."?id_arti=$c0&id_ordine=$ordine&do=do_del_all_art"; 
                
                $add= "<a class=\"option marrone awesome\" href=\"$url_add\" >A</a>";
                $mod= "<a class=\"option $color awesome\" href=\"$url_mod\"  onclick=\"is_edited=false;\">M</a>";
                $eli= "<a class=\"option black awesome\" href=\"$url_eli\"  onclick=\"is_edited=false;\">E</a>";
                
                $c20 ="$mod".$c20."$eli";
                $c21= (float)round($r_ar_dopp[1],2);
                
                
                
            }
            if(!empty($c17)){
            $c17 = "<a TITLE=\"Funzionalità per il momento disattivata.\">".substr($c17,0,12)."....</a>";
            }else{
            $c17 = "";
            }
    
            if($c18==1){$unico = " -U";}
    
            //---------------------------------------        
            $op3 = '<a rel="'.$c0.'" class="display_full_message" style="margin:4px;">Info</a>';  
              


            
            $opzioni = $row["articoli_opz_1"]." ".$row["articoli_opz_2"]." ".$row["articoli_opz_3"];
            if(trim($opzioni)<>""){
                $opzioni = "<span class=\"small_link\">(".$opzioni.")</span>";
            }else{
                $opzioni = "";
            }
            
            //PARTENZA TABELLA 
            
            $output_html .= "<tr class=\"$nascondi\" id=\"".$row["id_articoli"]."\">";    
            $output_html .="<td width=\"7%\"><a class=\"$colore\">$c1 $unico</a></td>";    
            $output_html .="
                 <td class=\"sinistra\"><a rel=\"".$c0."\" class=\"display_full_message\">$c2 $per_completare_scatola $opzioni</a></td>
                 <td width=\"15%\">$c3 $euro x $c4 $c5</td>
                 <td class=\"centro\">$c14</td> 
                 <td class=\"centro\"><a id=\"min_$id_box\">$c15</a></td> 
                 <td class=\"destra\">$c20</td>
                 <td class=\"destra\" id=\"total_item_$c0\">$spesa_attuale</td>
                 </tr>";
          $riga++;  
         }//end while
         
         
         $copertura_spese="<tr class=\"subtotal\">    
                            <th width=\"7%\">&nbsp;</th>
                            <th>Anticipo per copertura spese:</th>
                            
                            <th width=\"13%\">&nbsp;</th>
                            <th width=\"5%\">&nbsp;</th>  
                            <th width=\"5%\">&nbsp;</th>  
                            
                            <th id=\"perc_anticipo\" style=\"text-align:center;\">%</th>
                            <th id=\"valore_anticipo\" class=\"destra\">&nbsp;</th>
                            </tr>";
         
         $poi=1;
         $output_html .= "  </tbody>";
         $output_html .="
                    <tfoot>
                  
                    <tr class=\"total\">    
                    <th width=\"7%\">&nbsp;</th>
                    <th>TOTALI</th>
                    
                    <th width=\"13%\">&nbsp;</th>
                    <th width=\"5%\">&nbsp;</th>  
                    <th width=\"5%\">&nbsp;</th>  
                    
                    <th id=\"grandArt\" class=\"centro\">Articoli</th>
                    <th id=\"grandTotal\" class=\"destra\">Totale</th>
                    </tr>
                    
                    <tr>    
                    <td width=\"7%\">&nbsp</td>
                    <td>Dopo aver salvato torna su questa pagina <input type=\"checkbox\" name=\"the_next_step\" value=\"1\"></td>
                    <td width=\"13%\">&nbsp;</td>
                    <td width=\"5%\">&nbsp;</td>  
                    <td width=\"5%\">&nbsp;</td>  
                    
                    <td>&nbsp</td>
                    <td>&nbsp</td>
                    </tr>
                    </tfoot>
                 </tr>
                 
                 ";
         $output_html .= "  </table>";
         $output_html .= "<input type=\"hidden\" name=\"id_ordine\" value=\"$id\">  
                               <input type=\"hidden\" name=\"do\" value=\"salva_carrello\">
                               <input type=\"hidden\" id=\"hgt\" name=\"hidden_grand_total\" value=\"0\">
                               <input type=\"submit\" class = \"large green awesome\" style=\"margin:20px;\" value=\"Salva la spesa !\" onClick=\"is_edited=false;\">
               </div>";

       
               
               
         return $output_html;
    
      // END TABELLA ----------------------------------------------------------------------------
          
    }
    
    
    
    //TABELLE RETTIFICHE
    function ordine_render_rettifica_denaro_user($ref_table,$id_ordine){
         
        

      global $db;
      $h .= " <div class=\"rg_widget rg_widget_helper\">
                <h3>Lista partecipanti<h3>
                <form action=\"\" method=\"POST\" class=\"retegas_form\">
                <table id=\"$ref_table\" class=\"medium_size\">
                    <thead>     
                        <tr> 
                            <th>Utente</th>
                            <th>Gas</th>
                            <th>Conteggio ordini</th>
                            <th>Somma articoli</th>
                            <th>Importo totale netto su quantità ordinata</th>
                            <th>Importo rettificato netto su quantità arrivata</th> 
                        </tr>
                    <thead>
                    <tbody>";


       $col_5 = "style=\"text-align:right;\"";             
                    
       $result = $db->sql_query("SELECT
                                    Sum(retegas_dettaglio_ordini.qta_ord * retegas_articoli.prezzo) as importo_totale_qord,
                                    Sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) as importo_totale_qarr,
                                    Sum(retegas_dettaglio_ordini.qta_ord) as somma_articoli,
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
                                    retegas_dettaglio_ordini.id_utenti
                                    ORDER BY Sum(retegas_dettaglio_ordini.qta_arr * retegas_articoli.prezzo) DESC");


       $riga=0;  
         while ($row = $db->sql_fetchrow($result)){
         


              $id_ut = $row["userid"];
              $nome_ut = $row['fullname'];
              $gas_app = $row['descrizione_gas'];
              $id_gas_app = $row['id_gas'];
              $conto_articoli = $row['conto_articoli'];
              $somma_articoli = $row['somma_articoli'];
              $importo_totale_ord = $row["importo_totale_qord"];
              $importo_totale_arr = $row["importo_totale_qarr"];
              
              $totalone_ord = $totalone_ord+ $importo_totale_ord;
              $totalone_arr = $totalone_arr+ $importo_totale_arr;
              $totalone_articoli = $totalone_articoli + $somma_articoli;
              
              $importo_totale_ord = number_format($importo_totale_ord,2,",","");
              $importo_totale_arr = number_format($importo_totale_arr,3,",","");
              
              $somma_articoli = (float)$somma_articoli;
              
              $importo_rettificato = '<input type="checkbox" name="box_operate[]" value="'.$id_ut.'">
                                      <input type="text" name="box_value_qarr[]" style="text-align:right" size=5 value="'.$importo_totale_arr.'">
                                      <input type="hidden" name="box_value_qord[]" value="'.$importo_totale_ord.'">
                                      <input type="hidden" name="box_userid[]" value="'.$id_ut.'">';
              
              $h.= "<tr>";    
                $h.= "<td $col_1>$nome_ut</td>"; 
                $h.= "<td $col_2>$gas_app</td>";
                $h.= "<td $col_5>$conto_articoli</td>";
                $h.= "<td $col_5>$somma_articoli</td>";
                $h.= "<td $col_5>$importo_totale_ord</td>";
                $h.= "<td $col_5>$importo_rettificato</td>";
              $h .="</tr>";

         }//end while


         $totalone_articoli = number_format($totalone_articoli,2,",","");
         $totalone_ord = number_format($totalone_ord,2,",","");
         $totalone_arr = number_format($totalone_arr,3,",","");
         
         $h.= "</tbody>
               <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>Somme:</th>
                    <th $col_5>&nbsp;</th>
                    <th $col_5>$totalone_articoli</th>
                    <th $col_5>$totalone_ord</th>
                    <th $col_5>$totalone_arr</th>
                </tr>
               </tfoot>
               </table>
               <input name=\"id_ordine\" type=\"hidden\" value=\"$id_ordine\">
               <input name=\"do\" type=\"hidden\" value=\"do_rett\">
               <center>
               <input class=\"large green awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Salva i nuovi importi\">
               </center>
               </form>";

  return $h;

  }
    function ordine_render_rettifica_denaro_totale($ref_table,$id_ordine){
         
        

      global $db;
      $h .= " <div class=\"retegas_form ui-corner-all\">
               <form action=\"\" method=\"POST\">
               
               <h3>
               Questo ordine è stato chiuso con un totale netto di  
               ".number_format(valore_totale_ordine_qarr($id_ordine),4)." Eu.
               </h3>
               
               <p>
               Rettificando il totale dell'ordine, saranno modificati proporzionalmente i singoli quantitativi acquistati
               da ogni utente, in modo da riflettere alla fine il nuovo importo. Le quantità distribuite agli 'amici' dei partecipanti verranno mantenute il più possibile intatte, andando a 
               modificare soltanto quelle riferite all'utente ordinante. 
               </p>
                       <div class=\"form_box\">
                        <h4>1</h4>
                        <label for=\"nuovo_totale\">Inserisci il totale corretto</label>
                        <input type=\"text\" name=\"nuovo_totale\" value=\"$nuovo_totale\" size=\"10\"></input>
                        <h5 title=\"$help_nuovo_totale\">Inf.</h5>
                        </div> 
               <input name=\"id_ordine\" type=\"hidden\" value=\"$id_ordine\">
               <input name=\"do\" type=\"hidden\" value=\"do_rett_tot\">
               <center>
               <input class=\"large green awesome\" style=\"margin:20px;\" type=\"submit\" value=\"Salva i nuovi importi\">
               </center>
               </form>
               </div>";

  return $h;

  }