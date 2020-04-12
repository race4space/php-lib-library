<?php
namespace phplibrary;
class Auth{
  use General;
  function __construct() {
    $this->username="race4space";
    $this->userpass="letmein";
    $this->server_address=$_SERVER['SERVER_ADDR'];
    $this->local_address="127.0.0.1";
  }
  function fn_check(){
    session_start();
    if ( isset( $_SESSION['logged-in'] ) ) {}
    else {
        header("Location: /login");
        die();
    }
  }
  function fn_check_ajax(){
    session_start();
    if ( isset( $_SESSION['logged-in'] ) ) {}
    else {
        die('Please <a href="/login">login</a>');
        die();
    }
  }
  function fn_logout(){
    // Initialize the session.
    // If you are using session_name("something"), don't forget it now!
    session_start();
    // Unset all of the session variables.
    $_SESSION = array();
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    // Finally, destroy the session.
    session_destroy();
    //Send Redirect Header
    header("Location: /login");
    //Die
    die();
  }
  function fn_login(){
    $this->fn_check_submission();
    //WRITE FORM IN INDEX.PHP, INCLUDES SITE SPECIFIC KEY
  }
  function fn_check_submission(){
    $login_redirect="/";
      if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return;
      }
      //START post_captcha VIA GOOGLE
      if($this->server_address!=$this->local_address){
        $res = post_captcha($_POST['g-recaptcha-response']);//comment out to  bypass reaptcha
        //$res['success']=true; //uncomment to  bypass reaptcha
      }
      else{
        $res['success']=true;
      }
      //END post_captcha VIA GOOGLE
      if (!$res['success']) {
          // What happens when the CAPTCHA wasn't checked
          //echo '<p>Please go back and make sure you check the security CAPTCHA box.</p><br>';
      }
      else {//START If CAPTCHA is successfully completed...
          session_start();
          if ( ! empty( $_POST ) ) {
            if (isset($_POST["login-pass"])){
            	if($_POST["login-pass"]==="$this->userpass" and $_POST["login-name"]==="$this->username"){
                $_SESSION["logged-in"]=true;
                header("Location: ".$login_redirect);
            	}
            }
          }
      }//END If CAPTCHA is successfully completed...
  }//END fn_check_submission
}//END CLS
