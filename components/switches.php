<?php for($i = 0;$i < 5;$i++): ?>
<div class="custom-control custom-switch text-center">
    <input type="checkbox" class="custom-control-input" id="customSwitch<?= $i ?>">
    <label class="custom-control-label" for="customSwitch<?= $i ?>">Toggle switch <?= $i ?></label>
</div>
<?php endfor; ?>