<?php if ($pagination->pages_count > 1) : ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $pagination->pages_count; $i++ ): ?>
                <li class="page-item<?= $pagination->page == $i ? ' active' : '' ?>">
                    <?php if ($pagination->page != $i) : ?>
                        <a class="page-link" href="<?= $pagination->path ? '/' . $pagination->path . '/' : ''
                        ?>?page=<?= $i ?>&per_page=<?= $pagination->per_page ?>"><?= $i ?></a>
                    <?php else: ?>
                        <a class="page-link"><?= $i ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
