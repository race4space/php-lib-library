<?php
namespace phplibrary;
class Auth{
  function __construct() {
    use General;
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
    $this->fn_write_form();
  }

  function fn_check_submission(){


    $login_redirect="/";

      if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return;
      }
      //START Call the function post_captcha
      if($this->server_address!=$this->local_address){
        $res = post_captcha($_POST['g-recaptcha-response']);
      }
      else{
        $res['success']=true;
      }
      //END Call the function post_captcha

      if (!$res['success']) {
          // What happens when the CAPTCHA wasn't checked
          //echo '<p>Please go back and make sure you check the security CAPTCHA box.</p><br>';
      }
      else {
          // If CAPTCHA is successfully completed...
          session_start();
          if ( ! empty( $_POST ) ) {
            if (isset($_POST["login-pass"])){
            	if($_POST["login-pass"]==="$this->userpass"){
                $_SESSION["logged-in"]=true;
                header("Location: ".$login_redirect);
            	}
            }
          }
      }
  }
  function post_captcha($user_response) {
      $fields_string = '';
      $fields = array(
          'secret' => '6LcmZuIUAAAAABqMmfeYR6X8ga1LDB81yQysvi8i',
          'response' => $user_response
      );
      foreach($fields as $key=>$value)
      $fields_string .= $key . '=' . $value . '&';
      $fields_string = rtrim($fields_string, '&');

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
      curl_setopt($ch, CURLOPT_POST, count($fields));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result, true);
  }//END function post_captcha
  function fn_write_form(){
    echo <<< CLIENT
    <div class="d-flex justify-content-center h-75">
    <form class="form-inline text-center"  action="/login/" method="post">
    <input type="hidden" name="_csrfToken" autocomplete="off" value=""/>
    <input type="password" name="login-pass" value="" placeholder="Please login..." class="form-control input-lg">&nbsp;
    <input type="submit" value="Login" >&nbsp;&nbsp;
  CLIENT;
    if($this->server_address!=$this->local_address){
    echo <<< CLIENT
    <div class="g-recaptcha" data-sitekey="6LcmZuIUAAAAAPDkQEV9vCJ0_zYC3XevztFU9JYI"></div>
  CLIENT;
    }
    echo <<< CLIENT
    </form>
    </div>
  CLIENT;
  }
}
