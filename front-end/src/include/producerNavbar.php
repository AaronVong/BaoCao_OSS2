
    <ul class="navbar--producers">
<?php
    $_producer=new Producer();
    $producers = $_producer->getAllProducersbyCatId($catid);
    foreach ($producers as $producer) {
?>
        <li class="producer"><a href="<?php echo "category.php?catid=".$catid."&producerid=".$producer["producer_id"]; ?>" class="links"><img src="<?php echo "./front-end/images/brands/".$producer["producer_thumb"];?>"></a></li>
<?php
    }
?>
    </ul>
