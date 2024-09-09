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
    <title>Editar Aluno</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        * {box-sizing: border-box}
        .container {padding: 16px;}
        input[type=text], input[type=password], input[type=date] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }
        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }
        hr {border: 1px solid #f1f1f1; margin-bottom: 25px;}
        .sendbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }
        .sendbtn:hover {opacity:1;}
        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'config.php';

        if (isset($_GET['CPF'])) {
            $CPF = $_GET['CPF'];

            //Verifica se o formulário de edição foi enviado
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

            
                $sql = "UPDATE aluno SET Nome=?, Matricula=?, Email=?, Genero=?, Data_nasc=?, Cidade=?, UF=?, Reprovacoes=?, Acompanhamento=?, Aux_permanencia=?, Apoio_psic=?, Cotista=?, Estagio=?, Interno=?, Acomp_saude=?, Proj_pesq=?, Proj_ext=?, Proj_ens=? WHERE CPF=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssiiiiiiiisss", $name, $mat, $mail, $gen, $dat, $cty, $uf, $rep, $acomp, $aux_per, $ap_psic, $cot, $estag, $inter, $acomp_saude, $proj_pesq, $proj_ext, $proj_ens, $CPF);

                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">Aluno atualizado com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao atualizar aluno: ' . $stmt->error . '</div>';
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

                if ($row) {
                    // Exibe o formulário com os dados do aluno
                    echo '
                    <h1>Editar Aluno</h1>
                    <p>Atualize as informações do aluno abaixo.</p>
                    <hr>
                    <form method="POST" action="">
                        <label for="name"><b>Nome</b></label>
                        <input type="text" placeholder="Digite o nome" name="name" id="name" value="' . htmlspecialchars($row['Nome']) . '" required>
                        <label for="cpf"><b>CPF</b></label>
                        <input type="text" placeholder="Digite aqui" name="cpf" id="cpf" value="' . htmlspecialchars($row['CPF']) . '" readonly required>
                        <label for="mat"><b>Número de matrícula</b></label>
                        <input type="text" placeholder="Digite aqui" name="mat" id="mat" value="' . htmlspecialchars($row['Matricula']) . '" required>
                        <label for="mail"><b>E-mail</b></label>
                        <input type="text" placeholder="Digite aqui" name="mail" id="mail" value="' . htmlspecialchars($row['Email']) . '" required>
                        <label for="gen"><b>Gênero</b></label>
                        <input type="text" placeholder="Digite aqui" name="gen" id="gen" value="' . htmlspecialchars($row['Genero']) . '" required>
                        <label for="dat"><b>Data de nascimento</b></label>
                        <input type="date" name="dat" id="dat" value="' . htmlspecialchars($row['Data_nasc']) . '" required>
                        <label for="cty"><b>Cidade</b></label>
                        <input type="text" placeholder="Digite aqui" name="cty" id="cty" value="' . htmlspecialchars($row['Cidade']) . '" required>
                        <label for="uf"><b>UF</b></label>
                        <input type="text" placeholder="Digite aqui" name="uf" id="uf" value="' . htmlspecialchars($row['UF']) . '" required>
                        <label for="rep"><b>Reprovações</b></label>
                        <input type="number" placeholder="Digite aqui" name="rep" id="rep" value="' . htmlspecialchars($row['Reprovacoes']) . '" required>
                        <label for="acomp"><b>Acompanhamento</b></label>
                        <input type="radio" id="acomp_sim" name="acomp" value="1" ' . ($row['Acompanhamento'] == 1 ? 'checked' : '') . '>
                        <label for="acomp_sim">Sim</label>
                        <input type="radio" id="acomp_nao" name="acomp" value="0" ' . ($row['Acompanhamento'] == 0 ? 'checked' : '') . '>
                        <label for="acomp_nao">Não</label><br><br>
                        <label for="aux_per"><b>Auxílio Permanência</b></label>
                        <input type="radio" id="aux_per_sim" name="aux_per" value="1" ' . ($row['Aux_permanencia'] == 1 ? 'checked' : '') . '>
                        <label for="aux_per_sim">Sim</label>
                        <input type="radio" id="aux_per_nao" name="aux_per" value="0" ' . ($row['Aux_permanencia'] == 0 ? 'checked' : '') . '>
                        <label for="aux_per_nao">Não</label><br><br>
                        <label for="ap_psic"><b>Apoio Psicológico</b></label>
                        <input type="radio" id="ap_psic_sim" name="ap_psic" value="1" ' . ($row['Apoio_psic'] == 1 ? 'checked' : '') . '>
                        <label for="ap_psic_sim">Sim</label>
                        <input type="radio" id="ap_psic_nao" name="ap_psic" value="0" ' . ($row['Apoio_psic'] == 0 ? 'checked' : '') . '>
                        <label for="ap_psic_nao">Não</label><br><br>
                        <label for="cot"><b>Cotista</b></label>
                        <input type="radio" id="cot_sim" name="cot" value="1" ' . ($row['Cotista'] == 1 ? 'checked' : '') . '>
                        <label for="cot_sim">Sim</label>
                        <input type="radio" id="cot_nao" name="cot" value="0" ' . ($row['Cotista'] == 0 ? 'checked' : '') . '>
                        <label for="cot_nao">Não</label><br><br>
                        <label for="estag"><b>Estágio</b></label>
                        <input type="radio" id="estag_sim" name="estag" value="1" ' . ($row['Estagio'] == 1 ? 'checked' : '') . '>
                        <label for="estag_sim">Sim</label>
                        <input type="radio" id="estag_nao" name="estag" value="0" ' . ($row['Estagio'] == 0 ? 'checked' : '') . '>
                        <label for="estag_nao">Não</label><br><br>
                        <label for="inter"><b>Interno</b></label>
                        <input type="radio" id="inter_sim" name="inter" value="1" ' . ($row['Interno'] == 1 ? 'checked' : '') . '>
                        <label for="inter_sim">Sim</label>
                        <input type="radio" id="inter_nao" name="inter" value="0" ' . ($row['Interno'] == 0 ? 'checked' : '') . '>
                        <label for="inter_nao">Não</label><br><br>
                        <label for="acomp_saude"><b>Acompanhamento de saúde</b></label>
                        <input type="radio" id="acomp_saude_sim" name="acomp_saude" value="1" ' . ($row['Acomp_saude'] == 1 ? 'checked' : '') . '>
                        <label for="acomp_saude_sim">Sim</label>
                        <input type="radio" id="acomp_saude_nao" name="acomp_saude" value="0" ' . ($row['Acomp_saude'] == 0 ? 'checked' : '') . '>
                        <label for="acomp_saude_nao">Não</label><br><br>
                        <label for="proj_pesq"><b>Projeto de Pesquisa</b></label>
                        <input type="radio" id="proj_pesq_sim" name="proj_pesq" value="1" ' . ($row['Proj_pesq'] == 1 ? 'checked' : '') . '>
                        <label for="proj_pesq_sim">Sim</label>
                        <input type="radio" id="proj_pesq_nao" name="proj_pesq" value="0" ' . ($row['Proj_pesq'] == 0 ? 'checked' : '') . '>
                        <label for="proj_pesq_nao">Não</label><br><br>
                        <label for="proj_ext"><b>Projeto de Extensão</b></label>
                        <input type="radio" id="proj_ext_sim" name="proj_ext" value="1" ' . ($row['Proj_ext'] == 1 ? 'checked' : '') . '>
                        <label for="proj_ext_sim">Sim</label>
                        <input type="radio" id="proj_ext_nao" name="proj_ext" value="0" ' . ($row['Proj_ext'] == 0 ? 'checked' : '') . '>
                        <label for="proj_ext_nao">Não</label><br><br>
                        <label for="proj_ens"><b>Projeto de Ensino</b></label>
                        <input type="radio" id="proj_ens_sim" name="proj_ens" value="1" ' . ($row['Proj_ens'] == 1 ? 'checked' : '') . '>
                        <label for="proj_ens_sim">Sim</label>
                        <input type="radio" id="proj_ens_nao" name="proj_ens" value="0" ' . ($row['Proj_ens'] == 0 ? 'checked' : '') . '>
                        <label for="proj_ens_nao">Não</label><br><br>
                        <button type="submit" class="sendbtn">Atualizar</button>
                    </form>
                    ';
                } else {
                    echo '<div class="alert alert-danger">Aluno não encontrado.</div>';
                }
                $stmt->close();
            }
        } else {
            echo '<div class="alert alert-danger">CPF não fornecido.</div>';
        }
        ?>
        <div class="container" style="background-color:#f1f1f1">
            <button onclick="window.location.href='pag_aluno.php'" class="cancelbtn">Cancelar</button>
        </div>
    </div>
</body>
</html>
