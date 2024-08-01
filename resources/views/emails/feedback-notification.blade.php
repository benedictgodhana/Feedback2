<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Feedback Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #007BFF;
        }
        .content {
            padding: 20px;
            border-top: 1px solid #eee;
        }
        .content p {
            margin: 10px 0;
        }
        .content p strong {
            color: #007BFF;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Feedback Received</h1>
        </div>
        <div class="content">
            <p><strong>Category:</strong> {{ $feedback['category_name'] }}</p>
            <p><strong>Subject:</strong> {{ $feedback['subject'] }}</p>
            <p><strong>Subcategory:</strong> {{ $feedback['subcategory_name'] }}</p>
            <p><strong>Name:</strong> {{ $feedback['name'] }}</p>
            <p><strong>Email:</strong> {{ $feedback['email'] }}</p>
            <p><strong>Feedback:</strong> {{ $feedback['feedback'] }}</p>
        </div>
        <div class="footer">
            <p>Thank you for your attention.</p>
        </div>
    </div>
</body>
</html>
