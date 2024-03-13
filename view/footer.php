<?php

#echo __FILE__ . '<br>';

?>

<footer>
    <div class="footer-left">
        <a href="<?= url('/faq') ?>">FAQ</a>
        <a href="<?= url('/cgu') ?>">Conditions Générales d'Utilisation</a>
        <a href="<?= url('/legal') ?>">Mentions Légales</a>
        <p>&copy; 2023 Sound In Shape. Tous droits réservés.</p>
    </div>
    <div class="footer-center" id="qrcode">
        <img src="<?= url('/view/img/qr-code.png') ?>" alt="QR Code">
    </div>
    <div class="footer-right" id="general-info">
        <img src="<?= url('/view/img/general-info.png') ?>" alt="Image Info Pratique">
    </div>

</footer>

</body>

</html>