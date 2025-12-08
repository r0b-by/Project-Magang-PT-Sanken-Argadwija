<?php
// Safe pager template: only relies on $pager->links()
$links = $pager->links() ?? [];
if (empty($links)) {
    return;
}
?>

<nav aria-label="Pagination">
    <ul class="pagination justify-content-center mb-0">

        <!-- Previous (first link with title '‹' or '...') -->
        <?php
        // Try to find previous link — pager->links() may include a prev link with title '&laquo;' or similar.
        $firstPrev = null;
        foreach ($links as $l) {
            // Common pattern: previous links often have title like '&laquo;' or '‹'
            if (trim(strip_tags($l['title'])) === '«' || trim(strip_tags($l['title'])) === '‹' || trim($l['title']) === '&laquo;' || trim($l['title']) === '‹') {
                $firstPrev = $l;
                break;
            }
        }
        ?>
        <?php if ($firstPrev): ?>
            <li class="page-item <?= $firstPrev['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= esc($firstPrev['uri']) ?>"><?= $firstPrev['title'] ?></a>
            </li>
        <?php endif; ?>

        <!-- Page number links -->
        <?php foreach ($links as $link): ?>
            <?php
                // Skip if this link is a prev/next that we've already rendered above (best-effort)
                $title = trim(strip_tags($link['title']));
                if ($title === '«' || $title === '›' || $title === '‹' || $title === '»' || $title === '&laquo;' || $title === '&raquo;') {
                    // Let prev/next be handled separately below (or ignored if not matched)
                    continue;
                }
            ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= esc($link['uri']) ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>

        <!-- Next (try to find next link) -->
        <?php
        $firstNext = null;
        foreach ($links as $l) {
            if (trim(strip_tags($l['title'])) === '»' || trim(strip_tags($l['title'])) === '›' || trim($l['title']) === '&raquo;') {
                $firstNext = $l;
                break;
            }
        }
        ?>
        <?php if ($firstNext): ?>
            <li class="page-item <?= $firstNext['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= esc($firstNext['uri']) ?>"><?= $firstNext['title'] ?></a>
            </li>
        <?php endif; ?>

    </ul>
</nav>
