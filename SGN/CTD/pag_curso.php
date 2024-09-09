<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: f_login.php");
    exit();
}
?>

<?php
include "../config.php";

$emaillogado = $_SESSION['email'];

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Seleciona o usuário logado
$sqlx = "SELECT * FROM usuario_setor_professor_administrador WHERE email='$emaillogado'";
$resultx = $conn->query($sqlx);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <link href="../style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <a href="" class="d-block p-3 link-dark text-decoration-none" title="Iffar" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img height="48" src="../if.png" alt="Iffar">
                        <span class="visually-hidden">Iffar</span>
                    </a>
                    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link py-3 border-bottom" aria-current="page" title="Início" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 active border-bottom" title="Turmas" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="bi bi-collection"></i>
                            </a>
                        </li>
                        <li>
                            <a href="../pag_prof.php" class="nav-link py-3 border-bottom" title="Professores" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="bi bi-person-circle"></i>
                            </a>
                        </li>
                        <li>
                            <a href="../pag_aluno.php" class="nav-link py-3 border-bottom" title="Alunos" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="bi bi-globe"></i>
                            </a>
                        </li>
                        <li>
                            <a href="../pag_set.php" class="nav-link py-3 border-bottom" title="Setores" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="bi bi-calendar-week"></i>
                            </a>
                        </li>
                        <li>
                            <a href="../confirm_logout.php" class="nav-link py-3 border-bottom" title="Logout" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="bi bi-box-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Conteúdo principal -->
            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Lista de Cursos</h1>
                </div>
                <div class='d-flex justify-content-center col-1 p-2 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg mb-3 bg-primary'>
                    <a href="f_curso.php" class="nav-link"><i class="bi bi-plus-square-fill"></i></a>
                </div>
                
                <!-- Exibição dos alunos -->
                <div>
                    <?php 
                    // Seleciona todos os alunos
                    $sql = "SELECT * FROM curso";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='col-4 p-3 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg mb-3'>";
                            echo "<a href='pag_turma.php?ID=" . $row['ID'] . "' class='nav-link'>";
                            echo $row['Nome'];
                            echo "</a>";
                            echo "<div class= 'row'>";
                            echo "<div class='d-flex justify-content-center mt-2 col-2 p-2 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg bg-success'>
                                <a href='edit_curso.php?ID=" . $row['ID'] . "' class='nav-link'><i class='bi bi-pencil-square'></i></a>
                                </div>";
                            echo "<div class='d-flex justify-content-center mt-2 ms-2 col-2 p-2 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg bg-success'>
                                <a href='exc_curso.php?ID=" . $row['ID'] . "' class='nav-link'><i class='bi bi-trash3'></i></a>
                                </div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "Nenhum Curso encontrado.";
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <?php
    // Fecha a conexão
    $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9Bk6u6kD/5kHME9Hf/h2z2esC/6At77se9eNtfU4cg5CZ2/3ox" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-cH46zDFo4T+L46Wb5eKxE4l3JxfFkeTH8m+Cm08Qos9RVHSjtDtzHT3yZxDQ8Nd5" crossorigin="anonymous"></script>
</body>
</html>
