<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Tala Aklatan</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        background-image: url('../img/PTC.jpg');
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
        color: #ffffff;
        overflow-x: hidden;
    }

    
    .container {
        margin-top: 80px; 
        padding: 0 20px;
        padding-top: 100px;
        padding-bottom: 50px;
    }

    
    .content-box {
        background-color: #ffffff; 
        padding: 30px;
        border: 2px solid #ff8c00; 
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }

    
    h1 {
        font-size: 36px;
        margin-bottom: 20px;
        color: #333;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        text-align: center;
        font-weight: bold; 
    }

    
    h2 {
        font-size: 30px;
        margin-top: 30px;
        color: #333;
        border-bottom: 3px solid #ff8c00; 
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: bold; 
    }

    
    p {
        font-size: 18px;
        color: #333;
        line-height: 1.8;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        max-width: 800px;
        margin: 0 auto 20px;
    }

    
    .important {
        font-weight: bold;
        color: #ff8c00; 
    }

    
    .form-box {
        background-color: #fff; 
        padding: 20px;
        border: 2px solid brown; 
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        margin-top: 40px;
    }

    
    .form-box button {
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        background-color: #ff8c00;
    }

    .form-box button:hover {
        background-color: #e07b00;
    }

   
    @media (max-width: 768px) {
        .container h1 {
            font-size: 32px;
        }

        .container p {
            font-size: 16px;
        }

        .form-box {
            padding: 15px;
        }

        h2 {
            font-size: 26px;
        }

        .content-box {
            padding: 25px;
        }
    }

    @media (max-width: 480px) {
        .container h1 {
            font-size: 28px;
        }

        .container p {
            font-size: 14px;
        }

        h2 {
            font-size: 22px;
        }

        .form-box {
            padding: 10px;
        }

        .content-box {
            padding: 15px;
        }
    }

</style>

<body>

<!-- Navigation Bar -->
<nav>
    <ul class="navbar">
        <li><img src="../img/logo.jpeg" alt="Tala Aklatan Logo" class="logo"></li>
        <li><a href="../index.php">Home</a></li>
        <li><a href="privacy.php">Privacy Policy</a></li>
        <li><a href="terms.php">Terms & Conditions</a></li>
        <li><a href="contact.php">Contact Us</a></li>
    </ul>
</nav>

<div class="container mt-5">
    <div class="content-box">
        <h1>Contact Us</h1>
        <p>If you have any questions or feedback, feel free to reach out to us using the form below:</p>

        <!-- Display Success or Error Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Contact Form -->
        <form id="contact-form" action="contact_form_handler.php" method="POST" onsubmit="return handleFormSubmit()">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>
    </div>
</div>

<!-- Modal for Form Submission Success -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel" style="color: green;">Message Sent Successfully</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="color:black;">
                Thank you for contacting us! We will get back to you soon.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function handleFormSubmit() {
        
        setTimeout(function() {
           
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        }, 500); 

       
        return false;
    }
</script>

</body>
</html>
