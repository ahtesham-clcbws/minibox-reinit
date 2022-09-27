
<?php if ($pager->getPageCount() > 1) : ?>
    <?php $pager->setSurroundCount(2) ?>
    <style>
        .uk-custom-pagnation .innerPagination li a {
            min-width: 38px;
        }

        .uk-custom-pagnation>li>a {}

        .uk-custom-pagnation .uk-button svg {
            height: 14px;
            margin-top: -5px !important;
        }
    </style>

    <ul class="uk-pagination uk-width-1-1 uk-custom-pagnation uk-margin-top">
        <li>
            <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="uk-button uk-button-secondary uk-button-small">
                <span class="uk-margin-small-right" uk-pagination-previous></span><span class="paginatetext">First</span>
            </a>
        </li>

        <ul class="uk-pagination uk-flex-center innerPagination" style="flex-grow: 1;">
            <?php foreach ($pager->links() as $link) : ?>
                <li>
                    <a href="<?= $link['uri'] ?>" class="uk-button <?= $link['active'] ? 'uk-button-primary' : 'uk-button-secondary' ?> uk-button-small">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>


        <li>
            <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="uk-button uk-button-secondary uk-button-small">
                <span class="paginatetext">Last</span><span class="uk-margin-small-left" uk-pagination-next></span>
            </a>
        </li>

    </ul>
<?php endif; ?>