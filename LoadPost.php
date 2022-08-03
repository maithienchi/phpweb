<?php 
    require_once 'init.php';
?>
<?php
    $PostNewCount = $_POST['PostNewCount'];
    global $db;
    $stmt = $db->prepare("SELECT * from posts ORDER BY createdAt desc limit $PostNewCount");
    $stmt->execute(array());
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < count($result); $i++) {
        echo "<p>";
        echo $result[$i]['userId'];
        echo $result[$i]['content'];
        echo $result[$i]['createdAt'];
        echo "</p>";
    }
?>