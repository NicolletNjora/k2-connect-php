<?php
    include 'layout.php';
?>
<div class="container">

<?php
    if(isset($response)){
        // extract($response);
        echo "The response is:" . json_encode($response);
    } else{
        echo "There is no response";
    }
?>