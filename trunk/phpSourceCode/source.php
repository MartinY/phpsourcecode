<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">  
<head>  
<title>Show Source v1.0</title>  
<style type="text/css">  
<!--  
body { margin: 0; padding: 0; }  
div#dir { margin: 1%; }  
-->  
</style>  
</head>  

<body>  
<?php
$_GET['ver']='./buscaminas';
if ($_GET['ver']) {
   if ($_GET['ver'] == "show_source") {
      die("<div style=\"margin: 1%\">Lo siento, no puedes acceder al código fuente de este archivo</div>\n</body>\n</html>\n");
   }
   if (file_exists($_GET['ver'] .".php")) {
      $file = "{$_GET['ver']}.php";
      $archivo = file($file);  # Abrimos el archivo
      $lineas = count($archivo);  # Contamos el número de líneas que tiene
      $filesize = filesize($file);  # Obtenemos el tamaño en bytes
      $tamaño = round($filesize/1024, 2);  # Pasamos el tamaño a Kilobytes
?>  
<div id="php">  
<table width="100%" cellpadding="0" cellspacing="0" border="0">  
<tr>  
  <td style="background: #eee;">  
  <code>  
<?php
# Mostramos algunos datos del archivo que se está mostrando 
  echo " <b>Archivo:</b> {$file}";   
  echo " <b>Líneas:</b> {$lineas}";   
  echo " <b>Tamaño:</b> {$tamaño}Kb";   
?>  
  </code>  
  </td>  
</tr>  
</table>  
<table width="100%" cellpadding="0" cellspacing="0" border="0">  
<tr>  
  <td valign="top" style="background: #eee;">  
  <code>  
<?php
 for ($x=1; $x <= $lineas; $x++) {   
     echo " ".$x." <br />\n"; # Imprimimos los números de líneas 
 }   
?>  
  </code>  
  </td>  
  <td valign="top">  
   <code>  
<?php
# Reemplazamos las funciones con links hacia su documentación en http://php.net 
$codigo = show_source($file,1);  
$functionscolor = ini_get("highlight.keyword");  
$manual = "http://www.php.net/manual-lookup.php?lang=es&pattern=";  
$codigo = preg_replace(  
            '{([\w_]+)(\s*</font>)'.  
            '(\s*<font\s+color="'.$functionscolor.'">\s*\()}m',    
            '<a href="'.$manual.'$1" title="$1() en PHP.net" target="_blank">$1</a>$2$3',  
            $codigo);  
$codigo = eregi_replace('<font color="#([A-F0-9]{6})">', '<span style="color: #\\1">', $codigo);  
$codigo = str_replace('</font>', '</span>', $codigo);  
echo $codigo;  
?>  
   </code>  
  </td>  
</tr>  
</table>  
</div> 
<?php
   }
   else {
      echo "<div style=\"margin: 1%\">Lamento decirte, que el archivo: <strong><em>{$_GET['ver']}.php</em></strong> no existe</div>\n";
   }
}
else {
   echo "<div id=\"dir\">\nSeleccione alguno de estos archivos para ver el código fuente:\n<ul>\n";
   $rep=opendir("."); # Abrimos el directorio, en el cuál se encuentra en show_source.php
   while ($file = readdir($rep)) {
      if ($file != '..' && $file !='.' && $file !='') {
         $ext = strtolower(substr($file,-4,4)); # Quitamos la extensión .php y ponemos el nombre en minisculas 
         if (is_file($file) && ($ext == ".php") && ($file != "show_source.php")) { # Muestra los archivo con extensión .php y hace que no se muestre el show_source.php 
            $link="<a title=\"Ver código fuente\" href=\"?ver=".strtolower(substr($file,0,-4))."\">".strtolower(substr($file,0,-4))."</a>"; #Link de archivos para ver código fuente 
            echo "<li>$link</li>\n";
         }
      }
   }
   echo"</ul>\n</div>";
   closedir($rep); # Cerramos el directorio
   clearstatcache(); # Borramos la cache
}  
?> 
</body>  
</html> 