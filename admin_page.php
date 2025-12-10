<?php
session_start();

// verificar sesión
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';
// cargar libreria
require_once 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient('sk_test_51SbtF9Ad81OWEhXm6rHUiH5GOemujIf60L8T7CIfwVpo87tPn3ukDmmkKL8J7w4LVztMJV3HoFMkWqUf8WPcg0Ws00Td0RWPAr');
$sales_data = [];
$stripe_error = "";

try {
    // aqui, se consulta la seesion
    $sessions = $stripe->checkout->sessions->all([
        'limit' => 10,
        'expand' => ['data.line_items'] 
    ]);
    
    $sales_data = $sessions->data;

} catch (Exception $e) {
    $stripe_error = "Error al conectar con Stripe: " . $e->getMessage();
}

// consulta sql si es admin o user
$sql_users = "SELECT COUNT(*) as total FROM users WHERE role = 'user'";
$sql_admins = "SELECT COUNT(*) as total FROM users WHERE role = 'admin'";

$total_users = mysqli_fetch_assoc(mysqli_query($conn, $sql_users))['total'];
$total_admins = mysqli_fetch_assoc(mysqli_query($conn, $sql_admins))['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Mesa Feliz</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .badge-success { background-color: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: 600; }
        .badge-warning { background-color: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: 600; }
        .badge-fail { background-color: #fee2e2; color: #b91c1c; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: 600; }
        .product-list { list-style: none; padding: 0; margin: 0; text-align: left; font-size: 0.9em; }
        .product-list li { border-bottom: 1px solid #f1f5f9; padding: 4px 0; }
        .product-list li:last-child { border-bottom: none; }
        .qty-badge { background: #e2e8f0; color: #475569; padding: 1px 5px; border-radius: 4px; font-size: 0.8em; margin-right: 5px; }
    </style>
</head>
<body class="admin-mode">

    <nav class="admin-navbar">
        <div class="admin-brand">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <div>Mesa Feliz <span>Admin</span></div>
        </div>
        
        <div class="admin-user-menu">
            <span>Hola, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
            <a href="logout.php" class="btn-logout-pro">
                Cerrar Sesión
            </a>
        </div>
    </nav>

    <div class="dashboard-container">
        
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-info">
                    <h3>Clientes Registrados</h3>
                    <p><?php echo $total_users; ?></p>
                </div>
                <div class="stat-icon icon-users">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
            </div>

            <div class="stat-box">
                <div class="stat-info">
                    <h3>Administradores</h3>
                    <p><?php echo $total_admins; ?></p>
                </div>
                <div class="stat-icon icon-admin">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
            </div>

            <div class="stat-box">
                <div class="stat-info">
                    <h3>Productos Activos</h3>
                    <p>42</p>
                </div>
                <div class="stat-icon icon-products">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </div>
            </div>
        </div>
        
        <div class="table-wrapper" style="margin-bottom: 30px;">
            <div class="table-header">
                <h2>Últimas Ventas (Detalle de Pedidos)</h2>
            </div>
            
            <?php if ($stripe_error): ?>
                <div style="padding: 20px; color: #b91c1c; background: #fee2e2; border-radius: 8px; margin: 10px;">
                    <?php echo $stripe_error; ?>
                </div>
            <?php else: ?>
            
            <table class="fl-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th style="width: 35%;">Productos Comprados</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sales_data as $session) {
                        $date = date('d/m/Y H:i', $session->created);
                        $email = $session->customer_details->email ?? 'N/A';
                        $amount = strtoupper($session->currency) . ' $' . number_format($session->amount_total, 0, ',', '.');
                        $status_label = $session->payment_status;
                        $badge_class = 'badge-warning';
                        if ($session->payment_status == 'paid') {
                            $status_label = 'Pagado';
                            $badge_class = 'badge-success';
                        } else if ($session->status == 'open') {
                            $status_label = 'Pendiente'; 
                            $badge_class = 'badge-warning';
                        } else {
                            $status_label = 'Cancelado';
                            $badge_class = 'badge-fail';
                        }
                        echo "<tr>";
                        echo "<td>" . $date . "</td>";
                        echo "<td>" . htmlspecialchars($email) . "</td>";
                        
                        echo "<td>";
                        if (isset($session->line_items) && count($session->line_items->data) > 0) {
                            echo "<ul class='product-list'>";
                            foreach ($session->line_items->data as $item) {
                                echo "<li>";
                                echo "<span class='qty-badge'>" . $item->quantity . "x</span>";
                                echo htmlspecialchars($item->description);
                                echo "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<span style='color: #94a3b8; font-style: italic;'>Sin detalles</span>";
                        }
                        echo "</td>";

                        echo "<td><strong>" . $amount . "</strong></td>";
                        echo "<td><span class='$badge_class'>" . ucfirst($status_label) . "</span></td>";
                        echo "</tr>";
                    }

                    if (empty($sales_data)) {
                        echo "<tr><td colspan='5' style='text-align:center; padding: 20px; color: #64748b;'>No se han realizado ventas recientes.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <div class="table-wrapper">
            <div class="table-header">
                <h2>Últimos Usuarios Registrados</h2>
            </div>
            <table class="fl-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM users ORDER BY id DESC LIMIT 10";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $role_badge = ($row['role'] == 'admin') ? 'status-admin' : 'status-user';
                            
                            echo "<tr>";
                            echo "<td><strong>#" . $row['id'] . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td><span class='status-badge $role_badge'>" . ucfirst($row['role']) . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center'>Sin datos</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>