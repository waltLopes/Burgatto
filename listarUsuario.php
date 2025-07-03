<?php require('sec.php'); ?>
<?php include('head.php'); ?>
<body>

<?php 
include('menu.php'); 
require('connect.php');

// Captura os valores do formulário de pesquisa
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';
$valor = isset($_POST['valor']) ? $_POST['valor'] : '';

// Monta a query inicial, filtrando apenas usuários ativos
$query = "SELECT * FROM `tb_usuarios` WHERE `condicaoUsuario` = 'a'";

// Se houver um filtro e um valor, adiciona a condição à consulta
if (!empty($filtro) && !empty($valor)) {
    $query .= " AND `$filtro` LIKE '%$valor%'";
}

// Executa a consulta no banco de dados
$usuarios = mysqli_query($con, $query);
?>

<!-- Formulário de Pesquisa -->

<div class="fundoListar">

<form class="pesquisarUsuario" method="post">
    <h2>Pesquisar Usuário</h2>
    <div>
        <input type="radio" name="filtro" value="cod_usuario" id="radioID" onclick="ativarCampo('idPesquisa')">
        <label for="radioID">ID</label>
        <input type="text" name="valor" id="idPesquisa" disabled>
    </div>
    
    <div>
        <input type="radio" name="filtro" value="nome_usuario" id="radioNome" onclick="ativarCampo('nomePesquisa')">
        <label for="radioNome">Nome</label>
        <input type="text" name="valor" id="nomePesquisa" disabled>
    </div>

    <div>
        <input type="radio" name="filtro" value="cpf_usuario" id="radioCPF" onclick="ativarCampo('cpfPesquisa')">
        <label for="radioCPF">CPF</label>
        <input type="text" name="valor" id="cpfPesquisa" disabled>
    </div>

    <div>
        <input type="radio" name="filtro" value="telefone_usuario" id="radioTelefone" onclick="ativarCampo('telefonePesquisa')">
        <label for="radioTelefone">Telefone</label>
        <input type="text" name="valor" id="telefonePesquisa" disabled>
    </div>

    <button type="submit">Pesquisar</button>
</form>

<!-- Exibição dos usuários -->
<div class="cards">
    <?php while ($usuario = mysqli_fetch_assoc($usuarios)) : ?>
        <div class='card'>
            <p>ID: <?php echo $usuario['cod_usuario']; ?></p>
            <p>Nome: <?php echo $usuario['nome_usuario']; ?></p>
            <p>Email: <?php echo $usuario['email_usuario']; ?></p>
            <p>CPF: <?php echo $usuario['cpf_usuario']; ?></p>
            <p>Telefone: <?php echo $usuario['telefone_usuario']; ?></p>
            <p>Endereço: <?php echo "{$usuario['endereco_usuario']}, {$usuario['numero_endereco_usuario']}"; ?></p>
            <p>CEP: <?php echo $usuario['cep_usuario']; ?></p>
            <p>Data de Nascimento:</> <?php echo date('d/m/Y', strtotime($usuario['data_nasc_usuario'])); ?></p>
            <p><a href="editarUsuario.php?cod=<?php echo $usuario['cod_usuario']; ?>">Alterar</a></p>
            <p><a href="javascript:excluir(<?php echo $usuario['cod_usuario']; ?>)">Excluir</a></p>
        </div>
    <?php endwhile; ?>
</div>

<!-- Mensagem de erro ou sucesso -->
<div class="msg-erro">
    <?php
        @session_start();
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    ?>
</div>

</div>

<?php include('rodape.php'); ?>

</body>
</html>
