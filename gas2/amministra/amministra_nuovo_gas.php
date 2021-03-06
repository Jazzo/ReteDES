<?php
   
// immette i file che contengono il motore del programma
include_once ("../rend.php");
include_once ("../retegas.class.php");


// controlla se l'user ha effettuato il login oppure no
if (!_USER_LOGGED_IN){
     pussa_via(); 
}    

//controlla se l'utente ha i permessi necessari
if(!(_USER_PERMISSIONS & perm::puo_gestire_retegas)){
     pussa_via();
}


//-------------------------------------------------Check
if($do=="add"){
    
    $descrizione_gas = sanitize($descrizione_gas);
    (int)$default_permission;
    (int)$gas_permission;
    (int)$id_referente_gas;
    (int)$id_des;
    if($id_referente_gas>0){
    
    $my_query="INSERT INTO retegas_gas 
                (descrizione_gas,
                 default_permission,
                 gas_permission,
                 id_referente_gas,
                 id_des) VALUES (
                 '$descrizione_gas',
                 '$default_permission',
                 '$gas_permission',
                 '$id_referente_gas',
                 '$id_des');";
            $result = $db->sql_query($my_query);
            //PERICOLOSO
            $res = mysql_query("SELECT LAST_INSERT_ID();");
            $row = mysql_fetch_array($res);
            $last_id=$row[0];
            
    if (is_null($result)){
            $msg = "Errore nell'inserimento del record";
            include ("../index.php");
            exit;  
        }else{
            
            
            $query_update = "UPDATE maaking_users SET id_gas='".$last_id."' WHERE userid='".$id_referente_gas."' LIMIT 1;";
            $result = $db->sql_query($query_update);
            
            
            $msg = "Nuovo Gas Aggiunto, referenze aggiornate.";
            go("gas_table",_USER_ID,$msg);
        };
    
    }else{
        $msg = "Scegliere il referente GAS";
    } 
    
    
    
}









//Creazione della nuova pagina uso un oggetto rg_simplest
$r = new rg_simplest();
//Dico quale voce del menù verticale dovrà essere aperta
$r->voce_mv_attiva = menu_lat::user;
//Assegno il titolo che compare nella barra delle info
$r->title = "Inserimento Nuovo Gas";
//Assegno anche la libreria HighCharts

//Messaggio popup;
$r->messaggio = $msg; 
//Dico quale menù orizzontale dovrà essere associato alla pagina.
$r->menu_orizzontale = amministra_menu_completo();

//------------------------------TABELLA INSERIMENTO
        $help_descrizione_gas='Il nome della ditta.';
        $help_id_referente_gas = 'permettono di filtrarla pi� agevolmente in mezzo alle altre e quindi di ritrovarla subito.<br>Ad esempio, i tag di una ditta che vende miele possono essere : miele, api, arnie, vasetti, acacia, castagno, biologico, artigianale ';
        $help_default_permission ='Si possono mettere immagini facendo il copia e incolla dal sito della ditta in questione. Le immagini saranno collegate, non incorporate.';
        $help_gas_permission ='Si possono mettere immagini facendo il copia e incolla dal sito della ditta in questione. Le immagini saranno collegate, non incorporate.';

        $query_users = "SELECT * FROM maaking_users;";
        $res_users = $db->sql_query($query_users);

        while ($row = $db->sql_fetchrow($res_users)){

            if(isset($id_referente_gas)){
                if($id_referente_gas==$row["userid"]){$selected = " SELECTED ";}else{$selected="";}    
            }  
            $user_select .= '<option value="'.$row["userid"].'" '.$selected.'>'.$row["fullname"].'</option>\\n';     
        }
        
        $query_des = "SELECT * FROM retegas_des;";
        $res_des = $db->sql_query($query_des);

        while ($row = $db->sql_fetchrow($res_des)){

            if(isset($id_des)){
                if($id_des==$row["id_des"]){$selected = " SELECTED ";}else{$selected="";}    
            }  
            $des_select .= '<option value="'.$row["id_des"].'" '.$selected.'>'.$row["des_descrizione"].'</option>\\n';     
        }
        
        
        $h = '<div class="rg_widget rg_widget_helper">
        <h3>Inserisci una nuovo GAS</h3>

        <form name="nuovo_gas" method="POST" action="" class="retegas_form">

        
        <div>
        <h4>1</h4>
        <label for="descrizione_gas">Scrivi il nome del nuovo GAS</label>
        <input type="text" name="descrizione_gas" value="'.$descrizione_gas.'" size="50"></input>
        <h5 title="'.$help_descrizione_gas.'">Inf.</h5>
        </div>

        <div>
        <h4>2</h4>
        <label for="default_permission">Permessi di default (283 = base)</label>
        <input type="text" name="default_permission" value="'.$default_permission.'" size="50"></input>
        <h5 title="'.$help_default_permission.'">Inf.</h5>
        </div>

        <div>
        <h4>3</h4>
        <label for="gas_permission">Permessi del gas (7 = Condiviso; 0 = Privato)</label>
        <input type="text" name="gas_permission" value="'.$gas_permission.'" size="50"></input>
        <h5 title="'.$help_gas_permission.'">Inf.</h5>
        </div>
        
        <div>
        <h4>4</h4>
        <span>
        <label for="id_referente_gas">Utente referente</label>
        <select id="id_referente_gas" name="id_referente_gas">
        <option value="0">Nessun utente selezionato</OPTION>
        '.$user_select.'        
        </select>
        <h5 title="'.$help_id_referente_gas.'">Inf.</h5>
        </span>

        </div>
        
        <div>
        <h4>5</h4>
        <span>
        <label for="id_referente_gas">DES associato</label>
        <select id="id_des" name="id_des">
        <option value="0">Nessun DES selezionato</OPTION>
        '.$des_select.'        
        </select>
        <h5 title="'.$help_id_des.'">Inf.</h5>
        </span>

        </div>
        
                       
        <div>
        <h4>6</h4>
        <label for="submit">e infine... </label>
        <input type="submit" name="submit" value="Crea un nuovo GAS !" align="center" >
        <input type="hidden" name="do" value="add">
        <h5 title="'.$help_partenza.'">Inf.</h5>
        </div> 


        </form>
        </div>';


//------------------------------TABELLA INSERIMENTO




//Questo è il contenuto della pagina
$r->contenuto = $h;
//Mando all'utente la sua pagina
echo $r->create_retegas();
//Distruggo l'oggetto r    
unset($r)   
?>