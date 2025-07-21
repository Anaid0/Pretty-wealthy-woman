<?php
session_start();
require_once("../conexion.php");
require_once("../admin/enviar_correo.php");

if (!isset($_SESSION['correo'])) {
    header("Location: ../../pages/login.html");
    exit();
}

$correo = $_SESSION['correo'];
$stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$res = $stmt->get_result();
$id_usuario = $res->fetch_assoc()['id_usuario'];

$sql = "SELECT c.id_producto, c.cantidad, p.precio, p.stock, p.nombre
        FROM carrito c 
        JOIN productos p ON c.id_producto = p.id_producto 
        WHERE c.id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
    $total += $row['cantidad'] * $row['precio'];

    if ($row['cantidad'] > $row['stock']) {
        echo "<script>alert('No hay suficiente stock para el producto {$row['nombre']}'); window.location.href='ver_carrito.php';</script>";
        exit();
    }
}

if (count($productos) === 0) {
    echo "<script>alert('Tu carrito está vacío.'); window.location.href='ver_carrito.php';</script>";
    exit();
}

$stmt = $conexion->prepare("INSERT INTO compras (id_usuario, fecha_compra, total, correo_contacto) VALUES (?, NOW(), ?, ?)");
$stmt->bind_param("ids", $id_usuario, $total, $correo);
$stmt->execute();
$id_compra = $stmt->insert_id;

foreach ($productos as $p) {
    $stmt = $conexion->prepare("INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio_unitario, id_usuario) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiidi", $id_compra, $p['id_producto'], $p['cantidad'], $p['precio'], $id_usuario);
    $stmt->execute();

    $stmt = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
    $stmt->bind_param("ii", $p['cantidad'], $p['id_producto']);
    $stmt->execute();

    $sql_inactiva = "UPDATE productos SET activo = 'INACTIVO' WHERE stock = 0";
    $conexion->query($sql_inactiva);

}

$stmt = $conexion->prepare("DELETE FROM carrito WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

$mensaje = "<h2 style='color: #c91888;'>🛍️ Detalles de tu compra:</h2>";
$mensaje .= "<table style='border-collapse: collapse; width: 100%; font-family: Arial;'>";
$mensaje .= "<thead><tr style='background-color: #f8d7f8;'>
                <th style='padding: 8px; border: 1px solid #e2cce2;'>Producto</th>
                <th style='padding: 8px; border: 1px solid #e2cce2;'>Cantidad</th>
                <th style='padding: 8px; border: 1px solid #e2cce2;'>Precio Unitario</th>
                <th style='padding: 8px; border: 1px solid #e2cce2;'>Subtotal</th>
            </tr></thead><tbody>";

foreach ($productos as $p) {
    $subtotal = $p['precio'] * $p['cantidad'];
    $mensaje .= "<tr>
                    <td style='padding: 8px; border: 1px solid #e2cce2;'>{$p['nombre']}</td>
                    <td style='padding: 8px; border: 1px solid #e2cce2;'>{$p['cantidad']}</td>
                    <td style='padding: 8px; border: 1px solid #e2cce2;'>$" . number_format($p['precio'], 2) . "</td>
                    <td style='padding: 8px; border: 1px solid #e2cce2;'>$" . number_format($subtotal, 2) . "</td>
                 </tr>";
}

$mensaje .= "</tbody></table>";
$mensaje .= "<p style='margin-top: 20px; font-size: 16px;'><strong style='color: #ffadf4;'>Total a pagar:</strong> <span style='color: #b929ad;'>$" . number_format($total, 2) . "</span></p>";
$mensaje .= "<p style='color: #ffccf6; font-size: 15px;'>🙏 Gracias por comprar con nosotras los mejores productos de belleza. Te esperamos pronto 💖</p>";

if (enviarCorreo($correo, "Confirmacion de compra - Pretty Wealthy Woman", $mensaje)) {
    echo "<script>alert('¡Productos comprados con éxito! Revisa tu correo.'); window.location='../../index.php';</script>";
} else {
    echo "<script>alert('Hubo un error al enviar el correo.'); window.location='ver_carrito.php';</script>";
}

?>
