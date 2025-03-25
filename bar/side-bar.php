
<aside id="sidebar">
    <h2>Shipment</h2>
    <ul>
        <li><a href="http://localhost:3000/ship/tracking.php">Track Shipment</a></li>
        <li><a href="http://localhost:3000/ship/book_form.php">Book Shipment</a></li>
        <li><a href="http://localhost:3000/ship/my_shipment.php">My Shipments</a></li>
        <li><a href="#">Service Check</a></li>
        <li><a href="http://localhost:3000/ship/estimate.php">Rate Calculator</a></li>
        <li><a href="#">Pickup Address</a></li>
    </ul>

    <h2>Account</h2>
    <ul>
        <li><a href="#">My Account</a></li>
        <li><a href="#">Wallet</a></li>
        <li><a href="#">COD Setting</a></li>
        <li><a href="#">COD Shipments</a></li>
        <li><a href="#">Settings</a></li>
    </ul>
    <form id="logoutForm" action="" method="POST">
        <button type="button" class="btn logout" onclick="confirmLogout()">Logout</button>
        <input type="hidden" name="logout" value="Logout">
    </form>
    <script>
        function confirmLogout() {
            const confirmation = confirm("Are you sure you want to log out?");
            if (confirmation) {
                document.getElementById('logoutForm').submit();
            }
        }

        const toggleButton = document.getElementById('toggle-button');
        const sidebar = document.getElementById('sidebar');

        // Toggle sidebar visibility
        toggleButton.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</aside>
