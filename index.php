<?php

    define("IMGDIR", "./images");

    $images = array();
    if ($directory = opendir(IMGDIR)) {
        while ($image = readdir($directory)) {
            if ($image != "." && $image != "..") {
                if (in_array(substr($image, -4), array('.jpg', '.JPG', '.png', '.PNG')))
                    array_push($images, array("name" => $image));
            }
        }
        closedir($directory);
    }

?>
<html>
<head>
    <title>gallery</title>

    <script type="text/javascript">
        window.__images = <?php echo json_encode($images); ?>;
    </script>

    <script type="text/javascript" src="http://jsblocks.com/blocks/0.3.2/blocks.js"></script>
    <script type="text/javascript" src="assets/application.js"></script>
    <link rel="stylesheet" href="assets/application.css" />
</head>
<body data-query="view(Gallery)">

    <section id="image">
        <div id="image-holder">
            <img id="image-object" src="<?php echo IMGDIR; ?>/{{image}}" />
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
