<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestor Documental ReviBoyacá</title>
<link rel="shorcut icon" href="../images/logo.jpg"/>
</head>

<body>
  <?php
        include 'config.inc.php';
        $db=new Conect_MySql();
            $sql = "select* from documentos where id_documento=".$_GET['recordID'];
            $query = $db->execute($sql);
            if($datos=$db->fetch_row($query)){
                if($datos['soporte']==""){?>
        <p>NO tiene archivos</p>
                <?php }else{ ?>
        <p><a href="Archivos_lista.php">Volver a Lista de Archivos</a></p>
        <center>
        <iframe src="../DocumentosPDF/<?php echo $datos['soporte']; ?>" height="600px" width="700px"></iframe></center>
                
                <?php } } ?>
</body>
</html>