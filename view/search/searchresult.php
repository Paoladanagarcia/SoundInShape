<?php
global $search;
$GLOBALS['PAGE_TITLE'] = 'Resultat de la recherche';
require_view('view/header.php');
?>

<body>
    <div style="padding-top: 20px">
        <table class="recherche">
            <thead>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
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