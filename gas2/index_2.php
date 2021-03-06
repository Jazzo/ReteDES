<?php
 $_FUNCTION_LOADER=array("mobile","gas");

include_once ("rend.php");
include_once ("jqm.class.php");

if($do=="logout"){
    Logout_new($user);
    go("sommario_mobile");
}

if($do=="login"){
    $login_result = do_login($username,$password,$remember);
    go("sommario_mobile");
    
}


//Controllo su login
if(_USER_LOGGED_IN){

    if(_USER_PERMISSIONS & perm::puo_gestire_la_cassa){
        $butt_cassa = "<a data-role=\"button\" href=\"".$RG_addr["m_cassa_panel"]."\" data-icon=\"grid\" data-ajax=\"false\">Cassa</a>";
    }else{
        $butt_cassa = "<a data-role=\"button\" href=\"".$RG_addr["m_cassa_user_mov"]."\" data-icon=\"grid\" data-ajax=\"false\">Cassa</a>";
    }
    
    if(_USER_PERMISSIONS & perm::puo_partecipare_ordini){
        $butt_ordini = "<a data-role=\"button\" href=\"".$RG_addr["m_ordini"]."\"  data-icon=\"check\" rel=\"external\" data-prefetch>Ordini</a>";
    }
    if(_USER_PERMISSIONS & perm::puo_gestire_retegas){
        $butt_admin = "<a data-role=\"button\" href=\"".$RG_addr["m_admin_panel"]."\"  data-icon=\"gear\" rel=\"external\">Admin</a>";
    }
    
    
       
    $c="<h2>".fullname_from_id(_USER_ID)."</h2>
        <h4>".gas_nome(_USER_ID_GAS)."</h4>        
        $butt_ordini
        $butt_cassa
        $butt_admin
        <a data-role=\"button\" href=\"".$RG_addr["sommario_mobile"]."?do=logout\" data-icon=\"delete\" rel=\"external\" >Log Out</a>
        ";
    //IMPOSTO le cose uguali per tutte le pagine_
    $footer_title = _USER_FULLNAME.", ".gas_nome(_USER_ID_GAS);    
}else{
    $c="
            
            <h4>ReteDES.it (Rete dei Distretti Economia Solidale) � un social-coso informatico a \"Km 0\" nato per
            aiutare ad organizzare e semplificare la gestione degli acquisti all'interno dei GAS e dei DES aderenti a questo progetto, 
            creando sul territorio una rete di collaborazione flessibile e dinamica.
            </h4>
            <div data-role=\"collapsible\">
               <h3>Altre info</h3>
               <p>Il progetto \"ReteDes.it - Rete dei DES\" nasce dall'esigenza degli utenti di alcuni Gas di voler gestire in maniera semplice e pratica gli ordini di acquisto.<br>
                        E' stato realizzato all'interno del GAS di Borgomanero nella forma di software gestionale in grado di gestire gli acquisti all'interno del proprio gruppo, in collaborazione con alcuni GAS \"confinanti\" o addirittura con tutti i GAS aderenti al progetto. Dopo una prima fase positiva di collaudo, il sistema � stato poi presentato a diversi GAS dell'Alto Piemonte che lo hanno adottato come valido strumento per la promozione di una soddisfacente e dinamica rete di collaborazione reciproca.
                        Questo progetto � stato concepito ponendo come filosofia fondante la necessit� di agevolare ed incentivare l'iniziativa personale di ciascun singolo aderente ad un GAS di porsi come promotore e responsabile di un determinato acquisto. Questo si realizza grazie alla flessibilit� della piattaforma, che permette ad ognuno di creare ordini costruendoli secondo le proprie capacit� e disponibilit� di tempo da impiegare in tale iniziativa. Tra le diverse opportunit�, � da sottolineare ad esempio, la possibilit� in sede di creazione dell'ordine, di stabilire quanti e quali GAS aderenti saranno coinvolti nell'ordine stesso.
                        L' organizzazione di ogni ordine � di tipo gerarchico e si sviluppa a diversi livelli: Responsabile dell' ordine: � il promotore dell'intero ordine ed anche responsabile per il proprio GAS di appartenenza; Responsabile GAS: � il responsabile di ciascun GAS coinvolto. Il suo compito � quello di mantenere il collegamento tra il suo GAS di appartenenza con il Responsabile dell'ordine. Utente finale: chiunque sia iscritto a Retegasap potr� gestire personalmente i propri acquisti; potr� chiedere e ricevere informazioni in merito ai responsabili a vari livelli.
                        Il sito � in continua evoluzione e miglioramento, soprattutto per adattarlo alle richieste che ogni utente ed ogni GAS pu� sentirsi libero di esprimere. Tutto ci� � basato sull'impegno e sul lavoro volontario di alcuni partecipanti ai vari GAS.</p>
            </div>
            
            <a data-role=\"button\" href=\"".$RG_addr["sommario_mobile"]."#page_login_form\">Effettua il login</a>
            <a data-role=\"button\" href=\"".$RG_addr["sommario"]."\" rel=\"external\">Versione desktop</a>";
    //IMPOSTO le cose uguali per tutte le pagine_
    $footer_title = "Sviluppo : ma.morez at tiscali.it";       
}

       
                
//Nuovo oggetto Jquery MObile
$j = new jqm(load_jqm_param());

//$j->jqm_extra_css[]="<style type=\"text/css\">
//                            .ui-page {
//                                background: transparent url(http://retegas.altervista.org/gas2/images/piemonte_cuore.jpg);
//                            }
//                        </style>";                                

//Nuova pagina con relativi parametri
$p = new jqm_page(load_page_param("ReteDes.it","index"));
$p->jqm_header_icon_left="";

//$p->jqm_footer_title = $footer_title;
//Assegno la navbar

//if(_USER_LOGGED_IN){
//    $n = new jqm_navbar(load_page_navbar());
//    $n->jqm_navbar_attrib = "data-iconpos=\"top\"";
//    $p->jqm_header_navbar=$n->jqm_render_navbar();
//    unset($n);
//}
//Inserisco i contenuti
$p->jqm_page_content =$c;
//Creo la pagina
$j->jqm_pages[]=$p->jqm_render_page();
unset($p);

//Nuova pagina con relativi parametri------------------------------LOGIN
$p = new jqm_page(load_page_param("ReteDes.it (Login)","login_form"));
$p->jqm_footer_title = $footer_title;
//Inserisco i contenuti
$p->jqm_page_content ='
<form action="'.$RG_addr["sommario_mobile"].'" method="post" data-ajax="false">
<div data-role="fieldcontain" class="ui-hide-label">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" value="" placeholder="Username"/>
</div>
<div data-role="fieldcontain" class="ui-hide-label">
    <label for="password">Username:</label>
    <input type="password" name="password" id="password" value="" placeholder="Password"/>
</div>
<div data-role="fieldcontain" class="ui-hide-label">
    <label for="Accedi">Accedi</label>
    <input type="hidden" name="do" id="do" value="login"/>
    <input type="submit" name="submit" id="submit" value="Accedi"/>
</div>
</form>';
//Creo la pagina solo se l'utente non � loggato
if(!_USER_LOGGED_IN){
    $j->jqm_pages[]=$p->jqm_render_page();
}


//La visualizzo
echo $j->jqm_render();
  
?>