setup
-> composer install
-> env update

<!-- Before running migration do this -->
-> config/auth.php -> set default guard as admin
<!-- 
'defaults' => [
        'guard' => 'admin',
        'passwords' => 'users',
], 
-->
-> php artisan migrate:fresh --seed

<!-- After migration set default guard as web -->

-> php artisan key:generate