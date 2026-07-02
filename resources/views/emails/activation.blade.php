<!DOCTYPE html>
<html>
<head>
    <title>Активация аккаунта</title>
</head>
<body>
    <h2>Здравствуйте, {{ $customer->name }}!</h2>
    <p>Спасибо за регистрацию на нашем сайте.</p>
    <p>Для активации вашего аккаунта, пожалуйста, перейдите по ссылке ниже:</p>
    <p><a href="{{ $activationUrl }}" style="padding: 10px 20px; background: #000; color: #fff; text-decoration: none; display: inline-block;">Активировать аккаунт</a></p>
    <p>Если ссылка не нажимается, скопируйте её в браузер: {{ $activationUrl }}</p>
</body>
</html>
