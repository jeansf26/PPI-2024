<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }

    $ID = $_GET['ID'];

    include ('../config.php');

    $sql = "SELECT ID, Nome FROM usuario_setor_professor_administrador WHERE Tipo_usuario = 'prof'";
    $result = $conn->query($sql);

    $profs = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $profs[] = $row;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../style.css" rel="stylesheet">

 <title>Cadastro de Disciplinas</title>
</head>
<body>
<!-- Barra lateral -->

            <div class="sidebar">
                <ul>
                    <li class="logo">
                        <a href="#">
                            <span class="icone">
                                <div class="imgCaixa align-items-center">
                                    <img style="width: 50px;" src="../logo.png" alt="...">
                                </div>
                            </span>
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
                        <a href="../CTD/pag_curso.php">
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

<h2 style="margin-left: 210px !important;">Cadastro de Disciplina:</h2>
<br>

<!-- Formulário de cadastro -->

<div class="container" style="margin-left: 210px !important; font-size: 1.3rem; width: 80%; ">
        <form action="cadastro_disc.php" method="post">
            <div class="mb-3">
                <input type="hidden" name="ID" value="<?php echo $ID; ?>">

                <label class="form-label" for="name">Nome:</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="Digite o nome" required>
                
            </div>

            <div class="mb-3">
                <label class="form-label" for="prof">Professor responsável:</label>
                <select class="form-select py-1" id="prof" name="prof" required>
                    <option value="" disabled selected>Selecione um professor</option>
                    <?php foreach ($profs as $prof): ?>
                        <option value="<?= htmlspecialchars($prof['ID']) ?>"><?= htmlspecialchars($prof['Nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary p-1">Enviar</button>
            <button onclick="goBack()" class="btn btn-danger p-1">Cancel</button>
        </form>
    </div>
  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>
</html>