<?php
    $banner =[
        "banner_1.png",
        "banner_2.png",
        "banner_3.png",
        "banner_4.png",
        "banner_5.png",
        "banner_6.png",
        "banner_7.png",
        "banner_8.png",
    ]
?>

<div class="slick-carousel">
    <?php
            foreach ($banner as $image) {
                echo
                "<div class=\"slick-item\">
                    <a href=\"#banner\"><img class=\"carousel__image\"src=\"./front-end/images/banners/$image\"></a>
                </div>";
            }
        ?>
</div>

