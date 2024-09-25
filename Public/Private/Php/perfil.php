<?php
session_start();

if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo_usuario'])) {
    echo "<script>alert('Você precisa estar logado!'); window.location.href = 'http://localhost/Public/Log/php/login.php';</script>";
    exit();
}

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

$tipo_usuario = $_SESSION['tipo_usuario'];
$id_usuario = $_SESSION['id_usuario'];

if ($tipo_usuario === 'cliente') {
    $sql = $pdo->prepare("SELECT nm_cliente, email_cliente, cpf_cliente, endereco_cliente, telefone_cliente, data_cliente FROM cliente WHERE id_cliente = ?");
    $sql->execute([$id_usuario]);
    $cliente = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        echo "<script>alert('Cliente não encontrado!'); window.location.href = 'http://localhost/Public/Log/php/login.php';</script>";
        exit();
    }

} elseif ($tipo_usuario === 'empresa') {
    $sql = $pdo->prepare("SELECT nm_empresa, email_empresa, cnpj_empresa, endereco_empresa, telefone_empresa, descricao_empresa, contatovirtual_empresa, segmento_empresa FROM empresa WHERE id_empresa = ?");
    $sql->execute([$id_usuario]);
    $empresa = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$empresa) {
        echo "<script>alert('Empresa não encontrada!'); window.location.href = 'http://localhost/Public/Log/php/login.php';</script>";
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
    <link rel="stylesheet" type="text/css" href="http://localhost/Public/Private/Css/index.css" media="screen" />
    <link rel="icon" href="http://localhost/Public/Private/Docs/Images/logo.png" style="border-radius: 24px;">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="http://localhost/public/Home/Php/index.php">
                <img src="http://localhost/Public/Private/Docs/Images/logo.png" alt="Logo LociMerx">
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
            <?php if (isset($_SESSION['id_usuario'])): ?>
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


    <div class="profile-container">

    <h1>Perfil de <?php echo ($tipo_usuario === 'cliente') ? 'Cliente' : 'Empresa'; ?></h1>

        <?php if ($tipo_usuario === 'cliente') : ?>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($cliente['nm_cliente']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($cliente['email_cliente']); ?></p>
            <p><strong>CPF:</strong> <?php echo htmlspecialchars($cliente['cpf_cliente']); ?></p>
            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($cliente['endereco_cliente']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($cliente['telefone_cliente']); ?></p>
            <p><strong>Data de Cadastro:</strong> <?php echo htmlspecialchars($cliente['data_cliente']); ?></p>
        <?php elseif ($tipo_usuario === 'empresa') : ?>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($empresa['nm_empresa']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($empresa['email_empresa']); ?></p>
            <p><strong>CNPJ:</strong> <?php echo htmlspecialchars($empresa['cnpj_empresa']); ?></p>
            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($empresa['endereco_empresa']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($empresa['telefone_empresa']); ?></p>
            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($empresa['descricao_empresa']); ?></p>
            <p><strong>Contato Virtual:</strong> <?php echo htmlspecialchars($empresa['contatovirtual_empresa']); ?></p>
            <p><strong>Segmento:</strong> <?php echo htmlspecialchars($empresa['segmento_empresa']); ?></p>
        <?php endif; ?>

        <a href="edit_profile.php" class="btn">Editar Perfil</a>
    </div>

</body>
</html>