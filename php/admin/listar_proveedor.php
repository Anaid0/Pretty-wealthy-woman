<?php
require_once("../conexion.php");

$sql = "SELECT pr.id, pr.nombre_empresa, pr.telefono, pr.email FROM proveedores pr";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($proveedor = $resultado->fetch_assoc()) {
        echo '<div class="proveedor">';
        echo '<h3>' . $proveedor['nomre_empresa'] . '</h3>';
        echo '<p>' . $proveedor['telefono'] . '</p>';
        echo '<p>' . $proveedor['email'] . '</p>';

        echo '<form method="POST" action="editar_proveedor.php" style="display:inline-block">';
        echo '<input type="hidden" name="id" value="' . $proveedor['id'] . '">';
        echo '<button class="btn editar" type="submit">✏️ Editar</button>';
        echo '</form>';

        echo '<form method="POST" action="eliminar_proveedor.php" style="display:inline-block" onsubmit="return confirm(\'¿Seguro que deseas eliminar este proveedor?\')">';
        echo '<input type="hidden" name="id" value="' . $proveedor['id'] . '">';
        echo '<button class="btn eliminar" type="submit">🗑️ Eliminar</button>';
        echo '</form>';

        echo '</div>';
    }
} else {
    echo '<p>No hay productos registrados.</p>';
}
$conexion->close();
?>