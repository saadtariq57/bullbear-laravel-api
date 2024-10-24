<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    @if(!empty($data['address']))
        <p><strong>Address:</strong> {{ $data['address'] }}</p>
    @endif
    @if(!empty($data['phone']))
        <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
    @endif
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
    @if(!empty($data['message']))
        <p><strong>Message:</strong><br>{{ nl2br(e($data['message'])) }}</p>
    @endif
</body>
</html>
