<?php
namespace phplibrary;
trait General{
  function fn_replace_first($search, $replace, $subject) {
      $pos = strpos($subject, $search);
      if ($pos !== false) {
          return substr_replace($subject, $replace, $pos, strlen($search));
      }
      return $subject;
  }

  function fn_replace($str_needle, $str_replace, $str_haystack){
    return str_replace($str_needle, $str_replace, $str_haystack);
  }

  function fn_print_json($stmt){
    echo json_encode($stmt);
  }

  function fn_print($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }
  function fn_dump($var){
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    //fn_pre(var_dump($variable));
  }

  function fn_pre($variable){
    echo '<pre>';
    echo $variable;
    echo '</pre>';
  }

  function fn_get_select_option($str_val, $str_selected, $str_text=""){
    if($str_text===""){$str_text=$str_val;}
    $s='';
    $s.='<option value="'.$str_val.'" ';
    if($str_val==$str_selected){
      $s.='selected';
    }
    $s.='>';
    $s.=$str_text;
    $s.='</option>';
    return $s;
  }


  function fn_get_sql_date(){
    return date("Y-m-d H:i:s");
  }

  function fn_get_sql_date_time(){
    return date("Y-m-d H:i:s");
  }

  function fn_get_bool($str_bool){
    return  filter_var($str_bool,FILTER_VALIDATE_BOOLEAN);
  }

  function fn_write_debug($str_title, $foo_message){

    if(is_array($foo_message)){
      $s="";
      foreach ($foo_message as $key => $value) {
        $foo_value=$value;
        if(is_array($foo_value)){
          $foo_value="native array";
        }
        else if(is_object($foo_value)){
          $foo_value="native object";
        }
        $s.=fn_get_echo($key, $foo_value);
      }
      $str_message=$s;
    }
    else{
        $str_message=$foo_value;
    }

    if(empty($str_title)){
      $str='<h1>'.$str_title.'</h1><p>'."\r\n";
      $str=$str.$str_message;
    }
    else{
        $str=$str_message;
    }
    echo('<div class="container p-3 my-3 bg-dark text-white rounded-lg border border-light">'."\r\n");
    echo $str;
    echo '</div>'."\r\n";
  }


  function fn_write_message($str_title, $foo_message){


    if(is_array($foo_message)){
      $s="";
      foreach ($foo_message as $key => $value) {
        $foo_value=$value;
        if(is_array($foo_value)){
          $foo_value="native array";
        }
        else if(is_object($foo_value)){
          $foo_value="native object";
        }
        $s.=fn_get_echo($key, $foo_value);
      }
      $str_message=$s;
    }
    else{
        $str_message=$foo_message;
    }

    $str="";
    $str=$str.'<h1>'.$str_title.'</h1><p>'."\r\n";
    $str=$str.$str_message;
    fn_write_container($str);
  }


  function fn_write_container($str){
    echo '<div class="container p-3 my-3 bg-dark text-white rounded-lg">'."\r\n";
    echo $str."\r\n";
    echo '</div>'."\r\n";
  }

  function fn_write_container_dark($str){

    echo '<div class="container p-3 my-3 bg-dark text-white rounded-lg">'."\r\n";
    echo $str."\r\n";
    echo '</div>'."\r\n";
  }
  function fn_write_container_debug($str){

    echo '<div class="container p-3 my-3 rounded-lg">'."\r\n";
    echo $str."\r\n";
    echo '</div>'."\r\n";
  }


  function fn_title($str){
    echo(fn_get_title($str));
  }
  function fn_get_title($str){
    return "<div style='text-decoration:underline'>".$str . "</div>";
  }

  function fn_echo_ta($lab, $str){
    $s="";
    $s.="<textarea style='width:600px;height:600px'>";
    $s.=fn_get_echo($lab, $str);
    $s.="</textarea>";
    echo $s;
  }

  function fn_echo_highlight($lab, $str=""){
    echo('<div style="border:1px solid black;color:black;background-color:red;">'.fn_get_echo($lab, $str).'</div>');
  }

