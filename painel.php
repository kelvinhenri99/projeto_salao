<?php
include('verifica_login.php');
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome_cli = (isset($_POST["nome_cli"]) && $_POST["nome_cli"] != null) ? $_POST["nome_cli"] : "";
    $telefone = (isset($_POST["telefone"]) && $_POST["telefone"] != null) ? $_POST["telefone"] : "";
    $data = (isset($_POST["data"]) && $_POST["data"] != null) ? $_POST["data"] : "";
    $horario = (isset($_POST["horario"]) && $_POST["horario"] != null) ? $_POST["horario"] : "";
    $id_proc = (isset($_POST["id_proc"]) && $_POST["id_proc"] != null) ? $_POST["id_proc"] : "";
    $id_status = (isset($_POST["id_status"]) && $_POST["id_status"] != null) ? $_POST["id_status"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome_cli = NULL;
    $telefone = NULL;
    $data = NULL;
    $horario = NULL;
    $id_proc = NULL;
    $id_status = NULL;
}
 
// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost;dbname=285867", "285867", "-ieRRRW34_4S!NT");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão:".$erro->getMessage();
}
 
// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome_cli != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE clientes SET nome_cli=?, telefone=?, data=? horario=? , id_proc=? , id_status=? WHERE id = ?");
            $stmt->bindParam(7, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO clientes (nome_cli, telefone, data, horario, id_proc, id_status) VALUES (?, ?, ?, ?, ?, ?)");
        }
        $stmt->bindParam(1, $nome_cli);
        $stmt->bindParam(2, $telefone);
        $stmt->bindParam(3, $data);
        $stmt->bindParam(4, $horario);
        $stmt->bindParam(5, $id_proc);
		$stmt->bindParam(6, $id_status);
 
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
                $id = null;
                $nome_cli = null;
                $telefone = null;
                $data = null;
                $horario = null;
                $id_proc = null;
				$id_status = null;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

?>

<html>

<head>
	<meta charset="utf-8">
	<title>SEMPRE BELA</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></link>
</head>

<body class="kelvin99">
 
	<div class="pagina_geral1">
		<div class="logo"></div>
		<div class="parede"></div>
		<div class="apresentacao"><b>Seja Bem - Vindo(a) | <?php echo $_SESSION['login'];?></b><div class="botao_sair" align='center'><a href="logout.php">Sair</a></div>
			<div class="kelvin"></div>
		</div>
		
	</div>
	
	<div class="pagina_geral2">
		<div class="estilo3" align="center">CLIENTES AGENDADOS</div>
	
<?php
$servername = "localhost";
$username = "285867";
$password = "-ieRRRW34_4S!NT";
$dbname = "285867";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT clientes.id, clientes.NOME_CLI, clientes.TELEFONE, DATE_FORMAT(clientes.DATA, '%d/%m/%Y'), clientes.HORARIO, procedimentos.NOME_PROC, funcionarios.NOME_FUNC, STATUS1.NOME_STATUS FROM clientes INNER JOIN procedimentos ON clientes.ID_PROC = procedimentos.ID INNER JOIN funcionarios ON funcionarios.ID_PROC = procedimentos.ID INNER JOIN STATUS1 ON clientes.ID_STATUS = STATUS1.ID WHERE STATUS1.ID = '1';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo
	"<div class='ag_cliente'>".
	"<div class='foto_cli'>"."</div>";

    echo
	"<div class='quadrado_cli'>".
	"<div class='estilo5' align='center'>"."Nome: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_CLI"]."</div>".
	"<div class='estilo11' align='center'>"."Telefone: "."</div>".
	"<div class='estilo12' align='center'>".$row["TELEFONE"]."</div>".
	"<div class='estilo6' align='center'>"."Data Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["DATE_FORMAT(clientes.DATA, '%d/%m/%Y')"]."</div>".
	"<div class='estilo7' align='center'>"."Horário Previsto: "."</div>".
	"<div class='estilo12' align='center'>".$row["HORARIO"]."</div>".
	"<div class='estilo8' align='center'>"."Procedimento: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_PROC"]."</div>".
	"<div class='estilo9' align='center'>"."Profissional: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_FUNC"]."</div>".
	"<div class='estilo10' align='center'>"."Status da Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_STATUS"]."</div>".
	"<a href='#abrirModal'>"."<input type='button' value='EDITAR' class='botao1'>"."</a>".
	"</div>".
	"</div>";
  }
} else {
  echo "<div class='nao_ha' align='center'>"."<div class='nao_ha_dentro'>"."OPS!, NENHUM REGISTRO ENCONTRADO"."</div>"."</div>";
}

