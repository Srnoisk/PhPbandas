<?php
// Exibe o conteúdo do array $_POST para verificar o que foi enviado pelo formulário
print_r($_POST);
echo "<br>" . $_POST['Nome']; 

try {
    // Estabelece a conexão com o banco de dados MySQL
    $pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', '');

    // Prepara a query SQL. O nome da tabela não deve estar entre aspas simples.
    $sql = $pdo->prepare("INSERT INTO `clientes_cadastro` 
        VALUES (null,?,?,?)");

    // Executa a query passando os dados do formulário via $_POST
    $sql->execute(array(
        $_POST['Nome'],
        $_POST['Email'],
        $_POST['Mensagem'],
    ));

    echo "Dados inseridos com sucesso!";
} catch (PDOException $e) {
    // Captura e exibe qualquer erro do PDO
    echo "Erro: " . $e->getMessage();
}
?>
