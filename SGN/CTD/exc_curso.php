<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../f_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Curso</title>
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $conn->begin_transaction();

                try {
                    // Iniciar transação
                    $conn->begin_transaction();

                    // Seleciona disciplinas associadas ao curso
                    $sql_get_disciplinas = "SELECT ID FROM disciplina WHERE idTurma IN (SELECT ID FROM turma WHERE idCurso = ?)";
                    $stmt_get_disciplinas = $conn->prepare($sql_get_disciplinas);
                    $stmt_get_disciplinas->bind_param("i", $ID);
                    $stmt_get_disciplinas->execute();
                    $result_disciplinas = $stmt_get_disciplinas->get_result();

                    // Preparar comandos de exclusão
                    $sql_del_leciona = "DELETE FROM leciona WHERE ID = ?";
                    $stmt_del_leciona = $conn->prepare($sql_del_leciona);

                    $sql_del_disciplina_aluno = "DELETE FROM disciplina_aluno WHERE ID = ?";
                    $stmt_del_disciplina_aluno = $conn->prepare($sql_del_disciplina_aluno);

                    while ($disciplina = $result_disciplinas->fetch_assoc()) {
                        // Excluir relações disciplina_aluno
                        $stmt_del_disciplina_aluno->bind_param("i", $disciplina['ID']);
                        $stmt_del_disciplina_aluno->execute();

                        // Excluir relações leciona
                        $stmt_del_leciona->bind_param("i", $disciplina['ID']);
                        $stmt_del_leciona->execute();
                    }

                    // Excluir disciplinas associadas às turmas do curso
                    $sql_del_disciplinas = "DELETE FROM disciplina WHERE idTurma IN (SELECT ID FROM turma WHERE idCurso = ?)";
                    $stmt_del_disciplinas = $conn->prepare($sql_del_disciplinas);
                    $stmt_del_disciplinas->bind_param("i", $ID);
                    $stmt_del_disciplinas->execute();

                    // Excluir relações turma_aluno
                    $sql_del_turma_aluno = "DELETE FROM turma_aluno WHERE ID IN (SELECT ID FROM turma WHERE idCurso = ?)";
                    $stmt_del_turma_aluno = $conn->prepare($sql_del_turma_aluno);
                    $stmt_del_turma_aluno->bind_param("i", $ID);
                    $stmt_del_turma_aluno->execute();

                    // Excluir turmas associadas ao curso
                    $sql_del_turmas = "DELETE FROM turma WHERE idCurso = ?";
                    $stmt_del_turmas = $conn->prepare($sql_del_turmas);
                    $stmt_del_turmas->bind_param("i", $ID);
                    $stmt_del_turmas->execute();

                    // Excluir o curso
                    $sql_del_curso = "DELETE FROM curso WHERE ID = ?";
                    $stmt_del_curso = $conn->prepare($sql_del_curso);
                    $stmt_del_curso->bind_param("i", $ID);
                    $stmt_del_curso->execute();

                    // Confirmar a transação
                    $conn->commit();

                    echo "<script>
                            alert('Registro excluído com sucesso!');
                            window.location.href = 'pag_curso.php';
                          </script>";
                    exit();
                } catch (Exception $e) {
                    $conn->rollback();
                    echo 'Erro ao excluir o registro: ' . $e->getMessage();
                }
            } else {
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
                                <p>Tem certeza que deseja excluir este curso e todos os registros associados?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href=\'pag_curso.php\'">Cancelar</button>
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
