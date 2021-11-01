<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/img/icon-error-rounded-stop.ico" type="image">
    <link rel="stylesheet" href="../../assets/my-css/style.css">

    <title>ERRO</title>
</head>

<body class="body-pagina-erro">


    <div class="bg-pagina-erro">

        <div class="div-botao-voltar-pagina-erro">
            <a class="btn-voltar-pagina-erro" href="javascript:history.back()" title="Voltar para página anterior">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <img src="../../assets/img/bg-img-erro1280x1280.jpeg"
             srcset="../../assets/img/bg-img-erro1280x1280.jpeg 1280w, ../../assets/img/bg-img-erro600x600.jpeg 600w, ../../assets/img/bg-img-erro512x512.jpeg 512w"
             size="(max-width: 500px) 600px, 1280px"
             alt="Imagem de fundo da página de erro">
    </div>

</body>

</html>
