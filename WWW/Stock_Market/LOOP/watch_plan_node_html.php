<form action="./watch_plan_node_html.php">
  Amount of NODES:<br>
  <input type="text" name="nodes" value="3"><br>
  RW-NODES:<br>
  <input type="text" name="rw" value="0"><br><br>
  <input type="submit" value="Submit">
</form>


<?php
$nodes = $_GET['nodes'];

if (isset($nodes)){
$count= 2;
while ($count <= $nodes){

?>
<iframe src="./watch_plan_node.php?node=<?php echo $count;?>" style="width:0;height:0;border:0; border:none;"></iframe>

<?php

$count++; 
}
}

$nodes = $_GET['rw'];

if (isset($nodes)){
$count= 2;
while ($count <= $nodes){

?>
<iframe src="./watch_plan_node.php?node=<?php echo $count;?>&RW_LOOK=TRUE" style="width:0;height:0;border:0; border:none;"></iframe>

<?php

$count++; 
}
}

