
# Peduly



## Indices

* [Auth](#auth)

  * [Login](#1-login)
  * [Register](#2-register)
  * [Logout](#3-logout)
  * [Check email verif](#4-checkemailverif)
  * [Send email verif](#-sendemailverif) 

* [Doa](#doa)

  * [All Doa](#1-all-doa)
  * [Specific Doa](#2-specific-doa)

* [Donation](#donation)

  * [All Donation](#1-all-donation)
  * [Check Referal](#2-check-referal)
  * [Submit donation](#3-submit-donation)
  * [Donation Bank](#4-donation-bank)
  * [Donation Emoney](#5-donation-emoney)

* [Fundraiser](#fundraiser)

  * [Change To Approve](#1-change-to-approve)
  * [Change To Ditolak](#2-change-to-ditolak)
  * [Data Donatur](#3-data-donatur)
  * [Donation By Referal](#4-donation-by-referal)
  * [Ringkasan harian](#5-ringkasan-harian)

* [Galang Dana](#galang-dana)

  * [All](#1-all)
  * [Specific](#2-specific)
  * [Specific By Slug](#3-specific-by-slug)
  * [Buat Galangdana](#4-buat-galangdana)

* [Password](#password)

  * [Reset Password](#1-reset-password)
  * [Send Reset Email](#2-send-reset-email)

* [Token](#token)

  * [Get CSRF Token](#1-get-csrf-token)

* [User](#user)

  * [All Pekerjaan](#1-all-pekerjaan)
  * [All Organisasi](#2-all-organisasi)
  * [Provinsi](#3-provinsi)
  * [Kabupaten](#4-kabupaten)
  * [Kecamatan](#5-kecamatan)
  * [Edit Profil](#6-edit-profil)

* [Search](#search)

* [Riwayat Donasi](#riwayat-donasi)

  * [Details Riwayat](#1-details-riwayat)

--------


## Auth



### 1. Login



***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/auth/login
```



***Query body:***

| Key | Value | Description |
| --- | ------|-------------|
| email | lazu@mail.com |  |
| password | Password123 |  |



***More example Requests/Responses:***



##### I. Example Response: Login
```js
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYzODg2ODM5MSwiZXhwIjoxNjM4ODcxOTkxLCJuYmYiOjE2Mzg4NjgzOTEsImp0aSI6IjByS1AwSFVncVpudHBjaEMiLCJzdWIiOjIxMTEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.KYUHlQ0fUEwQp6jjKQp3XqhFfMpR8H5lFJWuV_ZsTXM"
}
```



***Status Code:*** 200

<br>



### 2. Register



***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/auth/register
```



***Query body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | lazu |  |
| email | lazu@mail.com |  |
| password | Password123 |  |



***More example Requests/Responses:***


##### I. Example Response: Register
```js
{
    "user": {
        "name": "mamat",
        "email": "usercoba5@mail.com",
        "updated_at": "2021-12-07T09:12:56.000000Z",
        "created_at": "2021-12-07T09:12:56.000000Z",
        "id": 2111
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9yZWdpc3RlciIsImlhdCI6MTYzODg2ODM3NiwiZXhwIjoxNjM4ODcxOTc2LCJuYmYiOjE2Mzg4NjgzNzYsImp0aSI6Inh6NlNvYkdGb0dVREd3NkciLCJzdWIiOm51bGwsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.8PemYKa_Bc9uykdtbtEG3YpVUyflO807lVOL0dNYW5Y"
}
```



***Status Code:*** 201

<br>


### 3. Logout



***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/auth/logout
```



***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Authorization | Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYzODg2ODM5MSwiZXhwIjoxNjM4ODcxOTkxLCJuYmYiOjE2Mzg4NjgzOTEsImp0aSI6IjByS1AwSFVncVpudHBjaEMiLCJzdWIiOjIxMTEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.KYUHlQ0fUEwQp6jjKQp3XqhFfMpR8H5lFJWuV_ZsTXM |  |



***More example Requests/Responses:***



##### I. Example Response: Logout
```js
{
    "error": false,
    "message": "auth.logged_out"
}
```



***Status Code:*** 200

<br>



## Doa



### 1. All Doa



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/doa
```



***More example Requests/Responses:***


##### I. Example Request: All Doa



##### I. Example Response: All Doa
```js
[
    {
        "id": 1,
        "user_id": 24,
        "body": "Semoga donasi saya bisa bermanfaat buat korban bencana. Saya ikut sedih mendengar kabar ini.",
        "created_at": "2021-08-12T13:47:43.000000Z",
        "updated_at": "2021-08-12T13:47:43.000000Z"
    },
    {
        "id": 2,
        "user_id": 24,
        "body": "Semoga berkat selalu ada untuk kita di hari ini. Amin.",
        "created_at": "2021-08-12T15:06:29.000000Z",
        "updated_at": "2021-08-12T15:06:29.000000Z"
    }
]
```


***Status Code:*** 200

<br>



### 2. Specific Doa



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/doa/1
```



***More example Requests/Responses:***


##### I. Example Request: Specific Doa



##### I. Example Response: Specific Doa
```js
{
    "data": {
        "doa": {
            "id": 1,
            "user_id": 24,
            "body": "Semoga donasi saya bisa bermanfaat buat korban bencana. Saya ikut sedih mendengar kabar ini.",
            "created_at": "2021-08-12T13:47:43.000000Z",
            "updated_at": "2021-08-12T13:47:43.000000Z",
            "user": {
                "id": 24,
                "socialite_id": null,
                "socialite_name": null,
                "name": "Peduly Surabaya",
                "role": "User",
                "tipe": "pribadi",
                "username": "pedulysurabaya",
                "email": "pedulysurabaya@gmail.com",
                "email_verified_at": "2019-11-06T10:03:03.000000Z",
                "status_akun": "Verified",
                "no_telp": "085706611112",
                "usia": null,
                "jenis_kelamin": null,
                "alamat": null,
                "tempat_lahir": null,
                "tanggal_lahir": null,
                "pekerjaan": null,
                "lembaga": null,
                "photo": "1313027184.png",
                "foto_ktp": null,
                "bank": null,
                "no_rek": null,
                "created_at": "2019-11-06T09:48:24.000000Z",
                "updated_at": "2019-11-06T16:37:53.000000Z"
            }
        },
        "user": {
            "id": 24,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Peduly Surabaya",
            "role": "User",
            "tipe": "pribadi",
            "username": "pedulysurabaya",
            "email": "pedulysurabaya@gmail.com",
            "email_verified_at": "2019-11-06T10:03:03.000000Z",
            "status_akun": "Verified",
            "no_telp": "085706611112",
            "usia": null,
            "jenis_kelamin": null,
            "alamat": null,
            "tempat_lahir": null,
            "tanggal_lahir": null,
            "pekerjaan": null,
            "lembaga": null,
            "photo": "1313027184.png",
            "foto_ktp": null,
            "bank": null,
            "no_rek": null,
            "created_at": "2019-11-06T09:48:24.000000Z",
            "updated_at": "2019-11-06T16:37:53.000000Z"
        }
    }
}
```


***Status Code:*** 200

<br>



## Donation

### 1. All Donation



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/donation/all
```



***More example Requests/Responses:***


##### I. Example Request: All Donation



##### I. Example Response: All Donation
```js
[
    {
        "id": 256,
        "user_id": 562,
        "nama": "kevin",
        "campaign_id": 30,
        "judul_slug": "bangun-rumah-singgah-surabaya",
        "biaya_persen": 15,
        "donasi": "20000",
        "kode_donasi": "0",
        "prantara_donasi": "Fundriser",
        "metode_pembayaran": null,
        "nomor_va": null,
        "email": "dauliacitra@gmail.com",
        "nomor_telp": null,
        "status_donasi": "Approved",
        "status_pembayaran": null,
        "snap_token": null,
        "payment_url": null,
        "status_pemberian_pertama": null,
        "foto_pertama": null,
        "status_pemberian_kedua": null,
        "foto_kedua": null,
        "status_pemberian_ketiga": null,
        "foto_ketiga": null,
        "status_terbaru": null,
        "komentar": null,
        "tanggal_donasi": null,
        "deadline": null,
        "created_at": "2021-04-19T06:47:45.000000Z",
        "updated_at": "2021-04-19T06:47:45.000000Z"
    },
]
```


***Status Code:*** 200

<br>

### 2. Check Referal



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/donation/checkreferal
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| referal | PDL1234 |  |



***More example Requests/Responses:***


##### I. Example Request: Check Referal



***Query:***

| Key | Value | Description |
| --- | ------|-------------|
| referal | PDL1234 |  |



##### I. Example Response: Check Referal
```js
{
    "msg": "kode referal ada",
    "status": 201,
    "data": [
        {
            "kode_referal": "PDL1234"
        }
    ]
}
```


***Status Code:*** 200

<br>



### 3. Submit donation



***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/donation
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| nominal | 20000 |  |
| metode | cod |  |
| nama_lengkap | lazu |  |
| alamat_email | lazuardi.akhmad@gmail.com |  |
| nomor_ponsel | 0812312312 |  |
| kode_referensi | 321 |  |
| pesan_baik | Semoga lekas sembuh |  |
| user_id | 1 |  |
| campaign_id | 1 |  |



***More example Requests/Responses:***

##### I. Example Response: Submit donation
```js
{
    "status": 201,
    "msg": "success"
}
```


***Status Code:*** 200

<br>


### 4. Donation Bank

***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/donation/bank_transfer
```

***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| nominal | 20000 |  |
| metode | bank_transfer |  |
| nama_lengkap | lazu |  |
| alamat_email | lazuardi.akhmad@gmail.com |  |
| nomor_ponsel | 0812312312 |  |
| kode_referensi | 321 |  |
| pesan_baik | Semoga lekas sembuh |  |
| user_id | 1 |  |
| campaign_id | 1 |  |
| bank_name | bni/permata/mandiri |  |


***More example Requests/Responses:***

##### I. Example Request: Donation Bank

***Query:***
| Key | Value | Description |
| --- | ------|-------------|
| nominal | 20000 |  |
| metode | bank_transfer |  |
| nama_lengkap | lazu |  |
| alamat_email | lazuardi.akhmad@gmail.com |  |
| nomor_ponsel | 0812312312 |  |
| kode_referensi | 321 |  |
| pesan_baik | Semoga lekas sembuh |  |
| user_id | 1 |  |
| campaign_id | 1 |  |
| bank_name | bni/permata/mandiri |  |



##### I. Example Response: Donation Bank
```js
{   
    "data": {
        "id": 1977,
        "user_id": 1,
        "nama": "Juan Angela Alma",
        "campaign_id": 1055,
        "judul_slug": null,
        "biaya_persen": 15,
        "donasi": "7000",
        "kode_donasi": "INV16584614482087",
        "prantara_donasi": null,
        "metode_pembayaran": "bank_transfer",
        "nomor_va": null,
        "email": "juanalmaaa@gmail.com",
        "nomor_telp": "83111064482",
        "status_donasi": "Pending",
        "status_pembayaran": null,
        "snap_token": null,
        "payment_url": null,
        "status_pemberian_pertama": null,
        "foto_pertama": null,
        "status_pemberian_kedua": null,
        "foto_kedua": null,
        "status_pemberian_ketiga": null,
        "foto_ketiga": null,
        "status_terbaru": null,
        "komentar": null,
        "deadline": "2022-07-23 10:44:08",
        "tanggal_donasi": "2022-07-22",
        "created_at": "2022-07-22T03:44:10.000000Z",
        "updated_at": null,
        "midtrans_response": {
            "status_code": "201",
            "status_message": "Success, Bank Transfer transaction is created",
            "transaction_id": "f3ea0941-e3e7-48ec-b766-acfae6bc1fad",
            "order_id": "INV16584614482087",
            "merchant_id": "G214967260",
            "gross_amount": "7000.00",
            "currency": "IDR",
            "payment_type": "bank_transfer",
            "transaction_time": "2022-07-22 10:44:33",
            "transaction_status": "pending",
            "va_numbers": [
                {
                    "bank": "bni",
                    "va_number": "9886726063363587"
                }
            ],
            "fraud_status": "accept"
        },
        "campaign": {
            "id": 1055,
            "user_id": 2194,
            "judul_campaign": "Bantu permakanan dan biaya sekolah anak serta pemasangan keramik lantai  panti asuhan",
            "judul_slug": "bantu-permakanan-dan-biaya-sekolah-anak-serta-pemasangan-keramik-lantai-panti-asuhan",
            "foto_campaign": "bantu-permakanan-dan-biaya-sekolah-anak-serta-pemasangan-keramik-lantai-panti-asuhan.jpg",
            "nominal_campaign": 30000000,
            "tag_campaign": null,
            "regencies": "kota surabaya",
            "batas_waktu_campaign": "2022-09-09",
            "detail_campaign": "Kami pengelola panti asuhan yabip yang saat ini mengasuh 26 anak yatim dan piatu. Berdiri dengan SK. Lembaga kesejahteraan sosial anak no. AHU-0079611.AH.01.07 tahun 2016\r\nSaat ini kami memiliki 3 panti asuhan.yang 2 sudah beroperasi.  Dan yg satu lagi msh pembangunan 30%. Tujuan penggalangan dana ini adalah untuk membiayai permakana dan biaya sekolah anak asuh serta pembelian keramik untuk menyelesaikan finishing lantai panti asuhan yabip 3. Karena akan segera kami operasional kan. Mengingat panti 1 dan 2 sudah penuh. Sehingga anak anak penghuni yg baru masuk akan kami tempatkan di panti 3.",
            "update_campaign": null,
            "kategori_campaign": "Panti Asuhan",
            "status": "Approved",
            "created_at": "2022-07-07T06:31:04.000000Z",
            "updated_at": "2022-07-07T06:31:04.000000Z",
            "deleted_at": null
        }
    },
    "msg": "success"
}
```
***Status Code:*** 201

### 5. Donation Emoney

***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/donation/emoney
```

***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| nominal | 20000 |  |
| metode | emoney |  |
| nama_lengkap | lazu |  |
| alamat_email | lazuardi.akhmad@gmail.com |  |
| nomor_ponsel | 0812312312 |  |
| kode_referensi | 321 |  |
| pesan_baik | Semoga lekas sembuh |  |
| user_id | 1 |  |
| campaign_id | 1 |  |
| emoney_name | gopay |  |


***More example Requests/Responses:***

##### I. Example Request: Donation Emoney

***Query:***
| Key | Value | Description |
| --- | ------|-------------|
| nominal | 20000 |  |
| metode | emoney |  |
| nama_lengkap | lazu |  |
| alamat_email | lazuardi.akhmad@gmail.com |  |
| nomor_ponsel | 0812312312 |  |
| kode_referensi | 321 |  |
| pesan_baik | Semoga lekas sembuh |  |
| user_id | 1 |  |
| campaign_id | 1 |  |
| emoney_name | gopay |  |

##### I. Example Response: Donation Emoney
```js
{
    "data": {
        "id": 1980,
        "user_id": 1,
        "nama": "Juan Angela Alma",
        "campaign_id": 1055,
        "judul_slug": null,
        "biaya_persen": 15,
        "donasi": "100000000",
        "kode_donasi": "INV16584616810726",
        "prantara_donasi": null,
        "metode_pembayaran": "emoney",
        "nomor_va": null,
        "email": "juanalmaaa@gmail.com",
        "nomor_telp": "83111064482",
        "status_donasi": "Pending",
        "status_pembayaran": null,
        "snap_token": null,
        "payment_url": null,
        "status_pemberian_pertama": null,
        "foto_pertama": null,
        "status_pemberian_kedua": null,
        "foto_kedua": null,
        "status_pemberian_ketiga": null,
        "foto_ketiga": null,
        "status_terbaru": null,
        "komentar": null,
        "deadline": "2022-07-23 10:48:01",
        "tanggal_donasi": "2022-07-22",
        "created_at": "2022-07-22T03:48:01.000000Z",
        "updated_at": null,
        "midtrans_response": {
            "status_code": "201",
            "status_message": "GoPay transaction is created",
            "transaction_id": "ce805284-25c3-450c-9e55-e035656c1f15",
            "order_id": "INV16584616810726",
            "merchant_id": "G214967260",
            "gross_amount": "100000000.00",
            "currency": "IDR",
            "payment_type": "gopay",
            "transaction_time": "2022-07-22 10:48:07",
            "transaction_status": "pending",
            "fraud_status": "accept",
            "actions": [
                {
                    "name": "generate-qr-code",
                    "method": "GET",
                    "url": "https://api.sandbox.midtrans.com/v2/gopay/ce805284-25c3-450c-9e55-e035656c1f15/qr-code"
                },
                {
                    "name": "deeplink-redirect",
                    "method": "GET",
                    "url": "https://simulator.sandbox.midtrans.com/gopay/partner/app/payment-pin?id=75a8ed9e-ae43-46d3-81d4-5d776be3153c"
                },
                {
                    "name": "get-status",
                    "method": "GET",
                    "url": "https://api.sandbox.midtrans.com/v2/ce805284-25c3-450c-9e55-e035656c1f15/status"
                },
                {
                    "name": "cancel",
                    "method": "POST",
                    "url": "https://api.sandbox.midtrans.com/v2/ce805284-25c3-450c-9e55-e035656c1f15/cancel"
                }
            ]
        },
        "campaign": {
            "id": 1055,
            "user_id": 2194,
            "judul_campaign": "Bantu permakanan dan biaya sekolah anak serta pemasangan keramik lantai  panti asuhan",
            "judul_slug": "bantu-permakanan-dan-biaya-sekolah-anak-serta-pemasangan-keramik-lantai-panti-asuhan",
            "foto_campaign": "bantu-permakanan-dan-biaya-sekolah-anak-serta-pemasangan-keramik-lantai-panti-asuhan.jpg",
            "nominal_campaign": 30000000,
            "tag_campaign": null,
            "regencies": "kota surabaya",
            "batas_waktu_campaign": "2022-09-09",
            "detail_campaign": "Kami pengelola panti asuhan yabip yang saat ini mengasuh 26 anak yatim dan piatu. Berdiri dengan SK. Lembaga kesejahteraan sosial anak no. AHU-0079611.AH.01.07 tahun 2016\r\nSaat ini kami memiliki 3 panti asuhan.yang 2 sudah beroperasi.  Dan yg satu lagi msh pembangunan 30%. Tujuan penggalangan dana ini adalah untuk membiayai permakana dan biaya sekolah anak asuh serta pembelian keramik untuk menyelesaikan finishing lantai panti asuhan yabip 3. Karena akan segera kami operasional kan. Mengingat panti 1 dan 2 sudah penuh. Sehingga anak anak penghuni yg baru masuk akan kami tempatkan di panti 3.",
            "update_campaign": null,
            "kategori_campaign": "Panti Asuhan",
            "status": "Approved",
            "created_at": "2022-07-07T06:31:04.000000Z",
            "updated_at": "2022-07-07T06:31:04.000000Z",
            "deleted_at": null
        }
    },
    "msg": "success"
}
```
***Status Code:*** 201

## Fundraiser



### 1. Change To Approve



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/fundraiser/approve
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| id_donasi | 1451 |  |



***More example Requests/Responses:***


##### I. Example Request: Change To Approve



***Query:***

| Key | Value | Description |
| --- | ------|-------------|
| id_donasi | 1451 |  |



##### I. Example Response: Change To Approve
```js
{
    "status": 201,
    "msg": "success edited"
}
```


***Status Code:*** 200

<br>



### 2. Change To Ditolak



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/fundraiser/ditolak
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| id_donasi | 1451 |  |



### 3. Data Donatur



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/fundraiser/getdonatur
```



### 4. Donation By Referal



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/fundraiser/donaturreferal
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| id_fundraiser | 1914 |  |



***More example Requests/Responses:***


##### I. Example Request: Donation By Fundraiser



***Query:***

| Key | Value | Description |
| --- | ------|-------------|
| id_fundraiser | 1914 |  |



##### I. Example Response: Donation By Fundraiser
```js
[
    [
        {
            "id_user": 1914,
            "kode_referal": "PDL1234",
            "id_donasi": 1452,
            "nama": "lazu",
            "email": "lazu@mail.com",
            "no_hp": "0812312312",
            "id": 1452,
            "user_id": 1,
            "campaign_id": 1,
            "judul_slug": null,
            "biaya_persen": 15,
            "donasi": "10000",
            "kode_donasi": null,
            "prantara_donasi": null,
            "metode_pembayaran": "cod",
            "nomor_va": null,
            "nomor_telp": "0812312312",
            "status_donasi": "Pending",
            "status_pembayaran": null,
            "snap_token": null,
            "payment_url": null,
            "status_pemberian_pertama": null,
            "foto_pertama": null,
            "status_pemberian_kedua": null,
            "foto_kedua": null,
            "status_pemberian_ketiga": null,
            "foto_ketiga": null,
            "status_terbaru": null,
            "komentar": "Semoga lekas sembuh",
            "created_at": null,
            "updated_at": null
        },
        {
            "id_user": 1914,
            "kode_referal": "PDL1234",
            "id_donasi": 1451,
            "nama": "lazu",
            "email": "lazu@mail.com",
            "no_hp": "0812312312",
            "id": 1451,
            "user_id": 1,
            "campaign_id": 1,
            "judul_slug": null,
            "biaya_persen": 15,
            "donasi": "10000",
            "kode_donasi": null,
            "prantara_donasi": null,
            "metode_pembayaran": "cod",
            "nomor_va": null,
            "nomor_telp": "0812312312",
            "status_donasi": "Ditolak",
            "status_pembayaran": null,
            "snap_token": null,
            "payment_url": null,
            "status_pemberian_pertama": null,
            "foto_pertama": null,
            "status_pemberian_kedua": null,
            "foto_kedua": null,
            "status_pemberian_ketiga": null,
            "foto_ketiga": null,
            "status_terbaru": null,
            "komentar": "Semoga lekas sembuh",
            "created_at": null,
            "updated_at": null
        }
    ]
]
```


***Status Code:*** 200

<br>



### 5. Ringkasan harian



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/fundraiser/ringkasanharian
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| id_fundraiser | 1914 |  |
| date | 2021-10-07 |  |



## Galang Dana



### 1. All



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/galangdana
```



***More example Requests/Responses:***


##### I. Example Request: All



##### I. Example Response: All
```js
{
    "data": [
        {
            "id": 11,
            "judul_campaign": "Campaign 1",
            "judul_slug": "campaign-1",
            "foto_campaign": "4432.jpg",
            "nominal_campaign": 100000000,
            "batas_waktu_campaign": "2022-08-20",
            "created_at": "2022-06-28T05:22:42.000000Z",
            "total_donasi": "0",
            "donations_count": "0"
        },
        {
            "id": 12,
            "judul_campaign": "Wisata Bersama Yatim dan Dhuafa",
            "judul_slug": "wisata-bersama-yatim-dan-dhuafa",
            "foto_campaign": "664126223.jpg",
            "nominal_campaign": 10000000,
            "batas_waktu_campaign": "2023-01-25",
            "created_at": "2019-11-06T04:26:38.000000Z",
            "total_donasi": "10000",
            "donations_count": "25"
        },
        {
            "id": 13,
            "judul_campaign": "Campaign 2",
            "judul_slug": "campaign-2",
            "foto_campaign": "3232.jpg",
            "nominal_campaign": 5000000,
            "batas_waktu_campaign": "2022-08-19",
            "created_at": "2022-06-28T05:25:18.000000Z",
            "total_donasi": "10000",
            "donations_count": "3"
        },
        {
            "id": 14,
            "judul_campaign": "Muiz",
            "judul_slug": "Muiz",
            "foto_campaign": "122.jpg",
            "nominal_campaign": 50000000,
            "batas_waktu_campaign": "2022-08-20",
            "created_at": "2022-06-28T07:16:11.000000Z",
            "total_donasi": 10000,
            "donations_count": "0"
        }
    ]
}
```


***Status Code:*** 200

<br>



### 2. Specific



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/galangdana/1005
```



***More example Requests/Responses:***


##### I. Example Request: Specific



##### I. Example Response: Specific
```js
{
    "data": {
        "campaign": {
            "id": 41,
            "user_id": 955,
            "judul_campaign": "bantu  sodara  kita yang kena banjir di Manado",
            "judul_slug": "bantu-sodara-kita-yang-kena-banjir-di-manado",
            "foto_campaign": "513865806.jpg",
            "nominal_campaign": 25000000,
            "tag_campaign": null,
            "regencies": "kota manado",
            "batas_waktu_campaign": "Tanpa Batas Waktu",
            "detail_campaign": "<p>mari kita ringankan sodara kita yang kena musibah&nbsp; banjir d Manado&nbsp;</p>",
            "update_campaign": null,
            "kategori_campaign": "Bencana Alam",
            "status": "pendding",
            "created_at": "2021-01-22T20:25:37.000000Z",
            "updated_at": "2021-01-22T20:25:37.000000Z",
            "user": {
                "id": 955,
                "socialite_id": null,
                "socialite_name": null,
                "name": "zaki assagaf",
                "role": "User",
                "tipe": "pribadi",
                "username": "zaki",
                "email": "zaki.assagaf@gmail.com",
                "email_verified_at": "2021-01-22T20:22:33.000000Z",
                "status_akun": "Not Verified",
                "no_telp": "082293552948",
                "usia": null,
                "jenis_kelamin": null,
                "alamat": null,
                "tempat_lahir": null,
                "tanggal_lahir": null,
                "pekerjaan": null,
                "lembaga": null,
                "photo": null,
                "foto_ktp": null,
                "bank": null,
                "no_rek": null,
                "created_at": "2021-01-22T20:20:25.000000Z",
                "updated_at": "2021-01-22T20:22:33.000000Z"
            }
        },
        "user": {
            "id": 955,
            "socialite_id": null,
            "socialite_name": null,
            "name": "zaki assagaf",
            "role": "User",
            "tipe": "pribadi",
            "username": "zaki",
            "email": "zaki.assagaf@gmail.com",
            "email_verified_at": "2021-01-22T20:22:33.000000Z",
            "status_akun": "Not Verified",
            "no_telp": "082293552948",
            "usia": null,
            "jenis_kelamin": null,
            "alamat": null,
            "tempat_lahir": null,
            "tanggal_lahir": null,
            "pekerjaan": null,
            "lembaga": null,
            "photo": null,
            "foto_ktp": null,
            "bank": null,
            "no_rek": null,
            "created_at": "2021-01-22T20:20:25.000000Z",
            "updated_at": "2021-01-22T20:22:33.000000Z"
        }
    }
}
```


***Status Code:*** 200

<br>



### 3. Specific By Slug



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/galangdana/byslug/donasi-untuk-semua
```

### 4. Buat Galangdana



***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/galangdana/create
```

***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |
| Authorization | Bearer <YOUR_TOKEN> |  |


***Body:***

```json
{
    "judul_campaign": "Juan Angela Alma",
    "judul_slug": "peduly-jatim-indonesia",
    "kategori_campaign": "Kesehatan",
    "target_donasi": 200000000,
    "batas_waktu_campaign": "2023-06-23",
    "lokasi": "Surabaya",
    "alamat_lengkap": "Jl bromo no 37",
    "tujuan": "Untuk anak yatim",
    "penerima": "Samsul hadi",
    "detail_campaign": "ini detail",
    "rincian": "ini adalah rincian",
    "foto_campaign": Image Object
}
```

***More example Requests/Responses:***


##### 3. Buat Galang dana


##### 1. Example Response: Buat Galang dana
```json
{
    "message": "berhasil membuat campaign",
    "data": {
        "kategori_campaign": "kesehatan",
        "judul_campaign": "Peduly Jatim",
        "batas_waktu_campaign": "2023-06-23",
        "regencies": "Surabaya",
        "alamat_lengkap": "Gubeng Surabaya",
        "tujuan": "Untuk anak yatim",
        "penerima": "bpk haji samsudin",
        "detail_campaign": "Ini detail",
        "user_id": 2223,
        "foto_campaign": "peduly-jatim.png",
        "judul_slug": "peduly-jatim-indonesia",
        "updated_at": "2022-07-25T04:58:49.000000Z",
        "created_at": "2022-07-25T04:58:49.000000Z",
        "id": 1068
    },
    "error": false
}
```


***Status Code:*** 201

<br>

## Password



### 1. Reset Password



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/password/resetpassword
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| email | lazuardi.akhmad@gmail.com |  |
| token | aMBcg3PFSDv1Cvl9TeWu8eDlLqcphnDXUvJvHQzpVqnOMRcey4cb4jdCZMWF |  |
| new_pass | Baru123! |  |



### 2. Send Reset Email



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/password/resetemail
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| email | lazuardi.akhmad@gmail.com |  |



## Token



### 1. Get CSRF Token



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/token/csrf
```



***More example Requests/Responses:***


##### I. Example Request: Get CSRF Token



##### I. Example Response: Get CSRF Token
```js
{
    "token": "x5OKF26wlnNG5DTacMRZS9DXxz7ZJ15b8rlQMEor"
}
```


***Status Code:*** 200

<br>



***Available Variables:***

| Key | Value | Type |
| --- | ------|-------------|
| api | http://127.0.0.1:8000/api/ |  |



## User



### 1. All Pekerjaan



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/pekerjaan
```



***More example Requests/Responses:***



##### I. Example Response: All Pekerjaan
```js
    {
        "id": 1,
        "pekerjaan": "Administrator"
    },
    {
        "id": 2,
        "pekerjaan": "Advokat"
    },
```


***Status Code:*** 200



### 2. All Organisasi



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/organisasi
```



***More example Requests/Responses:***



##### I. Example Response: All Organisasi
```js
    {
        "id": 1,
        "jenis_lembaga": "Komunitas"
    },
    {
        "id": 2,
        "jenis_lembaga": "Lembaga Swadaya Masyarakat"
    },
```


***Status Code:*** 200



### 3. Provinsi



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/prov
```



***More example Requests/Responses:***



##### I. Example Response: Provinsi
```js
    {
        "id": "11",
        "name": "ACEH"
    },
    {
        "id": "12",
        "name": "SUMATERA UTARA"
    },
```


***Status Code:*** 200



### 4. Kabupaten



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/kab
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| provinceId | 11 |  |



### 5. Kecamatan



***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/kec
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| regencyId | 1901 |  |


### 6. Edit Profil



***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/user
```


***More example Requests/Responses:***


##### I. Example Request: Edit Profil

***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |
| Authorization | Bearer <YOUR_TOKEN> |  |


***Query:***

| Key | Value | Description |
| --- | ------|-------------|
| nama | Albert |  |
| username | albert123 |  |
| tipe | Individu |  |
| pekerjaan | Programmer |  |
| jenis_organisasi |  |  |
| tanggal_lahir | 2000-05-27 |  |
| jenis_kelamin | Laki - laki |  |
| no_telp | 089786787655 |  |
| provinsi | Jawa Timur |  |
| kabupaten | Tuban |  |
| kecamatan | Jatirogo |  |


##### I. Example Response: Edit Profil
```js
{
    "status": true,
    "msg": "Profile Updated!",
    "data": {
        "id": 2157,
        "socialite_id": null,
        "socialite_name": null,
        "name": "Albert",
        "role": "User",
        "tipe": "Individu",
        "username": "albert123",
        "email": "demosatu@demo.com",
        "email_verified_at": null,
        "status_akun": "Not Verified",
        "no_telp": "089786787655",
        "usia": null,
        "jenis_kelamin": "laki - laki",
        "alamat": null,
        "provinsi": "Jawa timur",
        "kabupaten": "Tuban",
        "kecamatan": "Jatirogo",
        "tempat_lahir": null,
        "tanggal_lahir": "2000-05-27",
        "pekerjaan": "Programmer",
        "jenis_organisasi": null,
        "photo": null,
        "foto_ktp": null,
        "bank": null,
        "no_rek": null,
        "created_at": "2021-12-28T16:15:47.000000Z",
        "updated_at": "2021-12-28T16:18:20.000000Z",
        "deleted_at": "2001-11-29T16:52:48.000000Z"
    }
}
```


***Status Code:*** 200

<br>


## Search


***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/search?keyword=<your keyword>
```

### examples request

***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |


***Query:***

| Key | Value | Description |
| --- | ------|-------------|
| keyword | Campaign | user atau campaign |

```js
{
    "error": false,
    "data": {
        "users": [
            {
                "id": 927,
                "name": "Campaign #ForChange",
                "status_akun": "Not Verified",
                "created_at": "2021-01-14T09:10:56.000000Z"
            }
        ],
        "galangdana": [
            {
                "id": 11,
                "judul_campaign": "Campaign 1",
                "judul_slug": "campaign-1",
                "foto_campaign": "4432.jpg",
                "nominal_campaign": 100000000,
                "batas_waktu_campaign": "2022-08-20",
                "total_donasi": null
            },
            {
                "id": 13,
                "judul_campaign": "Campaign 2",
                "judul_slug": "campaign-2",
                "foto_campaign": "3232.jpg",
                "nominal_campaign": 5000000,
                "batas_waktu_campaign": "2022-08-19",
                "total_donasi": "60000"
            }
        ]
    }
}
```


***Status Code:*** 200

<br>

## Bantuan Mendesak

***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/urgent
```

### examples request

***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |


```js
{
    "error": false,
    "data": [
        {
            "id": 1,
            "campaign_id": 11,
            "created_at": "2022-06-30T06:29:46.000000Z",
            "updated_at": "2022-06-30T06:29:46.000000Z",
            "campaign": {
                "id": 11,
                "user_id": 24,
                "judul_campaign": "Campaign 1",
                "judul_slug": "campaign-1",
                "foto_campaign": "4432.jpg",
                "nominal_campaign": 100000000,
                "tag_campaign": null,
                "regencies": "kota surabaya",
                "batas_waktu_campaign": "2022-08-20",
                "detail_campaign": "<p>Berwisata mungkin adalah hal yang sangat dinantikan bagi setiap orang, baik untuk diri pribadi maupun bersama keluarga. Karena dengan berwisata kita bisa melepas penat melalui berbagai jenis hiburan yang menyenangkan, sekaligus juga ajang yang digunakan untuk berkumpul bersama dengan keluarga.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Akan tetapi tidak semua orang dapat berwisata, termasuk anak-anak yatim piatu dan dhuafa. Dengan berbagai keterbatasan yang ada khususnya dalam hal biaya, sulit bagi mereka untuk berwisata atau sekedar untuk jalan-jalan. Bahkan tidak sedikit dari mereka yang belum pernah merasakan wisata bersama keluarga maupun teman-teman.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Dengan adanya keterbatasan inilah, Peduly Surabaya&nbsp;mengambil langkah untuk berbagi kebahagiaan bersama adik-adik Yatim Dhuafa dari Yayasan Al-Madina Surabaya&nbsp;melalui kegiatan bertema &ldquo;Wisata Bersama Yatim Dhuafa&rdquo;.</p>\r\n\r\n<p>yuk bantu sukseskan anak-anak yatim dan dhuafa bisa wisata dengan cara:</p>\r\n\r\n<p><br />\r\n1. klik &quot;donasi sekarang&quot;<br />\r\n2. masukkan nominal donasi<br />\r\n3. pilih metode pembayaran<br />\r\n&nbsp;</p>",
                "update_campaign": "",
                "kategori_campaign": "Kesehatan",
                "status": "Approved",
                "created_at": "2022-06-28T05:22:42.000000Z",
                "updated_at": "2022-06-28T05:22:42.000000Z"
            }
        }
    ]
}
```


***Status Code:*** 200

<br>


## Riwayat Donasi


***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/donation/histories
```

### examples request

***Headers:***


| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |
| Authorization | Bearer <YOUR_TOKEN> |  |


```js
[
    {
        "id": 64,
        "month_year": "05-2022",
        "total_donasi": 0,
        "jumlah_donasi": 0,
        "donasi": [
            {
                "id": 64,
                "judul_campaign": "Wisata Bersama Yatim dan Dhuafa",
                "foto_campaign": "664126223.jpg",
                "user_id": 2221,
                "judul_slug": "wisata-bersama-yatim-dan-dhuafa",
                "donasi": "200000",
                "status_donasi": "Pending",
                "campaign_id": 12,
                "created_at": "2022-05-28T07:51:39.000000Z"
            }
        ]
    },
    {
        "id": 62,
        "month_year": "06-2022",
        "total_donasi": "220000",
        "jumlah_donasi": 2,
        "donasi": [
            {
                "id": 62,
                "judul_campaign": "Wisata Bersama Yatim dan Dhuafa",
                "foto_campaign": "664126223.jpg",
                "user_id": 2221,
                "judul_slug": "wisata-bersama-yatim-dan-dhuafa",
                "donasi": "20000",
                "status_donasi": "Approved",
                "campaign_id": 12,
                "created_at": "2022-06-28T07:23:22.000000Z"
            },
            {
                "id": 63,
                "judul_campaign": "Wisata Bersama Yatim dan Dhuafa",
                "foto_campaign": "664126223.jpg",
                "user_id": 2221,
                "judul_slug": "wisata-bersama-yatim-dan-dhuafa",
                "donasi": "200000",
                "status_donasi": "Approved",
                "campaign_id": 12,
                "created_at": "2022-06-28T07:51:39.000000Z"
            },
            {
                "id": 1683,
                "judul_campaign": "Campaign 2",
                "foto_campaign": "3232.jpg",
                "user_id": 1,
                "judul_slug": "",
                "donasi": "20000",
                "status_donasi": "Pending",
                "campaign_id": 13,
                "created_at": "2022-06-30T04:18:50.000000Z"
            },
            {
                "id": 1684,
                "judul_campaign": "Campaign 2",
                "foto_campaign": "3232.jpg",
                "user_id": 1,
                "judul_slug": null,
                "donasi": "20000",
                "status_donasi": "Pending",
                "campaign_id": 13,
                "created_at": "2022-06-30T04:24:01.000000Z"
            }
        ]
    }
]
```
***Status Code:*** 200

<br>

### 1. Details Riwayat

***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/donation/histories/{riwayat_id}/details
```

### examples request

***Headers:***


| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |
| Authorization | Bearer <YOUR_TOKEN> |  |


```js
{
    "message": "successfully fetching donation detail",
    "data": [
        {
            "id": 1685,
            "kode_donasi": "PDLY16565644270423",
            "judul_campaign": "Campaign 2",
            "donasi": "20000",
            "metode_pembayaran": "COD",
            "status_donasi": "Pending",
            "created_at": "2022-06-30 11:47:16",
            "deadline": "2022-07-01 11:47:07"
        }
    ],
    "error": false
}

```

***Status Code:*** 200

<br>




___
[Back to top](#peduly)
> Made with &#9829; by [thedevsaddam](https://github.com/thedevsaddam) | Generated at: 2021-10-19 11:55:52 by [docgen](https://github.com/thedevsaddam/docgen)
