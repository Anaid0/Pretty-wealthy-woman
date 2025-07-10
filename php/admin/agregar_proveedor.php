<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /login.php");
    exit();
}
require_once("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pretty Wealthy Woman</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>

    <header><h1>Panel Administrativo 💼</h1></header>

    <div class="botones top-actions">
        <button onclick="mostrarFormulario('formProducto')">➕ Agregar Producto</button>
        <button onclick="mostrarFormulario('formProveedor')">🏢 Agregar Proveedor</button>
        <button onclick="mostrarFormulario('formVerProveedores')">📋 Ver Proveedores</button>
        <a href="../logout.php">🚪 Cerrar sesión</a>
    </div>

    <!-- ✅ Modal Agregar Producto -->
    <div class="modal" id="formProducto">
        <div class="modal-contenido">
            <span class="cerrar" onclick="ocultarFormulario('formProducto')">&times;</span>
            <?php include('agregar_producto.php'); ?>
        </div>
    </div>

    <!-- ✅ Modal Agregar Proveedor -->
    <div class="modal" id="formProveedor">
        <div class="modal-contenido">
            <span class="cerrar" onclick="ocultarFormulario('formProveedor')">&times;</span>
            <?php include('agregar_proveedor.php'); ?>
        </div>
    </div>

    <!-- ✅ Modal Ver Proveedores -->
    <div class="modal" id="formVerProveedores">
        <div class="modal-contenido">
            <span class="cerrar" onclick="ocultarFormulario('formVerProveedores')">&times;</span>
            <h2>Lista de Proveedores</h2>
            <table class="tabla-proveedores">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultado = $conexion->query("SELECT * FROM proveedores");
                    if ($resultado->num_rows > 0) {
                        while ($proveedor = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$proveedor['nombre_empresa']}</td>";
                            echo "<td>{$proveedor['telefono']}</td>";
                            echo "<td>{$proveedor['email']}</td>";
                            echo "<td>
                                <form method='POST' action='editar_proveedor.php' style='display:inline-block;'>
                                    <input type='hidden' name='id' value='{$proveedor['id']}'>
                                    <button class='btn editar'>✏️ Editar</button>
                                </form>
                                <form method='POST' action='eliminar_proveedor.php' style='display:inline-block;' onsubmit='return confirm(\"¿Eliminar proveedor?\")'>
                                    <input type='hidden' name='id' value='{$proveedor['id']}'>
                                    <button class='btn eliminar'>🗑️ Eliminar</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay proveedores registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ✅ Tabla de Productos -->
    <h2 style="text-align:center;">Lista de Productos</h2>
    <table class="tabla-productos">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Proveedor</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.*, pr.nombre_empresa 
                    FROM productos p
                    JOIN proveedores pr ON p.id_proveedor = pr.id";
            $productos = $conexion->query($sql);
            if ($productos->num_rows > 0) {
                while ($producto = $productos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><img src='../../img/{$producto['imagen']}' width='60'></td>";
                    echo "<td>{$producto['nombre']}</td>";
                    echo "<td>{$producto['descripcion']}</td>";
                    echo "<td>$" . number_format($producto['precio'], 2) . "</td>";
                    echo "<td>{$producto['stock']}</td>";
                    echo "<td>{$producto['nombre_empresa']}</td>";
                    echo "<td>{$producto['activo']}</td>";
                    echo "<td>
                        <button onclick='abrirModalEditar(" . htmlspecialchars(json_encode($producto)) . ")'>✏️ Editar</button>
                        <button onclick='eliminarProducto({$producto['id_producto']})'>🗑️ Eliminar</button>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No hay productos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- ✅ Modal Editar Producto -->
    <div class="modal" id="modalEditar">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalEditar()">&times;</span>
            <form id="formEditar" action="./editar_producto.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_producto" id="edit_id">
                <label>Nombre:</label><input type="text" name="nombre" id="edit_nombre" required><br>
                <label>Descripción:</label><textarea name="descripcion" id="edit_descripcion" required></textarea><br>
                <label>Precio:</label><input type="number" name="precio" id="edit_precio" step="0.01" required><br>
                <label>Stock:</label><input type="number" name="stock" id="edit_stock" required><br>
                <label>Proveedor:</label>
                <select name="id_proveedor" id="edit_proveedor">
                    <?php
                    $proveedores = $conexion->query("SELECT id, nombre_empresa FROM proveedores");
                    while ($prov = $proveedores->fetch_assoc()) {
                        echo "<option value='{$prov['id']}'>{$prov['nombre_empresa']}</option>";
                    }
                    ?>
                </select><br>
                <label>Imagen (opcional):</label><input type="file" name="imagen"><br>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script src="../../js/dashboard.js"></script>
</body>
</html>
