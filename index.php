<?php
// Verificar si la sesión está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializar el array de compras si no existe
if (!isset($_SESSION['compras'])) {
    $_SESSION['compras'] = [];
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $producto = $_POST['producto'];
    $precio_unitario = (float)$_POST['precio_unitario'];
    $cantidad = (int)$_POST['cantidad'];
    $precio_total = $precio_unitario * $cantidad;

    // Agregar los datos al array de compras
    $_SESSION['compras'][] = [
        'nombre' => $nombre,
        'dni' => $dni,
        'producto' => $producto,
        'precio_unitario' => $precio_unitario,
        'cantidad' => $cantidad,
        'precio_total' => $precio_total,
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Compras</title>
</head>
<body>
    <h1>Registro de Compras</h1>
    <form method="POST" action="">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>

        <label>DNI:</label><br>
        <input type="text" name="dni" required maxlength="8"><br>

        <label>Producto:</label><br>
        <input type="text" name="producto" required><br>

        <label>Precio Unitario:</label><br>
        <input type="number" name="precio_unitario" step="0.01" required><br>

        <label>Cantidad:</label><br>
        <input type="number" name="cantidad" min="1" required><br><br>

        <button type="submit">Agregar Compra</button>
    </form>

    <h2>Compras Realizadas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['compras'] as $compra): ?>
                <tr>
                    <td><?= htmlspecialchars($compra['nombre']) ?></td>
                    <td><?= htmlspecialchars($compra['dni']) ?></td>
                    <td><?= htmlspecialchars($compra['producto']) ?></td>
                    <td><?= number_format($compra['precio_unitario'], 2) ?></td>
                    <td><?= $compra['cantidad'] ?></td>
                    <td><?= number_format($compra['precio_total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <form method="POST" action="generar_pdf.php">
        <button type="submit">Generar PDF</button>
    </form>
</body>
</html>
