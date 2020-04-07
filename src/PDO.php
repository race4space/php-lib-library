<?php
namespace phplibrary;

class PDO {

  public $pdo;
  public $db;

  function __construct() {
  }

  public function fn_connect($host, $user, $pass, $db="", $charset="utf8",$str_name="myPDO") {
    //parent::__construct($str_name);
    $dsn = "mysql:host=$host;charset=$charset;";
    if(!empty($db)){
        $dsn.="dbname=$db";
    }
    $options = [
        \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES=>false,
        \PDO::ATTR_PERSISTENT=>true
    ];

    try {
        $this->db=$db;
        $this->pdo = new \PDO($dsn, $user, $pass, $options);
        $this->str_default_user=$user;
        $this->str_default_schema=$this->fn_get_default_schema();
        //$this->fn_echo("this->str_default_schema", $this->str_default_schema);
        $this->int_count_process=$this->fn_count_process();
        //$this->fn_echo("this->int_count_process", $this->int_count_process);
        //$this->fn_check_pool();
     } catch (\PDOException $e) {
       //throw new \PDOException($e->getMessage(), (int)$e->getCode());
       $this->fn_write_message("Error", "Connection failed: " . $e->getMessage());
       die();
    }
  }

  public function fn_get_default_schema() {

    $str_sql="SELECT DATABASE();;";
    $stmt=$this->pdo->query($str_sql);
    return $stmt->fetchColumn();
  }
  public function fn_check_pool() {
    $int_count_a=$this->fn_count_process();
    $this->fn_echo("int_count_a", $int_count_a);
    $int_count_b=$this->fn_count_process();
    $this->fn_echo("int_count_b", $int_count_b);
    $bln_result=true;
    if($int_count_a<>$int_count_b){
      $bln_result=false;
    }
    $this->fn_echo("bln_result", $bln_result);
  }
  public function fn_count_process() {
    $str_schema="IS NULL";
    if(!empty($this->str_default_schema)){
      $str_schema="='$this->str_default_schema'";
    }
    $str_sql="SELECT count(id) FROM INFORMATION_SCHEMA.PROCESSLIST WHERE user='$this->str_default_user' and DB $str_schema;";
    //$this->fn_echo("str_sql", $str_sql);
    $stmt=$this->pdo->query($str_sql);
    $int_count=$stmt->fetchColumn();
    return $int_count;
  }

  public static function interpolateQuery($query, $params) {

    /*
    **
   * Replaces any parameter placeholders in a query with the value of that
   * parameter. Useful for debugging. Assumes anonymous parameters from
   * $params are are in the same order as specified in $query
   *
   * @param string $query The sql query with parameter placeholders
   * @param array $params The array of substitution parameters
   * @return string The interpolated query
   */

      $keys = array();

      # build a regular expression for each parameter
      foreach ($params as $key => $value) {
          if (is_string($key)) {
              $keys[] = '/:'.$key.'/';
          } else {
              $keys[] = '/[?]/';
          }
      }

      $query = preg_replace($keys, $params, $query, 1, $count);
      #trigger_error('replaced '.$count.' keys');

      return $query."<br>";
  }
  function fn_get_simple_count($str_sql, $int_id){

    $str_sql=preg_replace('/'.preg_quote("*", '/').'/', "count(*)", $str_sql, 1);
    $stmt = $this->pdo->prepare($str_sql);
    $stmt->execute([$int_id]);
    $row = $stmt->fetch();

    $int_count=0;
    if($row){$int_count=$row["count(*)"];}
    return $int_count;
  }

  function __destruct() {
    $this->pdo = null;
  }

  function fn_debug_write_rs($stmt){
    $int_column_count=$stmt->columnCount();
    echo '<table id="my-table" class="display" style="width:100%;border-collapse:collapse">'.PHP_EOL;
    echo "<thead>".PHP_EOL;
    echo "<tr>".PHP_EOL;
    for ($i = 0; $i < $int_column_count; $i++) {
        $col = $stmt->getColumnMeta($i);
        echo "<th style='border:1px solid black'>".$col['name']."</th>".PHP_EOL;
    }
    echo "</tr>".PHP_EOL;
    echo "</thead>".PHP_EOL;
    echo "<tbody>".PHP_EOL;
    while($row=$stmt->fetch(PDO::FETCH_NUM)){
      echo "<tr>".PHP_EOL;
      for ($i = 0; $i < $int_column_count; $i++) {
          echo "<td style='border:1px solid black'>".$row[$i]."</td>".PHP_EOL;
      }
      echo "</tr>".PHP_EOL;
    }
    echo "</tbody>".PHP_EOL;
    echo "</table>".PHP_EOL;
  }
  function fn_echo($lab, $str=""){
    $s="<div>";
    $s.=$lab;
    if(!empty($str) or  $str==="0"){
      $s.=": ";
      $s.=$str;
    }
    $s.="</div>".PHP_EOL;
    echo($s);
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
    $this->fn_write_container($str);
  }
  function fn_write_container($str){
    echo '<div class="container p-3 my-3 bg-dark text-white rounded-lg">'."\r\n";
    echo $str."\r\n";
    echo '</div>'."\r\n";
  }
}//END CLS PDO
?>
