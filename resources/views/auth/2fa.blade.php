<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
    <style>
        /* Style for the modal */
        .modal {
            display: none; 
            position: fixed;
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            background-color: rgba(0, 0, 0, 0.5); 
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
        }

        .modal-button {
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .modal-button.cancel {
            background-color: #dc3545;
        }

        /* Timer styling */
        .timer {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Setup Two-Factor Authentication</h1>

    {{-- Display Secret Key --}}
    <p><strong>Secret Key:</strong> {{ $secret }}</p>

    {{-- Generate and display the QR code --}}
    <p><strong>Scan this QR code with your authentication app:</strong></p>
    <div>
        <img id="qrCode" src="{!! QrCode::size(200)->generate($qrCodeUrl) !!}" alt="QR Code">
    </div>

    {{-- Button to show the message box --}}
    <button class="modal-button" id="openModalBtn">Login</button>

    {{-- Modal Message Box --}}
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Important</h2>
            <p><strong>Make sure that you have already scanned or used the secret key for Two-Factor Authentication before continuing to the login page.</strong></p>
            <button class="modal-button cancel" id="cancelBtn">Cancel</button>
            <button class="modal-button" id="confirmBtn">Confirm</button>
        </div>
    </div>

    {{-- Timer Display --}}
    <p class="timer" id="countdownTimer">Time to refresh new QR code: 30 seconds</p>

    <script>
        // Get modal and buttons
        const modal = document.getElementById("modal");
        const openModalBtn = document.getElementById("openModalBtn");
        const cancelBtn = document.getElementById("cancelBtn");
        const confirmBtn = document.getElementById("confirmBtn");
        const countdownTimer = document.getElementById("countdownTimer");

        // Open the modal
        openModalBtn.onclick = function() {
            modal.style.display = "block";
        };

        // Close the modal (Cancel button)
        cancelBtn.onclick = function() {
            modal.style.display = "none";
        };

        // Redirect to login page (Confirm button)
        confirmBtn.onclick = function() {
            window.location.href = "/login"; // Replace with the correct login route
        };

        // Close modal if clicked outside of modal content
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        // Function to refresh the page every 30 seconds
        function refreshPage() {
            window.location.reload();  // Reload the page
        }

        // Countdown logic
        let countdownValue = 30; // Set countdown starting value
        function updateCountdown() {
            countdownTimer.textContent = `Time to refresh new QR code: ${countdownValue} seconds`;
            if (countdownValue === 0) {
                refreshPage(); // Refresh page when countdown reaches 0
            } else {
                countdownValue--; // Decrement the countdown value
            }
        }

        // Update the countdown every second (1000 ms)
        setInterval(updateCountdown, 1000);

        // Set page to refresh every 30 seconds (30000 ms)
        setTimeout(refreshPage, 30000);
    </script>
</body>
</html>
