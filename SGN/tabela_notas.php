<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../f_login.php");
    exit();
}

include "config.php";

// Processa os dados enviados pelo formulário antes de gerar qualquer HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $cpf = $_POST['save'];

    // validação dos dados
    $ppi = max(0, min(10, floatval($_POST['PPI'][$cpf])));
    $ais = max(0, min(10, floatval($_POST['AIS'][$cpf])));
    $mc = max(0, min(10, floatval($_POST['MC'][$cpf])));
    $nota1 = max(0, min(10, floatval($_POST['Nota1'][$cpf])));
    $nota2 = max(0, min(10, floatval($_POST['Nota2'][$cpf])));
    $aia = max(0, min(10, floatval($_POST['AIA'][$cpf])));
    $faltas = intval($_POST['Faltas'][$cpf]); // Apenas inteiros para faltas
    $observacoes = htmlspecialchars($_POST['Observacoes'][$cpf], ENT_QUOTES, 'UTF-8');

    //Atualiza os dados
    $sql_update = "UPDATE disciplina_aluno 
                   SET PPI = ?, AIS = ?, MC = ?, Nota1 = ?, Nota2 = ?, 
                       AIA = ?, Faltas = ?, Observacoes = ?
                   WHERE CPF = ? AND ID = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ddddddisss", $ppi, $ais, $mc, $nota1, $nota2, $aia, $faltas, $observacoes, $cpf, $_GET['ID']);

    if ($stmt->execute()) {
        // Redireciona para recarregar os dados atualizados
        header("Location: " . $_SERVER['PHP_SELF'] . "?ID=" . $_GET['ID']);
        exit();
    } else {
        echo "<script>alert('Erro ao atualizar os dados: " . $stmt->error . "');</script>";
    }
}

$id = $_GET['ID'];

$sql_d = "SELECT * FROM disciplina WHERE ID=?";
$stmt_d = $conn->prepare($sql_d);
$stmt_d->bind_param("s", $id);
$stmt_d->execute();
$result_d = $stmt_d->get_result();
$row_d = $result_d->fetch_assoc();
$turma = $row_d['idTurma'];

$sql_t = "SELECT * FROM turma WHERE ID=?";
$stmt_t = $conn->prepare($sql_t);
$stmt_t->bind_param("s", $turma);
$stmt_t->execute();
$result_t = $stmt_t->get_result();
$row_t = $result_t->fetch_assoc();

$sql_l = "SELECT * FROM leciona WHERE ID=?";
$stmt_l = $conn->prepare($sql_l);
$stmt_l->bind_param("s", $id);
$stmt_l->execute();
$result_l = $stmt_l->get_result();
$row_l = $result_l->fetch_assoc();

$emaillogado = $_SESSION['email'];

$sqlx = "SELECT * FROM usuario_setor_professor_administrador WHERE email='$emaillogado'";
$resultx = $conn->query($sqlx);
$rowsx = $resultx->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabela de Notas</title>
    <!-- Link do Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table {
            width: 98%;
            margin: auto;
        }
        .form-control {
            text-align: center;        }
    </style>

    <!-- Não sou fã de javascript mas  foi necessário -->

    <script>
        // Função para validar os valores nos campos de texto
        function limitarValor(elemento) {
            let valor = parseFloat(elemento.value); // Converte para número

            // Se o valor não for numérico, limpa o campo
            if (isNaN(valor)) {
                elemento.value = "";
                return;
            }

            // Limita os valores entre 0 e 10
            if (valor < 0) {
                elemento.value = "0";
            } else if (valor > 10) {
                elemento.value = "10";
            }
        }

        // Aplica o evento de validação a todos os inputs após o carregamento da página
        document.addEventListener("DOMContentLoaded", () => {
            const inputs = document.querySelectorAll(".nota-input");
            inputs.forEach((input) => {
                input.addEventListener("input", () => limitarValor(input));
            });
        });
    </script>
