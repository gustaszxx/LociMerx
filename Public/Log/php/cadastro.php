<?php
session_start();

$host = 'localhost';
$dbname = 'Teste_sistema';
$username = 'root';
$password = '06082006Gwas!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$isLoggedIn = isset($_SESSION['id_usuario']);

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

function validarCNPJ($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    $tamanho = strlen($cnpj) - 2;
    $numeros = substr($cnpj, 0, $tamanho);
    $digitos = substr($cnpj, $tamanho);

    $soma = 0;
    $pos = $tamanho - 7;
    for ($i = $tamanho; $i >= 1; $i--) {
        $soma += $numeros[$tamanho - $i] * $pos--;
        if ($pos < 2) {
            $pos = 9;
        }
    }

    $resultado = $soma % 11 < 2 ? 0 : 11 - ($soma % 11);
    if ($resultado != $digitos[0]) {
        return false;
    }

    $tamanho++;
    $numeros = substr($cnpj, 0, $tamanho);
    $soma = 0;
    $pos = $tamanho - 7;
    for ($i = $tamanho; $i >= 1; $i--) {
        $soma += $numeros[$tamanho - $i] * $pos--;
        if ($pos < 2) {
            $pos = 9;
        }
    }

    $resultado = $soma % 11 < 2 ? 0 : 11 - ($soma % 11);
    if ($resultado != $digitos[1]) {
        return false;
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['endereco'], $_POST['tipo'], $_POST['telefone'])) {
    $tipo = $_POST['tipo'];

    if ($tipo === 'cliente' && isset($_POST['cpf'])) {
        $cpf = $_POST['cpf'];

        if (!validarCPF($cpf)) {
            echo "<script>alert('CPF inválido!'); window.location.href = 'index-cadastro.php';</script>";
            exit();
        }

        try {
            $sql = $pdo->prepare("INSERT INTO cliente (nm_cliente, email_cliente, senha_cliente, cpf_cliente, endereco_cliente, telefone_cliente, data_cliente) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $sql->execute([$_POST['nome'], $_POST['email'], $_POST['senha'], $cpf, $_POST['endereco'], $_POST['telefone']]);

            $_SESSION['tipo_usuario'] = 'cliente';
            $_SESSION['id_usuario'] = $pdo->lastInsertId();
            
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = 'perfil.php';</script>";
            exit();
        } catch (PDOException $e) {
            echo "<script>alert('Erro ao cadastrar cliente: " . $e->getMessage() . "'); window.location.href = 'index-cadastro.php';</script>";
            exit();
        }
    } elseif ($tipo === 'empresa' && isset($_POST['cnpj'], $_POST['descricao'], $_POST['contatovirtual'], $_POST['segmento'])) {
        $cnpj = $_POST['cnpj'];

        if (!validarCNPJ($cnpj)) {
            echo "<script>alert('CNPJ inválido!'); window.location.href = 'index-cadastro.php';</script>";
            exit();
        }

        try {
            $sql = $pdo->prepare("INSERT INTO empresa (nm_empresa, cnpj_empresa, endereco_empresa, email_empresa, senha_empresa, telefone_empresa, descricao_empresa, contatovirtual_empresa, segmento_empresa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->execute([$_POST['nome'], $cnpj, $_POST['endereco'], $_POST['email'], $_POST['senha'], $_POST['telefone'], $_POST['descricao'], $_POST['contatovirtual'], $_POST['segmento']]);

            $_SESSION['tipo_usuario'] = 'empresa';
            $_SESSION['id_usuario'] = $pdo->lastInsertId();
            
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = 'perfil.php';</script>";
            exit();
        } catch (PDOException $e) {
            echo "<script>alert('Erro ao cadastrar empresa: " . $e->getMessage() . "'); window.location.href = 'index-cadastro.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Campos obrigatórios ausentes!'); window.location.href = 'index-cadastro.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>LociMerx</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Public/Log/Css/cadastro.css">
    <link rel="icon" href="http://localhost/Public/Log/Docs/Images/logo.png" style="border-radius: 24px;">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="http://localhost/public/Home/Php/index.php">
                <img src="http://localhost/Public/Log/Docs/Images/logo.png" alt="Logo LociMerx">
                <h1>LociMerx</h1>
            </a>
        </div>
        <div class="search-container">
            <form action="" class="search-form">
                <input type="text" id="search" name="search" class="search-input" placeholder="Pesquisar">
                <button type="submit" class="search-button"><i class="fi fi-rr-search"></i></button>
            </form>
        </div>        
        <nav class="profile">
            <?php if ($isLoggedIn): ?>
                <a href="http://localhost/Public/Private/Php/perfil.php">
                    <p>
                        <?php
                            if (isset($cliente['nm_cliente'])) {
                                echo htmlspecialchars($cliente['nm_cliente']);
                            } elseif (isset($empresa['nm_empresa'])) {
                                echo htmlspecialchars($empresa['nm_empresa']);
                            } else {
                                echo "Usuário";
                            }
                        ?>
                    </p>
                    <i class="fi fi-rr-user"></i>
                </a>
            <?php else: ?>
                <a href="http://localhost/Public/Log/php/login.php" class="login">Login</a>
                <span>|</span>
                <a href="http://localhost/Public/Log/php/cadastro.php" class="register">Cadastrar</a>
                <i class="fi fi-rr-user"></i>
            <?php endif; ?>
        </nav>
        <div class="car">
            <a href="">
                <i class="fi fi-rr-shopping-cart"></i>
            </a>
        </div>
    </header>

    <section>
        <div class="carousel">
            <nav class="horizontal-nav">
                <ul>
                    <li><a href="">Alimentos e Bebidas</a></li>
                    <li><a href="">Artigos de Cozinha</a></li>
                    <li><a href="">Artigos de Esporte</a></li>
                    <li><a href="">Artigos para Animais de Estimação</a></li>
                    <li><a href="">Automotivos</a></li>
                    <li><a href="">Beleza e Cuidados Pessoais</a></li>
                    <li><a href="">Bebês e Crianças</a></li>
                    <li><a href="">Brinquedos</a></li>
                    <li><a href="">Colecionáveis e Hobbies</a></li>
                    <li><a href="">Decoração</a></li>
                    <li><a href="">Eletrodomésticos</a></li>
                    <li><a href="">Eletrônicos</a></li>
                    <li><a href="">Ferramentas</a></li>
                    <li><a href="">Informática e Acessórios</a></li>
                    <li><a href="">Instrumentos Musicais</a></li>
                    <li><a href="">Jardim e Exterior</a></li>
                    <li><a href="">Joias e Relógios</a></li>
                    <li><a href="">Livros e Mídias</a></li>
                    <li><a href="">Moda Fitness</a></li>
                    <li><a href="">Papelaria e Escritório</a></li>
                    <li><a href="">Produtos de Limpeza</a></li>
                    <li><a href="">Produtos para Casa</a></li>
                    <li><a href="">Roupas e Acessórios</a></li>
                    <li><a href="">Saúde e Bem-Estar</a></li>
                    <li><a href="">Viagem e Lazer</a></li>
                </ul>
            </nav>
        </div>
    </section>

    <form action="" method="POST">
        <div class="input">
            <h1>Cadastro</h1>

            <label for="tipo">Sou:</label><br>
            <select id="tipo" name="tipo" required onchange="toggleFields()">
                <option value="cliente">Pessoa Física</option>
                <option value="empresa">Pessoa Jurídica</option>
            </select>

            <br><br>

            <p>Nome: </p><br><input type="text" name="nome" required>
            <br>
            <p>Email: </p><br><input type="email" name="email" required>
            <br>
            <p>Senha: </p><br><input type="password" name="senha" required>
            <br>
            <p>Endereço: </p><br><input type="text" name="endereco" required>
            <br>
            <p>Telefone: </p><br><input type="tel" name="telefone" id="telefone">
            <br>

            <div id="clienteFields">
                <p>CPF: </p><br><input type="text" name="cpf" id="cpf">
                <br>
                <p>Data de Nascimento: </p><br><input type="date" name="data" id="">
                <br>
            </div>

            <div id="empresaFields" style="display:none;">
                <p>CNPJ: </p><br><input type="text" name="cnpj" id="cnpj">
                <br>
                <p>Descrição: </p><br><input type="text" name="descricao" id="descricao">
                <br>
                <p>Contato Virtual: </p><br><input type="link" name="contatovirtual" id="contatovirtual">
                <br>
                <label for="tipo">Tipo de Segmento:</label><br>
                <select id="segmento" name="segmento">
                    <option value="Alimentos e Bebidas">Alimentos e Bebidas</option>
                    <option value="Artigos de Cozinha">Artigos de Cozinha</option>
                    <option value="Artigos de Esporte">Artigos de Esporte</option>
                    <option value="Artigos para Animais de Estimação">Artigos para Animais de Estimação</option>
                    <option value="Automotivos">Automotivos</option>
                    <option value="Beleza e Cuidados Pessoais">Beleza e Cuidados Pessoais</option>
                    <option value="Bebês e Crianças">Bebês e Crianças</option>
                    <option value="Brinquedos">Brinquedos</option>
                    <option value="Colecionáveis e Hobbies">Colecionáveis e Hobbies</option>
                    <option value="Decoração">Decoração</option>
                    <option value="Eletrodomésticos">Eletrodomésticos</option>
                    <option value="Eletrônicos">Eletrônicos</option>
                    <option value="Ferramentas">Ferramentas</option>
                    <option value="Informática e Acessórios">Informática e Acessórios</option>
                    <option value="Instrumentos Musicais">Instrumentos Musicais</option>
                    <option value="Jardim e Exterior">Jardim e Exterior</option>
                    <option value="Joias e Relógios">Joias e Relógios</option>
                    <option value="Livros e Mídias">Livros e Mídias</option>
                    <option value="Moda Fitness">Moda Fitness</option>
                    <option value="Papelaria e Escritório">Papelaria e Escritório</option>
                    <option value="Produtos de Limpeza">Produtos de Limpeza</option>
                    <option value="Produtos para Casa">Produtos para Casa</option>
                    <option value="Roupas e Acessórios">Roupas e Acessórios</option>
                    <option value="Saúde e Bem-Estar">Saúde e Bem-Estar</option>
                    <option value="Viagem e Lazer">Viagem e Lazer</option>
                </select>
            </div>

            <br>
            <button type="submit">Cadastrar</button>
        </div>
    </form>

    <footer>
        <div class="fundo">
            <p>ㅤ</p>
        </div>
    </footer>

    <script src="http://localhost/Public/Log/Js/rolagem_segmento.js"></script>
    <script src="http://localhost/Public/Log/Js/form.js"></script>
    <script src="http://localhost/Public/Log/Js/mascaras.js"></script>
</body>
</html>