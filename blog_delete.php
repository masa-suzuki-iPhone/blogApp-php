<?php
require_once('blog.php');
$blog = new Blog();
$result = $blog->delete($_GET['id']);

?>

<button type="button" onclick="history.back()">戻る</button>