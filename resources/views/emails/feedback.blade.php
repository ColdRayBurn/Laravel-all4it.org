<!DOCTYPE html>
<html>
<head>
    <title>Новое сообщение обратной связи</title>
</head>
<body>
<h1>Новое сообщение обратной связи</h1>
<p><strong>Имя:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Компания:</strong> {{ $data['companyName'] }}</p>
<p><strong>Телефон:</strong> {{ $data['phoneNumber'] }}</p>
<p><strong>Комментарий:</strong></p>
<p>{{ $data['comment'] }}</p>
</body>
</html>
