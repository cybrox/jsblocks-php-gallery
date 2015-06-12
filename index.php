<?php

    define("IMGDIR", "./s");

    $images = array();
    if ($directory = opendir(IMGDIR)) {
        while ($image = readdir($directory)) {
            if ($image != "." && $image != "..") {
                if (in_array(substr($image, -4), array('.jpg', '.JPG', '.png', '.PNG'))) {
                    if ($_GET['pw'] == 'zitronenkuchen') {
                        array_push($images, $image);
                    } else {
                        if (strstr($image, "_")) array_push($images, $image);
                    }
                }
            }
        }
        closedir($directory);
    }

    sort($images);
    $images = array_map(function($x){ return array("name" => $x); }, $images);

?>
<html>
<head>
    <title>gallery</title>

    <script type="text/javascript">
        window.__imgdir = "<?php echo IMGDIR; ?>";
        window.__images = <?php echo json_encode($images); ?>;
    </script>

    <script type="text/javascript" src="http://jsblocks.com/blocks/0.3.2/blocks.js"></script>
    <script type="text/javascript" src="assets/application.js"></script>
    <link rel="stylesheet" href="assets/application.css" />
</head>
<body data-query="view(Gallery).on('keydown', Gallery.handleAction)">

    <section id="image">
        <div id="image-holder">
            <img id="image-object" src="<?php echo IMGDIR; ?>/{{image}}" data-query="click(openImage).on('touchend', openImage)"/>
        </div>
    </section>

    <section id="sidebar">
        <div id="sidebar-filter">
            <input type="text" placeholder="filter..." data-query="val(filterValue)"/>
        </div>
        <div id="sidebar-list" data-query="each(images.view)">
            <div class="sidebar-item" data-query="click(setImage).on('touchend', setImage).setClass('active', active)">
                &#128196; {{name}}
            </div>
        </div>
    </section>

</body>
</html>
