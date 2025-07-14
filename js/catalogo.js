function mostrarDetalle(producto) {
  document.getElementById("modalProducto").style.display = "block";
  document.getElementById("modalImagen").src = "../" + producto.imagen;
  document.getElementById("modalNombre").innerText = producto.nombre;
  document.getElementById("modalDescripcion").innerText = producto.descripcion;
  document.getElementById("modalPrecio").innerText = parseFloat(producto.precio).toLocaleString();
  document.getElementById("modalCantidad").value = 1;
  document.getElementById("modalProducto").setAttribute("data-id", producto.id_producto);
}

function cerrarModal() {
  document.getElementById("modalProducto").style.display = "none";
}

function agregarAlCarrito() {
  const id = document.getElementById("modalProducto").getAttribute("data-id");
  const cantidad = document.getElementById("modalCantidad").value;

  if (!estaLogueado) {
    alert("Debes iniciar sesión para agregar productos al carrito.");
    return;
  }

 window.location.href = `user/agregar_carrito.php?id=${id}&cantidad=${cantidad}`;
}

