<?php
global $search;
$GLOBALS['PAGE_TITLE'] = 'Search Results';
require_view('view/header.php');
?>

<body>
    <div style="padding-top: 20px">
        <table class="recherche">
            <thead>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th>Genre</th>
            </thead>
            <?php
            foreach ($search as $ligne) {
                echo "<tr>";
                foreach ($ligne as $colonne) {
                    echo "<td>$colonne</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

<?php
require_view('view/footer.php');
?>