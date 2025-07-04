<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact BSFE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'includes/header.php' ?>
    <div class="contact-container">
        <h2 class="contact-title">Contactez le BSFE</h2>
        <form class="contact-form" action="backend/php/contact.php" method="POST">
        <div class="input-group">
                <?php

                      if (isset($_SESSION["error"]) AND !empty($_SESSION["error"])) {
                        echo $_SESSION["error"] ;
                      }else {
                        echo ' ';
                      }

                ?>
            </div>
            <div class="input-group">
                <input type="text" placeholder="Nom" class="form-input" name="nom" required>
                <input type="text" placeholder="Prénom" class="form-input" name="prenom" required>
            </div>
            <textarea placeholder="Votre message" class="form-input" rows="5" name="message" required></textarea>
            <button type="submit" class="contact-btn">Envoyer le message</button>
        </form>
        <div class="contact-options">
            <a href="#" class="contact-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email">
                <span>Email</span>
            </a>
            <a href="#" class="contact-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="WhatsApp">
                <span>WhatsApp</span>
            </a>
            <a href="#" class="contact-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968764.png" alt="Messenger">
                <span>Messenger</span>
            </a>
            <a href="#" class="contact-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/4213/4213359.png" alt="Téléphone">
                <span>Téléphone</span>
            </a>

        </div>
    </div>
    <?php include 'includes/footer.php' ?>
    <script>
        // document.querySelector('.contact-form').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     alert('Message envoyé avec succès !');
        // });

        const icons = document.querySelectorAll('.contact-icon');
        icons.forEach(icon => {
            icon.addEventListener('click', function() {
                const text = this.querySelector('span').textContent;
                alert(`Redirection vers ${text}`);
            });
        });
    </script>
    <script src="scripts.js"></script>
</body>
</html>