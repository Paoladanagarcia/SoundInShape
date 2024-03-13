<?php
global $faq;
$GLOBALS['PAGE_TITLE'] = 'FAQ';
addCSS('faq.css');
require_view('view/header.php');
?>

<h1>FAQ (Foire Aux Questions)</h1>

<main>
    <div class="container">
        <div class="strip"></div>
        <div class="text-area">
            <!-- loop through the faq -->
            <?php
            $i = 0;
            foreach ($faq as $elem) :
                $i++;
            ?>

                <div><button onclick="displayText('extraText<?= $i ?>')" class="BigButton">
                        <?=
                        $elem['question']
                        ?>
                    </button>
                    <div class="extra-text" id="extraText<?= $i ?>">
                        <?=
                        $elem['answer']
                        ?>
                    </div>
                </div>

            <?php endforeach ?>
        </div>
    </div>
    <script>
        function displayText(id) {
            var extraText = document.getElementById(id);
            extraText.classList.toggle('show-text');
        }
    </script>
</main>

<?php
require_view('view/footer.php');
?>