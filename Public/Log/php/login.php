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

$isLoggedIn = false;

if (isset($_SESSION['id_usuario'])) {
    $isLoggedIn = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT id_cliente FROM cliente WHERE email_cliente = ? AND senha_cliente = ?");
    $stmt->execute([$email, $senha]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $_SESSION['tipo_usuario'] = 'cliente';
        $_SESSION['id_usuario'] = $cliente['id_cliente'];
        header('Location: http://localhost/Public/Private/Php/perfil.php');
        exit();
    }

    $stmt = $pdo->prepare("SELECT id_empresa FROM empresa WHERE email_empresa = ? AND senha_empresa = ?");
    $stmt->execute([$email, $senha]);
    $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($empresa) {
        $_SESSION['tipo_usuario'] = 'empresa';
        $_SESSION['id_usuario'] = $empresa['id_empresa'];
        header('Location: http://localhost/Public/Private/Php/perfil.php');
        exit();
    }

    echo "<script>alert('Email ou senha incorretos!'); window.location.href = 'index-login.html';</script>";
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<script>alert('Todos os campos são obrigatórios!'); window.location.href = 'index-login.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>LociMerx</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/public/Log/Css/login.css">
    <link rel="icon" href="http://localhost/public/Log/Docs/Images/logo.png" style="border-radius: 24px;">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="http://localhost/public/Home/Php/index.php">
                <img src="http://localhost/ADMIN/Docs/Images/logo.png" alt="Logo LociMerx">
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
            <h1>Login</h1>
            <p>Email: </p><br><input type="email" name="email" required>
            <br>
            <p>Senha: </p><br><input type="password" name="senha" required>
            <br>
            <button>Entrar</button>
        </div>
    </form>    

    <script src="../Js/rolagem_segmento.js"></script>
</body>
</html>