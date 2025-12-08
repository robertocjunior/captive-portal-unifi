<?php
echo "<h1>Diagnostico do Sistema</h1>";

// 1. Verifica se o arquivo process.php existe
if (file_exists('process.php')) {
    echo "<p style='color:green'>✅ Arquivo process.php encontrado.</p>";
} else {
    echo "<p style='color:red'>❌ Arquivo process.php NÃO encontrado.</p>";
}

// 2. Verifica a extensão cURL (Necessária para falar com a UniFi)
if (function_exists('curl_init')) {
    echo "<p style='color:green'>✅ Biblioteca cURL instalada.</p>";
} else {
    echo "<p style='color:red'>❌ Biblioteca cURL NÃO instalada (Refaça o Dockerfile).</p>";
}

// 3. Tenta conectar no Banco
require 'db.php';
if ($conn) {
    echo "<p style='color:green'>✅ Conexão com Banco de Dados OK.</p>";
}
?>