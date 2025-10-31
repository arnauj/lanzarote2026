
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="mb-3">
            <form action="/bienvenida.php" method="POST" >
                <label for="idEmail" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" id="idEmail" placeholder="usuario@dominio.com">

                <label for="idPassword" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="idPassword" >
                <br />
                <input type="submit" class="btn btn-primary" />

            </form>
        </div>
    </div>
</body>
</html>

