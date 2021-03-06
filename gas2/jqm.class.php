<?php

class jqm{

public $jqm_meta_tags=array();    
public $jqm_app_title ="";    
public $jqm_jqm_url="";
public $jqm_jqm_css="";
public $jqm_jquery_url ="";
public $jqm_overrides =array();
public $jqm_java_headers=array();
public $jqm_extra_css=array();
public $jqm_java_bottombody = array();
public $jqm_translate_html_entities = true;


public $jqm_pages = array();
    

public function __construct($params = null){

    foreach ($params as $key => $value){
        if(isset($this->{$key})){
            $this->{$key} = $value;
        }
    }
    
}    
    
public function jqm_render(){

global $RG_addr;    
    
$j = "<!DOCTYPE html>";
$j.= "  <html>";
$j.= "      <head>";
$j.= "          <title>".$this->jqm_app_title."</title>";
$j.= "          <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";

//META TAGS
foreach ($this->jqm_meta_tags as $meta_tag) {
        $j .= $meta_tag;
     }

$j.= "          <link rel=\"stylesheet\" href=\"".$this->jqm_jqm_css."\" />";
//$j.= "          <link rel=\"stylesheet\" href=\"".$RG_addr["m_css"]."\" />";
//ALTRI Css
foreach ($this->jqm_extra_css as $extra_css) {
        $j .= $extra_css;
     }
$j.= "          <script type=\"text/javascript\" src=\"".$this->jqm_jquery_url."\"></script>";
//PRE MOBILE
foreach ($this->jqm_overrides as $override) {
        $j .= $override;
     }
$j.= "          <script type=\"text/javascript\" src=\"".$this->jqm_jqm_url."\"></script>";
//ALTRI Headers
foreach ($this->jqm_java_headers as $java_header) {
        $j .= $java_header;
     }
$j.= "      </head>";
$j.= "      <body>";


//PAGINE-----------------------------------------------------------
foreach ($this->jqm_pages as $page) {
        $j .= $page;
     }


//JAVA BOTTOM BODY
foreach ($this->jqm_java_bottombody as $java_bottombody) {
        $j .= $java_bottombody;
    }

$j.= "      </body>";
$j.= "";
$j.= "      </html>";


//traduco gli accenti in html_entities
if ($this->jqm_translate_html_entities){
    $conversion_chars = array (    "à" => "&agrave;", 
                                   "è" => "&egrave;", 
                                   "é" => "&egrave;", 
                                   "ì" => "&igrave;", 
                                   "ò" => "&ograve;", 
                                   "ù" => "&ugrave;"); 
    $j = str_replace (array_keys ($conversion_chars), array_values($conversion_chars), $j);
       
}


return $j;
}   

}
class jqm_page{

public $jqm_page_attrib = "";
    
public $jqm_header_title = "";
public $jqm_header_icon_left ="";
public $jqm_header_icon_right="";
public $jqm_header_attrib = "";

public $jqm_header_navbar="";
public $jqm_header_navbar_sub="";

public $jqm_footer_hide = false;
public $jqm_footer_title ="";
public $jqm_footer_icon_left="";
public $jqm_footer_icon_right="";
public $jqm_footer_attrib = "";    

public $jqm_page_content ="";
    
public function __construct($params = null){

//if(array_key_exists("jqm_page_attrib",$params)){$this->jqm_page_attrib=$params["jqm_page_attrib"];}        
//if(array_key_exists("jqm_header_title",$params)){$this->jqm_header_title=$params["jqm_header_title"];}  
//if(array_key_exists("jqm_header_attrib",$params)){$this->jqm_header_attrib=$params["jqm_header_attrib"];}
//if(array_key_exists("jqm_header_icon_left",$params)){$this->jqm_header_icon_left=$params["jqm_header_icon_left"];}
//if(array_key_exists("jqm_header_icon_right",$params)){$this->jqm_header_icon_right=$params["jqm_header_icon_right"];}
//if(array_key_exists("jqm_header_navbar",$params)){$this->jqm_header_navbar=$params["jqm_header_navbar"];}
//if(array_key_exists("jqm_footer_title",$params)){$this->jqm_footer_title=$params["jqm_footer_title"];}
//if(array_key_exists("jqm_footer_attrib",$params)){$this->jqm_footer_attrib=$params["jqm_footer_attrib"];}

    foreach ($params as $key => $value){
        if(isset($this->{$key})){
            $this->{$key} = $value;
        }
    }
    
}

public function jqm_render_page(){
    
$p.="<div data-role=\"page\" ".$this->jqm_page_attrib.">";

$p.="<div data-role=\"header\" ".$this->jqm_header_attrib.">";
$p.=$this->jqm_header_icon_left;
$p.="<h1>".$this->jqm_header_title."</h1>";
$p.=$this->jqm_header_icon_right;
$p.=$this->jqm_header_navbar;
$p.=$this->jqm_header_navbar_sub;
$p.="</div>";

$p.="<div data-role=\"content\">";
$p.=$this->jqm_page_content;
$p.="</div>";

if(!$this->jqm_footer_hide){
    $p.="<div data-role=\"footer\" ".$this->jqm_footer_attrib.">";
    $p.=$this->jqm_footer_icon_left;
    $p.="<h1>".$this->jqm_footer_title."</h1>";
    $p.=$this->jqm_footer_icon_right;
    $p.="</div>";
}    

$p.="</div>";
$p.="";



return $p;    
}

    
}
class jqm_list{
    
public $jqm_list_attrib = array();
public $jqm_list_items=array();

public function __construct($params=null){
    
    if(is_array($params)){
        foreach ($params as $key => $value){
            if(isset($this->{$key})){
                $this->{$key} = $value;
            }
        }    
    }
}

public function jqm_list_render(){
    
//Attributes

    foreach ($this->jqm_list_attrib as $key => $value){
        $a .= $value." ";
    }
    $l .="<ul data-role=\"listview\" $a>";

foreach ($this->jqm_list_items as $list_item) {
        $l .=$list_item;
     }

$l .="</ul>";


 
    
return $l;    
}    
    
}
class jqm_navbar{
    public $jqm_navbar_attrib="";
    public $jqm_navbar_items = array();
    
