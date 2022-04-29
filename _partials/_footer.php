<footer id="footer" class="bg-light">
    <div class="container p-4">
        <div class="row">
            <div class="col-md">
                <div class="row">
                    <div class="col">
                        <h4 class="text-primary">Pages</h4>
                        <a href="/">Home</a><br>
                        <a href="coins.php">Coins</a><br>
                        <a href="contact.php">Contact</a><br>
                    </div>
                    <div class="col">
                        <h4 class="text-primary">Contact</h4>
                        <a href="contact.php">Contact form</a><br>
                        <a href="mailto:info@website.com">info@website.com</a><br>
                    </div>
                </div>
            </div>
            <div class="col">
                <h3 class="text-secondary">Lorem ipsum</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet viverra blandit. Vivamus nec lacus vitae quam consequat ornare. Integer vel augue nec orci venenatis eleifend vel at ex. Ut hendrerit, ante nec molestie ornare, ante lectus pretium lectus, id faucibus erat ipsum sit amet enim. Morbi auctor, neque et venenatis posuere, dui nisl tempus risus, id eleifend dolor ligula nec sapien.
                </p>
            </div>
        </div>
    </div>
</footer>
<script src="public/js/app.js"></script>
<?php
if (isset($_SESSION['id'])) {
    ?>
        <script src="public/js/admin.js"></script>
    <?php
}
?>