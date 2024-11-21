<!--Checa se o usuário está logado, evitando alterações por invasores-->
<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: ../f_login.php");
        exit(); // Adiciona um exit após o header redirecionar para garantir que o script pare de executar
    }
?>
<?php
include "config.php";

// Processa os dados enviados pelo formulário antes de gerar qualquer HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $cpf = $_POST['save'];
    $ppi = $_POST['PPI'][$cpf];
    $ais = $_POST['AIS'][$cpf];
    $mc = $_POST['MC'][$cpf];
    $nota1 = $_POST['Nota1'][$cpf];
    $nota2 = $_POST['Nota2'][$cpf];
    $aia = $_POST['AIA'][$cpf];
    $faltas = $_POST['Faltas'][$cpf];
    $observacoes = $_POST['Observacoes'][$cpf];

    $sql_update = "UPDATE disciplina_aluno 
                   SET PPI = '$ppi', AIS = '$ais', MC = '$mc', Nota1 = '$nota1', Nota2 = '$nota2', 
                       AIA = '$aia', Faltas = '$faltas', Observacoes = '$observacoes'
                   WHERE CPF = '$cpf' AND ID = {$_GET['ID']}";

    if ($conn->query($sql_update) === TRUE) {
        // Redireciona para recarregar os dados atualizados
        header("Location: " . $_SERVER['PHP_SELF'] . "?ID=" . $_GET['ID']);
        exit(); // Sempre finalize o script após o header
    } else {
        echo "<script>alert('Erro ao atualizar os dados: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabela de Notas Editável</title>
    <!-- Link do Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .table {
        width: 98%;
        margin: auto;
    }
</style>
<body>
    <div class="container mt-3">
        <h3 class="text-center">Tabela de Notas Editável</h3>
        <form action="" method="POST">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">PPI</th>
                        <th scope="col">AIS</th>
                        <th scope="col">Mostra de ciências</th>
                        <th scope="col">Nota 1° Semestre</th>
                        <th scope="col">Nota 2° Semestre</th>
                        <th scope="col">Nota final</th>
                        <th scope="col">AIA</th>
                        <th scope="col">Faltas</th>
                        <th scope="col">Observações</th>
                        <th scope="col">Salvar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $id = $_GET['ID'];
                $sql = "SELECT * FROM disciplina_aluno WHERE ID = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $cpf = $row['CPF'];
                        $nome_result = $conn->query("SELECT Nome FROM aluno WHERE CPF = '$cpf'");
                        $nome_row = $nome_result->fetch_assoc();
                        $nome = $nome_row['Nome'];

                        echo "<tr>
                            <td>{$nome}</td>
                            <td><input type='text' name='PPI[{$cpf}]' value='{$row['PPI']}' class='form-control'></td>
                            <td><input type='text' name='AIS[{$cpf}]' value='{$row['AIS']}' class='form-control'></td>
                            <td><input type='text' name='MC[{$cpf}]' value='{$row['MC']}' class='form-control'></td>
                            <td><input type='text' name='Nota1[{$cpf}]' value='{$row['Nota1']}' class='form-control'></td>
                            <td><input type='text' name='Nota2[{$cpf}]' value='{$row['Nota2']}' class='form-control'></td>
                            <td><input type='text' name='NotaFinal[{$cpf}]' value='0' class='form-control' disabled></td>
                            <td><input type='text' name='AIA[{$cpf}]' value='{$row['AIA']}' class='form-control'></td>
                            <td><input type='text' name='Faltas[{$cpf}]' value='{$row['Faltas']}' class='form-control'></td>
                            <td><input type='text' name='Observacoes[{$cpf}]' value='" . htmlspecialchars($row['Observacoes'], ENT_QUOTES, 'UTF-8') . "' class='form-control'></td>
                            <td>
                                <button type='submit' name='save' value='{$cpf}' class='btn btn-success btn-sm'>Salvar</button>
                            </td>
                        </tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
