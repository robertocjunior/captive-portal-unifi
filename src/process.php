<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';
require 'unifi.php';

$mac = $_POST['mac'] ?? '';
$type = $_POST['auth_type'] ?? '';

if (!$mac) die("Erro: MAC Address não encontrado.");

$unifi = new UnifiAPI();
$success = false;

if ($type === 'register') {
    // 1. REGISTRO (24 horas = 1440 minutos)
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    
    // Salva no banco (LGPD: Apenas logs de acesso)
    $stmt = $conn->prepare("INSERT INTO wifi_users (mac_address, fullname, email, method) VALUES (?, ?, ?, 'registro')");
    $stmt->bind_param("sss", $mac, $name, $email);
    $stmt->execute();
    
    // Libera no UniFi
    $unifi->authorize_guest($mac, 1440);
    $success = true;

} elseif ($type === 'token') {
    // 2. TOKEN (Usa o tempo do Token definido no UniFi)
    $token = $_POST['token_code'];
    
    // Tenta aplicar o voucher. 
    // OBS: Se o voucher for inválido, o UniFi não libera.
    // Para logs, salvamos que ele tentou usar token.
    $stmt = $conn->prepare("INSERT INTO wifi_users (mac_address, fullname, email, method) VALUES (?, 'Token User', ?, 'token')");
    $stmt->bind_param("ss", $mac, $token);
    $stmt->execute();

    // Envia comando de voucher para o UniFi
    // Nota técnica: O endpoint exato de voucher via API externa pode variar. 
    // Alternativa: authorize-guest passando 'voucher_code'.
    $resp = $unifi->exec_curl('/api/s/default/cmd/stamgr', [
        'cmd' => 'authorize-guest',
        'mac' => $mac,
        'voucher' => $token
    ]);
    
    // Verifica se o UniFi aceitou (meta.rc = ok)
    if (isset($resp['meta']['rc']) && $resp['meta']['rc'] == 'ok') {
        $success = true;
    } else {
        die("Token Inválido ou Expirado.");
    }
}

if ($success) {
    // Redireciona para o Google ou página de sucesso
    header("Location: https://www.google.com");
} else {
    echo "Erro ao autenticar. Tente novamente.";
}
?>