mysqli_close($conn);

?>	
	</div>
	
	
	<div class="pagina_geral3">
	
	<hr size="10" style="border:0px solid black;">
	
		<div class="estilo3" align="center">CLIENTES CANCELADOS</div>
<?php
$servername = "localhost";
$username = "285867";
$password = "-ieRRRW34_4S!NT";
$dbname = "285867";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT clientes.id, clientes.NOME_CLI, clientes.TELEFONE, DATE_FORMAT(clientes.DATA, '%d/%m/%Y'), clientes.HORARIO, procedimentos.NOME_PROC, funcionarios.NOME_FUNC, STATUS1.NOME_STATUS FROM clientes INNER JOIN procedimentos ON clientes.ID_PROC = procedimentos.ID INNER JOIN funcionarios ON funcionarios.ID_PROC = procedimentos.ID INNER JOIN STATUS1 ON clientes.ID_STATUS = STATUS1.ID WHERE STATUS1.ID = '2';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo
	"<div class='ag_cliente'>".
	"<div class='foto_cli'>"."</div>";

    echo
	"<div class='quadrado_cli'>".
	"<div class='estilo5' align='center'>"."Nome: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_CLI"]."</div>".
	"<div class='estilo11' align='center'>"."Telefone: "."</div>".
	"<div class='estilo12' align='center'>".$row["TELEFONE"]."</div>".
	"<div class='estilo6' align='center'>"."Data Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["DATE_FORMAT(clientes.DATA, '%d/%m/%Y')"]."</div>".
	"<div class='estilo7' align='center'>"."Horário Previsto: "."</div>".
	"<div class='estilo12' align='center'>".$row["HORARIO"]."</div>".
	"<div class='estilo8' align='center'>"."Procedimento: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_PROC"]."</div>".
	"<div class='estilo9' align='center'>"."Profissional: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_FUNC"]."</div>".
	"<div class='estilo10' align='center'>"."Status da Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_STATUS"]."</div>".
	"<a href='#abrirModal'>"."<input type='button' value='EDITAR' class='botao1'>"."</a>".
	"</div>".
	"</div>";
	
  }
} else {
  echo "<div class='nao_ha' align='center'>"."<div class='nao_ha_dentro'>"."OPS!, NENHUM REGISTRO ENCONTRADO"."</div>"."</div>";
}

mysqli_close($conn);

?>
	</div>
	
	<div class="pagina_geral4">
	
		<hr size="10" style="border:0px solid black;">
	
		<div class="estilo3" align="center">CLIENTES AGUARDANDO</div>
