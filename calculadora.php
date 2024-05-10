<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calculadora PHP</title>
</head>

<body>
    
    <form method="post" id="main-calculadora">

      
        <div id="top-txt">
            <span id="titulo">Calculadora PHP</span>
        </div>


        <div id="digitar-numeros-wrapper">

            <div id="numero1" class="numeros">
                <div class="numero-txt">
                    <span>Número 1</span>
                </div>

                <input type="number" name="numero1" class="input-numero">
            </div>


            <div id="operacao-wrapper">
                <select name="operacao" id="operacao">
                    <option value="adi">+ (Soma)</option>
                    <option value="sub">- (Subtração)</option>
                    <option value="mult">x (Multiplicação)</option>
                    <option value="div">/ (Divisão)</option>
                    <option value="pot">^ (Potência)</option>
                    <option value="fat">n! (Fatoração)</option>

                </select>

            </div>

            <div id="numero2" class="numeros">
                <div class="numero-txt">
                    <span>Número 2</span>
                </div>

                <input type="number" name="numero2" class="input-numero">

            </div>


        </div>

        <input type="submit" value="Calcular" id="calcular">
        <input type="submit" value="Salvar na Memória" id="salvar">
        <input type="submit" value="Recuperar da Memória" id="recuperar">
        <input type="submit" value="M" id="m">
        <input type="submit" value="Limpar da Memória" id="limpar">


        <div id="resultado-wrapper">
            <?php
            $resultado = '';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $numero1 = $_POST['numero1'];
                $numero2 = $_POST['numero2'];
                $operacao = $_POST['operacao'];

                switch ($operacao) {
                    case 'adi':
                        $resultado = $numero1 + $numero2;
                        break;
                    case 'sub':
                        $resultado = $numero1 - $numero2;
                        break;
                    case 'mult':
                        $resultado = $numero1 * $numero2;
                        break;
                    case 'div':
                        if ($numero2 != 0) {
                            $resultado = $numero1 / $numero2;
                        } else {
                            $resultado = "Divisão por zero não é permitida.";
                        }
                        break;
                    case 'pot':
                        $resultado = $numero1 ** $numero2;
                        break;

                    default:
                        $resultado = 1;
                        for ($i = 1; $i <= $numero1; $i++) {
                            $resultado *= $i;
                        }
                        break;
                }



                session_start();


                if (isset($_POST['save_memory'])) {

                    $_SESSION['memory'] = array(
                        'numero1' => $_POST['numero1'],
                        'numero2' => $_POST['numero2'],
                        'operacao' => $_POST['operacao']
                    );
                }


                if (isset($_POST['retrieve_memory'])) {

                    if (isset($_SESSION['memory'])) {

                        $_POST['numero1'] = $_SESSION['memory']['numero1'];
                        $_POST['numero2'] = $_SESSION['memory']['numero2'];
                        $_POST['operacao'] = $_SESSION['memory']['operacao'];
                    } else {

                        $resultado = "Nenhum valor armazenado na memória.";
                    }
                }

                $resultado = strval($resultado);
            }
            if (!isset($_SESSION['historico'])) {
                $_SESSION['historico'] = array();
            }
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $numero1 = $_POST['numero1'];
                $numero2 = $_POST['numero2'];
                $operacao = $_POST['operacao'];
            
                switch ($operacao) {
                    case 'adi':
                        $resultado = $numero1 + $numero2;
                        break;
                    case 'sub':
                        $resultado = $numero1 - $numero2;
                        break;
                    case 'mult':
                        $resultado = $numero1 * $numero2;
                        break;
                    case 'div':
                        if ($numero2 != 0) {
                            $resultado = $numero1 / $numero2;
                        } else {
                            $resultado = "Divisão por zero não é permitida.";
                        }
                        break;
                    case 'pot':
                        $resultado = $numero1 ** $numero2;
                        break;
                    case 'fat':
                        $resultado = 1; 
                        for ($i = 1; $i <= $numero1; $i++) {
                            $resultado *= $i;
                        }
                        break;
                    default:
                        $resultado = "Selecione uma operação válida.";
                        break;
                }
            
                
                $_SESSION['historico'][] = array(
                    'numero1' => $numero1,
                    'numero2' => $numero2,
                    'operacao' => $operacao,
                    'resultado' => $resultado
                );
            
                
            
            }
            
            
            if (isset($_POST['limpar_historico'])) {
                $_SESSION['historico'] = array();
            }

            if ($resultado !== '') {
                echo "<div id='resultado'>";
                echo "Resultado: " . $resultado;
                echo "</div><!--resultado-->";
            }
            echo "<div id='historico'>";
                echo "<h2>Histórico de Operações</h2>";
                foreach ($_SESSION['historico'] as $op) {
                    echo "Número 1: " . $op['numero1'] . ", Número 2: " . $op['numero2'] . ", Operação: " . $op['operacao'] . ", Resultado: " . $op['resultado'] . "<br>";
                }
                echo "</div>";
            ?>
        </div>


    </form>



</body>

</html>