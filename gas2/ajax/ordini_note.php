<?php

include_once ("../rend.php");
if(_USER_LOGGED_IN){ 
    if(isset($id_ordine)){
    
        $id_ordine = CAST_TO_INT($id_ordine);

        if($id_ordine==0){
            die();
        }
        
        $value = strip_tags($value);
        
        if(trim($value)=="Clicca per scrivere"){
            die();
        }
        
        
      log_me($id_ordine,_USER_ID,"ORD","NOT","Inserita una nota personale",0,$value);
      write_option_note(_USER_ID,"ORD_NOTE_".$id_ordine,$value);                 
      //$sql ="UPDATE  `maaking_users` SET  `city` =  '$newvalue' WHERE  `maaking_users`.`userid` ='$id_utente' LIMIT 1 ;";    
      //$db->sql_query($sql);
      echo $value;
      die();
       
    }
}
?>