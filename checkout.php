<?php
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(401); 
    echo json_encode(['error' => 'Debes iniciar sesión para realizar una compra.']);
    exit(); 
}

require 'vendor/autoload.php'; 
\Stripe\Stripe::setApiKey('sk_test_51SbtF9Ad81OWEhXm6rHUiH5GOemujIf60L8T7CIfwVpo87tPn3ukDmmkKL8J7w4LVztMJV3HoFMkWqUf8WPcg0Ws00Td0RWPAr');

header('Content-Type: application/json');

try {
    // recibir datos del carrito dsde el json
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);

    if (empty($jsonObj->items)) {
        throw new Exception("El carrito está vacío");
    }

    // ¿formatear item pa stripe
    $line_items = [];
    foreach ($jsonObj->items as $item) {
        $precioLimpio = str_replace(['$', '.', ' '], '', $item->precio);       
        $line_items[] = [
            'price_data' => [
                'currency' => 'clp', 
                'product_data' => [
                    'name' => $item->titulo,                ],
                'unit_amount' => $precioLimpio, 
            ],
            'quantity' => $item->cantidad,
        ];
    }

    // crear sesión checkout
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/mesafeliz-main/exito.html', 
        'cancel_url' => 'http://localhost/mesafeliz-main/index.php',
        'customer_email' => $_SESSION['email'], 
    ]);

    echo json_encode(['url' => $checkout_session->url]);

} catch (Exception $e) { 
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>