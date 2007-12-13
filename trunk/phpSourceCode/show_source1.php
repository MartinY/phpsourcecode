<?php 

/* 
    func_info(int funcion) Función que busca información sobre funciones en PHP.net 
    Creada por Omar Soto (OmaRPR) para PHP-Hispano.net (#php_para_torpes) 
    Para dudas enviame un email o añademe a tu msn. OmaRPR <omarpr@gmail.com 
*/ 

function func_info ($funcion) { 
    $funcionn = str_replace('_','-',$funcion); 
    $url = 'http://es2.php.net/manual/es/print/function.'.strtolower($funcionn).'.php'; 

    // Si conecte a PHP.net correctamente 
    if($contenido = @file($url)) { 
        // Convierto el array en una variable y saco los saltos de linea 
        $contenido = implode($contenido); $contenido = str_replace("\n","",$contenido); 
             
        // Saco la sintaxis 
        preg_match_all('/<\/H2>(.*)<BR>/i',$contenido,$sintaxis); 
        $sintaxis = (isset($sintaxis[1][0])) ? strip_tags($sintaxis[1][0]) : FALSE; 
         
        // Saco las versiones y la descripción 
        preg_match_all('/<P>(.*)<DIVCLASS="refsect1">/i',$contenido,$verydesc); 
        $verydesc = strip_tags($verydesc[1][0]); 
         
        // Saco las versiones 
        preg_match_all('/\((.*)\)/i',$verydesc,$versiones); 
        $versiones = (isset($versiones[1][0])) ? '('.$versiones[1][0].')' : FALSE; 
        $versiones = str_replace('&#62;','>',$versiones); 
                     
        // Saco la descripción 
        preg_match_all('/--&nbsp;(.*)/i',$verydesc,$descripcion); 
        $descripcion = (isset($descripcion[1][0])) ? trim($descripcion[1][0]) : FALSE; 
         
        // Seteo el array 
        if(isset($sintaxis)) $return['sintaxis'] = $sintaxis; 
        if(isset($versiones)) $return['versiones'] = $versiones; 
        if(isset($descripcion)) $return['descripcion'] = $descripcion; 
    } 
     
    // Retorno el array si eh conseguido la función, sino retorno FALSE 
    return (isset($return)) ? $return : FALSE; 
} 


// Probando la función, Recuerda que para buscar informacion tiene que estar conectado a internet 
echo '<pre>'; 
print_r(func_info('mysql_query')); 
echo '</pre>'; 

?> 
