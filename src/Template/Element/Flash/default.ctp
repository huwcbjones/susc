<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div role="alert" class="alert <?= h($class) ?>"><?= h($message) ?></div>
