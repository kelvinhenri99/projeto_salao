<?php
session_start();
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <title>Sistema de Login - SEMPRE BELA</title>
    <link rel="stylesheet" type="text/css" href="CSS/login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></link>
</head>

<body>
<div class="principal">
    <section>
	<div class="quadrado1" align="center">
                    <div class="estilo1">Sistema de Login</div>
                    <div class="estilo2">SEMPRE BELA</div>
                   <?php
                    if(isset($_SESSION['nao_autenticado'])):
                    ?>
                    <div class="erro" align="center">
                     ERRO: Usuário/senha inválidos.
                    </div>
					
<?php
	endif;
	unset($_SESSION['nao_autenticado']);
?>
	
                    <div class="quadrado2">
                        <form action="login.php" method="POST">
                                <input name="login" name="text" class="usuario" placeholder="usuário" autofocus="">
                                <input name="senha" class="senha" type="password" placeholder="senha">								
			<button type="submit" class="entrar">ENTRAR</button>
                        </form>
                    </div>
	</div>
    </section>
</div>
</body>

</html>