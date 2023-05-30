<?php if (!is_null($output)): ?>
    <h2 class="naslov2">Your request outputted: </h2>
    <ul class="list">
        <?php foreach ($output as $value): ?>
            <li><?php echo $value; ?></li><br>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>