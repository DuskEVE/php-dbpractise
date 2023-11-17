
<style>
    table, tr, td{
        border: 1px solid;
        border-collapse: collapse;
    }
</style>

<div class="container">

    <!-- <div class="form-box">
        <form action="./db.php">
            <label for="tableName">table name:</label>
            <select name="tableName" id="tableName">

            </select><br>

            <label for="tableName">table name:</label>
            <select name="tableName" id="tableName">

            </select>
        </form>
    </div> -->

</div>

<?php

    function printArray($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    function printTable($arr){
        $keys = [];
        $result = [];

        foreach($arr[0] as $key=>$value){
            array_push($keys, $key);
        };

        array_push($result, '<tr><td>'.join('</td><td>', $keys).'</td></tr>');

        for($i=0; $i<count($arr); $i++){
            array_push($result, '<tr>');

            foreach($arr[$i] as $key=>$value){
                array_push($result, '<td>'.$value.'</td>');
            }

            array_push($result, '</tr>');
        }

        return '<table>'.join($result).'</table>';
    }

    function dbLogIn(){
        $dsn = "mysql:host=localhost; charset=utf8; dbname=school";
        return new PDO($dsn, 'root', '');
    }

    function searchAll($tableName){
        $pdo = dbLogIn();
        $sql = "select * from `{$tableName}`";

        $arr = $pdo->query($sql)->fetchAll();
        return $arr;
    }

    function searchSingleType($tableName, $targetType, ...$target){
        $pdo = dbLogIn();
        $target = implode(",", $target);
        $sql = "select * from `{$tableName}` where `{$targetType}` in ({$target})";
        // echo $sql;

        $arr = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }

    // $targets = [['targetType, targetName'], ...]
    function searchTarget($tableName, $targets){
        $pdo = dbLogIn();
        $strs = [];

        foreach($targets as $element){
            $targetType = $element[0];
            $targetName = $element[1];
            $str = " `{$targetType}`='{$targetName}'";

            array_push($strs, $str);
        }

        $strs = implode("&&", $strs);
        $sql = "select `id`, `uni_id`, `name`, `dept`, `graduate_at` from `{$tableName}` where {$strs}";
        // echo $sql;

        $arr = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }

    // printArray(searchSingleType('dept', 'id', 1, 2, 3));

    // echo printArray(searchTarget('students', [['dept','2'], ['graduate_at','2']]));
    echo printTable(searchTarget('students', [['dept','2'], ['graduate_at','2']]));


?>