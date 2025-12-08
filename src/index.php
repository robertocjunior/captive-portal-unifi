<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Wi-Fi - Grupo Nico</title>
    <style>
        /* --- ESTÉTICA GRUPO NICO --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body {
            background-color: #2F5233; /* Verde escuro fundo */
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; padding: 20px;
        }

        .login-card {
            background-color: #ffffff; width: 100%; max-width: 400px;
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 2rem; text-align: center;
        }

        .logo {
            max-width: 250px; height: auto; margin-bottom: 25px;
            display: block; margin-left: auto; margin-right: auto;
        }

        /* Abas */
        .tabs { display: flex; border-bottom: 1px solid #e0e0e0; margin-bottom: 20px; }
        .tab {
            flex: 1; padding: 10px; cursor: pointer; font-size: 14px;
            font-weight: 500; color: #666; background: none; border: none; outline: none;
        }
        .tab.active {
            color: #387C2B; border-bottom: 3px solid #387C2B; font-weight: bold;
        }
        .tab:hover:not(.active) { background-color: #f9f9f9; }

        /* Formulário */
        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; color: #333; font-size: 14px; }
        .input-group input {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;
            font-size: 14px; outline: none; transition: border-color 0.3s;
        }
        .input-group input:focus { border-color: #387C2B; box-shadow: 0 0 0 2px rgba(56, 124, 43, 0.2); }

        /* Checkbox */
        .terms-container {
            display: flex; align-items: center; justify-content: center;
            gap: 8px; margin: 20px 0; font-size: 13px; color: #333;
        }
        .terms-container input[type="checkbox"] { width: 16px; height: 16px; cursor: pointer; accent-color: #387C2B; }
        .terms-container label { cursor: pointer; }

        .btn-connect {
            width: 100%; padding: 12px; background-color: #387C2B; color: white;
            border: none; border-radius: 4px; font-size: 16px; font-weight: bold;
            cursor: pointer; transition: background-color 0.3s;
        }
        .btn-connect:hover { background-color: #2a6120; }
        
        .hidden { display: none; }
    </style>
</head>
<body>

    <div class="login-card">
        <img src="http://www.nicoalimentos.com.br/assinatura/logo-dinamica.php" alt="Grupo Nico" class="logo">

        <div class="tabs">
            <button type="button" class="tab active" id="tab-register" onclick="switchTab('register')">Cadastro (24h)</button>
            <button type="button" class="tab" id="tab-token" onclick="switchTab('token')">Tenho Token</button>
        </div>

        <form action="/process.php" method="POST">
            
            <input type="hidden" name="mac" value="<?php echo $_GET['id'] ?? ''; ?>">
            <input type="hidden" name="auth_type" id="auth_type" value="register">

            <div id="section-register">
                <div class="input-group">
                    <label for="fullname">Nome Completo</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Seu nome">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="seu@email.com">
                </div>
                
                <div class="terms-container">
                    <input type="checkbox" id="termos" name="termos" required>
                    <label for="termos">Aceito os termos de uso.</label>
                </div>
            </div>

            <div id="section-token" class="hidden">
                <div class="input-group">
                    <label for="token_code">Código do Voucher</label>
                    <input type="text" id="token_code" name="token_code" placeholder="Ex: 12345-67890">
                </div>
            </div>

            <button type="submit" class="btn-connect">Conectar</button>
        </form>
    </div>

    <script>
        function switchTab(type) {
            document.getElementById('auth_type').value = type;
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById('tab-' + type).classList.add('active');

            if (type === 'register') {
                document.getElementById('section-register').classList.remove('hidden');
                document.getElementById('section-token').classList.add('hidden');
                
                document.getElementById('fullname').required = true;
                document.getElementById('email').required = true;
                document.getElementById('termos').required = true;
                document.getElementById('token_code').required = false;
            } else {
                document.getElementById('section-register').classList.add('hidden');
                document.getElementById('section-token').classList.remove('hidden');

                document.getElementById('fullname').required = false;
                document.getElementById('email').required = false;
                document.getElementById('termos').required = false;
                document.getElementById('token_code').required = true;
            }
        }
        switchTab('register');
    </script>
</body>
</html>