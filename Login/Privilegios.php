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

$colname_Privilegios = "-1";
if (isset($_GET['id_usuario'])) {
  $colname_Privilegios = $_GET['id_usuario'];
}
mysql_select_db($database_Conexion, $Conexion);
$query_Privilegios = sprintf("SELECT * FROM usuarios WHERE usuarios.id_usuario = %s", GetSQLValueString($colname_Privilegios, "int"));
$Privilegios = mysql_query($query_Privilegios, $Conexion) or die(mysql_error());
$row_Privilegios = mysql_fetch_assoc($Privilegios);
$totalRows_Privilegios = mysql_num_rows($Privilegios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestor Documental ReviBoyacá</title>
 <link rel="shorcut icon" href="../images/logo.jpg"/>
</head>

<body>
<h1>Usted no tiene privilegios para Ingresar a esta pagina....</h1>
<br />
      <a href="../admin/index.php">Volver</a><br />
      <br />
</body>
</html>
<?php
mysql_free_result($Privilegios);
?>
