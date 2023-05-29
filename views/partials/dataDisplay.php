<?php if (!is_null($output)): ?>
    <h2>Your request outputted: </h2>
    <ul>
        <?php foreach ($output as $value): ?>
            <li><?php echo $value; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>