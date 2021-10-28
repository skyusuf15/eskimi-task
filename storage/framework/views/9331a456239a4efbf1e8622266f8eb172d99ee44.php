<div class="card">
    <?php if(!empty($title)): ?>
    <header class="card-header">
        <p class="card-header-title">
            <?php echo $title; ?>

        </p>
    </header>
    <?php endif; ?>

    <?php echo @$upperToolbar; ?>


    <div class="card-content">
        <?php echo $slot; ?>

    </div>

    <?php if(!empty($footer)): ?>
    <footer class="card-footer">
        <?php echo $footer; ?>

    </footer>
    <?php endif; ?>
</div><?php /**PATH /Users/sky/repositories/SKY-PP/eskimi-task/resources/views/components/card.blade.php ENDPATH**/ ?>