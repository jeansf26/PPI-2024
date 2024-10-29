<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../f_login.php");
    exit();
}
?>

<?php

//Seleciona o usuário logado, conecta e tals

include "../config.php";

$emaillogado = $_SESSION['email'];
$ID = $_GET['ID'];

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlx = "SELECT * FROM usuario_setor_professor_administrador WHERE email='$emaillogado'";
$resultx = $conn->query($sqlx);
$rowsx = $resultx->fetch_assoc()
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas</title>
    <link href="../style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="sidebar">
                <ul>
                    <li class="logo">
                        <a href="#">
                            <span class="icone"></span>
                            <span class="titulo">SGN</span>
                        </a>
                    </li>
                    <li>
                        <a href="../index.php">
                            <span class="icone bi bi-house"></span>
                            <span class="titulo">Início</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="icone bi bi-collection"></span>
                            <span class="titulo">Cursos</span>
                        </a>
                    </li>
                    <li>
                        <a href="../pag_prof.php">
                            <span class="icone bi bi-person-circle"></span>
                            <span class="titulo">Professores</span>
                        </a>
                    </li>
                    <li>
                        <a href="../pag_aluno.php">
                            <span class="icone bi bi-globe"></span>
                            <span class="titulo">Alunos</span>
                        </a>
                    </li>
                    <li>
                        <a href="../pag_set.php">
                            <span class="icone bi bi-calendar-week"></span>
                            <span class="titulo">Setores</span>
                        </a>
                    </li>
                    <li>
                        <a href="../confirm_logout.php">
                            <span class="icone bi bi-box-arrow-left"></span>
                            <span class="titulo">Sair</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Conteúdo principal -->
            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Lista de Turmas</h1>
                </div>
                <div class="row">
                <div class='d-flex justify-content-center col-1 p-2 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg mb-3 me-3 ms-3 bg-danger'>
                    <a href="pag_curso.php" class="nav-link"><i class="bi bi-arrow-return-left"></i></a>
                </div>
                <?php  
                if ($rowsx['Tipo_usuario'] == 'admin') {
                    echo "<div class='d-flex justify-content-center col-1 p-2 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg mb-3 bg-primary'>
                    <a href='f_turma.php?ID=$ID' class='nav-link'><i class='bi bi-plus-square-fill'></i></a>
                </div>";
                }
                ?>
                
                </div>
                
                <!-- Exibição das turmas -->
                <div>
                    <?php 
                    

                    // Seleciona todos as turmas do curso selecionado
                    $sql = "SELECT * FROM turma WHERE idCurso = $ID";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='col-4 p-3 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg mb-3'>";
                            echo "<a href='pag_disc.php?ID=" . $row['ID'] . "' class='nav-link'>";
                            echo $row['Nome'];
                            echo "</a>";
                            echo "<div class= 'row'>";
                            if ($rowsx['Tipo_usuario'] == 'admin') {
                                echo "<div class='d-flex justify-content-center mt-2 col-2 p-2 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg bg-success'>
                                    <a href='edit_turma.php?ID=" . $row['ID'] . "' class='nav-link'><i class='bi bi-pencil-square'></i></a>
                                    </div>";
                                echo "<div class='d-flex justify-content-center mt-2 ms-2 col-2 p-2 border border-dark border-3 border-opacity-75 rounded-5 shadow-lg bg-success'>
                                    <a href='exc_turma.php?ID=" . $row['ID'] . "' class='nav-link'><i class='bi bi-trash3'></i></a>
                                    </div>";
                                }
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "Nenhuma turma encontrada.";
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9Bk6u6kD/5kHME9Hf/h2z2esC/6At77se9eNtfU4cg5CZ2/3ox" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-cH46zDFo4T+L46Wb5eKxE4l3JxfFkeTH8m+Cm08Qos9RVHSjtDtzHT3yZxDQ8Nd5" crossorigin="anonymous"></script>
</body>
</html>
