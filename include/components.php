<div class="connectedSortable my-3" id="component-sidebar">
    <?php
    $counter = 0;
    while ($component = mysqli_fetch_array($query)) : ?>
        <div class="card mb-1" data-component-id="<?= $component['id'] ?>" data-counter="<?= $counter++ ?>">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="<?= $component['icon'] ?> mr-1"></i>
                    <?= $component['title'] ?>
                </h3>
            </div>
        </div>
    <?php endwhile; ?>
</div>