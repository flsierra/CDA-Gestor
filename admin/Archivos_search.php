<title>Gestor Documental ReviBoyacá</title>
<link rel="shorcut icon" href="../images/logo.jpg"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Archivos_search.php" id="cdr" >
  <h1><strong>Buscar Archivos </strong></h1>
 
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder =" Placa" required=""><br /><br />
        <input type="submit" name="Submit" value="Buscar Archivos" />
        </p>
      </p>
  <p><a href="Archivos_lista.php">Lista de Archivos</a></p>
</form>
</center>
 <p>
  <style type="text/css">
input{outline:none;border:0px;}
#busqueda{background:#FFF;color:#000;}
#cdr{padding:5px;background:#9CC;width:220px;border-radius:10px 0px 0px 10px;}
#tab{background:#CCC;;border-radius:10px 10px 10px 10px;}
</style>
   
  <?php
$busca="";
if(isset($_POST['busca']))
$busca=$_POST['busca'];
mysql_connect("localhost","root","");// si haces conexion desde internnet usa 3 parametros si es a nivel local solo 2
mysql_select_db("gestor_documental");//nombre de la base de datos
if(isset($_POST['busca']))
$busca=$_POST['busca'];
if($busca!=""){
$busqueda=mysql_query("SELECT id_documento,descripcion,fecha,soporte FROM documentos WHERE descripcion LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="100%" border="1" id="tab">
   <tr>
   <td bgcolor="#00FFFF"><strong>Descripcion </strong></td>
     <td bgcolor="#00FFFF"><strong>Fecha </strong></td>
     <td  bgcolor="#00FFFF"><strong>Documentos</strong></td>
      <td  bgcolor="#00FFFF"><strong>Acciones</strong></td>
     
   
  </tr>
 
<?php

while($f=mysql_fetch_array($busqueda)){
echo '<tr>';
echo '<td width="20">'.$f['descripcion'].'</td>';
echo '<td width="20">'.$f['fecha'].'</td>';
echo '<td width="20">'.$f['soporte'].'</td>';
echo '<td>'.'<a href="Archivos_edit.php?recordID='.$f['id_documento'].'">'.'Modificar'.'</a>'.'</td>';




echo '</tr>';

}

}
?>

</table>

