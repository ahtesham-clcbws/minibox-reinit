<?php if ($pagedata['id'] && !empty($pagedata['title']) || $pagedata['id'] && !empty($pagedata['content'])) : ?>
    <section class="uk-section-small uk-section-default">
        <div class="uk-container uk-container-small uk-text-center">
            <?php if ($pagedata['id'] && !empty($pagedata['title'])) : ?>
                <h3 class="about-text-title"><?= $pagedata['title'] ?></h3>
            <?php endif; ?>
            <?php if ($pagedata['id'] && !empty($pagedata['content'])) : ?>
            <p><?= $pagedata['content'] ?></p>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>