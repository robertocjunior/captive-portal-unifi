<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Wi-Fi</title>
    <style>
        /* Estilos básicos para o exemplo */
        body { font-family: sans-serif; background: #eee; display: flex; justify-content: center; padding-top: 50px; }
        .box { background: white; padding: 20px; border-radius: 8px; width: 350px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;}
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .tabs { display: flex; margin-bottom: 20px; border-bottom: 1px solid #ddd; }
        .tab { flex: 1; padding: 10px; text-align: center; cursor: pointer; background: #f9f9f9; }
        .tab.active { background: white; border-bottom: 2px solid #007bff; font-weight: bold; }
        .hidden { display: none; }
    </style>
    <script>
        function openTab(name) {
            document.querySelectorAll('.form-section').forEach(d => d.classList.add('hidden'));
            document.getElementById(name).classList.remove('hidden');
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById('tab-'+name).classList.add('active');
            document.getElementById('auth_type').value = name;
        }
    </script>
</head>
<body>
    <div class="box">
        <h2 style="text-align:center">Acesso Wi-Fi</h2>
        
        <div class="tabs">
            <div id="tab-register" class="tab active" onclick="openTab('register')">Cadastro (24h)</div>
            <div id="tab-token" class="tab" onclick="openTab('token')">Tenho Token</div>
        </div>

        <form action="process.php" method="POST">
            <input type="hidden" name="mac" value="<?php echo $_GET['id'] ?? ''; ?>">
            <input type="hidden" name="auth_type" id="auth_type" value="register">

            <div id="register" class="form-section">
                <label>Nome Completo</label>
                <input type="text" name="fullname">
                
                <label>Email</label>
                <input type="email" name="email">
                
                <p style="font-size:12px"><input type="checkbox" required> Aceito os termos de uso.</p>
            </div>

            <div id="token" class="form-section hidden">
                <label>Código do Voucher</label>
                <input type="text" name="token_code" placeholder="12345-67890">
            </div>

            <button type="submit">Conectar</button>
        </form>
    </div>
</body>
</html>