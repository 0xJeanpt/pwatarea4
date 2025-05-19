// Confirmar antes de eliminar una tarea
function confirmarEliminacion() {
    return confirm("¿Estás seguro de que deseas eliminar esta tarea?");
}

// Validar el formulario de nueva tarea
function validarFormulario() {
    const input = document.querySelector('input[name="descripcion"]');
    if (input.value.trim() === "") {
        alert("Por favor, escribe una descripción para la tarea.");
        return false;
    }
    return true;
}