<?php
$servername = "localhost";
$username = "285867";
$password = "-ieRRRW34_4S!NT";
$dbname = "285867";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT clientes.id, clientes.NOME_CLI, clientes.TELEFONE, DATE_FORMAT(clientes.DATA, '%d/%m/%Y'), clientes.HORARIO, procedimentos.NOME_PROC, funcionarios.NOME_FUNC, STATUS1.NOME_STATUS FROM clientes INNER JOIN procedimentos ON clientes.ID_PROC = procedimentos.ID INNER JOIN funcionarios ON funcionarios.ID_PROC = procedimentos.ID INNER JOIN STATUS1 ON clientes.ID_STATUS = STATUS1.ID WHERE STATUS1.ID = '3';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo
	"<div class='ag_cliente'>".
	"<div class='foto_cli'>"."</div>";

    echo
	"<div class='quadrado_cli'>".
	"<div class='estilo5' align='center'>"."Nome: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_CLI"]."</div>".
	"<div class='estilo11' align='center'>"."Telefone: "."</div>".
	"<div class='estilo12' align='center'>".$row["TELEFONE"]."</div>".
	"<div class='estilo6' align='center'>"."Data Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["DATE_FORMAT(clientes.DATA, '%d/%m/%Y')"]."</div>".
	"<div class='estilo7' align='center'>"."Horário Previsto: "."</div>".
	"<div class='estilo12' align='center'>".$row["HORARIO"]."</div>".
	"<div class='estilo8' align='center'>"."Procedimento: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_PROC"]."</div>".
	"<div class='estilo9' align='center'>"."Profissional: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_FUNC"]."</div>".
	"<div class='estilo10' align='center'>"."Status do Cliente: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_STATUS"]."</div>".
	"<a href='#abrirModal'>"."<input type='button' value='EDITAR' class='botao1'>"."</a>".
	"</div>".
	"</div>";
  }
} else {
  echo "<div class='nao_ha' align='center'>"."<div class='nao_ha_dentro'>"."OPS!, NENHUM REGISTRO ENCONTRADO"."</div>"."</div>";
}

mysqli_close($conn);

?>
	</div>
	
	<div class="pagina_geral5">
	
		<hr size="10" style="border:0px solid black;">
		
		<div class="estilo3" align="center">CLIENTES REAGENDADOS</div>
<?php
$servername = "localhost";
$username = "285867";
$password = "-ieRRRW34_4S!NT";
$dbname = "285867";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT clientes.id, clientes.NOME_CLI, clientes.TELEFONE, DATE_FORMAT(clientes.DATA, '%d/%m/%Y'), clientes.HORARIO, procedimentos.NOME_PROC, funcionarios.NOME_FUNC, STATUS1.NOME_STATUS FROM clientes INNER JOIN procedimentos ON clientes.ID_PROC = procedimentos.ID INNER JOIN funcionarios ON funcionarios.ID_PROC = procedimentos.ID INNER JOIN STATUS1 ON clientes.ID_STATUS = STATUS1.ID WHERE STATUS1.ID = '4';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo
	"<div class='ag_cliente'>".
	"<div class='foto_cli'>"."</div>";

    echo
	"<div class='quadrado_cli'>".
	"<div class='estilo5' align='center'>"."Nome: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_CLI"]."</div>".
	"<div class='estilo11' align='center'>"."Telefone: "."</div>".
	"<div class='estilo12' align='center'>".$row["TELEFONE"]."</div>".
	"<div class='estilo6' align='center'>"."Data Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["DATE_FORMAT(clientes.DATA, '%d/%m/%Y')"]."</div>".
	"<div class='estilo7' align='center'>"."Horário Previsto: "."</div>".
	"<div class='estilo12' align='center'>".$row["HORARIO"]."</div>".
	"<div class='estilo8' align='center'>"."Procedimento: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_PROC"]."</div>".
	"<div class='estilo9' align='center'>"."Profissional: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_FUNC"]."</div>".
	"<div class='estilo10' align='center'>"."Status da Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_STATUS"]."</div>".
	"<a href='#abrirModal'>"."<input type='button' value='EDITAR' class='botao1'>"."</a>".
	"</div>".
	"</div>";
	
  }
} else {
  echo "<div class='nao_ha' align='center'>"."<div class='nao_ha_dentro'>"."OPS!, NENHUM REGISTRO ENCONTRADO"."</div>"."</div>";
}

mysqli_close($conn);

?>
	</div>
	
	<div class="pagina_geral6">
	
		<hr size="10" style="border:0px solid black;">
		
		<div class="estilo3" align="center">CLIENTES FALTANTES</div>
