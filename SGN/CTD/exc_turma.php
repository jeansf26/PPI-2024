<?php
// Checa se o usuário está logado, evitando alterações por invasores
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../f_login.php");
    exit(); // Garante que o script pare de executar
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Turma</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <?php
        include '../config.php';

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['ID'])) {
            $ID = intval($_GET['ID']); 

            // Pega o ID do curso para redirecionamento
            $ID_return = "SELECT idCurso FROM turma WHERE ID = ?";
            $stmtID_return = $conn->prepare($ID_return);
            $stmtID_return->bind_param("i", $ID);
            $stmtID_return->execute();
            $result = $stmtID_return->get_result();
            $ID_returnrow = $result->fetch_assoc();

            // Verifica se o formulário foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $conn->begin_transaction();

                try {
                    // Pega todos os IDs das disciplinas associadas à turma
                    $sql_get_id_d = "SELECT ID FROM disciplina WHERE idTurma = ?";
                    $stmt_get_id_d = $conn->prepare($sql_get_id_d);
                    $stmt_get_id_d->bind_param("i", $ID); 
                    $stmt_get_id_d->execute();
                    $result_d = $stmt_get_id_d->get_result();

                    // Exclui as relações de todas as disciplinas encontradas
                    $sql_del_da = "DELETE FROM disciplina_aluno WHERE ID = ?";
                    $stmt_da = $conn->prepare($sql_del_da);

                    while ($row_d = $result_d->fetch_assoc()) {
                        $ID_da = $row_d['ID'];
                        $stmt_da->bind_param("i", $ID_da);
                        $stmt_da->execute();
                    }

                    // Exclui todas as disciplinas associadas à turma
                    $sql_del_d = "DELETE FROM disciplina WHERE idTurma = ?";
                    $stmt_d = $conn->prepare($sql_del_d);
                    $stmt_d->bind_param("i", $ID); 
                    $stmt_d->execute();

                    // Exclui a turma
                    $sql_del_t = "DELETE FROM turma WHERE ID = ?";
                    $stmt_t = $conn->prepare($sql_del_t);
                    $stmt_t->bind_param("i", $ID);
                    $stmt_t->execute();

                    // Exclui relações de alunos com a turma
                    $sql_del_ta = "DELETE FROM turma_aluno WHERE ID = ?";
                    $stmt_ta = $conn->prepare($sql_del_ta);
                    $stmt_ta->bind_param("i", $ID);
                    $stmt_ta->execute();

                    // Confirma a transação
                    $conn->commit();

                    // Redireciona para a página anterior após a exclusão
                    echo "<script>
                            alert('Registro excluído com sucesso!');
                            window.location.href = 'pag_turma.php?ID=" . $ID_returnrow['idCurso'] . "';
                          </script>";
                    exit();
                } catch (Exception $e) {
                    // Desfaz a transação em caso de erro
                    $conn->rollback();
                    echo 'Erro ao excluir o registro: ' . $e->getMessage();
                }
            } else {
                // Exibe o modal de confirmação
                echo '
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Confirmar Exclusão</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja excluir este registro?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href=\'pag_turma.php?ID='. $ID_returnrow['idCurso'] . '\'">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Sim, Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $("#confirmModal").modal("show");
                    });
                </script>
                ';
            }
        } else {
            echo 'ID do registro não fornecido.';
        }

        ?>
    </div>
</body>
</html>
