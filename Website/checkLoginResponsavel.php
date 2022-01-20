<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function senhaIncorreta(){
            swal('Senha e/ou CPF incorretos!' ,'Tente novamente!', 'error').then((value) => {
                window.history.back();//simula o voltar do navegador
            });
        }
        function cpfInexistente(){
            swal('CPF não cadastrado!' ,'Tente acessar uma conta com CPF válido!', 'error').then((value) => {
                window.history.back();//simula o voltar do navegador
            });
        }
    </script>
</head>
<body>
<?php
    //menu de navegação
    include_once("navegacaoInicial.html");
?>
    

<?php
    //incluir o arquivo de conexão com o BD
    include_once("conexao.php");

    //iniciando sessão
    session_start();
    $_SESSION['logged'] = false;

    //receber os dados que vieram do form via POST
    $cpf = $_POST["cpfLogin"];
    $senha = $_POST["senhaLogin"];

    /*if($senha = null || $cpf = null){
        ?>
        <script>
            senhaIncorreta();
        </script>
        <?php
    }*/

    $sql = "SELECT * FROM tb_responsavel WHERE Cpf = '$cpf'";
    $consulta = $conn->query($sql);

    //verificando se o cpf existe
    if($consulta->num_rows == 0){
        ?>
        <script>
            cpfInexistente();
        </script>
        <?php
    }else{

        $usuario = $consulta->fetch_assoc();

    
        //verificando se a senha digitada($senha) é igual a senha criptografada no banco($usuario['senha'])
        if(password_verify($senha, $usuario['Senha'])){
            $_SESSION['logged'] = true;
            $_SESSION['cpf'] = $cpf;
            $_SESSION['tipoUsuario'] = "responsavel";

            ?>
                <script>
                    window.location = "menuResponsavel.php";
                </script>

                <?php
        }
        else{
            ?>
            <script>
                senhaIncorreta();
            </script>

            <?php
        }

        /*
        if($consulta->num_rows > 0){
            $_SESSION['logged'] = true;
            $_SESSION['cpf'] = $cpf;
            $_SESSION['tipoUsuario'] = "responsavel";

            ?>
                <script>
                    window.location = "menuResponsavel.php";
                </script>

                <?php
        }else{
            ?>
                <script>
                    alert("CPF e/ou senha incorretos!");
                    window.history.back(); //simula o voltar do navegador
                </script>

                <?php
        }*/
    }

   
    

    
?>
</body>
</html>