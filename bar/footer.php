<div class="section">
    <h2>About</h2>
    <div class="footer-section">
        <div class="col">
            <h3>Account</h3>
            <ul>
                <li><img src="images/foot-icon/my-account.png" alt="My Account"><a href="#">My Account</a></li>
                <li><img src="images/foot-icon/my-shipment.png" alt="My Shipment"><a href="#">My Shipment</a></li>
                <li><img src="images/foot-icon/my-wellet.png" alt="My Wellet"><a href="#">My Wallet</a></li>
                <li><img src="images/foot-icon/my-invoice.png" alt="My Invoice"><a href="#">My Invoices</a></li>
            </ul>
        </div>
        <div class="col">
            <h3>Support</h3>
            <ul>
                <li><img src="images/foot-icon/call.png" alt="Call Us"><a href="http://localhost:3000/ship/contact.php">Call Us</a></li>
                <li><img src="images/foot-icon/email.png" alt="Mail Us"><a href="http://localhost:3000/ship/contact.php">Mail Us</a></li>
                <li><img src="images/foot-icon/video.png" alt="Tutorials"><a href="#">Tutorials</a></li>
                <li><img src="images/foot-icon/question.png" alt="Ack Query"><a href="#">Ask Query</a></li>
            </ul>
        </div>
        <div class="col">
            <h3>Connect Us</h3>
            <ul>
                <li><img src="images/foot-icon/instagram.png" alt="Instagram"><a href="http://localhost:3000/ship/contact.php">Instagram</a></li>
                <li><img src="images/foot-icon/facebook.png" alt="Facebook"><a href="http://localhost:3000/ship/contact.php">Facebook</a></li>
                <li><img src="images/foot-icon/youtube.png" alt="Youtube"> <a href="http://localhost:3000/ship/contact.php">YouTube</a></li>
                <li><img src="images/foot-icon/linkedin.png" alt="Linkedin"><a href="http://localhost:3000/ship/contact.php">LinkedIn</a></li>
            </ul>
        </div>
        <div class="col">
            <h3>About Us</h3>
            <ul>
                <li><img src="images/foot-icon/about.png" alt="About Us"><a href="about.php?section=our-info">Our Info</a></li>
                <li><img src="images/foot-icon/refer.png" alt="Refer & Earn"><a href="about.php?section=refer">Refer & Earn</a></li>
                <li><img src="images/foot-icon/privacy.png" alt="Privacy Policy"><a href="about.php?section=policy">Privacy Policy</a></li>
                <li><img src="images/foot-icon/term.png" alt="Our T&C"><a href="about.php?section=terms">Our T&C </a></li>
            </ul>
        </div>
    </div>
</div>

<style>
    .footer-section {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        /* 4 equal columns */
        gap: 10px;
        padding: 10px 10px 10px 30px;
    }

    .col h3 {
        align-self : left;
        margin-bottom: 10px;
    }

    .col ul {
        list-style: none;
        padding: 0;
    }

    .col ul li {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    /* Optional styling for the footer links */
    .col ul li:hover {
        color: #1fa9ff;
        /* Optional hover color */
        cursor: pointer;
    }

    .col ul li a {
        font-size: small;
    }

    .col ul li img {
        width: 20px;
        margin-right: 5px;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .footer-section {
            grid-template-columns: repeat(2, 1fr);
            /* 2 columns for medium screens */
        }
        .col{
            margin-left: 0px ;
        }
        .col ul li a {
            font-size: small;
        }
    }
</style>