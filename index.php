<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./src/output.css" rel="stylesheet">
</head>
<body  class="bg-white flex items-center justify-center min-h-screen">
    <div class="bg-gradient-to-b from-gray-800 to-gray-700 w-80 rounded-xl overflow-hidden shadow-xl">
        <div class="text-white text-right text-5xl px-5 py-6 font-light bg-black">
        <?php
            session_start();
            
            $display = $_SESSION['display'] ?? '0';
            $storedValue = $_SESSION['storedValue'] ?? null;
            $lastOperator = $_SESSION['lastOperator'] ?? null;
            $resetDisplay = $_SESSION['resetDisplay'] ?? false;
            
            if(isset($_POST['button'])) {
                $pressedButton = $_POST['button'];
                if (is_numeric($pressedButton) || $pressedButton === '.') {
                    if ($resetDisplay) {
                        $display = $pressedButton;
                        $resetDisplay = false;
                    } else {
                        if ($pressedButton === '.' && strpos($display, '.') !== false) {
                        } else {
                            $display = ($display === '0' && $pressedButton !== '.') ? $pressedButton : $display . $pressedButton;
                        }
                    }
                } 
                elseif (in_array($pressedButton, ['+', '-', '*', '/', '%'])) {
                    if ($storedValue === null) {
                        $storedValue = $display;
                    } else if (!$resetDisplay) {
                        $storedValue = calculate($storedValue, $display, $lastOperator);
                        $display = $storedValue;
                    }
                    $lastOperator = $pressedButton;
                    $resetDisplay = true;
                }
                elseif ($pressedButton === '=') {
                    if ($storedValue !== null && $lastOperator !== null && !$resetDisplay) {
                        $display = calculate($storedValue, $display, $lastOperator);
                        $storedValue = null;
                        $lastOperator = null;
                    }
                    $resetDisplay = true;
                }
                elseif ($pressedButton === 'C') {
                    $display = '0';
                    $storedValue = null;
                    $lastOperator = null;
                    $resetDisplay = false;
                }
                elseif ($pressedButton === '+/-') {
                    if ($display !== '0') {
                        if (strpos($display, '-') === 0) {
                            $display = substr($display, 1);
                        } else {
                            $display = '-' . $display;
                        }
                    }
                }
                $_SESSION['display'] = $display;
                $_SESSION['storedValue'] = $storedValue;
                $_SESSION['lastOperator'] = $lastOperator;
                $_SESSION['resetDisplay'] = $resetDisplay;
            }
            
            function calculate($num1, $num2, $operator) {
                $num1 = floatval($num1);
                $num2 = floatval($num2);
                switch ($operator) {
                    case '+': return $num1 + $num2;
                    case '-': return $num1 - $num2;
                    case '*': return $num1 * $num2;
                    case '/': return $num2 != 0 ? $num1 / $num2 : 'Error';
                    case '%': return $num2 != 0 ? $num1 % $num2 : 'Error';
                    default: return $num2;
                }
            }
            
            echo htmlspecialchars($display);
            ?>
        </div>
        <form method="post" class="grid grid-cols-4 gap-px bg-gray-600 text-white text-2xl font-medium">
            <button type="submit" name="button" value="C"  class="bg-gray-500 py-6">C</button>
            <button type="submit" name="button" value="+/-" class="bg-gray-500 py-6">+/-</button>
            <button type="submit" name="button" value="%" class="bg-gray-500 py-6">%</button>
            <button type="submit" name="button" value="/" class="bg-orange-500 py-6">÷</button>
            <button type="submit" name="button" value="7" class="bg-gray-700 py-6">7</button>
            <button type="submit" name="button" value="8" class="bg-gray-700 py-6">8</button>
            <button type="submit" name="button" value="9" class="bg-gray-700 py-6">9</button>
            <button type="submit" name="button" value="*" class="bg-orange-500 py-6">x</button>
            <button type="submit" name="button" value="4" class="bg-gray-700 py-6">4</button>
            <button type="submit" name="button" value="5" class="bg-gray-700 py-6">5</button>
            <button type="submit" name="button" value="6" class="bg-gray-700 py-6">6</button>
            <button type="submit" name="button" value="-" class="bg-orange-500 py-6">-</button>
            <button type="submit" name="button" value="1" class="bg-gray-700 py-6">1</button>
            <button type="submit" name="button" value="2" class="bg-gray-700 py-6">2</button>
            <button type="submit" name="button" value="3" class="bg-gray-700 py-6">3</button>
            <button type="submit" name="button" value="+" class="bg-orange-500 py-6">+</button>
            <button type="submit" name="button" value="0" class="bg-gray-700 py-6 col-span-2">0</button>
            <button type="submit" name="button" value="." class="bg-gray-700 py-6">.</button>
            <button type="submit" name="button" value="=" class="bg-orange-500 py-6">=</button>
        </form>
    </div>
</body>
</html>