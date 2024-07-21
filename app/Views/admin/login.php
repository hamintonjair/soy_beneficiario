<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Jojama" />
        <meta name="author" content="Jojama" />
        <link href="<?php echo base_url(); ?>favicon.ico" rel="icon">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/logo.jpg'); /* Cambia la ruta por la imagen que deseas usar como fondo */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            height: 100vh; /* Ajusta el tamaño del cuerpo al 100% del viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.8); /* Color de fondo con transparencia para mejorar la legibilidad */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Login</h2>
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="<?php echo base_url('login'); ?>" method="post">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <?php if(isset($validation) && $validation->hasError('username')): ?>
                        <p class="text-danger"><?= $validation->getError('username'); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <?php if(isset($validation) && $validation->hasError('password')): ?>
                        <p class="text-danger"><?= $validation->getError('password'); ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
