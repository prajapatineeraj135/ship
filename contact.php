<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="images/favicon_io/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <title>Home</title>
</head>
<body>
    <!-- import nav-bar and side-bar from images/bar folder -->
    <?php
    include 'bar/nav-bar.php';
    ?>
    <main>
        <section class="header">
            <div class="header-content">
                <h1>Contact Us</h1>
            </div>
        </section>
        
        <!-- Contact Options Section -->
        <section class="contact-options">
            <div class="contact-item">
                <i class="icon-call"><img src="images/foot-icon/call.png" alt="Call icon"></i>
                <p>Call</p>
            </div>
            <div class="contact-item">
                <i class="icon-find"><img src="images/foot-icon/location.png" alt="Location icon"></i>
                <p>Find</p>
            </div>
            <div class="contact-item">
                <i class="icon-chat"><img src="images/foot-icon/whatsapp.png" alt="Whatsapp icon"></i>
                <p>Chat</p>
            </div>
            <div class="contact-item">
                <i class="icon-follow"><img src="images/foot-icon/instagram.png" alt="Instagram icon"></i>
                <p>Follow</p>
            </div>
            <div class="contact-item">
                <i class="icon-like"><img src="images/foot-icon/facebook.png" alt="Facebook icon"></i>
                <p>Like</p>
            </div>
            <div class="contact-item">
                <i class="icon-join"><img src="images/foot-icon/telegram.png" alt="Telegram icon"></i>
                <p>Join</p>
            </div>
        </section>

        <section class="contact">
        
        <form action="#" method="post" class="contact-form">
        <h2>Get in Touch</h2>
        <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your email" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" placeholder="Your contact" required>

            <label for="topic">Topic:</label>
            <select name="topic" id="topic">
                <option value="" disabled selected>Select Your Topic</option>
                <option value="account">Account</option>
                <option value="shpment">Shipment</option>
                <option value="wellet">Wellet</option>
                <option value="other">Other</option>
            </select>
            

            <label for="message">Message</label>
            <input type="text"  id="message" name="message" placeholder="Message">
            <button type="submit" name="submit">Submit</button>
        </form>
    </section>
        <section class="details">
            <div class="col">
            <h2>Details</h2>
            <h4>Name:</h4>
            <p>Shipet™</p>
            <h4>Address:</h4>
            <p>Kota-06 Rajasthan</p>
            <h4>Phone:</h4>
            <p>+91-9509930493</p>
            <h4>Email:</h4>
            <p>contact@shipet.in</p>
            </div>
            <div class="col">
            <h2>Documents</h2>
            <p><strong>GST</strong> Verified</p>
            <p><strong>MSME</strong> Verified</p>
            <p><strong>BRN</strong> Verified</p>
            <p><strong>TM</strong> Verified</p>
            </div>
            <div class="col">
            <h2>Social Media</h2>
            <p><strong>WhatsApp</strong><a href=""> Click Here</a></p>
            <p><strong>Instagram</strong><a href=""> @shipet.in</a></p>
            <p><strong>Telegram</strong><a href=""> @shipet.in</a></p>
            <p><strong>Facebook</strong><a href=""> @shipet.in</a></p>
            </div>
            <div class="col">
            <h2>Location</h2>
            <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2921.458308289162!2d75.84165686490579!3d25.182503319000663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396f9bf40dc84eb9%3A0xb161a3852089b404!2zUGV0c2hhbGHihKI!5e0!3m2!1sen!2sin!4v1741607798849!5m2!1sen!2sin" style="border: 2px solid; width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
            </div>
        </section>

        
    </main>
    <!-- import here footer file from images/bar/footer.php -->
    <footer>
        <?php include 'bar/footer.php'; ?>
    </footer>
</body>
</html>
<style>
    /* Header Section */
    .header {
        background-color: rgb(250, 250, 150);
        text-align: center;
        padding: 20px 0;
        border-radius: 50px 10px 50px 10px;
    }
    .header h1 {
        font-family: 'Autour One', sans-serif;
        color: #000000;
        margin-bottom: 10px;
    }
    @media (max-width: 768px) {
        .header h1 {
            font-size: 30px;
        }
    }
    @media (max-width: 480px) {
        .header h1 {
            font-size: 24px;
            line-height: 1.6em;
        }
    }
    /* Contact Options Section */
    .contact-options {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        padding: 20px;
    }
    .details {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        padding: 20px;
    }

    .details h2  {
        margin-bottom: 15px;
    }
    .details p {

        margin-bottom: 10px;
    }
    .contact-item {
        text-align: center;
    }
    .contact-item i {
        font-size: 25px;
        color: #000000;
        display: block;
        margin-top: 15px;
    }
    .contact-item p {
        font-size: 20px;
    }
    /* Responsive for mobile */
    @media (max-width: 480px) {
        .contact-options {
            grid-template-columns: repeat(3, 1fr);
        }
        .contact-item p {
            font-size: 15px;
        }
        .details {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 10px;
        }
    }

/* Contact Form Section */
.contact {
    width: 50%;
    padding: 40px;
    margin: 40px auto;
    background-color: #f9f9f9;
    text-align: center;
    border-radius: 1em 3em 1em 1em;
    box-shadow: 10px 10px 10px black;
}

.contact-form h2 {

    margin-bottom: 10px;
    font-size: 30px;
    color: black;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.contact-form label {
    font-size: 14px;
    color: #333;
    text-align: left;
    font-weight: bold;
}

.contact-form input,select {
    padding: 6px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    
}

.contact-form #message {
    height: 100px;
}
.contact-form button {
    padding: 15px;
    font-size: 18px;
    width: 200px;
    align-self: self-end;
    background-color: #fdc732;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.2s ease;
}

.contact-form button:hover {
    background-color: #e0a700;
}

/* Responsive for smaller screens */
@media (max-width: 768px) {
    .contact {
        width: 90%;
        padding: 20px;
    }
    .contact-form button {
   width: 100px;
}
}

</style>