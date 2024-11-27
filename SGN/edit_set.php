<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Setor</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
        <?php
        include 'config.php';

        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];


            //Verifica se o formulário de edição foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Recebe os dados do formulário
                $name = $_POST['name'];
                $mail = $_POST['mail'];
                $psw = $_POST['psw'];
                if (empty($psw) or is_null($psw)) {
                    $sql_s = "SELECT * FROM usuario_setor_professor_administrador WHERE ID=?";
                    $stmt_s = $conn->prepare($sql_s);
                    $stmt_s->bind_param("s", $ID);
                    $stmt_s->execute();
                    $result_s = $stmt_s->get_result();
                    $row_s = $result_s->fetch_assoc();
                    $psw = $row_s['Senha'];
                }
                else {
                    $psw = md5($_POST['psw']);
                }
                $g_prof = $_POST['g_prof'];
                $g_aluno = $_POST['g_aluno'];
                $g_emiss = $_POST['g_emiss'];
                $g_data = $_POST['g_data'];
                $g_orient = $_POST['g_orient'];
                $g_obs = $_POST['g_obs'];
                $g_nota = $_POST['g_nota'];
                $g_falta = $_POST['g_falta'];

                // Atualiza os dados no banco de dados
                $sql = "UPDATE usuario_setor_professor_administrador SET Nome=?, Email=?, Senha=?, Alt_list_prof=?, G_alunos=?, G_emiss=?, G_datas=?, G_orient=?, G_obs=?, G_notas=?, G_faltas=? WHERE ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssiiiiiiiii", $name, $mail, $psw, $g_prof, $g_aluno, $g_emiss, $g_data, $g_orient, $g_obs, $g_nota, $g_falta, $ID);

                if ($stmt->execute()) { ?>
                    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
                        alert("Setor atualizado com sucesso!");
                        window.location.href = "pag_set.php";
                    </SCRIPT>
                <?php
                } else { ?>
                    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
                        alert("Erro ao atualizar setor.");
                    </SCRIPT>
                <?php
                }
                $stmt->close();
            } else {
                // Carrega os dados atuais do setor
                $sql = "SELECT * FROM usuario_setor_professor_administrador WHERE ID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $ID);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    // Exibe o formulário com os dados do setor
                    echo '
                    <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                <link href="style.css" rel="stylesheet">
                <title>Editar Aluno</title>
            </head>
            <body>
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
                        <a href="index.php">
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
                        <a href="">
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
                <div class="container" style="margin-left: 210px !important; margin-top: 30px; font-size: 1.3rem; width: 80%;">
                    <h2>Editar Setor</h2>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label" for="name">Nome:</label>
                            <input class="form-control py-1" type="text" id="name" name="name" placeholder="Digite o nome" value="' . htmlspecialchars($row['Nome']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="mail">Email:</label>
                            <input class="form-control py-1" type="text" id="mail" name="mail" placeholder="Digite o email" value="' . htmlspecialchars($row['Email']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="psw">Senha:</label>
                            <input class="form-control py-1" type="text" id="psw" name="psw" placeholder="Digite a senha se deseja alterá-la">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_prof"><b>Gerenciar Professores:</b></label><br>
                            <input type="radio" id="g_prof_sim" name="g_prof" value="1" ' . ($row['Alt_list_prof'] == 1 ? 'checked' : '') . '>
                            <label for="g_prof_sim">Sim</label>
                            <input type="radio" id="g_prof_nao" name="g_prof" value="0" ' . ($row['Alt_list_prof'] == 0 ? 'checked' : '') . '>
                            <label for="g_prof_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_aluno"><b>Gerenciar alunos:</b></label><br>
                            <input type="radio" id="g_aluno_sim" name="g_aluno" value="1" ' . ($row['G_alunos'] == 1 ? 'checked' : '') . '>
                            <label for="g_aluno_sim">Sim</label>
                            <input type="radio" id="g_aluno_nao" name="g_aluno" value="0" ' . ($row['G_alunos'] == 0 ? 'checked' : '') . '>
                            <label for="g_aluno_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_emiss"><b>Emitir boletins e relatórios:</b></label><br>
                            <input type="radio" id="g_emiss_sim" name="g_emiss" value="1" ' . ($row['G_emiss'] == 1 ? 'checked' : '') . '>
                            <label for="g_emiss_sim">Sim</label>
                            <input type="radio" id="g_emiss_nao" name="g_emiss" value="0" ' . ($row['G_emiss'] == 0 ? 'checked' : '') . '>
                            <label for="g_emiss_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_data"><b>Gerenciar datas de entrega:</b></label><br>
                            <input type="radio" id="g_data_sim" name="g_data" value="1" ' . ($row['G_datas'] == 1 ? 'checked' : '') . '>
                            <label for="g_data_sim">Sim</label>
                            <input type="radio" id="g_data_nao" name="g_data" value="0" ' . ($row['G_datas'] == 0 ? 'checked' : '') . '>
                            <label for="g_data_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_orient"><b>Gerenciar orientador da mostra:</b></label><br>
                            <input type="radio" id="g_orient_sim" name="g_orient" value="1" ' . ($row['G_orient'] == 1 ? 'checked' : '') . '>
                            <label for="g_orient_sim">Sim</label>
                            <input type="radio" id="g_orient_nao" name="g_orient" value="0" ' . ($row['G_orient'] == 0 ? 'checked' : '') . '>
                            <label for="g_orient_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_obs"><b>Gerenciar observações:</b></label><br>
                            <input type="radio" id="g_obs_sim" name="g_obs" value="1" ' . ($row['G_obs'] == 1 ? 'checked' : '') . '>
                            <label for="g_obs_sim">Sim</label>
                            <input type="radio" id="g_obs_nao" name="g_obs" value="0" ' . ($row['G_obs'] == 0 ? 'checked' : '') . '>
                            <label for="g_obs_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_nota"><b>Gerenciar notas:</b></label><br>
                            <input type="radio" id="g_nota_sim" name="g_nota" value="1" ' . ($row['G_notas'] == 1 ? 'checked' : '') . '>
                            <label for="g_nota_sim">Sim</label>
                            <input type="radio" id="g_nota_nao" name="g_nota" value="0" ' . ($row['G_notas'] == 0 ? 'checked' : '') . '>
                            <label for="g_nota_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="g_falta"><b>Gerenciar faltas:</b></label><br>
                            <input type="radio" id="g_falta_sim" name="g_falta" value="1" ' . ($row['G_faltas'] == 1 ? 'checked' : '') . '>
                            <label for="g_falta_sim">Sim</label>
                            <input type="radio" id="g_falta_nao" name="g_falta" value="0" ' . ($row['G_faltas'] == 0 ? 'checked' : '') . '>
                            <label for="g_falta_nao">Não</label>
                        </div>
                        <button class="btn btn-primary p-1" type="submit">Atualizar</button>
                    </form>
                    <button onclick="goBack()" class="btn btn-danger mt-3 p-1">Cancelar</button>
                </div>
            </body>
            </html>
            ';
        } else {
            echo '<div class="alert alert-danger">Setor não encontrado.</div>';
        }
        $stmt->close();
    }
} else {
    echo '<div class="alert alert-danger">Setor não encontrado.</div>';
}
?>
    <script>
    function goBack() {
      window.history.back();
    }
  </script>
