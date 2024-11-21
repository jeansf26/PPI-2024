<!--Checa se o usuário está logado, evitando alterações por invasores-->

<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }

    $email = $_SESSION['email'];
    include 'config.php';

    $conn = new mysqli($servername, $username, $password, $database);

    $sql = "SELECT * FROM usuario_setor_professor_administrador WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    
    <!-- Link do Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Link de ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Link do CSS -->
</head>
<style type="text/css">
    
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
        list-style: none;
        margin: 0px !important;
        padding: 0px !important;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
        background: white;
    }

    .sidebar {
        position: absolute;
        width: 60px;
        height: 100vh;
        background: darkblue;
        transition: .5s;
        overflow: hidden;
    }

    .sidebar:hover {
        width: 200px;
    }
    .sidebar ul li:hover {
        background: darkslateblue;
    }
    .sidebar ul li a {
        display: flex;
        white-space: nowrap;
        text-decoration: none;
    }

    .sidebar ul li .icone {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
        min-width: 60px;
        height: 60px;
        color: white;
    }
    .sidebar ul li .titulo {
        width: 100%;
        height: 60px;
        display: flex;
        align-items: center;
        color: white;
        font-size: 1rem;
    }
    .sidebar ul li.logo {
        margin-bottom: 50px !important;
    }
    .sidebar ul li .imgCaixa {
        position: relative;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
    }
    .sidebar ul li.logo:hover {
        background: none;
    }
    .sidebar ul li.logo .icone {
        font-size: 2rem;
    }
    .sidebar ul li.logo .titulo {
        font-size: 1.2rem;
    }
    .sidebar ul li:last-of-type {
        position: absolute;
        bottom: 0;
        width: 100%;
    }

</style>
<body>
            <!-- Barra lateral -->

            <div class="sidebar">
                <ul>
                    <li class="logo">
                        <a href="#">
                            <span class="icone">
                                <div class="imgCaixa align-items-center">
                                    <img style="width: 50px;" src="logo.png" alt="...">
                                </div>
                            </span>
                            <span class="titulo">SGN</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icone bi bi-house"></span>
                            <span class="titulo">Início</span>
                        </a>
                    </li>
                    <li>
                        <a href="CTD/pag_curso.php">
                            <span class="icone bi bi-collection"></span>
                            <span class="titulo">Cursos</span>
                        </a>
                    </li>
                    <li>
                        <a href="pag_prof.php">
                            <span class="icone bi bi-person-circle"></span>
                            <span class="titulo">Professores</span>
                        </a>
                    </li>
                    <li>
                        <a href="pag_aluno.php">
                            <span class="icone bi bi-globe"></span>
                            <span class="titulo">Alunos</span>
                        </a>
                    </li>
                    <li>
                        <a href="pag_set.php">
                            <span class="icone bi bi-calendar-week"></span>
                            <span class="titulo">Setores</span>
                        </a>
                    </li>
                    <li>
                        <a href="confirm_logout.php">
                            <span class="icone bi bi-box-arrow-left"></span>
                            <span class="titulo">Sair</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Conteúdo principal -->
            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">BEM VINDO!</h1>
                    <div class="align-self-end"><?php 
                    echo "<div class='col-12 p-2 border border-dark border-2 border-opacity-50 rounded-3 mb-3'>";
                    echo $row['Nome'] . " - " . $row['Email'] . "<br>";
                    echo "</div>";?>
                        
                    </div>
                </div>


                <!-- Adicione o conteúdo principal aqui -->
                <div>
                    <p>Bem-vindo à página principal!</p>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9Bk6u6kD/5kHME9Hf/h2z2esC/6At77se9eNtfU4cg5CZ2/3ox" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-cH46zDFo4T+L46Wb5eKxE4l3JxfFkeTH8m+Cm08Qos9RVHSjtDtzHT3yZxDQ8Nd5" crossorigin="anonymous"></script>
</body>
</html>
