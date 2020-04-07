<?php
namespace phplibrary;
function fn_get_query_string_value($str_name){

  $str_value="";
  if (isset($_GET[$str_name])){
      $str_value=htmlspecialchars($_GET[$str_name]) ;
      //$str_value=$_GET[$str_name] ;
  }
  if($str_value=="undefined"){
    $str_value="";
  }
  if($str_value=="NaN"){
    $str_value="";
  }
  return $str_value;
}

class ServerVariables{
  function __construct() {
    global $bln_debug;
    $this->server_address=$_SERVER['SERVER_ADDR'];
    $this->local_address="127.0.0.1";
    $this->server_folder_prefix="page/";//prefix varaible without leading slash. db href prefix with leading slash
    $this->str_request_uri=strtok($_SERVER['REQUEST_URI'],'?');
    $this->str_query_string=$_SERVER["QUERY_STRING"];
    $this->str_basename_tok=$this->fn_get_basename_tok($_SERVER['REQUEST_URI']);
    $this->str_php_self_orig=dirname($_SERVER["PHP_SELF"]);
    $this->str_php_self=$this->str_php_self_orig;
    if($bln_debug){$this->fn_debug();}
  }
  function fn_get_basename_tok($str_uri){
    $str_basename_tok=basename(strtok($str_uri,'?'));
    if(!empty($str_basename_tok)){
      $str_basename_tok=$this->server_folder_prefix.$str_basename_tok;
    }
    return $str_basename_tok;
  }

  function fn_get_var(){
    $s="";
    foreach ( $_SERVER as $key=>$value ) {
        $s.= "[$key] ".$value."</br>".PHP_EOL;
    }
    return $s;
  }

  function fn_var(){
      echo fn_get_var();
  }
  function fn_debug(){

    fn_echo("str_request_uri", $this->str_request_uri);
    fn_echo("str_basename_tok", $this->str_basename_tok);
    fn_echo("str_php_self", $this->str_php_self);

    $s="";
    $s.='<br><p>'.PHP_EOL;
    $s.='<button onclick="myFunction()">SEE FULL $_SERVER</button>'.PHP_EOL;
    $s.='</p>'.PHP_EOL;
    $s.='<div style="display:none" id="myDIV">'.PHP_EOL;
    $s.=$this->fn_get_var();
    $s.='</div>'.PHP_EOL;
    $s.='<script>'.PHP_EOL;
    $s.='function myFunction() {'.PHP_EOL;
    $s.='var x = document.getElementById("myDIV");'.PHP_EOL;
    $s.='if (x.style.display === "none") {'.PHP_EOL;
    $s.='x.style.display = "block";'.PHP_EOL;
    $s.='} else {'.PHP_EOL;
    $s.='x.style.display = "none";'.PHP_EOL;
    $s.='}'.PHP_EOL;
    $s.='}'.PHP_EOL;
    $s.='</script>';
    echo $s;
    //$this->fn_var();
  }
  function fn_get_post_value($str_name){

    $str_value="";

    if (isset($_POST[$str_name])){
        $str_value=$_POST[$str_name] ;
    }

    if($str_value=="undefined"){
      $str_value="";
    }
    if($str_value=="NaN"){
      $str_value="";
    }

    return $str_value;
  }
}
// END CLS SERVER
?>