</head>
<body>
    <!-- Tabela de inserção de notas -->

    <div class="container mt-3">
        <h3 class="text-center">Tabela de Notas <?php echo $row_d['Nome']; ?> - Turma <?php echo $row_t['Nome']; ?></h3>
        <form action="" method="POST">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">PPI</th>
                        <th scope="col">AIS</th>
                        <th scope="col">Mostra de Ciências</th>
                        <th scope="col">1° Parcial</th>
                        <th scope="col">Nota 1° Semestre</th>
                        <th scope="col">2° Parcial</th>
                        <th scope="col">Nota 2° Semestre</th>
                        <th scope="col">Nota Final</th>
                        <th scope="col">AIA</th>
                        <th scope="col">Faltas</th>
                        <th scope="col">Observações</th>
                        <th scope="col">Salvar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM disciplina_aluno WHERE ID = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $cpf = $row['CPF'];
                        $nome_result = $conn->query("SELECT Nome FROM aluno WHERE CPF = '$cpf'");
                        $nome_row = $nome_result->fetch_assoc();
                        $nome = $nome_row['Nome'];

                        //Variaveis que definem o que o usuario com determinada permissão pode ver

                        $obs_view = 'readonly';
                        $notas_view = 'readonly';
                        $faltas_view = 'readonly';
                        $button_view = 'disabled';

                        if ($rowsx['Tipo_usuario'] == 'setor') {
                            if ($rowsx['G_obs']) {
                                $obs_view = '';
                                $button_view = '';
                            }
                            if ($rowsx['G_notas']) {
                                $notas_view = '';
                                $button_view = '';
                            }
                            if ($rowsx['G_faltas']) {
                                $faltas_view = '';
                                $button_view = '';
                            }
                        }

                        // Calcula a nota final
                        $notafinal = (($row['Nota1'] * 6) + ($row['Nota2'] * 4)) / 10;


                        if ($rowsx['Tipo_usuario'] == 'admin' or $rowsx['ID'] == $row_l['idProfessor']) {
                            echo "<tr>
                            <td>{$nome}</td>
                            <td><input type='text' name='PPI[{$cpf}]' value='{$row['PPI']}' class='form-control nota-input'></td>
                            <td><input type='text' name='AIS[{$cpf}]' value='{$row['AIS']}' class='form-control nota-input'></td>
                            <td><input type='text' name='MC[{$cpf}]' value='{$row['MC']}' class='form-control nota-input'></td>
                            <td><input type='text' name='Parcial1[{$cpf}]' value='{$row['parcial1']}' class='form-control nota-input'></td>
                            <td><input type='text' name='Nota1[{$cpf}]' value='{$row['Nota1']}' class='form-control nota-input'></td>
                            <td><input type='text' name='Parcial2[{$cpf}]' value='{$row['parcial2']}' class='form-control nota-input'></td>
                            <td><input type='text' name='Nota2[{$cpf}]' value='{$row['Nota2']}' class='form-control nota-input'></td>
                            <td><input type='text' name='NotaFinal[{$cpf}]' value='{$notafinal}' class='form-control' disabled></td>
                            <td><input type='text' name='AIA[{$cpf}]' value='{$row['AIA']}' class='form-control nota-input'></td>
                            <td><input type='text' name='Faltas[{$cpf}]' value='{$row['Faltas']}' class='form-control'></td>
                            <td><input type='text' name='Observacoes[{$cpf}]' value='" . htmlspecialchars($row['Observacoes'], ENT_QUOTES, 'UTF-8') . "' class='form-control'></td>
                            <td>
                                <button type='submit' name='save' value='{$cpf}' class='btn btn-success btn-sm'>Salvar</button>
                            </td>
                        </tr>";
                        } else {
                            echo "<tr>
                            <td>{$nome}</td>
                            <td><input type='text' name='PPI[{$cpf}]' value='{$row['PPI']}' class='form-control'". $notas_view ."></td>
                            <td><input type='text' name='AIS[{$cpf}]' value='{$row['AIS']}' class='form-control' ". $notas_view ."></td>
                            <td><input type='text' name='MC[{$cpf}]' value='{$row['MC']}' class='form-control' ". $notas_view ."></td>
                            <td><input type='text' name='Parcial1[{$cpf}]' value='{$row['parcial1']}' class='form-control' ". $notas_view ."></td>
                            <td><input type='text' name='Nota1[{$cpf}]' value='{$row['Nota1']}' class='form-control' ". $notas_view ."></td>
                            <td><input type='text' name='Parcial2[{$cpf}]' value='{$row['parcial2']}' class='form-control' ". $notas_view ."></td>
                            <td><input type='text' name='Nota2[{$cpf}]' value='{$row['Nota2']}' class='form-control' ". $notas_view ."></td>
                            <td><input type='text' name='NotaFinal[{$cpf}]' value='{$notafinal}' class='form-control' disabled></td>
                            <td><input type='text' name='AIA[{$cpf}]' value='{$row['AIA']}' class='form-control' ". $notas_view ."></td>
                            <td><input type='text' name='Faltas[{$cpf}]' value='{$row['Faltas']}' class='form-control' ". $faltas_view ."></td>
                            <td><input type='text' name='Observacoes[{$cpf}]' value='" . htmlspecialchars($row['Observacoes'], ENT_QUOTES, 'UTF-8') . "' class='form-control' ". $obs_view ."></td>
                            <td>
                                <button type='submit' name='save' value='{$cpf}' class='btn btn-success btn-sm' ". $button_view .">Salvar</button>
                            </td>
                        </tr>";
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </form>
        <div class="d-flex justify-content-center mt-3">
            <a href="CTD/pag_disc.php?ID=<?php echo $turma; ?>" class="btn btn-danger">Retornar</a>
        </div>
    </div>
</body>
</html>
