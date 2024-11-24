<?php

// Exibe os dados recebidos via POST (opcional para depuração)
print_r($_POST);
echo "<br>" . $_POST['nome']; 

try {
    // Conecta ao banco de dados
    $pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', ''); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Prepara o comando SQL para inserir os dados
$sql = $pdo->prepare("INSERT INTO `clientes_cadastro` (nome, email, mensagem) VALUES (?, ?, ?)");

try {
    // Executa o comando SQL
    $sql->execute(array(
        $_POST['nome'],
        $_POST['email'],
        $_POST['mensagem']
    ));

    // Exibe uma mensagem de sucesso
    echo "<script>alert('Cadastro concluído com sucesso!');</script>";

    // Redireciona imediatamente para a página inicial
    header('Location: index.html');
    exit;

} catch (PDOException $e) {
    // Exibe uma mensagem de erro, caso ocorra
    echo "Erro ao inserir os dados: " . $e->getMessage();
    echo "<pre>";
    print_r($e);
    echo "</pre>";
}
?>
