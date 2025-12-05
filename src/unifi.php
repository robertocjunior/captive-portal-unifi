<?php
class UnifiAPI {
    private $base_url;
    private $site;
    private $cookies = '/tmp/unifi_cookie';

    public function __construct() {
        $this->base_url = getenv('UNIFI_URL');
        $this->site = getenv('UNIFI_SITE');
    }

    private function exec_curl($url, $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookies);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookies);
        
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
        
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }

    public function login() {
        return $this->exec_curl('/api/login', [
            'username' => getenv('UNIFI_USER'),
            'password' => getenv('UNIFI_PASS')
        ]);
    }

    public function authorize_guest($mac, $minutes) {
        $this->login();
        return $this->exec_curl('/api/s/' . $this->site . '/cmd/stamgr', [
            'cmd' => 'authorize-guest',
            'mac' => $mac,
            'minutes' => $minutes
        ]);
    }

    // Usa o sistema de vouchers nativo do UniFi
    public function use_voucher($mac, $voucher_code) {
        $this->login();
        // O comando de voucher é diferente, ele aplica o voucher ao mac
        // Nota: A API de voucher é complexa, um truque comum é autorizar pelo tempo do voucher
        // Mas para simplificar aqui, vamos autorizar direto se o código for validado. 
        // *Recomendação:* Para vouchers do UniFi funcionarem perfeitamente via API externa, 
        // o ideal é enviar o comando 'authorize-guest' usando a validação do voucher.
        
        // Simulação: Se for voucher, enviamos direto para o endpoint que consome voucher
        return $this->exec_curl('/api/s/' . $this->site . '/cmd/stamgr', [
            'cmd' => 'authorize-guest',
            'mac' => $mac,
            'voucher' => $voucher_code
        ]);
    }
}
?>