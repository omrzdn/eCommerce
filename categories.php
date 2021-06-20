<?php include 'ini.php'; ?>

<div class="container">
    <h1 class="text-center"><? echo str_replace('-', ' ', $_GET['pagename']); ?></h1>
    <div class="row">
        <?
        foreach (getItems('catID',$_GET['pageID']) as $item) {
            echo '<div class="col-sm-6 col-md-3">';
                echo '<div class="img-thumbnail item-box">';
                    echo '<span class="price-tag">' . $item['Price'] . '</span>';
                    echo '<img class="img-fluid" src="img.png" alt="" />';
                    echo '<div class="caption">';
                            echo '<h3>' . $item['Name'] . '</h3>';
                            echo '<p>' . $item['Description'] . '</p>';
                    echo '</div>';
                echo '</div>';
            echo "</div>";
        }
        ?>
    </div>
</div>

<? include $tplRoute . "footer.php"; ?>