    public function jqm_navbar_set_item_attrib($id_item,$attrib){
        $this->jqm_navbar_items[$id_item]= str_replace("<a","<a ".$attrib." ",$this->jqm_navbar_items[$id_item]);  
    }
    
    public function __construct($navbar){
        $this->jqm_navbar_items = $navbar;
    }
    public function jqm_render_navbar(){
    
    $n .="<div data-role=\"navbar\" ".$this->jqm_navbar_attrib.">";
    $n .="<ul>";
    $counter = 0;
    foreach ($this->jqm_navbar_items as $navbar_item) {
         
         $n .=$navbar_item;
         $counter ++ ;     
    }
    $n .="</ul>";
    $n .="</div>";
    
        
    return $n;    
    }
}



class jqm_form{

 public $id ="";   
 public $method = "POST";
 public $action = "";
 public $name = "jqm_form";
 public $class = "";
 public $style = "";
 public $attribs ="";
 public $items = array();
 public $form = array();
 
 public function __construct($params){
     foreach ($params as $key => $value){
        if(isset($this->{$key})){
            $this->{$key} = $value;
        }
    }    
     
 }
 
 public function render_form(){
     
     if(!empty($this->id)){
         $this->id = " ID=\"".$this->id."\""; 
     }
     
     if(!empty($this->class)){
         $this->class = " CLASS=\"".$this->class."\""; 
     }
     
     if(!empty($this->method)){
         $this->method = " METHOD=\"".$this->method."\""; 
     }
     
     if(!empty($this->style)){
         $this->style = " STYLE=\"".$this->style."\""; 
     }
     
     if(!empty($this->action)){
         $this->action = " ACTION=\"".$this->action."\""; 
     }
     
     if(!empty($this->name)){
         $this->name = " NAME=\"".$this->name."\""; 
     }    
     
     
     $h = "<FORM ".$this->name.$this->method.$this->action.$this->class.$this->style.$this->attribs.">";
     
     foreach ($this->items as $i) {
        $h .= $i;
     }
     
     
     
     $h .="</FORM>"; 
     
     
     
     return $h;
 }
    
}
class jqm_form_text{

public $has_container = true;
public $value="";
public $name="";
public $attribs="";
public $label="";
public $class="";
public $style="";
public $id="";

public function __construct($params){
    foreach ($params as $key => $value){
        if(isset($this->{$key})){
            $this->{$key} = $value;
        }
    }    
}

public function create_form_text_item(){

if(empty($this->label)){
         $this->label = $this->name;
}    
    
if(!empty($this->value)){
         $this->value = " VALUE=\"".$this->value."\""; 
}
if(!empty($this->name)){
         $this->name_for_label = $this->name;
         $this->id = " ID=\"".$this->name."\"";
         $this->name = " NAME=\"".$this->name."\"";
          
}

if(!empty($this->class)){
         $this->class = " CLASS=\"".$this->class."\""; 
}
if(!empty($this->style)){
         $this->style = " STYLE=\"".$this->style."\""; 
}
 
    
if($this->has_container){    
    $h  = "<DIV data-role=\"fieldcontain\">";
}

$h .= "<LABEL FOR=\"".$this->name_for_label."\">".$this->label."</LABEL>";
$h .= "<INPUT TYPE=\"TEXT\" ".$this->id.$this->name.$this->value.$this->class.$this->style.$this->attribs."></INPUT>"; 

if($this->has_container){ 
    $h .= "</DIV>"; 
}
return $h;    
}    
    
}
class jqm_form_select{

public $value="";
public $size ="";
public $name="";
public $name_for_label="";
public $help="";
public $label="";
public $number="";
public $class="";
public $style="";
public $id="";
public $options = array();

public function create_form_select_item(){

if(empty($this->label)){
         $this->label = $this->name;
}    
    
if(!empty($this->value)){
         $this->value = " VALUE=\"".$this->value."\""; 
}
if(!empty($this->name)){
         $this->name_for_label = $this->name;
         $this->name = " NAME=\"".$this->name."\""; 
}
if(!empty($this->size)){
         $this->size = " SIZE=\"".$this->size."\""; 
}
if(!empty($this->class)){
         $this->class = " CLASS=\"".$this->class."\""; 
}
if(!empty($this->style)){
         $this->style = " STYLE=\"".$this->style."\""; 
}
if(!empty($this->id)){
         $this->id = " ID=\"".$this->id."\""; 
}    
    
    
$h  = "<DIV>";
$h .= "<h4>".$this->number."</h4>";
$h .= "<LABEL FOR=\"".$this->name_for_label."\">".$this->label."</LABEL>";
$h .= "<SELECT  ".$this->id.$this->name.$this->size.$this->class.$this->style.">";
foreach ($this->options as $i) {
        $h .= $i;
}
$h .= "</SELECT>";
$h .= "<H5 TITLE=\"".$this->help."\">Inf.</H5>"; 
$h .= "</DIV>"; 

return $h;    
}    
public function create_option_item($label,$value){
    
        if($this->value==$value){
            $sel = "SELECTED";
        }
    return "<option value=\"$value\" $sel >$label</option>";    

}    
}
class jqm_form_submit{

public $value="";
public $size ="";
public $name="";
public $name_for_label="";
public $help="";
public $label="";
public $number="";
public $class="";
public $style="";
public $id="";

public function create_form_submit_item(){

if(empty($this->label)){
         $this->label = $this->name;
}    
    
if(!empty($this->value)){
         $this->value = " VALUE=\"".$this->value."\""; 
}
if(!empty($this->name)){
         $this->name_for_label = $this->name;
         $this->name = " NAME=\"".$this->name."\""; 
}
if(!empty($this->size)){
         $this->size = " SIZE=\"".$this->size."\""; 
}
if(!empty($this->class)){
         $this->class = " CLASS=\"".$this->class."\""; 
}
if(!empty($this->style)){
         $this->style = " STYLE=\"".$this->style."\""; 
}
if(!empty($this->id)){
         $this->id = " ID=\"".$this->id."\""; 
}    
    
    
$h  = "<DIV>";
$h .= "<h4>".$this->number."</h4>";
$h .= "<LABEL FOR=\"".$this->name_for_label."\">".$this->label."</LABEL>";
$h .= "<INPUT TYPE=\"SUBMIT\" ".$this->id.$this->name.$this->value.$this->size.$this->class.$this->style."></INPUT>";
$h .= "<H5 TITLE=\"".$this->help."\">Inf.</H5>"; 
$h .= "</DIV>"; 

return $h;    
}    
    
}
class jqm_form_hidden{

public $value="";
public $name="";
public $id="";

public function create_form_hidden_item(){

  
    
if(!empty($this->value)){
         $this->value = " VALUE=\"".$this->value."\""; 
}
if(!empty($this->name)){
         $this->name_for_label = $this->name;
         $this->name = " NAME=\"".$this->name."\""; 
}

if(!empty($this->id)){
         $this->id = " ID=\"".$this->id."\""; 
}    

$h .= "<INPUT TYPE=\"HIDDEN\" ".$this->id.$this->name.$this->value."></INPUT>";


return $h;    
}    
    
}
  
?>