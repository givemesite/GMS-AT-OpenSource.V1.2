<?php


clone new class {public function __clone(){clone $this;}};

//
function a() { a(); } a();


?>