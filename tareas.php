<?php
session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id"];
$rol = $_SESSION["rol"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["descripcion"])) {
        $desc = $_POST["descripcion"];
        $stmt = $conexion->prepare("INSERT INTO tareas (descripcion, usuario_id) VALUES (?, ?)");
        $stmt->bind_param("si", $desc, $id_usuario);
        $stmt->execute();
    } elseif (isset($_POST["completar"])) {
        $id_tarea = $_POST["completar"];
        $conexion->query("UPDATE tareas SET completada = 1 WHERE id = $id_tarea");
    } elseif (isset($_POST["eliminar"]) && $rol == 1) {
        $id_tarea = $_POST["eliminar"];
        $conexion->query("DELETE FROM tareas WHERE id = $id_tarea");
    }
}

$tareas = $conexion->query("SELECT * FROM tareas");
?>

<h2>Lista de Tareas</h2>
<form method="post">
    <input type="text" name="descripcion" placeholder="Nueva tarea">
    <input type="submit" value="Agregar">
</form>

<ul>
<?php while($t = $tareas->fetch_assoc()): ?>
    <li>
        <?= htmlspecialchars($t["descripcion"]) ?> 
        <?= $t["completada"] ? "✅" : "" ?>
        <form method="post" style="display:inline">
            <?php if (!$t["completada"]): ?>
                <button name="completar" value="<?= $t["id"] ?>">✔</button>
            <?php endif; ?>
            <?php if ($rol == 1): ?>
                <button name="eliminar" value="<?= $t["id"] ?>">❌</button>
            <?php endif; ?>
        </form>
    </li>
<?php endwhile; ?>
</ul>
<a href="logout.php">Cerrar sesión</a>
