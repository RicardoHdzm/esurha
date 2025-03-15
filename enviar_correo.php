<?php
// Habilitar la visualización de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y sanitizarlos
    $nombre = htmlspecialchars(strip_tags(trim($_POST["name"] ?? '')));
    $asunto = htmlspecialchars(strip_tags(trim($_POST["asunto"] ?? '')));
    $email = htmlspecialchars(strip_tags(trim($_POST["email"] ?? '')));
    $telefono = htmlspecialchars(strip_tags(trim($_POST["phone"] ?? '')));
    $mensaje = htmlspecialchars(strip_tags(trim($_POST["mensaje"] ?? '')));

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($asunto) || empty($email) || empty($telefono) || empty($mensaje)) {
        header("Location: proyectos.html?status=error");
        exit();
    }

    // Destinatario (cambia esto por tu correo)
    $destinatario = "c.velazquez@esurha.com"; // Reemplázalo por tu dirección de correo

    // Construir el mensaje
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo Electrónico: $email\n";
    $contenido .= "Teléfono: $telefono\n\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    // Cabeceras del correo
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Enviar el correo
    $exito = mail($destinatario, $asunto, $contenido, $headers);

    // Redirigir con mensaje de éxito o error
    if ($exito) {
        header("Location: mensaje-enviado?status=success");
    } else {
        header("Location: mensaje-enviado?status=error");
    }
    exit();
} else {
    // Si no es una solicitud POST, redirigir a proyectos.html
    header("Location: mensaje-enviado");
    exit();
}
?>
