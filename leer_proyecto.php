<?php
/**
 * Script para extraer contenido de archivos del proyecto
Cómo usarlo:
Abre tu terminal en C:\xampp\htdocs\miPHP.

Ejecuta el comando:

Bash
php leer_proyecto.php
 *
 *
Tip Pro: Si quieres guardar todo eso en un solo archivo de texto para leerlo luego o enviarlo, usa el redireccionamiento de la terminal:

Bash
php leer_proyecto.php > resumen_codigo.txt
¿Por qué este script y no otro?
Recursividad: Entra en todas las subcarpetas (Models, Controllers, etc.) automáticamente.

Filtros: No te saca la basura de la carpeta vendor, que tiene miles de líneas de código que no has escrito tú.

Claridad: Pone separadores para que sepas dónde empieza y termina cada clase.

 */

// Configuración: Carpetas que queremos leer
$directorios = ['src', 'public', 'views'];
// Extensiones que nos interesan
$extensiones = ['php', 'json', 'env', 'example'];
// Archivos o carpetas a ignorar
$ignorar = ['vendor', 'composer.lock', '.git'];

echo "=== CONTENIDO DEL PROYECTO miPHP ===\n\n";

foreach ($directorios as $dir) {
    if (!is_dir($dir)) continue;

    $iterador = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterador as $archivo) {
        if ($archivo->isDir()) continue;

        $ruta = $archivo->getPathname();
        $ext = pathinfo($ruta, PATHINFO_EXTENSION);

        // Filtrar por extensión y evitar carpetas ignoradas
        if (in_array($ext, $extensiones)) {
            echo "------------------------------------------\n";
            echo "ARCHIVO: $ruta\n";
            echo "------------------------------------------\n";
            echo file_get_contents($ruta) . "\n\n";
        }
    }
}

// También leer archivos sueltos en la raíz que interesen
$archivosRaiz = ['composer.json', '.env.example'];
foreach ($archivosRaiz as $f) {
    if (file_exists($f)) {
        echo "------------------------------------------\n";
        echo "ARCHIVO: $f (RAÍZ)\n";
        echo "------------------------------------------\n";
        echo file_get_contents($f) . "\n\n";
    }
}
