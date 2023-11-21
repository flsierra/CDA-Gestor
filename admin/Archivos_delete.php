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

if ((isset($_GET['recordID'])) && ($_GET['recordID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM documentos WHERE id_documento=%s",
                       GetSQLValueString($_GET['recordID'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($deleteSQL, $Conexion) or die(mysql_error());

  $deleteGoTo = "Archivos_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestor Documental ReviBoyacá</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../css/estilo_principal.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.jpg" />
</head>

<body>

<div class="container">
  <div class="header"><!-- end .header --></div>
  <div class="sidebar1">
<?php 
include ("../includes/cabeceraadmin.php")
?>
  </div>
  <div class="content"><!-- InstanceBeginEditable name="Contenido" -->
    <H1>Eliminando Archivos</H1>
    <p>Eliminando... Por favor Aguarde un momento...</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  <!-- InstanceEndEditable -->
 
  <!-- end .content --></div>
  <div class="footer">
    <p>Administracion de Archivos Gestor Documental Reviboyacá, ©Todos los derehos reservados 2019      <!-- end .footer --></p>
  </div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
