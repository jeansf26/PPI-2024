<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: f_login.php");
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
    <link href="style.css" rel="stylesheet">

 <title>Cadastro de professores</title>
</head>
<body>
<!-- Barra lateral -->

            <div class="sidebar">
                <ul>
                    <li class="logo">
                        <a href="#">
                            <span class="icone"></span>
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

<h2 style="margin-left: 210px !important;">Cadastro de Alunos:</h2>
<br>


<div class="container" style="margin-left: 210px !important; font-size: 1.3rem; width: 80%; ">
        <form action="cadastro_aluno.php" method="post">
            <div class="mb-3">
                <label class="form-label" for="name">Nome:</label>
                <input class="form-control py-1" type="text" id="name" name="name" placeholder="Digite o nome" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="cpf">CPF:</label>
                <input class="form-control py-1" type="text" id="cpf" name="cpf" placeholder="Digite aqui" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="mat">Número de Matrícula:</label>
                <input class="form-control py-1" type="text" id="mat" name="mat" placeholder="Digite aqui" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="mail">E-mail:</label>
                <input class="form-control py-1" type="text" id="mail" name="mail" placeholder="Digite aqui" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="gen">Gênero:</label>
                <input class="form-control py-1" type="text" id="gen" name="gen" placeholder="Digite aqui" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="dat">Data de Nascimento:</label>
                <input class="form-control py-1" type="date" id="dat" name="dat" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="cty">Cidade:</label>
                <input class="form-control py-1" type="text" id="cty" name="cty" placeholder="Digite aqui" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="uf">UF:</label>
                <input class="form-control py-1" type="text" id="uf" name="uf" placeholder="Digite aqui" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="rep">Reprovações:</label>
                <input class="form-control py-1" type="number" id="rep" name="rep" placeholder="Digite aqui" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="turma">Turma:</label>
                <input class="form-control py-1" type="text" id="turma" name="turma" placeholder="Digite aqui" required>
            </div>

            <!-- Radios para opções Sim/Não -->
            <div class="mb-3">
                <label><b>Acompanhamento:</b></label><br>
                <input type="radio" id="acomp_sim" name="acomp" value="1"> <label for="acomp_sim">Sim</label>
                <input type="radio" id="acomp_nao" name="acomp" value="0" checked> <label for="acomp_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Auxílio Permanência:</b></label><br>
                <input type="radio" id="aux_per_sim" name="aux_per" value="1"> <label for="aux_per_sim">Sim</label>
                <input type="radio" id="aux_per_nao" name="aux_per" value="0" checked> <label for="aux_per_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Apoio Psicológico:</b></label><br>
                <input type="radio" id="psicologico_sim" name="ap_psic" value="1"> <label for="psicologico_sim">Sim</label>
                <input type="radio" id="psicologico_nao" name="ap_psic" value="0" checked> <label for="psicologico_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Cotista:</b></label><br>
                <input type="radio" id="cot_sim" name="cot" value="1"> <label for="cot_sim">Sim</label>
                <input type="radio" id="cot_nao" name="cot" value="0" checked> <label for="cot_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Estágio:</b></label><br>
                <input type="radio" id="estag_sim" name="estag" value="1"> <label for="estag_sim">Sim</label>
                <input type="radio" id="estag_nao" name="estag" value="0" checked> <label for="estag_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Interno:</b></label><br>
                <input type="radio" id="inter_sim" name="inter" value="1"> <label for="inter_sim">Sim</label>
                <input type="radio" id="inter_nao" name="inter" value="0" checked> <label for="inter_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Acompanhamento de Saúde:</b></label><br>
                <input type="radio" id="acomp_saude_sim" name="acomp_saude" value="1"> <label for="acomp_saude_sim">Sim</label>
                <input type="radio" id="acomp_saude_nao" name="acomp_saude" value="0" checked> <label for="acomp_saude_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Projeto de Pesquisa:</b></label><br>
                <input type="radio" id="proj_pesq_sim" name="proj_pesq" value="1"> <label for="proj_pesq_sim">Sim</label>
                <input type="radio" id="proj_pesq_nao" name="proj_pesq" value="0" checked> <label for="proj_pesq_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Projeto de Extensão:</b></label><br>
                <input type="radio" id="proj_ext_sim" name="proj_ext" value="1"> <label for="proj_ext_sim">Sim</label>
                <input type="radio" id="proj_ext_nao" name="proj_ext" value="0" checked> <label for="proj_ext_nao">Não</label>
            </div>
            <div class="mb-3">
                <label><b>Auxílio Moradia:</b></label><br>
                <input type="radio" id="aux_moradia_sim" name="aux_moradia" value="1"> <label for="aux_moradia_sim">Sim</label>
                <input type="radio" id="aux_moradia_nao" name="aux_moradia" value="0" checked> <label for="aux_moradia_nao">Não</label>
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