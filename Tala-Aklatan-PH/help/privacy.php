<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Tala Aklatan</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>

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

<!-- Main Content Area -->
<div class="container mt-5">
    <div class="content-box">
        <h1>Privacy Policy</h1>
        <p>Welcome to Tala Aklatan. We value your privacy. This policy explains how we collect, use, and protect your information.</p>

        <h2>Information We Collect</h2>
        <p>We collect personal data such as your <span class="important">name</span>, <span class="important">email address</span>, and purchase history for the purpose of providing better service to you.</p>

        <h2>How We Use Your Information</h2>
        <p>We use your information to process orders, improve our services, and communicate with you regarding your account.</p>

        <h2>Data Protection</h2>
        <p>Your personal data is stored securely and is never shared with third parties without your consent, unless required by law.</p>

        <h2>Changes to This Policy</h2>
        <p>We may update this Privacy Policy from time to time. We encourage you to check this page regularly for any updates.</p>
    </div>
</div>

</body>
</html>
