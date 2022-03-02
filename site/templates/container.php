<?php

$children = $page->children()->listed();
$containerId = $page->id();
// kill($children);
?>

<?php
foreach ($children as $child):
  ?>
  <div class="bubble-wrapper" data-level="2"><?= $child->render() ?></div>
<?php endforeach;

?>