  function fn_echo($lab, $str=""){
    echo(fn_get_echo($lab, $str));
  }
  function fn_get_echo($lab, $str){
    $s="<div>";
    $s.=$lab;
    if(!empty($str) or  $str==="0"){
      $s.=": ";
      $s.=$str;
    }
    $s.="</div>".PHP_EOL;
    return $s;
  }
  function fn_debug_class($str_name_class){
    //print_r($obj_child);
    $class_methods = get_class_methods($str_name_class);
    //$class_methods = get_class_methods(new myclass());
    foreach ($class_methods as $method_name) {
    echo "$method_name<br>";
    }
  }

  function fn_starts_with ($string, $startString)
  {
      $len = strlen($startString);
      return (substr($string, 0, $len) === $startString);
  }
  function fn_ends_with($string, $endString)
  {
      $len = strlen($endString);
      if ($len == 0) {
          return true;
      }
      return (substr($string, -$len) === $endString);
  }
  function fn_trim_add_space($str){
    $str=trim($str);
    $str.=" ";
    return $str;
  }



  function fn_itrim_from($str_to_search, $str_trim){
    $int_pos=stripos($str_to_search, $str_trim);
    if($int_pos===false){return $str_to_search;}
    $str_val=substr($str_to_search, 0, $int_pos);
    return $str_val;
  }
  function fn_iget_from($str_to_search, $str_till){
    $int_pos=stripos($str_to_search, $str_till);
    if($int_pos===false){return $str_to_search;}
    return substr($str_to_search, $int_pos);
  }
  function fn_iget_till($str, $str_till){
    //fn_echo("fn_iget_till");
    //fn_echo("str", "[".$str."]");
    //fn_echo("str_till", "[".$str_till."]");
    $int_pos=stripos($str, $str_till);
    //fn_echo("int_pos", "[".$int_pos."]");
    if($int_pos===false){return $str;}
    //$str_return=substr($str, 0, $int_pos);
    //fn_echo("str_return", "[".$str_return."]");
    //return $str_return;
    return substr($str, 0, $int_pos);
  }

  function fn_in_istr($needle, $haystack){
    $int_pos=stripos($haystack, $needle);
    if($int_pos===false){
      return false;
    }
    return true;
  }
  function fn_in_str($needle, $haystack){
    $int_pos=strpos($haystack, $needle);
    if($int_pos===false){
      return false;
    }
    return true;
  }
  function fn_add_and($str, $str_add){
    $str_trim=trim($str);
    $s="";
    if(!empty($str_trim)){
      $s.="AND ";
    }
    $s.=$str_add;
    return $s;
  }


  function fn_write_card($arr, $str_theme_color="dark"){

    echo '<div class="card" style="width: 18rem;">'.PHP_EOL;
    echo '<ul class="list-group list-group-flush">'.PHP_EOL;
      foreach ($arr as $key => $value) {
        $foo_value=$value;
        echo '<li class="list-group-item">'.$key.': '.$foo_value.'</li>'.PHP_EOL;
      }
    echo '</ul>'.PHP_EOL;
    echo '</div>'.PHP_EOL;
  }

  function fn_write_container_card($arr, $str_theme_color="dark"){

    $str_border='border border-light';
    echo('<div class="d-flex flex-row w-50 p-3 my-3 bg-'.$str_theme_color.' text-white rounded-lg '.$str_border.'">'."\r\n");
    echo('<table class="recordtable">'."\r\n");
    foreach ($arr as $key => $value) {
      $foo_value=$value;
      echo('<tr><td class="recordlabel">'.$key.':&nbsp;</td><td class="recordvalue">'.$foo_value.'</td></tr>'."\r\n");
    }
    echo('</table>'."\r\n");
    echo("</div>\r\n");
  }

  function fn_get_array_value($array, $key){
    return $array[$key] ?? "";
  }

  function fn_write_array($arr){

    $str_border='border border-light';
    //$str_border='';
    echo('<div class="container p-3 my-3 bg-dark text-white rounded-lg '.$str_border.'">'."\r\n");
    if (empty($arr)) {
      echo "No Records";
    }
    echo('<table class="recordtable">'."\r\n");
    foreach ($arr as $key => $value) {
      $foo_value=$value;
      if(is_array($foo_value)){
          $foo_value="native array";
      }
      else if(is_object($foo_value)){
        $foo_value="native object";
      }

      echo('<tr><td class="recordlabel">'.$key.':&nbsp;</td><td class="recordvalue">'.$foo_value.'</td></tr>'."\r\n");
    }
    echo('</table>'."\r\n");
    echo("</div>\r\n");
  }
}
?>
