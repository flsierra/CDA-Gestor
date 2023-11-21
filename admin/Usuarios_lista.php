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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Lista_Usuarios = 10;
$pageNum_Lista_Usuarios = 0;
if (isset($_GET['pageNum_Lista_Usuarios'])) {
  $pageNum_Lista_Usuarios = $_GET['pageNum_Lista_Usuarios'];
}
$startRow_Lista_Usuarios = $pageNum_Lista_Usuarios * $maxRows_Lista_Usuarios;

mysql_select_db($database_Conexion, $Conexion);
$query_Lista_Usuarios = "SELECT * FROM usuarios ORDER BY usuarios.nombres_apellidos ASC";
$query_limit_Lista_Usuarios = sprintf("%s LIMIT %d, %d", $query_Lista_Usuarios, $startRow_Lista_Usuarios, $maxRows_Lista_Usuarios);
$Lista_Usuarios = mysql_query($query_limit_Lista_Usuarios, $Conexion) or die(mysql_error());
$row_Lista_Usuarios = mysql_fetch_assoc($Lista_Usuarios);

if (isset($_GET['totalRows_Lista_Usuarios'])) {
  $totalRows_Lista_Usuarios = $_GET['totalRows_Lista_Usuarios'];
} else {
  $all_Lista_Usuarios = mysql_query($query_Lista_Usuarios);
  $totalRows_Lista_Usuarios = mysql_num_rows($all_Lista_Usuarios);
}
$totalPages_Lista_Usuarios = ceil($totalRows_Lista_Usuarios/$maxRows_Lista_Usuarios)-1;

$queryString_Lista_Usuarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Lista_Usuarios") == false && 
        stristr($param, "totalRows_Lista_Usuarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Lista_Usuarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Lista_Usuarios = sprintf("&totalRows_Lista_Usuarios=%d%s", $totalRows_Lista_Usuarios, $queryString_Lista_Usuarios);
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
    <h1>Lista de Usuarios</h1>
    <p><a href="Usuarios_add.php">Añadir Usuario</a> <a href="Usuarios_add.php"><img src="../images/add.jpg" width="82" height="60"/></a></p>   <p><a href="Usuarios_search.php">Buscar Usuario</a> <a href="Usuarios_search.php"><img src="../images/search.jpg" width="82" height="60"/></a></p>
    
    <table width="100%" border="0">
      <tr>
        <td bgcolor="#00FFFF"><strong>Nombres y Apellidos</strong></td>
        <td bgcolor="#00FFFF"><strong>Identificación</strong></td>
        <td bgcolor="#00FFFF"><strong>Correo</strong></td>
        <td bgcolor="#00FFFF"><strong>Telefonó</strong></td>
        <td bgcolor="#00FFFF"><strong>Acciones</strong></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_Lista_Usuarios['nombres_apellidos']; ?></td>
          <td><?php echo $row_Lista_Usuarios['identificacion']; ?></td>
          <td><?php echo $row_Lista_Usuarios['correo']; ?></td>
          <td><?php echo $row_Lista_Usuarios['telefono']; ?></td>
          <td><a href="Usuarios_edit.php?recordID=<?php echo $row_Lista_Usuarios['id_usuario']; ?>"><img src="../images/edit.jpg" width="21" height="20"/></a> / <a href="Usuarios_delete.php?recordID=<?php echo $row_Lista_Usuarios['id_usuario']; ?>"><img src="../images/delet.jpg" width="21" height="20"/></a></td>
        </tr>
        <?php } while ($row_Lista_Usuarios = mysql_fetch_assoc($Lista_Usuarios)); ?>
    </table>
    <p>&nbsp;</p>
    <table border="0">
      <tr>
        <td><?php if ($pageNum_Lista_Usuarios > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Lista_Usuarios=%d%s", $currentPage, 0, $queryString_Lista_Usuarios); ?>">Primero</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_Lista_Usuarios > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Lista_Usuarios=%d%s", $currentPage, max(0, $pageNum_Lista_Usuarios - 1), $queryString_Lista_Usuarios); ?>">Anterior</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_Lista_Usuarios < $totalPages_Lista_Usuarios) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Lista_Usuarios=%d%s", $currentPage, min($totalPages_Lista_Usuarios, $pageNum_Lista_Usuarios + 1), $queryString_Lista_Usuarios); ?>">Siguiente</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_Lista_Usuarios < $totalPages_Lista_Usuarios) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Lista_Usuarios=%d%s", $currentPage, $totalPages_Lista_Usuarios, $queryString_Lista_Usuarios); ?>">&Uacute;ltimo</a>
            <?php } // Show if not last page ?></td>
      </tr>
    </table>
    </p>
    
  <!-- InstanceEndEditable -->
 
  <!-- end .content --></div>
  <div class="footer">
    <p>Administracion de Archivos Gestor Documental Reviboyacá, ©Todos los derehos reservados 2019      <!-- end .footer --></p>
  </div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Lista_Usuarios);
?>
