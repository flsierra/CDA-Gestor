<title>Gestor Documental ReviBoyacá</title>
<link rel="shorcut icon" href="../images/logo.jpg"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Usuarios_search.php" id="cdr" >
  <h1><strong>Buscar Cliente </strong></h1>
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder="Nombre" required=""><br /><br />
        <input type="submit" name="Submit" value="Buscar Usuario" />
  </p>
      </p>
  <p><a href="Usuarios_lista.php">Lista de Usuarios</a></p>
</form>
</center>
 <p>
  <style type="text/css">
input{outline:none;border:0px;}
#busqueda{background:#fff;color:#000;}
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
$busqueda=mysql_query("SELECT id_usuario,nombres_apellidos,identificacion,correo,telefono FROM usuarios WHERE nombres_apellidos LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="1166" border="1" id="tab">
   <tr>
     <td width="19" bgcolor="#00FFFF"><strong>Nombres y Apellidos </strong></td>
     <td width="61" bgcolor="#00FFFF"><strong>Identificación</strong></td>
     <td width="157" bgcolor="#00FFFF"><strong>Correo </strong></td>
     <td width="221" bgcolor="#00FFFF"><strong>Telefono</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Acciones</strong></td>
     
   
  </tr>
 
<?php

while($f=mysql_fetch_array($busqueda)){
echo '<tr>';
echo '<td width="20">'.$f['nombres_apellidos'].'</td>';
echo '<td width="61">'.$f['identificacion'].'</td>';
echo '<td width="157">'.$f['correo'].'</td>';
echo '<td width="157">'.$f['telefono'].'</td>';
echo '<td>'.'<a href="Usuarios_edit.php?recordID='.$f['id_usuario'].'">'.'Modificar'.'</a>'.'</td>';
echo '<td>'.'<a href="Usuarios_delete.php?recordID='.$f['id_usuario'].'">'.'Eliminar'.'</a>'.'</td>';




echo '</tr>';

}

}
?>

</table>
