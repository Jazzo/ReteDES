<?php

if(isset($root) AND isset($iroot)){
$locations_ajax=Array(// Posizione Pagine Ajax
                          "ajax_listini"            =>$root."ordini/add/ordini_elenco_listini.php",
                          "ajax_articoli"           =>$root."listini/listini_elenco_articoli.php",
                          "ajax_toggle_header"      =>$root."utenti/ajax_toggle_header.php",
                          "ajax_articoli_note"      =>$root."articoli/articoli_form_note.php",
                          "ajax_cassa_note"         =>$root."ajax/cassa_form_note.php",
                          "ajax_widget_order"       =>$root."ajax/widget_order.php",
                          "ajax_gasap_chat"         =>$root."gas/gasap_chat.php",
                          "ajax_post_chat"          =>$root."gas/post.php",
                          "ajax_ordini_note"        =>$root."ajax/ordini_note.php",
                          "ajax_admin_user_info"    =>$root."ajax/admin_edit_user_info.php",
                          "ditte_edit_address"      =>$root."ajax/ditte_edit_address.php",
                          "ajax_schedina_log"       =>$root."ajax/schedina_log.php",
                          "ajax_schedina_articolo"  =>$root."ajax/schedina_articolo.php",
                          "ajax_widget_settings"    =>$root."ajax/widget_settings.php",
                          "ajax_user_opt"           =>$root."ajax/user_opt.php");
}


  
?>