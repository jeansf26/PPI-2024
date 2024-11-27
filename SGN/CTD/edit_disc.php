<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: ../f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
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

 <title>Edição de disciplina</title>
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
            <div class="container">

        <?php
        include '../config.php';

        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];

            //Faz uma consulta e armazena ID e Nome de cada professor em uma lista

            $sql = "SELECT ID, Nome FROM usuario_setor_professor_administrador WHERE Tipo_usuario = 'prof'";
            $result = $conn->query($sql);

            $profs = [];
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $profs[] = $row;
                }
            }

            //Seleciona o id do professor que da aula na disciplina

            $sql_p = "SELECT idProfessor FROM leciona WHERE ID=?";
            $stmt_p = $conn->prepare($sql_p);
            $stmt_p->bind_param("s", $ID);
            $stmt_p->execute();
            $result_p = $stmt_p->get_result();
            $row_p = $result_p->fetch_assoc();
            $ID_p = $row_p['idProfessor'];

            //Verifica se o formulário de edição foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                // Recebe os dados do formulário
                $name = $_POST['name'];
                $prof = $_POST['prof'];

                if ($prof != $ID_p) {
                    $sql_u = "UPDATE leciona SET idProfessor=? WHERE ID=?";
                    $stmt_u = $conn->prepare($sql_u);
                    $stmt_u->bind_param("ii", $prof, $ID);
                    $stmt_u->execute();
                }


                // Atualiza os dados no banco de dados
                $sql = "UPDATE disciplina SET Nome=? WHERE ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $name, $ID);

                if ($stmt->execute()) { ?>
                    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
                        alert("Disciplina atualizada com sucesso!");
                        window.history.go(-2);
                    </SCRIPT>
                <?php
                } else { ?>
                    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
                        alert("Erro ao atualizar Disciplina.");
                    </SCRIPT>
                <?php
                }
                $stmt->close();
            } else {
                // Carrega os dados atuais da disciplina
                $sql = "SELECT * FROM disciplina WHERE ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $ID);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    // Exibe o formulário com os dados da disciplina
                    echo '
                    <h2 style="margin-left: 210px !important;">Editar disciplina:</h2>
                    <br>
                    <div class="container " style="margin-left: 210px !important; font-size: 1.3rem; width: 80%;">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label" for="name">Nome:</label>
                            <input class="form-control py-1" type="text" id="name" name="name" placeholder="Digite o nome" value="' . htmlspecialchars($row['Nome']) . '">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="prof">Professor responsável:</label>
                            <select class="form-select py-1" id="prof" name="prof" required>
                                <option value="" disabled>Selecione um professor</option>';
                                foreach ($profs as $prof) {
                                // Verifica se a turma atual do aluno corresponde ao ID da turma na lista
                                $selected = ((int)$prof['ID'] === (int)$ID_p) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($prof['ID']) . '" ' . $selected . '>' . htmlspecialchars($prof['Nome']) . '</option>';
                            }
                        echo '
                            </select>
                        </div>
                        <button class="btn btn-primary p-1" type="submit">Enviar</button>
                    </form>
                    <button onclick="goBack()" class="btn btn-danger mt-3 p-1">Cancel</button>
                    </div>
                    ';
                } else {
                    echo '<div class="alert alert-danger">disciplina não encontrada.</div>';
                }
                $stmt->close();
            }
        } else {
            echo '<div class="alert alert-danger">Disciplina não encontrada.</div>';
        }
        ?>
    </div>
  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>

</html>
