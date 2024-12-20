<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: f_login.php");
    exit();
}

include 'config.php';

if (isset($_GET['CPF'])) {
    $CPF = $_GET['CPF'];

    //Um monte de consultas ao banco de dados para pegar o id da turma que o aluno está

    $sql_ta = "SELECT ID FROM turma_aluno WHERE CPF=?";
    $stmt_ta = $conn->prepare($sql_ta);
    $stmt_ta->bind_param("s", $CPF);
    $stmt_ta->execute();
    $result_ta = $stmt_ta->get_result();

    if ($result_ta->num_rows > 0) {
        $row_ta = $result_ta->fetch_assoc();
        $ID_t = $row_ta['ID'];
    } else {
        $ID_t = 0;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recebe os dados do formulário
        $name = $_POST['name'];
        $mat = $_POST['mat'];
        $mail = $_POST['mail'];
        $gen = $_POST['gen'];
        $dat = $_POST['dat'];
        $cty = $_POST['cty'];
        $uf = $_POST['uf'];
        $rep = $_POST['rep'];
        $turma = $_POST['turma'];

        
        $sql_t = "SELECT Nome FROM turma WHERE ID=?";
        $stmt_t = $conn->prepare($sql_t);
        $stmt_t->bind_param("s", $ID_t);
        $stmt_t->execute();
        $result_t = $stmt_t->get_result();
        $row_t = $result_t->fetch_assoc();

        if (empty($row_t['Nome']) or is_null($row_t['Nome'])) {
            $turma_atual = '';
        } else {
            $turma_atual = $row_t['Nome'];
        }

        //Verifica se a turma escolhida no formulário é diferente da que o aluno está

            if ($turma != $turma_atual) {

                //Excluindo a linha do aluno com a turma
                $sql_apagar1 = "DELETE FROM turma_aluno WHERE CPF = ?";
                $stmt_apagar1 = $conn->prepare($sql_apagar1);
                $stmt_apagar1->bind_param("s", $CPF); 
                $stmt_apagar1->execute();

                //Excluindo a linha do aluno com suas disciplinas
                $sql_apagar2 = "DELETE FROM disciplina_aluno WHERE CPF = ?";
                $stmt_apagar2 = $conn->prepare($sql_apagar2);
                $stmt_apagar2->bind_param("s", $CPF); 
                $stmt_apagar2->execute();


                // Consulta para obter ID da turma
                $id_turma_query = "SELECT ID FROM turma WHERE Nome = ?";
                $stmt_turma = $conn->prepare($id_turma_query);
                $stmt_turma->bind_param("s", $turma);
                $stmt_turma->execute();
                $result_turma = $stmt_turma->get_result();
                $row_turma = $result_turma->fetch_assoc();
                $id_turma = $row_turma['ID'];

                // Inserção na tabela turma_aluno
                $sql2 = "INSERT INTO turma_aluno (ID, CPF) VALUES ('{$id_turma}', '{$CPF}')";
                $salvar2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

                // Inserção nas disciplinas
                $sql_disciplinas = "SELECT ID FROM disciplina WHERE idTurma = {$id_turma}";
                $result_disciplinas = mysqli_query($conn, $sql_disciplinas);

                if ($result_disciplinas && mysqli_num_rows($result_disciplinas) > 0) {
                    while ($row = mysqli_fetch_assoc($result_disciplinas)) {
                        $sql3 = "INSERT INTO disciplina_aluno (PPI, MC, AIA, Observacoes, AIS, Faltas, Nota1, Nota2, CPF, ID, parcial1, parcial2)
                                 VALUES ('', '', '', '', '', '', '', '', '{$CPF}', '{$row['ID']}', '', '')";
                        $salvar3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
                    }
                }
            }
        
        $acomp = $_POST['acomp'];
        $aux_per = $_POST['aux_per'];
        $ap_psic = $_POST['ap_psic'];
        $cot = $_POST['cot'];
        $estag = $_POST['estag'];
        $inter = $_POST['inter'];
        $acomp_saude = $_POST['acomp_saude'];
        $proj_pesq = $_POST['proj_pesq'];
        $proj_ext = $_POST['proj_ext'];
        $proj_ens = $_POST['proj_ens'];




        // Atualiza os dados no banco de dados
        $sql = "UPDATE aluno SET Nome=?, Matricula=?, Email=?, Genero=?, Data_nasc=?, Cidade=?, UF=?, Reprovacoes=?, Acompanhamento=?, Aux_permanencia=?, Apoio_psic=?, Cotista=?, Estagio=?, Interno=?, Acomp_saude=?, Proj_pesq=?, Proj_ext=?, Proj_ens=? WHERE CPF=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssssssssiiiiiiiisss", $name, $mat, $mail, $gen, $dat, $cty, $uf, $rep, $acomp, $aux_per, $ap_psic, $cot, $estag, $inter, $acomp_saude, $proj_pesq, $proj_ext, $proj_ens, $CPF);

        if ($stmt->execute()) { ?>
            <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
                alert("Aluno atualizado com sucesso!");
                window.location.href = "pag_aluno.php";
            </SCRIPT>
        <?php
        } else { ?>
            <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript"> 
                alert("Erro ao atualizar aluno.");
            </SCRIPT>
        <?php
        }
        $stmt->close();
    } else {
        // Carrega os dados atuais do aluno
        $sql = "SELECT * FROM aluno WHERE CPF=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $CPF);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Carrega as turmas do banco de dados
        $sqlTurmas = "SELECT * FROM turma";
        $resultTurmas = $conn->query($sqlTurmas);
        $turmas = [];
        if ($resultTurmas->num_rows > 0) {
            while ($turma = $resultTurmas->fetch_assoc()) {
                $turmas[] = $turma;
            }
        }

        if ($row) {
            // Exibe o formulário com os dados do aluno
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
                    <h2>Editar Aluno</h2>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label" for="name">Nome:</label>
                            <input class="form-control py-1" type="text" id="name" name="name" placeholder="Digite o nome" value="' . htmlspecialchars($row['Nome']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="mat">Matrícula:</label>
                            <input class="form-control py-1" type="text" id="mat" name="mat" placeholder="Digite a matrícula" value="' . htmlspecialchars($row['Matricula']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="mail">Email:</label>
                            <input class="form-control py-1" type="text" id="mail" name="mail" placeholder="Digite o email" value="' . htmlspecialchars($row['Email']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="gen">Gênero:</label>
                            <input class="form-control py-1" type="text" id="gen" name="gen" placeholder="Digite o gênero" value="' . htmlspecialchars($row['Genero']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="dat">Data de Nascimento:</label>
                            <input class="form-control py-1" type="date" id="dat" name="dat" value="' . htmlspecialchars($row['Data_nasc']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="cty">Cidade:</label>
                            <input class="form-control py-1" type="text" id="cty" name="cty" placeholder="Digite a cidade" value="' . htmlspecialchars($row['Cidade']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="uf">UF:</label>
                            <input class="form-control py-1" type="text" id="uf" name="uf" placeholder="Digite o UF" value="' . htmlspecialchars($row['UF']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="rep">Reprovações:</label>
                            <input class="form-control py-1" type="number" id="rep" name="rep" placeholder="Digite as reprovações" value="' . htmlspecialchars($row['Reprovacoes']) . '" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="turma">Turma:</label>
                            <select class="form-select py-1" id="turma" name="turma" required>
                                <option value="" >Selecione uma turma</option>';
                                foreach ($turmas as $turma) {
                                // Verifica se a turma atual do aluno corresponde ao ID da turma na lista
                                $selected = ((int)$turma['ID'] === (int)$ID_t) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($turma['Nome']) . '" ' . $selected . '>' . htmlspecialchars($turma['Nome']) . '</option>';
                            }



                        echo '
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="acomp"><b>Acompanhamento:</b></label><br>
                            <input type="radio" id="acomp_sim" name="acomp" value="1" ' . ($row['Acompanhamento'] == 1 ? 'checked' : '') . '>
                            <label for="acomp_sim">Sim</label>
                            <input type="radio" id="acomp_nao" name="acomp" value="0" ' . ($row['Acompanhamento'] == 0 ? 'checked' : '') . '>
                            <label for="acomp_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="aux_per"><b>Auxílio Permanência:</b></label><br>
                            <input type="radio" id="aux_per_sim" name="aux_per" value="1" ' . ($row['Aux_permanencia'] == 1 ? 'checked' : '') . '>
                            <label for="aux_per_sim">Sim</label>
                            <input type="radio" id="aux_per_nao" name="aux_per" value="0" ' . ($row['Aux_permanencia'] == 0 ? 'checked' : '') . '>
                            <label for="aux_per_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ap_psic"><b>Apoio psicológico:</b></label><br>
                            <input type="radio" id="ap_psic_sim" name="ap_psic" value="1" ' . ($row['Apoio_psic'] == 1 ? 'checked' : '') . '>
                            <label for="ap_psic_sim">Sim</label>
                            <input type="radio" id="ap_psic_nao" name="ap_psic" value="0" ' . ($row['Apoio_psic'] == 0 ? 'checked' : '') . '>
                            <label for="ap_psic_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="cot"><b>Cotista:</b></label><br>
                            <input type="radio" id="cot_sim" name="cot" value="1" ' . ($row['Cotista'] == 1 ? 'checked' : '') . '>
                            <label for="cot_sim">Sim</label>
                            <input type="radio" id="cot_nao" name="cot" value="0" ' . ($row['Cotista'] == 0 ? 'checked' : '') . '>
                            <label for="cot_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="estag"><b>Estágio:</b></label><br>
                            <input type="radio" id="estag_sim" name="estag" value="1" ' . ($row['Estagio'] == 1 ? 'checked' : '') . '>
                            <label for="estag_sim">Sim</label>
                            <input type="radio" id="estag_nao" name="estag" value="0" ' . ($row['Estagio'] == 0 ? 'checked' : '') . '>
                            <label for="estag_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inter"><b>Interno:</b></label><br>
                            <input type="radio" id="inter_sim" name="inter" value="1" ' . ($row['Interno'] == 1 ? 'checked' : '') . '>
                            <label for="inter_sim">Sim</label>
                            <input type="radio" id="inter_nao" name="inter" value="0" ' . ($row['Interno'] == 0 ? 'checked' : '') . '>
                            <label for="inter_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="acomp_saude"><b>Acompanhamento de saúde:</b></label><br>
                            <input type="radio" id="acomp_saude_sim" name="acomp_saude" value="1" ' . ($row['Acomp_saude'] == 1 ? 'checked' : '') . '>
                            <label for="acomp_saude_sim">Sim</label>
                            <input type="radio" id="acomp_saude_nao" name="acomp_saude" value="0" ' . ($row['Acomp_saude'] == 0 ? 'checked' : '') . '>
                            <label for="acomp_saude_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="proj_pesq"><b>Projeto de pesquisa:</b></label><br>
                            <input type="radio" id="proj_pesq_sim" name="proj_pesq" value="1" ' . ($row['Proj_pesq'] == 1 ? 'checked' : '') . '>
                            <label for="proj_pesq_sim">Sim</label>
                            <input type="radio" id="proj_pesq_nao" name="proj_pesq" value="0" ' . ($row['Proj_pesq'] == 0 ? 'checked' : '') . '>
                            <label for="proj_pesq_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="proj_ext"><b>Projeto de extensão:</b></label><br>
                            <input type="radio" id="proj_ext_sim" name="proj_ext" value="1" ' . ($row['Proj_ext'] == 1 ? 'checked' : '') . '>
                            <label for="proj_ext_sim">Sim</label>
                            <input type="radio" id="proj_ext_nao" name="proj_ext" value="0" ' . ($row['Proj_ext'] == 0 ? 'checked' : '') . '>
                            <label for="proj_ext_nao">Não</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="proj_ens"><b>Projeto de ensino:</b></label><br>
                            <input type="radio" id="proj_ens_sim" name="proj_ens" value="1" ' . ($row['Proj_ens'] == 1 ? 'checked' : '') . '>
                            <label for="proj_ens_sim">Sim</label>
                            <input type="radio" id="proj_ens_nao" name="proj_ens" value="0" ' . ($row['Proj_ens'] == 0 ? 'checked' : '') . '>
                            <label for="proj_ens_nao">Não</label>
                        </div>
                        <button class="btn btn-primary p-1" type="submit">Atualizar</button>
                    </form>
                    <button onclick="goBack()" class="btn btn-danger mt-3 p-1">Cancelar</button>
                </div>
            </body>
            </html>';
        } else {
            echo '<div class="alert alert-danger">Aluno não encontrado.</div>';
        }
        $stmt->close();
    }
} else {
    echo '<div class="alert alert-danger">CPF não fornecido.</div>';
}
?>
    <script>
    function goBack() {
      window.history.back();
    }
  </script>
