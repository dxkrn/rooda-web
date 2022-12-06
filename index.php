<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome! - Rooda</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon/icon_favicon.png">
</head>

<body>
    <section>
        <div class="circle"></div>
        <header>
            <a href="index">
                <image src="assets/img/logo/logo_rooda.png" class="logo">
            </a>
            <div class="toggle" onclick="toggleMenu()"></div>
            <ul class="navigation">
                <li><a href="index" class="activePage">Home</a></li>
                <li><a href="katalogMotor">Katalog</a></li>
                <!-- <li><a href="#">About</a></li> -->
                <li><a href="login">Login</a></li>
            </ul>
        </header>
        <div class="content">
            <div class="textBox">
                <h2>Color Up Your Day,<br>With <span>Rooda</span></h2>
                <p>
                    Find your dream motorbike, explore the streets together, and make your journey more awesome.
                </p>
                <a href="katalogMotor">Explore Now</a>
            </div>
            <div class="imgBox">
                <img src="assets/img/landing/thumb1.png" class="motors">
            </div>
        </div>
        <ul class="thumb">
            <li><img src="assets/img/landing/thumb1.png" onclick="imgSlider('assets/img/landing/thumb1.png'); changeCricleColor('#A2CFB8')"></li>
            <li><img src="assets/img/landing/thumb2.png" onclick="imgSlider('assets/img/landing/thumb2.png'); changeCricleColor('#E56931')"></li>
            <li><img src="assets/img/landing/thumb3.png" onclick="imgSlider('assets/img/landing/thumb3.png'); changeCricleColor('#2F4537')"></li>
        </ul>
        <ul class="sci">
            <li><a href="#"><img src="assets/img/icons/facebook.png"></a></li>
            <li><a href="#"><img src="assets/img/icons/twitter.png"></a></li>
            <li><a href="#"><img src="assets/img/icons/instagram.png"></a></li>
        </ul>
    </section>

    <script type="text/javascript">
        function imgSlider(anything) {
            document.querySelector('.motors').src = anything;
        }

        function changeCricleColor(color) {
            const circle = document.querySelector('.circle');
            circle.style.background = color;
        }

        function toggleMenu() {
            var menuToggle = document.querySelector('.toggle');
            var navigation = document.querySelector('.navigation')
            menuToggle.classList.toggle('active')
            navigation.classList.toggle('active')
        }
    </script>

</body>

</html>