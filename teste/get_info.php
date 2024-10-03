<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";  
$password = "";    
$dbname = "feira";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura o local passado pela requisição
$local = isset($_GET['local']) ? $_GET['local'] : null;

if ($local) {
    // Prepara a consulta
    $sql = "SELECT * FROM projetos WHERE local = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $local); // 's' para string

    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch os resultados
    $data = [];
    if ($result->num_rows > 0) {
        while ($linha = $result->fetch_assoc()) {
            $data[] = $linha; // Adiciona cada linha ao array
        }
        echo json_encode($data); // Retorna todos os dados em formato JSON
    } else {
        echo json_encode(['error' => 'Nenhum projeto encontrado.']);
    }

    // Fecha a conexão
    $stmt->close();
} else {
    echo json_encode(['error' => 'Local não fornecido.']);
}

$conn->close();
?>
