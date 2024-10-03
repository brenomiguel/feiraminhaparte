<?php
$servername = "localhost";
$username = "root";  
$password = "";    
$dbname = "projetos";

// Verifica se o parâmetro 'curso' está presente
if (isset($_GET['curso'])) {
    $curso = $_GET['curso'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        error_log('Conexão falhou: ' . $conn->connect_error);
        die(json_encode(['error' => 'Conexão falhou: ' . $conn->connect_error]));
    }

    // Prepara a consulta SQL
    $stmt = $conn->prepare("SELECT id_stand, nome, ods, descricao, integrantes, turma, local, logo FROM projetos WHERE curso = ?");
    $stmt->bind_param('s', $curso);
    
    if (!$stmt->execute()) {
        error_log('Erro na execução da consulta: ' . $stmt->error);
        die(json_encode(['error' => 'Erro na execução da consulta: ' . $stmt->error]));
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $projetos = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($projetos);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Curso não especificado']);
}
?>
