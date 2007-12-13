<?php

// phpSourceCode v0.5
// uso:
// if (isset($_GET['phpSourceCode'])) include 'phpSourceCode.php';

$archivo = file(basename($_SERVER['PHP_SELF']));
$lineas = count($archivo);
$filesize = filesize(basename($_SERVER['PHP_SELF']));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
<title>Show Source: <?php echo basename($_SERVER['PHP_SELF']); ?></title>
<style type="text/css">
<!--
body { margin: 0px; padding: 0px; }
#barra_superior { background-color: #eee; }
#linea span { display: block; }
#linea .par { background-color: #ee0; }
#linea .impar { background-color: #ee9; }
-->
</style>
</head>

<body>

<div id="php" style="position: absolute;">
   <div id="barra_superior">
      <div id="datos" style="position: relative">
         <code>
<?php
// Mostramos información sobre el archivo mostrado
  echo ' <b>Archivo:</b> '.basename($_SERVER['PHP_SELF']);
  echo ' <b>Líneas:</b> '.$lineas;
  echo ' <b>Tamaño:</b> '.round($filesize/1024, 2).'Kb';
?>
         </code>
      </div>
      <div id="opciones" style="position: relative; text-align: right;">
         <code>
         opciones
         </code>
      </div>
   </div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
  <td valign="top" style="background: #eee;">
  <div id="linea">
  <code>
<?php
// Imprimimos los numeros de linea
for ($x=1; $x <= $lineas; $x++) {
   if ($x%2 == 0) {
      echo '<span class="par">'.$x.'</span>'."\n";
   }
   else {
      echo '<span class="impar">'.$x.'</span>'."\n";
   }
}
?>
  </code>
  </div>
  </td>
  <td valign="top">
   <code>
<?php
# Reemplazamos las funciones con links hacia su documentación en http://php.net
$codigo = show_source(basename($_SERVER['PHP_SELF']),1);
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

</body>

</html>

<?php exit; ?>