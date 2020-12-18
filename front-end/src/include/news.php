<?php
    $news=[
        "637398677436892936_F-H2_385x100.png",
        "637413952999516549_F-H2_385x100.png",
        "398-110-398x110.png",
    ];
?>
<article class="news">
    <h4 class="title--news title">
        <span>Tin Khuyến mãi</span>
    </h4>
    <div class="posts">
    <?php
        foreach ($news as $image) {
    ?>
        <a href="#news" class="post__links"><img class="fluid-img post__images" src="<?php echo "./front-end/images/salenews/$image"; ?>"></a>
    <?php
        }
    ?>
    </ul>
</div>