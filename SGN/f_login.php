<!-- Simplesmente o formulário de login -->

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="stylelogin.css" rel="stylesheet">
    <title>Página de Login</title>
</head>
<body class="d-flex align-items-center bg-body-tertiary">
    <main class="w-100 mx-auto form-container">
        <form action="login.php" method="post">
            <img src="logo.png" class="mb-3" style="height: 110px;"/>
            <h1 style="color: darkblue;" class="h3 mb-3">Login</h1>
            <div class="form-floating">
                <input style="border-color: darkblue;" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label style="color: darkblue;" for="floatingInput">Endereço de email</label>
              </div>
              <div class="form-floating">
                <input style="border-color: darkblue;" name="senha" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label style="color: darkblue;" for="floatingPassword">Senha</label>
              </div>
          
              <div style="border-color: darkblue; color: darkblue;" class="checkbox mb-3">
                <label>
                  <input type="checkbox" value="remember-me"> Lembrar de mim
                </label>
              </div>
              <button style="color: darkblue; border-color: darkblue;" class="w-100 btn btn-lg" type="submit">Login</button>
        </form>
    </main>
</body>
</html>