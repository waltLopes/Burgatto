<?php include('head.php'); ?>
<body>
    <?php include('menu.php'); ?>
    <div class="fundoCadastro">
        <form action="cadastro.act.php" method="post" enctype="multipart/form-data" id="formCadastro">
            <h1>Cadastrar</h1>
            
            <p>
                <label for="nome">Nome:</label> 
                <input type="text" name="nome" placeholder="Digite seu nome" required>
            </p>
            <p>
                <label for="email">E-mail:</label>
                <input type="text" name="email" placeholder="Digite seu e-mail" required>
            </p>      

            <div class="grupoCampos">
                <p>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" placeholder="Digite seu CPF" required>
                </p>
                <p>
                    <label for="data_nascimento">Data de nascimento:</label>
                    <input type="date" name="data_nasc" required>
                </p>
            </div>

            <div class="grupoCampos">
                <p>
                    <label for="telefone">Telefone:</label> 
                    <input type="text" name="telefone" id="telefone" placeholder="Digite seu telefone" required>
                </p>
                <p>
                    <label for="cep">CEP:</label>
                    <input type="text" name="cep" id="cep" placeholder="Digite seu CEP" required maxlength="9" onblur="buscarEndereco()">
                </p>
            </div>

            <div class="grupoCampos2">
                <p>
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" id="endereco" placeholder="Digite seu endereço" required readonly>
                </p>
                <p>
                    <label for="numero">Número:</label>
                    <input type="text" name="num_endereco" id="num_endereco" placeholder="Nº" required>
                </p>
            </div>
           
            <p>
                <label for="senha">Senha:</label> 
                <input type="password" name="senha" placeholder="Digite sua senha" required>
            </p>
            <p>
                <label for="confirmarSenha">Confirmar senha:</label> 
                <input type="password" name="confirmarSenha" placeholder="Confirme sua senha" required>
            </p>
        

            <p><input type="submit" value="Salvar"></p>
        </form>

        <div class="msgErroCadastro">
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
