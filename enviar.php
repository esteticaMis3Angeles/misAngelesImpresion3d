<?php 
    // Email destination - Update this to your email address
    $destino = "argofrogg@gmail.com";
    
    // Get form data
    $nombre = isset($_POST["nombre"]) ? htmlspecialchars($_POST["nombre"]) : "";
    $correo = isset($_POST["correo"]) ? filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL) : "";
    $telefono = isset($_POST["telefono"]) ? htmlspecialchars($_POST["telefono"]) : "";
    $mensaje = isset($_POST["mensaje"]) ? htmlspecialchars($_POST["mensaje"]) : "";
    
    // Validate required fields
    if (empty($nombre) || empty($correo) || empty($telefono) || empty($mensaje)) {
        header("Location: contacto.html?error=incomplete");
        exit;
    }
    
    // Validate email format
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: contacto.html?error=invalid_email");
        exit;
    }
    
    // Email headers for proper formatting
    $headers = "From: " . $correo . "\r\n";
    $headers .= "Reply-To: " . $correo . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Email subject and content
    $asunto = "Nuevo mensaje de contacto - " . $nombre;
    $contenido = "NUEVO MENSAJE DE CONTACTO\n";
    $contenido .= "========================\n\n";
    $contenido .= "Nombre: " . $nombre . "\n";
    $contenido .= "Correo: " . $correo . "\n";
    $contenido .= "Teléfono: " . $telefono . "\n";
    $contenido .= "\nMensaje:\n";
    $contenido .= $mensaje . "\n";

    // Handle uploaded file (optional)
    $uploadedFileName = '';
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = basename($_FILES['archivo']['name']);
        $fileSize = $_FILES['archivo']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExt = array('stl', 'obj');
        $maxSize = 8 * 1024 * 1024; // 8 MB

        if (!in_array($fileExt, $allowedExt)) {
            header("Location: contacto.html?error=invalid_file_type");
            exit;
        }

        if ($fileSize > $maxSize) {
            header("Location: contacto.html?error=file_too_large");
            exit;
        }

        $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $safeFileName = uniqid('stl_', true) . '.' . $fileExt;
        $destPath = $uploadDir . DIRECTORY_SEPARATOR . $safeFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $uploadedFileName = $safeFileName;
            $contenido .= "\nArchivo subido: " . $uploadedFileName . "\n";
        }
    }

    // Send email
    if (mail($destino, $asunto, $contenido, $headers)) {
        header("Location: contacto.html?success=true");
    } else {
        header("Location: contacto.html?error=send_failed");
    }
    exit;
?>