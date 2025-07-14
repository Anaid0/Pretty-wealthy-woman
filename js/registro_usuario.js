function validarFormulario() {
const pass = document.getElementById('contrasena').value;
const confirmar = document.getElementById('confirmar_contrasena').value;

if (pass.length < 6) {
    alert('❌ La contraseña debe tener al menos 6 caracteres.');
    return false;
}

if (pass !== confirmar) {
    alert('❌ Las contraseñas no coinciden.');
    return false;
}

return true;
}

function validarFormulario() {
const pass = document.getElementById('contrasena').value;
const confirmar = document.getElementById('confirmar_contrasena').value;

if (pass.length < 6) {
    alert('❌ La contraseña debe tener al menos 6 caracteres.');
    return false;
}

if (pass !== confirmar) {
    alert('❌ Las contraseñas no coinciden.');
    return false;
}

return true;        
}

function togglePassword(id, el) {
const input = document.getElementById(id);
if (input.type === "password") {
    input.type = "text";
    el.textContent = "🙈";
} else {
    input.type = "password";
    el.textContent = "👁️";
}
}

