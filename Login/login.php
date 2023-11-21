<?php require_once('../Connections/Conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_Conexion, $Conexion);
$query_Recordset1 = "SELECT correo, password FROM usuarios";
$Recordset1 = mysql_query($query_Recordset1, $Conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['txtEmail'])) {
  $loginUsername=$_POST['txtEmail'];
  $password=$_POST['txtPassword'];
  $MM_fldUserAuthorization = "rol";
  $MM_redirectLoginSuccess = "../admin/index.php";
  $MM_redirectLoginFailed = "../login/error.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Conexion, $Conexion);
  	
  $LoginRS__query=sprintf("SELECT correo, password, rol FROM usuarios WHERE correo=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $Conexion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'rol');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestor Documental ReviBoyacá</title>
</head>
 <meta name="viewport" content="width=device-width, initial-scale=1" />
 <link rel="shorcut icon" href="../images/logo.jpg"/>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="keywords" content="Gaze Sign up & login Form Responsive Widget, Audio and Video players, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design"
         />
      <script>
         addEventListener("load", function () { setTimeout(hideURLbar, 0); }, false); function hideURLbar() { window.scrollTo(0, 1); }
      </script>
      <link href="../css/style.css" rel='stylesheet' type='text/css' media="all">
      <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
   </head>
   <body>
      <div class="mid-class">
         <div class="art-right-w3ls">
            <h2>Inicie Sesion</h2>
            <form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST">
            <div class="main">
              <div class="form-left-to-w3l">
                <input type="text" name="txtEmail" placeholder="Usuario" required="">
              </div>
              <div class="form-left-to-w3l ">
                <input type="password" name="txtPassword" placeholder="Contraseña" required="">
                <div class="clear"></div>
              </div>
            </div>
            <div class="clear"></div>
            <div class="btnn">
              <button type="submit" name="button" id="button"> Iniciar Sesion </button>
            </div>
            </form>
            <div id="content1" class="popup-effect">
               <div class="popup">

                  <a class="close" href="#">&times;</a>
               </div>
            </div>
            <!-- //popup -->
         </div>
         <div class="art-left-w3ls">
            <h1 class="header-w3ls">
              Inicie su sesion por favor para poder
              ingresar al Gestor Documental
            </h1>
         </div>
      </div>
      <footer class="bottem-wthree-footer">
      </footer>
   </body>
</html>
<?php
mysql_free_result($Recordset1);
?>
