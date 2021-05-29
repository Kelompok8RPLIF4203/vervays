@component('mail::message')
{{-- Greeting --}}
# Hello!

Selamat Datang di Vervays

Langkah terakhir untuk membuat akun di Vervays adalah dengan memverifikasi email.
Untuk memferivikasi email, silakan klik tombol berikut

{{-- Action Button --}}
@component('mail::button', [
'url' => $url, 
'color' => 'red'])
Verifikasi Email
@endcomponent

Jika anda tidak mendaftar akun di Vervays, harap abaikan email ini

@endcomponent