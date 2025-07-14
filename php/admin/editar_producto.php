<?php
require_once("../conexion.php");

$id = $_POST['id_producto'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$id_proveedor = $_POST['id_proveedor'];
$activo = ($stock == 0) ? 'INACTIVO' : 'ACTIVO';

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $img_nombre = basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], "../../img/" . $img_nombre);

    $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, activo=?, imagen=?, id_proveedor=? WHERE id_producto=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdissii", $nombre, $descripcion, $precio, $stock, $activo, $img_nombre, $id_proveedor, $id);
} else {
    $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, activo=?, id_proveedor=? WHERE id_producto=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdissi", $nombre, $descripcion, $precio, $stock, $activo, $id_proveedor, $id);
}

if ($stmt->execute()) {
    echo "<script>alert('✅ Producto actualizado correctamente'); window.location.href = './dashboard.php';</script>";
} else {
    echo "<script>alert('❌ Error al actualizar Producto'); window.location.href = './dashboard.php';</script>" . $stmt->error;
}
$conexion->close();
?>
