<?php
$target_directory = __DIR__ . "themes/";
$target_file = $target_directory . basename($_FILES["theme_file"]["name"]);
move_uploaded_file($_FILES["theme_file"]["tmp_name"], $target_file);
echo "File uploaded successfully.";
?>
