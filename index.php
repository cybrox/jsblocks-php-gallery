<?php

    require_once('./config.php'); /* config defines PASSWD */
    define("IMGDIR", "./s");

    // Shitty auth
    $permitted = ($_GET['pw'] == PASSWD);

    $images = array();
    if ($directory = opendir(IMGDIR)) {
        while ($image = readdir($directory)) {
            if ($image != "." && $image != "..") {
                if ($image == "_missing.jpg") continue;
                if (in_array(substr($image, -4), array('.jpg', '.JPG', '.png', '.PNG'))) {
                    if ($permitted) {
                        array_push($images, $image);
                    } else {
                        if (strstr($image, "_")) array_push($images, $image);
                    }
                }
            }
        }
        closedir($directory);
    }

    rsort($images);
    $images = array_map(function($x){ return array("name" => $x); }, $images);

?>
<html>
<head>
    <title>gallery</title>

    <script type="text/javascript">
        window.__imgdir = "<?php echo IMGDIR; ?>";
        window.__images = <?php echo json_encode($images); ?>;

        var imageExists = false;
        var imageNeeded = window.location.hash.replace('#', '');
        window.__images.forEach(function(image, index) {
            if (image.name == imageNeeded) window.__imgndx = index;
            window.__images[index].index = index;
        });

        if (imageNeeded == "") imageNeeded = "???";

        <?php if($permitted): ?>
        if (window.__imgndx === undefined)
            window.location.hash = "_missing.jpg";
        <?php else: ?>
        if (window.__imgndx === undefined) {
            window.__images.unshift({name: imageNeeded, active: true});
            window.__imgndx = 0;
        }
        <?php endif; ?>
    </script>

    <script type="text/javascript" src="http://jsblocks.com/blocks/0.3.2/blocks.js"></script>
    <script type="text/javascript" src="assets/application.js"></script>
    <link rel="stylesheet" href="assets/application.css" />
</head>
<body data-query="view(Gallery).on('keydown', Gallery.handleAction)">

    <section id="image">
        <div id="image-holder">
            <img id="image-object" src="<?php echo IMGDIR; ?>/{{image}}" data-query="click(openImage).on('touchend', openImage)"/>
            <script type="text/javascript">
                window.__imgobj = document.getElementById('image-object');
                window.__imgobj.onerror = function() {
                    window.__imgobj.src = "<?php echo IMGDIR; ?>/_missing.jpg";
                }
            </script>
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
