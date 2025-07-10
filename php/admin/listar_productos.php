<?php
require_once("../conexion.php");

$sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, pr.nombre_empresa 
        FROM productos p 
        JOIN proveedores pr ON p.id_proveedor = pr.id 
        WHERE p.activo = 'ACTIVO'";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($producto = $resultado->fetch_assoc()) {
        echo '<div class="producto">';
        echo '<img src="../../img/' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
        echo '<h3>' . $producto['nombre'] . '</h3>';
        echo '<p>' . $producto['descripcion'] . '</p>';
        echo '<p>💲' . number_format($producto['precio'], 2) . '</p>';
        echo '<p><strong>Stock:</strong> ' . $producto['stock'] . '</p>';
        echo '<p><strong>Proveedor:</strong> ' . $producto['nombre_empresa'] . '</p>';

        echo '<form method="POST" action="editar_producto.php" style="display:inline-block">';
        echo '<input type="hidden" name="id_producto" value="' . $producto['id_producto'] . '">';
        echo '<button class="btn editar" type="submit">✏️ Editar</button>';
        echo '</form>';

        echo '<form method="POST" action="eliminar_producto.php" style="display:inline-block" onsubmit="return confirm(\'¿Seguro que deseas eliminar este producto?\')">';
        echo '<input type="hidden" name="id_producto" value="' . $producto['id_producto'] . '">';
        echo '<button class="btn eliminar" type="submit">🗑️ Eliminar</button>';
        echo '</form>';

        echo '</div>';
    }
} else {
    echo '<p>No hay productos registrados.</p>';
}
$conexion->close();
?>