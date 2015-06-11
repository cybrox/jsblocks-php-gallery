<?php

    define("IMGDIR", "./images");

    $images = array();
    if ($directory = opendir(IMGDIR)) {
        while ($image = readdir($directory)) {
            if ($image != "." && $image != "..") {
                if (in_array(substr($image, -4), array('.jpg', '.JPG', '.png', '.PNG')))
                    array_push($images, $image);
            }
        }
        closedir($directory);
    }

?>
<html>
<head>
    <title>gallery</title>
    
    <script type="text/javascript">
        var __images = <?php echo json_encode($images); ?>;
    </script>
</head>
<body>



</body>
</html>