<?php
$servername = "localhost";
$username = "285867";
$password = "-ieRRRW34_4S!NT";
$dbname = "285867";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT clientes.id, clientes.NOME_CLI, clientes.TELEFONE, DATE_FORMAT(clientes.DATA, '%d/%m/%Y'), clientes.HORARIO, procedimentos.NOME_PROC, funcionarios.NOME_FUNC, STATUS1.NOME_STATUS FROM clientes INNER JOIN procedimentos ON clientes.ID_PROC = procedimentos.ID INNER JOIN funcionarios ON funcionarios.ID_PROC = procedimentos.ID INNER JOIN STATUS1 ON clientes.ID_STATUS = STATUS1.ID WHERE STATUS1.ID = '5';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo
	"<div class='ag_cliente'>".
	"<div class='foto_cli'>"."</div>";

    echo
	"<div class='quadrado_cli'>".
	"<div class='estilo5' align='center'>"."Nome: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_CLI"]."</div>".
	"<div class='estilo11' align='center'>"."Telefone: "."</div>".
	"<div class='estilo12' align='center'>".$row["TELEFONE"]."</div>".
	"<div class='estilo6' align='center'>"."Data Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["DATE_FORMAT(clientes.DATA, '%d/%m/%Y')"]."</div>".
	"<div class='estilo7' align='center'>"."Horário Previsto: "."</div>".
	"<div class='estilo12' align='center'>".$row["HORARIO"]."</div>".
	"<div class='estilo8' align='center'>"."Procedimento: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_PROC"]."</div>".
	"<div class='estilo9' align='center'>"."Profissional: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_FUNC"]."</div>".
	"<div class='estilo10' align='center'>"."Status da Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_STATUS"]."</div>".
	"<a href='#abrirModal'>"."<input type='button' value='EDITAR' class='botao1'>"."</a>".
	"</div>".
	"</div>";
	
  }
} else {
  echo "<div class='nao_ha' align='center'>"."<div class='nao_ha_dentro'>"."OPS!, NENHUM REGISTRO ENCONTRADO"."</div>"."</div>";
}

mysqli_close($conn);

?>
	</div>
	
	<div class="pagina_geral7">
	
		<hr size="10" style="border:0px solid black;">
		
		<div class="estilo3" align="center">CLIENTES ATENDIDOS</div>
<?php
$servername = "localhost";
$username = "285867";
$password = "-ieRRRW34_4S!NT";
$dbname = "285867";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT clientes.id, clientes.NOME_CLI, clientes.TELEFONE, DATE_FORMAT(clientes.DATA, '%d/%m/%Y'), clientes.HORARIO, procedimentos.NOME_PROC, funcionarios.NOME_FUNC, STATUS1.NOME_STATUS FROM clientes INNER JOIN procedimentos ON clientes.ID_PROC = procedimentos.ID INNER JOIN funcionarios ON funcionarios.ID_PROC = procedimentos.ID INNER JOIN STATUS1 ON clientes.ID_STATUS = STATUS1.ID WHERE STATUS1.ID = '6';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo
	"<div class='ag_cliente'>".
	"<div class='foto_cli'>"."</div>";

    echo
	"<div class='quadrado_cli'>".
	"<div class='estilo5' align='center'>"."Nome: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_CLI"]."</div>".
	"<div class='estilo11' align='center'>"."Telefone: "."</div>".
	"<div class='estilo12' align='center'>".$row["TELEFONE"]."</div>".
	"<div class='estilo6' align='center'>"."Data Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["DATE_FORMAT(clientes.DATA, '%d/%m/%Y')"]."</div>".
	"<div class='estilo7' align='center'>"."Horário Previsto: "."</div>".
	"<div class='estilo12' align='center'>".$row["HORARIO"]."</div>".
	"<div class='estilo8' align='center'>"."Procedimento: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_PROC"]."</div>".
	"<div class='estilo9' align='center'>"."Profissional: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_FUNC"]."</div>".
	"<div class='estilo10' align='center'>"."Status da Agenda: "."</div>".
	"<div class='estilo12' align='center'>".$row["NOME_STATUS"]."</div>".
	"<a href='#abrirModal'>"."<input type='button' value='EDITAR' class='botao1'>"."</a>".
	"</div>".
	"</div>";
	
  }
} else {
  echo "<div class='nao_ha' align='center'>"."<div class='nao_ha_dentro'>"."OPS!, NENHUM REGISTRO ENCONTRADO"."</div>"."</div>";
}

