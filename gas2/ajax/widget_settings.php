 <?php 

include_once ("../rend.php");

$cookie_read     =explode("|", base64_decode($user));
$id_user  = $cookie_read[0];

 switch($id_widget){
     case 10:
         $settings=array("N_Ordini_da_mostrare"=>CAST_TO_INT($N_Ordini_da_mostrare),
                         "Aperto_al_caricamento"=>sanitize($Aperto_al_caricamento));
         write_option_text($id_user,"WGS_".$id_widget,base64_encode(serialize($settings)));
         
         Header("Location: ".$RG_addr["sommario"]."?q=7"); die();
     break;
     case 11:
         $settings=array("N_Ordini_da_mostrare"=>CAST_TO_INT($N_Ordini_da_mostrare),
                         "Aperto_al_caricamento"=>sanitize($Aperto_al_caricamento));
         write_option_text($id_user,"WGS_".$id_widget,base64_encode(serialize($settings)));
         
         Header("Location: ".$RG_addr["sommario"]."?q=7"); die();
     break;
     case 12:
         $settings=array(//"N_Ordini_da_mostrare"=>CAST_TO_INT($N_Ordini_da_mostrare),
                         "Aperto_al_caricamento"=>sanitize($Aperto_al_caricamento));
         write_option_text($id_user,"WGS_".$id_widget,base64_encode(serialize($settings)));
         
         Header("Location: ".$RG_addr["sommario"]."?q=7"); die();
     break;
     case 13:
         $settings=array("Aperto_al_caricamento"=>sanitize($Aperto_al_caricamento));
         
         write_option_text($id_user,"WGS_".$id_widget,base64_encode(serialize($settings)));
         
         Header("Location: ".$RG_addr["sommario"]."?q=7"); die();
     break;
     case 14:
         $settings=array("Aperto_al_caricamento"=>sanitize($Aperto_al_caricamento),
                            "id_ordine_1"=>CAST_TO_INT($id_ordine_1));
         
         write_option_text(_USER_ID,"WGS_".$id_widget,base64_encode(serialize($settings)));
         
         Header("Location: ".$RG_addr["sommario"]."?q=7"); die();
     break; 
     case 15:
         $settings=array("Finestra"=>sanitize($Finestra),
                         "Aperto_al_caricamento"=>sanitize($Aperto_al_caricamento));
         
         write_option_text(_USER_ID,"WGS_".$id_widget,base64_encode(serialize($settings)));
         
         go("sommario",_USER_ID,"Settaggi widget IDS modificati"); die();
     break;
 }

 
?>