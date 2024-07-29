<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<p>New feedback has been received:</p>
<p><strong>Category:</strong> {{ $feedback['category_id'] }}</p>
<p><strong>Subject:</strong> {{ $feedback['subject'] }}</p>
<p><strong>Subcategory:</strong> {{ $feedback['subcategory_id'] }}</p>
<p><strong>Name:</strong> {{ $feedback['name'] }}</p>
<p><strong>Email:</strong> {{ $feedback['email'] }}</p>
<p><strong>Feedback:</strong> {{ $feedback['feedback'] }}</p>

</body>
</html>
