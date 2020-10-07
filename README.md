# lib-otp

Adalah library untuk menggenerasi OTP, module ini tidak mengirim SMS, aplikasi
bertanggungjawab bagaimana menyampaikan kode OTP tersebut ke user.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-otp
```

## Penggunaan

Module ini menambah satu library dengan nama `LibOtp\Library\Otp` yang bisa digunakan
untuk menggenerasi OTP dan memvalidasi OTP input user:

```php
use LibOtp\Library\Otp;

$u_phone = '081';
$u_otp = Otp::generate($u_phone);

$valid = Otp::validate($u_phone, $u_otp);
```

## Method

### static generate(string $identity, int $len=6, string $expires='+2 hour'): string

### static validate(string $identity, string $otp): bool