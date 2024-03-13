<?php
if (mysqli_num_rows($result) > 0) {
?>
    <ul class="pagination justify-content-end">
        <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?= 1; ?>">&laquo;</a>
        </li>
        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?= $previous; ?>">&lt;</a>
        </li>
        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?= $next; ?>">&gt;</a>
        </li>
        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?= $pages; ?>">&raquo;</a>
        </li>
    </ul>
<?php
}
?>