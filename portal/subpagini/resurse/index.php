
<?php 

if ($subpagina == "") {
    if ($ajax_redir) {
        require("prima.ajax.php");
    } else if ($js_redir) {
		header("Content-type: application/javascript");
        require("prima.js");
    } else require("prima.php");

} else if ($subpagina == "nou") {
    if ($js_redir) {
		header("Content-type: application/javascript");
        require("nou.js");
    } else if ($post_redir) {
        require("nou.post.php");
    } else require("nou.php");

}

?>