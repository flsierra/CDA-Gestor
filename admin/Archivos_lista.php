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

$maxRows_lista_documentos = 10;
$pageNum_lista_documentos = 0;
if (isset($_GET['pageNum_lista_documentos'])) {
  $pageNum_lista_documentos = $_GET['pageNum_lista_documentos'];
}
$startRow_lista_documentos = $pageNum_lista_documentos * $maxRows_lista_documentos;

mysql_select_db($database_Conexion, $Conexion);
$query_lista_documentos = "SELECT * FROM documentos ORDER BY documentos.fecha ASC";
$query_limit_lista_documentos = sprintf("%s LIMIT %d, %d", $query_lista_documentos, $startRow_lista_documentos, $maxRows_lista_documentos);
$lista_documentos = mysql_query($query_limit_lista_documentos, $Conexion) or die(mysql_error());
$row_lista_documentos = mysql_fetch_assoc($lista_documentos);

if (isset($_GET['totalRows_lista_documentos'])) {
  $totalRows_lista_documentos = $_GET['totalRows_lista_documentos'];
} else {
  $all_lista_documentos = mysql_query($query_lista_documentos);
  $totalRows_lista_documentos = mysql_num_rows($all_lista_documentos);
}
$totalPages_lista_documentos = ceil($totalRows_lista_documentos/$maxRows_lista_documentos)-1;

$queryString_lista_documentos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_lista_documentos") == false && 
        stristr($param, "totalRows_lista_documentos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_lista_documentos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_lista_documentos = sprintf("&totalRows_lista_documentos=%d%s", $totalRows_lista_documentos, $queryString_lista_documentos);
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
    <h1>Listado de Archivos </h1>
    <p><a href="Archivos_add.php">Añadir Archivos</a> <a href="Archivos_add.php"><img src="../images/add.jpg" width="82" height="60"/></a> </p>
    <p><a href="Archivos_search.php">Buscar Archivo</a> <a href="Archivos_search.php"><img src="../images/search.jpg" width="82" height="60"/></a></p>
   
    <table width="100%" border="0">
      <tr>
      <td bgcolor="#00FFFF"><strong>Placa Vehiculo</strong></td>
        <td bgcolor="#00FFFF"><strong>Fecha</strong></td>
        <td bgcolor="#00FFFF"><strong>Registro RTM y EC</strong></td>
        <td bgcolor="#00FFFF"><strong>Acciones</strong></td>
      </tr>
     
      <?php do { ?>
        <tr>
        <td><?php echo $row_lista_documentos['descripcion']; ?></td>
          <td><?php echo $row_lista_documentos['fecha']; ?></td>
          <td><a href="archivo.php?recordID=<?php echo $row_lista_documentos['id_documento']; ?>"><?php echo $row_lista_documentos['soporte']; ?></a></td>
          <td> <a href="Archivos_edit.php?recordID=<?php echo $row_lista_documentos['id_documento']; ?>"><img src="../images/edit.jpg" width="41" height="40"/></a> / <a href="Archivos_delete.php?recordID=<?php echo $row_lista_documentos['id_documento']; ?>"><img src="../images/delet.jpg" width="41" height="40"/></a></td>
        </tr>
        <?php } while ($row_lista_documentos = mysql_fetch_assoc($lista_documentos)); ?>
 
    </table>
    <p>&nbsp;    </p>
    <table border="0">
      <tr>
        <td><?php if ($pageNum_lista_documentos > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_lista_documentos=%d%s", $currentPage, 0, $queryString_lista_documentos); ?>">Primero</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_lista_documentos > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_lista_documentos=%d%s", $currentPage, max(0, $pageNum_lista_documentos - 1), $queryString_lista_documentos); ?>">Anterior</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_lista_documentos < $totalPages_lista_documentos) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_lista_documentos=%d%s", $currentPage, min($totalPages_lista_documentos, $pageNum_lista_documentos + 1), $queryString_lista_documentos); ?>">Siguiente</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_lista_documentos < $totalPages_lista_documentos) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_lista_documentos=%d%s", $currentPage, $totalPages_lista_documentos, $queryString_lista_documentos); ?>">&Uacute;ltimo</a>
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
mysql_free_result($lista_documentos);
?>
