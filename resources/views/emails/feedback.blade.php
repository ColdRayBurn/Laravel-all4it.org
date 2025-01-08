<!DOCTYPE html>
<html>
<head>
    <title>Новое сообщение обратной связи</title>
</head>
<body>
<h1>Новое сообщение обратной связи</h1>

@isset($data['name'])
    <p><strong>Имя:</strong> {{ $data['name'] }}</p>
@endisset

<p><strong>Email:</strong> {{ $data['email'] }}</p>

@isset($data['companyName'])
    <p><strong>Компания:</strong> {{ $data['companyName'] }}</p>
@endisset

@isset($data['phoneNumber'])
    <p><strong>Телефон:</strong> {{ $data['phoneNumber'] }}</p>
@endisset

@isset($data['comment'])
    <p><strong>Комментарий:</strong></p>
    <p>{{ $data['comment'] }}</p>
@endisset

</body>
</html>