mysqli_close($conn);

?>
	</div>
	
		<div class="pagina3">
		<div class="estilo4" align="center">CADASTRAMENTO DE CLIENTES</div>
		<div class="quadrado_2">
			<div class="fundo_foto"></div>
	        <form action="?act=save" method="POST" name="form1" >
				<input type="hidden" name="id" <?php
            
            if (isset($id) && $id != null || $id != "") {
                echo "value=\"{$id}\"";
            }
            ?> />
				<input type="text" name="nome_cli" placeholder="                NOME DO CLIENTE" class="nome_cli"
				<?php
					if (isset($nome_cli) && $nome_cli != null || $nome_cli != ""){
					echo "value=\"{$nome_cli}\"";
					}
				?> />
				<input type="text" name="telefone" maxlength="16" placeholder="                       TELEFONE" class="telefone"
				<?php
					if (isset($telefone) && $telefone != null || $telefone != ""){
					echo "value=\"{$telefone}\"";
					}
				?> />
				<input type="date" name="data" class="data"
				<?php
					if (isset($data) && $data != null || $data != ""){
					echo "value=\"{$data}\"";
					}
				?> />
				<input type="time" name="horario" class="horario"
				<?php
					if (isset($horario) && $horario != null || $horario != ""){
					echo "value=\"{$horario}\"";
					}
				?> />
				<select name="id_proc" class="procedimento">
				<option>PROCEDIMENTO</option>
				<option value="1"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>ESCOVA
				</option>
				<option value="2"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>LAVAGEM
				</option>
				<option value="3"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>CORTE
				</option>
				<option value="4"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>SELAGEM COM FORMOL
				</option>
				<option value="5"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>SELAGEM SEM FORMOL
				</option>
				<option value="6"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>PROGRESSIVA
				</option>
				<option value="7"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>TINTURA
				</option>
				<option value="8"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>MANICURE
				</option>
				<option value="9"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>PEDICURE
				</option>
				<option value="10"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>MANICURE E PEDICURE
				</option>
				<option value="11"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>DEPILACAO
				</option>
				<option value="12"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>PENTEADO
				</option>
				<option value="13"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>MAQUIAGEM
				</option>
				<option value="14"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>DIA DA NOIVA
				</option>
				<option value="15"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>DIA DA DEBUTANTE
				</option>
				<option value="16"
				<?php
					if (isset($id_proc) && $id_proc != null || $id_proc != ""){
					echo "value=\"{$id_proc}\"";
					}
				?>>MASSAGEM RELAXANTE
				</option>
				</select>
				<select name="id_status" class="status">
				<option>STATUS DO CLIENTE</option>
				<option value="1"
				<?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>AGENDADO
				</option>
				<option value="2"
				<?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>CANCELADO
				</option>
				<option value="3"
				<?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>AGUARDANDO
				</option>
				<option value="4"
				<?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>REAGENDAR
				</option>
				<option value="5"
				<?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>FALTA
				</option>
				<option value="6"
				<?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>ATENDIDO
				</option>
				</select>			

				<input type="submit" value="SALVAR" class="botao2"/>

			</form>
		</div>
	</div>
	
<div class="copy">Copyright © 2021 - Todos os direitos reservados</div>

<div id="abrirModal" class="modal">
	<div>
		<a href="#fechar" title="Fechar" class="fechar">x</a>
	</div>
</div>
	
</body>

</html>
