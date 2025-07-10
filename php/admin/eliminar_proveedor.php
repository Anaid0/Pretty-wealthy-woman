<?php
require_once("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // ⚠️ Antes de eliminar, revisa si el proveedor está siendo usado por productos
    $check = $conexion->query("SELECT COUNT(*) AS total FROM productos WHERE id_proveedor = $id");
    $res = $check->fetch_assoc();

    if ($res['total'] > 0) {
        echo "<script>alert('Este proveedor está asociado a productos. No se puede eliminar.'); location.href='dashboard.php';</script>";
    } else {
        $sql = "DELETE FROM proveedores WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Proveedor eliminado correctamente'); location.href='dashboard.php';</script>";
        } else {
            echo "Error al eliminar: " . $stmt->error;
        }
    }
    $conexion->close();
}
?>
