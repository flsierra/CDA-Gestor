<?php require_once('../Connections/Conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../Login/Privilegios.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET nombres_apellidos=%s, identificacion=%s, correo=%s, telefono=%s, rol=%s, password=%s WHERE id_usuario=%s",
                       GetSQLValueString($_POST['nombres_apellidos'], "text"),
                       GetSQLValueString($_POST['identificacion'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['rol'], "int"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['id_usuario'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($updateSQL, $Conexion) or die(mysql_error());

  $updateGoTo = "Usuarios_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varUsuario_Recordset1 = "0";
if (isset($_GET['recordID'])) {
  $varUsuario_Recordset1 = $_GET['recordID'];
}
mysql_select_db($database_Conexion, $Conexion);
$query_Recordset1 = sprintf("SELECT * FROM usuarios WHERE usuarios.id_usuario =%s", GetSQLValueString($varUsuario_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $Conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
    <h1>Editar Usuario</h1>
    
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nombres y Apellidos</td>
          <td><input type="text" name="nombres_apellidos" value="<?php echo htmlentities($row_Recordset1['nombres_apellidos'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Identificacion</td>
          <td><input type="text" name="identificacion" value="<?php echo htmlentities($row_Recordset1['identificacion'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Correo</td>
          <td><input type="text" name="correo" value="<?php echo htmlentities($row_Recordset1['correo'], ENT_COMPAT, 'utf-8'); ?>" size="32" required="" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Telefono</td>
          <td><input type="text" name="telefono" value="<?php echo htmlentities($row_Recordset1['telefono'], ENT_COMPAT, 'utf-8'); ?>" size="32" required="" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Rol</td>
          <td><select name="rol">
            <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['rol'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Administrador</option>
            <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['rol'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Estandar</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Contraseña</td>
          <td><input type="password" name="password" value="" size="32" required=""/></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Actualizar Usuario" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id_usuario" value="<?php echo $row_Recordset1['id_usuario']; ?>" />
    </form>
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
<?php
mysql_free_result($Recordset1);
?>
