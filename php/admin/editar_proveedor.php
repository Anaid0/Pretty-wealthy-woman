<?php
require_once("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre_empresa'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $sql = "UPDATE proveedores SET nombre_empresa=?, telefono=?, email=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $telefono, $email, $id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Proveedor actualizado correctamente'); window.location.href = './dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Error al actualizar Proveedor'); window.location.href = './dashboard.php';</script> " . $stmt->error;
    }
    $conexion->close();
    exit();
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
    $resultado = $conexion->query("SELECT * FROM proveedores WHERE id = $id");
    $proveedor = $resultado->fetch_assoc();
} else {
    echo "No se ha seleccionado ningún proveedor.";
    exit();
}
?>

<h2>Editar Proveedor</h2>
<form action="editar_proveedor.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $proveedor['id']; ?>">

    <label>Nombre de la Empresa:</label>
    <input type="text" name="nombre_empresa" value="<?php echo $proveedor['nombre_empresa']; ?>" required><br>

    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?php echo $proveedor['telefono']; ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $proveedor['email']; ?>" required><br>

    <button type="submit">Actualizar</button>
</form>
