<h3>Логирование</h3>

<p>Добавить в confing/app.php в блок providers - Magnetar\Log\LogServiceProvider::class,</p>
<p>php artisan vendor:publish: миграции и конфиги. Или php artisan vendor:publish —provider="Magnetar\Log\LogServiceProvider"</p>
