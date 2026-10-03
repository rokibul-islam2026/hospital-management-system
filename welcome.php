<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - City General Hospital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #007bff, #00d2ff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .welcome-card {
            background: #ffffff;
            padding: 35px 30px;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .welcome-card h1 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .welcome-card p {
            color: #555;
            font-size: 15px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .hospital-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            display: block;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #28a745;
            color: white;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="welcome-card">
        <h1>City General Hospital</h1>
        <p>সিটি জেনারেল হাসপাতালে আপনাকে স্বাগতম। আপনার স্বাস্থ্যসেবা নিশ্চিত করতে আমরা সর্বদা প্রস্তুত।</p>

        <!-- হাসপাতালের সুন্দর একটি ছবি -->
        <img src="https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?q=80&w=600&auto=format&fit=crop" alt="Hospital Building" class="hospital-img">

        <div class="btn-group">
            <a href="index.php" class="btn btn-primary">Book Patient Appointment</a>
            <!-- পাসওয়ার্ড দিয়ে ঢোকার জন্য login.php দেওয়া হলো -->
            <a href="login.php" class="btn btn-secondary">Admin & Doctor Portal</a>
        </div>
    </div>

</body>
</html>