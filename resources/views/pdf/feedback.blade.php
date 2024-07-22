<!DOCTYPE html>
<html>
<head>
    <title>Feedbacks</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h1>Feedbacks</h1>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->category->name ?? 'N/A' }}</td>
                    <td>{{ $feedback->subcategory->name ?? 'N/A' }}</td>
                    <td>{{ $feedback->name }}</td>
                    <td>{{ $feedback->email }}</td>
                    <td>{{ $feedback->subject }}</td>
                    <td>{{ $feedback->feedback }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
    