<style>

*{
    font-family: 'Courier New', Courier, monospace;
    line-height: 10px;
}
body{
    width: 100vw;
    height: 100vh;
}
.container{
    width: 100%;
    height: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-content: center;
}
.form-box{
    width: 100%;
}
.result{
    width: 100%;
    text-align: center;
}
.red{
    color: red;
}


</style>

<?php

    $sum = function(...$arr){
        $result = 0;
        for($i=0; $i<count($arr); $i++){
            echo "當前總值為{$result}，下一個輸入為:{$arr[$i]}<br>";
            $result += $arr[$i];
        }
        return $result;
    };

    // echo $sum(1, 2, 3, 4);
?>

<div class="container">

    <div class="fomr-box">
        <form action="./graph.php" method="get">
            <label for="num">大小:</label>
            <input type="number" name="num" id="num" min=1 
            <?php if(isset($_GET['num'])) echo "value={$_GET['num']}"; ?> require>
            <br>

            <input type="radio" name="type" id="type" value="triU">
            <label for="type">正三角形(向上)</label>
            <input type="radio" name="type" id="type" value="triD">
            <label for="type">正三角形(向下)</label>
            <input type="radio" name="type" id="type" value="dim">
            <label for="type">菱形</label>
            <input type="radio" name="type" id="type" value="squ">
            <label for="type">四邊形</label>
            <br>

            <input type="submit">
        </form>
    </div>

    <?php
        $printGraph = function($type, $n){
            $str = '';
            $arr = [];

            if($type == 'triU'){
                for($i=1; $i<=$n; $i++){
                    if($i == 1) $str = '*';
                    else $str = '*'.$str.'*';
                    $space = str_repeat(' ', $n - $i);
                    array_push($arr, $space.$str.$space.'<br>');
                }
            }
            else if($type == 'triD'){
                for($i=0; $i<$n; $i++){
                    if($i == 0) $str = str_repeat('*', 2 * $n + 1);
                    
                    $str = substr($str, 1, strlen($str)-2);
                    $space = str_repeat(' ', $i);
                    array_push($arr, $space.$str.$space.'<br>');
                }
            }
            else if($type == 'dim'){
                for($i=0; $i<$n; $i++){
                    if($i < floor($n / 2)){
                        if($i == 0) $str = '*';
                        else $str = '*'.$str.'*';
                
                        $space = str_repeat(' ', floor($n / 2) - $i - 1);
                        array_push($arr, $space.$str.$space.'<br>');
                    }
                    else{
                        if($str == '') break;
                
                        $str = substr($str, 1, strlen($str)-2);
                        $space = str_repeat(' ', $i - floor($n / 2) + 1);
                        array_push($arr, $space.$str.$space.'<br>');
                    }
                }
            }
            else if($type == 'squ'){
                for($i=0; $i<$n; $i++){
                    if($i == 0 || $i == $n-1) $str = str_repeat('*', $n);
                    else $str = '*'.(str_repeat(' ', $n-2)).'*';
                    array_push($arr, $str.'<br>');
                }
            }
            else return 'input error';

            return join('', $arr);
        };

        if(!empty($_GET)){
            echo '<div class="result"><pre>'.$printGraph($_GET['type'], $_GET['num']).'</pre></div>';
        }


    ?>

</div>