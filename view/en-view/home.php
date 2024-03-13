<?php
$GLOBALS['PAGE_TITLE'] = 'Accueil | Sound In Shape';
// No Boostrap for the carousel to work
$GLOBALS['BOOTSTRAP'] = false;
addCSS('home.css');
require_view('view/header.php');
?>

<main>
    <div class="slideshow-container">

        <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <img src="<?= url('/view/img/image1.jpeg') ?>" style="width:100%">
            <div class="text">Caption One</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">2 / 5</div>
            <img src="<?= url('/view/img/image2.jpeg') ?>" style="width:100%">
            <div class="text">Caption Two</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">3 / 5</div>
            <img src="<?= url('/view/img/image3.jpeg') ?>" style="width:100%">
            <div class="text">Caption Three</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">4 / 5</div>
            <img src="<?= url('/view/img/image4.jpeg') ?>" style="width:100%">
            <div class="text">Caption Four</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">5 / 5</div>
            <img src="<?= url('/view/img/image5.jpeg') ?>" style="width:100%">
            <div class="text">Caption Five</div>
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br>

    <!-- The dots! -->
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>
    </div>

    <div class="overlay1">
        <h1>Sound in Shape</h1>
        <h2>Training Matters!</h2>
    </div>
    <div class="overlay2">
        <p>Actuellement, dans la salle :
            <select class="custom-select">
                <option value="option1">Paris 15</option>
                <option value="option2">Paris 16</option>
                <option value="option3">Paris 17</option>
                <option value="option4">Boulogne</option>
            </select>
        </p>
        <p><button id="decrease">-</button>
            45 dB
            <button id="increase">+</button>
        </p>
        <p>Titre: Chanson / Auteur </p>
    </div>
    <div class="overlay3">
        <h3>Our mission?</h3>
        <p>Help you achieve your goal. Offer you a sound environment adapted to your needs, according to your abilities, your availability and your objectives. We work on optimizing the sound that surrounds you in your sessions so that you give the best of yourself!</p>
    </div>

</main>

<script>
    $(document).ready(function() {
        let slideIndex = 1;
        showSlides(slideIndex);

        window.plusSlides = function(n) {
            showSlides(slideIndex += n);
        }

        window.currentSlide = function(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let slides = $(".mySlides");
            let dots = $(".dot");
            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }
            for (let i = 0; i < slides.length; i++) {
                $(slides[i]).hide();
            }
            for (let i = 0; i < dots.length; i++) {
                $(dots[i]).removeClass('active');
            }
            $(slides[slideIndex - 1]).show();
            $(dots[slideIndex - 1]).addClass('active');
        }
    });
</script>

<?php
require_view('view/footer.php');
?>