<?php

include 'conexao.php';


$sql = $pdo->prepare("SELECT * FROM `clientes_cadastro`");
$sql->execute();
$resultados = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Lista de Registros</h2>
<table border="1" class="tm-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Mensagem</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultados as $linha): ?>
        <tr>
            <td><?php echo $linha['id']; ?></td>
            <td><?php echo $linha['nome']; ?></td>
            <td><?php echo $linha['email']; ?></td>
            <td><?php echo $linha['mensagem']; ?></td>
            <td>
                
                <a href="editar.php?id=<?php echo $linha['id']; ?>" class="tm-btn">Editar</a>
                
                <a href="excluir.php?id=<?php echo $linha['id']; ?>" class="tm-btn" onclick="return confirm('Tem certeza que deseja excluir este registro?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
