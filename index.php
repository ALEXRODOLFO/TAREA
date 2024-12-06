<?php
require_once "database.php";
require_once "perfiles.php";

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Instancia de la clase Perfiles
$perfiles = new Perfiles($db);

// Manejar la creación de un perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_perfil'])) {
    if (isset($_POST['id_perfil']) && $_POST['id_perfil'] !== "") {
        // Editar perfil existente
        $id_perfil = intval($_POST['id_perfil']);
        $nombre_perfil = htmlspecialchars($_POST['nombre_perfil']);
        $perfiles->actualizarPerfil($id_perfil, $nombre_perfil);
    } else {
        // Crear un nuevo perfil
        $nombre_perfil = htmlspecialchars($_POST['nombre_perfil']);
        $perfiles->crearPerfil($nombre_perfil);
    }
    header("Location: index.php");
    exit;
}

// Manejar la eliminación de un perfil
if (isset($_GET['eliminar'])) {
    $id_perfil = intval($_GET['eliminar']);
    $perfiles->eliminarPerfil($id_perfil);
    header("Location: index.php");
    exit;
}

// Obtener datos para edición
$perfilEditar = null;
if (isset($_GET['editar'])) {
    $id_perfil = intval($_GET['editar']);
    $perfilEditar = $perfiles->obtenerPerfilPorId($id_perfil);
}

// Obtener todos los perfiles
$listaPerfiles = $perfiles->obtenerPerfiles();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Perfiles</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { margin-bottom: 20px; }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 10px; }
        a { color: red; text-decoration: none; margin-left: 10px; }
        .editar { color: blue; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Gestión de Perfiles</h1>

    <!-- Formulario para crear o editar un perfil -->
    <form method="POST">
        <input type="hidden" name="id_perfil" value="<?php echo $perfilEditar['id_perfil'] ?? ''; ?>">
        <label for="nombre_perfil"><?php echo isset($perfilEditar) ? "Editar Perfil" : "Nuevo Perfil"; ?>:</label>
        <input type="text" id="nombre_perfil" name="nombre_perfil" value="<?php echo htmlspecialchars($perfilEditar['nombre_perfil'] ?? ''); ?>" required>
        <button type="submit"><?php echo isset($perfilEditar) ? "Actualizar" : "Crear"; ?></button>
        <?php if (isset($perfilEditar)): ?>
            <a href="index.php">Cancelar</a>
        <?php endif; ?>
    </form>

    <!-- Lista de perfiles -->
    <h2>Lista de Perfiles</h2>
    <ul>
        <?php foreach ($listaPerfiles as $perfil): ?>
            <li>
                <?php echo htmlspecialchars($perfil['nombre_perfil']); ?>
                <a href="?editar=<?php echo $perfil['id_perfil']; ?>" class="editar">Editar</a>
                <a href="?eliminar=<?php echo $perfil['id_perfil']; ?>" onclick="return confirm('¿Estás seguro de eliminar este perfil?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
