<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $rol_id = $_POST["rol_id"];

    $stmt = $conexion->prepare("INSERT INTO usuarios (username, password, rol_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $password, $rol_id);
    $stmt->execute();

    echo "Usuario registrado";
}
?>
<form method="post">
    Usuario: <input type="text" name="username"><br>
    Contraseña: <input type="password" name="password"><br>
    Rol: 
    <select name="rol_id">
        <option value="1">Admin</option>
        <option value="2">Usuario</option>
    </select><br>
    <input type="submit" value="Registrar">
</form>
