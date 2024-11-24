<?php

print_r($_POST);


$pdo = new PDO('mysql:host=localhost;dbname=bd', 'root', '');


$sql = $pdo->prepare("SELECT * FROM `clientes_cadastro` WHERE email = ? AND senha = ?");


$sql->execute(array($_POST['email'], sha1($_POST['senha'])));


$dados = $sql->fetchAll(PDO::FETCH_ASSOC);


if (!empty($dados)) {
    session_start();
    $_SESSION['email'] = $dados[0]['email'];
    echo "<meta http-equiv='refresh' content='0; url=home.php'>";
} else {
    session_start();
    $_SESSION['erro'] = "<div class='alert alert-danger' role='alert'>Usuário ou senha não encontrados!</div>";
    echo "<meta http-equiv='refresh' content='0; url=login.php'>";
}
?>
