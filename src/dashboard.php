<?php
require 'db.php';
// Adicionar autenticação simples aqui em produção!

// Busca últimos 50 registros
$result = $conn->query("SELECT * FROM wifi_users ORDER BY created_at DESC LIMIT 50");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Painel Admin Wi-Fi</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8em; color: white; }
        .reg { background-color: #28a745; }
        .tok { background-color: #17a2b8; }
    </style>
</head>
<body>
    <h1>Logs de Acesso</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Data/Hora</th>
            <th>Método</th>
            <th>Nome/Token</th>
            <th>Email</th>
            <th>MAC Address</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
            <td>
                <span class="badge <?php echo ($row['method']=='registro'?'reg':'tok'); ?>">
                    <?php echo ucfirst($row['method']); ?>
                </span>
            </td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['mac_address']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>