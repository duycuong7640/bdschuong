<div class="b-search-right">
    <label>Tìm kiếm các dự án</label>
    <form method="post" action="<?php echo DOMAIN; ?>tim-kiem">
        <input type="text" name="tukhoa" class="form-control span12"/>
        <button type="submit" class="btn btn-danger">Tìm kiếm</button>
    </form>
</div>

<div class="bn-adv">
    <?php
    foreach ($hotline as $value) {
        ?>
        <a href="<?php echo DOMAIN; ?>">
            <?php if (get_extension($value['Extention']['images']) == "swf") { ?>
                <embed src="<?php echo SWF_URL . $value['Extention']['images']; ?>" quality="high"
                       pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"
                       wmode="transparent" width="320" height="215" scale="ExactFit"></embed>
            <?php } else { ?>
                <img src="<?php echo DOMAIN . 'img/w320/fill!' . $value['Extention']['images']; ?>"/>
            <?php } ?>
        </a>
        <div class="clear-content"></div>
        <div class="clear-content"></div>
    <?php } ?>
</div>

<div class="aside-item">
    <h2 class="title-head">
        <a href="#" style="cursor: none;"
           title="">Thông tin cần biết</a>
    </h2>
    <div class="list-blogs">
        <?php $dem = 0;
        foreach ($list_post_right as $k => $row) { ?>
            <article class="blog-item blog-item-list clearfix">
                <a href="<?php echo DOMAIN . $row['Post']['link']; ?>.html"
                   title="<?php echo $row['Post']['name'] ?>">
                    <div class="panel-box-media">
                        <img class="lazy loaded"
                             src="<?php echo DOMAIN; ?>img/w357/h265/fill!<?php echo $row['Post']['images'] ?>"
                             alt="<?php echo $row['Post']['name'] ?>"
                             title="<?php echo $row['Post']['name'] ?>" data-was-processed="true">

                    </div>
                    <div class="blogs-rights">
                        <h3 class="blog-item-name"><?php echo $row['Post']['name'] ?></h3>
                    </div>
                </a>
            </article>
            <?php $dem++;
            if ($dem == 10) break;
        } ?>
    </div>
    <!--    <div class="blogs-mores text-center"><a href="tin-tuc" title="Xem thêm">Xem thêm</a></div>-->
</div>

<div class="bn-adv">
    <?php
    foreach ($quangcaophai as $value) {
        ?>
        <a href="<?php echo DOMAIN; ?>">
            <?php if (get_extension($value['Extention']['images']) == "swf") { ?>
                <embed src="<?php echo SWF_URL . $value['Extention']['images']; ?>" quality="high"
                       pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"
                       wmode="transparent" width="320" height="215" scale="ExactFit"></embed>
            <?php } else { ?>
                <img src="<?php echo DOMAIN . 'img/w320/fill!' . $value['Extention']['images']; ?>"/>
            <?php } ?>
        </a>
        <div class="clear-content"></div>
    <?php } ?>
</div>