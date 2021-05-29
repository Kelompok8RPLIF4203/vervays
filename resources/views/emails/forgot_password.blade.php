@component('mail::message')
{{-- Greeting --}}
# Hallo {{ $firstName }},

Permintaan untuk mengubah password pada akunmu telah diterima.
Klik tombol berikut untuk reset password.

{{-- Action Button --}}
@component('mail::button', [
'url' => $url, 
'color' => 'red'])
Reset Password
@endcomponent

Jika kamu tidak meminta reset password, abaikan email ini

@endcomponent