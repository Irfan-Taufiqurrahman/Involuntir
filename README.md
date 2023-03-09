
# Involuntir

* [Aktivitas](#aktivitas)

  * [Create](#1-create-aktivitas)
  * [All](#2-all-aktivitas)
  * [Specific](#3-specific-aktivitas)
  * [By Slug](#4-by-slug-aktivitas)
  * [Publish](#5-publish-aktivitas)
  * [Draft](#6-draft-aktivitas)
  * [Update](#7-update-aktivitas)
  * [Delete](#8-delete-aktivitas)
  * [Is Exist](#9-is-exist-aktivitas)

* [Kriteria](#kriteria)
  * [Create](#1-create-kriteria)
  * [Tampilkan](#2-tampilkan-kriteria)
  * [Update](#3-update-kriteria)
  * [Delete](#4-delete-kriteria)

* [Tugas](#tugas)
  * [Create](#1-create-tugas)
  * [Tampilkan](#2-tampilkan-tugas)
  * [Update](#3-update-tugas)
  * [Delete](#4-delete-tugas)

* [Partisipasi](#partisipasi)
  * [Submit](#1-submit-partisipasi)
  * [Partisipan](#2-specific-partisipan)

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
  * [Donation Balance](#6-donation-balance)
  * [Detail Transaksi Donasi](#7-detail-transaksi-donasi)

* [Fundraiser](#fundraiser)

  * [Change To Approve](#1-change-to-approve)
  * [Change To Ditolak](#2-change-to-ditolak)
  * [Data Donatur](#3-data-donatur)
  * [Donation By Referal](#4-donation-by-referal)
  * [Ringkasan harian](#5-ringkasan-harian)
  * [Ringkasan User](#6-ringkasan-user)
  * [Detail Donasi](#7-detail-donasi)

* [Galang Dana](#galang-dana)

  * [All](#1-all)
  * [Specific](#2-specific)
  * [Specific By Slug](#3-specific-by-slug)
  * [Buat Galangdana](#4-buat-galangdana)
  * [Buat Campaign sebagai Urgent](#5-buat-campaign-sebagai-urgent)
  * [Campaign Milik User](#6-campaign-milik-user)
  * [Laporkan Galang Dana](#7-laporkan-galang-dana)
  * [Batalkan Laporan Galang Dana](#8-batalkan-laporan-galang-dana)

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
  * [Detail User](#7-detail-user)
  * [Ganti Password](#8-ganti-password)
  * [Kode Referal User](#9-kode-referal-user)

* [Search](#search)

* [Bantuan Mendesak](#bantuan-mendesak)

* [Riwayat Donasi](#riwayat-donasi)

  * [Details Riwayat](#1-details-riwayat)

* [Kabar Terbaru](#kabar-terbaru)

  * [Upload](#1-upload)
  * [Store](#2-store)

* [Wishlist](#wishlist)
  * [Get Wishlist](#1-get-wishlist)
  * [Buat Wishlist](#2-buat-wishlist)
  * [Hapus Wishlist](#3-hapus-wishlist)

* [Slider](#slider)
  * [Buat Slider](#1-buat-slider)
  * [All Slider](#2-all-slider)
  * [Ubah Slider](#3-ubah-slider)
  * [Hapus Slider](#4-hapus-slider)

* [Topup](#topup)
  * [Topup Emoney](#1-topup-emoney)
  * [Detail Topup](#2-detail-topup)

* [Feeds](#feeds)
  * [All Feeds](#1-all-feeds)
  * [Menyukai Feed](#2-menyukai-feed)
  * [Batalkan Menyukai Feed](#3-batalkan-menyukai-feed)

* [Ada Yang Baru](#ada-yang-baru)
  * [All Ada Yang Baru](#1-all-ada-yang-baru)
  * [Buat Ada Yang Baru](#2-buat-ada-yang-baru)
  * [Ubah Ada Yang Baru](#3-ubah-ada-yang-baru)
  * [Hapus Ada Yang Baru](#4-hapus-ada-yang-baru)

--------

* [ADMIN](#admin)
    * [Get Users](#1-admin-get-users)
    * [Galang Dana](#2-admin-galang-dana)

## Aktivitas

### 1. Create Aktivitas

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/create
```

***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| status_publish | published, drafted |  |
| category_id | 2 |  |
| judul_activity | Judul2 |  |
| judul_slug | tes_slug2 |  |
| foto_activity | Image Object |  |
| detail_activity | tesdetail2 |  |
| batas_waktu | 21 |  |
| waktu_activity | 2023-12-31 |  |
| lokasi | rumah |  |
| tipe_activity | In-Person, Virtual, Hybrid |  |
| criterias | [blabla, blabla, blabla] | array |
| tasks | [blabla, blabla, blabla] | array |
| kuota | 100 |  |
| tautan | involuntir |  |

***Response:***
```js
{
    "data": {
        "category_id": "2",
        "user_id": 3,
        "judul_activity": "Judul2",
        "judul_slug": "tes_slug2",
        "foto_activity": "tes_slug2.png",
        "detail_activity": "tesdetail2",
        "batas_waktu": "2023-01-24T16:52:00.787353Z",
        "waktu_activity": "2023-01-31",
        "lokasi": "rumah",
        "tipe_activity": "In-Person",
        "status_publish": "published",
        "status": "Pending",
        "kuota": 100,
        "tautan": "involuntir",
        "updated_at": "2023-01-10T16:52:00.000000Z",
        "created_at": "2023-01-10T16:52:00.000000Z",
        "id": 2,
        "user": {
            "id": 3,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Developer Peduly",
            "role": "Admin",
            "tipe": "Individu",
            "username": null,
            "email": "developer@peduly.com",
            "email_verified_at": "2022-12-14T06:42:38.000000Z",
            "status_akun": "Verified",
            "no_telp": "081333544085",
            "usia": "32",
            "jenis_kelamin": "Pria",
            "alamat": "rumahrumahrumah",
            "provinsi": 0,
            "kabupaten": 0,
            "kecamatan": 0,
            "tempat_lahir": "rumahrumahrumah",
            "tanggal_lahir": "1990-01-01",
            "pekerjaan": "Pendeta",
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": "Mandiri",
            "no_rek": "999999",
            "created_at": "2022-12-14T06:41:14.000000Z",
            "updated_at": "2022-12-14T06:42:38.000000Z",
            "deleted_at": "-000001-11-29T16:52:48.000000Z"
        }
    }
}
```

***Status Code:*** 200

### 2. All Aktivitas

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/aktivitas
```

***Response:***
```js
{
    "data": [
        {
            "id": 5,
            "judul_activity": "Judul2",
            "judul_slug": "tes_slug2",
            "foto_activity": "tes_slug2.jpg",
            "batas_waktu": "2023-01-26 18:15:47",
            "created_at": "2023-01-12T11:15:48.000000Z",
            "total_volunteer": 0
        },
        {
            "id": 4,
            "judul_activity": "judultiga",
            "judul_slug": "slug-3-tes",
            "foto_activity": "slug-3-tes.jpg",
            "batas_waktu": "2023-02-11 00:11:45",
            "created_at": "2023-01-11T17:11:45.000000Z",
            "total_volunteer": 0
        },
        {
            "id": 1,
            "judul_activity": "gantijudul",
            "judul_slug": "tes_slug",
            "foto_activity": "tes_slug.jpg",
            "batas_waktu": "2023-01-20 13:35:12",
            "created_at": "2023-01-06T06:35:12.000000Z",
            "total_volunteer": 1
        }
    ]
}
```

***Status Code:*** 200

### 3. Specific Aktivitas

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/{id}
```

***Response:***
```js
{
    "data": {
        "activity": {
            "id": 2,
            "category_id": 2,
            "user_id": 3,
            "judul_activity": "Judul2",
            "judul_slug": "tes_slug2",
            "foto_activity": "tes_slug2.png",
            "detail_activity": "tesdetail2",
            "batas_waktu": "2023-01-24 23:52:00",
            "waktu_activity": "2023-01-31",
            "lokasi": "rumah",
            "tipe_activity": "In-Person",
            "status_publish": "published",
            "status": "Pending",
            "created_at": "2023-01-10T16:52:00.000000Z",
            "updated_at": "2023-01-10T16:52:00.000000Z",
            "deleted_at": null,
            "user": {
                "id": 3,
                "socialite_id": null,
                "socialite_name": null,
                "name": "Developer Peduly",
                "role": "Admin",
                "tipe": "Individu",
                "username": null,
                "email": "developer@peduly.com",
                "email_verified_at": "2022-12-14T06:42:38.000000Z",
                "status_akun": "Verified",
                "no_telp": "081333544085",
                "usia": "32",
                "jenis_kelamin": "Pria",
                "alamat": "rumahrumahrumah",
                "provinsi": 0,
                "kabupaten": 0,
                "kecamatan": 0,
                "tempat_lahir": "rumahrumahrumah",
                "tanggal_lahir": "1990-01-01",
                "pekerjaan": "Pendeta",
                "jenis_organisasi": null,
                "tanggal_berdiri": null,
                "photo": null,
                "foto_ktp": null,
                "bank": "Mandiri",
                "no_rek": "999999",
                "created_at": "2022-12-14T06:41:14.000000Z",
                "updated_at": "2022-12-14T06:42:38.000000Z",
                "deleted_at": "-000001-11-29T16:52:48.000000Z"
            }
        },
        "total_volunteer": [
            {
                "total_volunteer": 0
            }
        ]
    }
}
```

***Status Code:*** 200

### 4. By Slug Aktivitas

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/byslug/{slug}
```

***Response:***
```js
{
    "data": {
        "activity": [
            {
                "id": 1,
                "category_id": 1,
                "user_id": 3,
                "judul_activity": "gantijudul",
                "judul_slug": "tes_slug",
                "foto_activity": "tes_slug.jpg",
                "detail_activity": "tesdetailll",
                "batas_waktu": "2023-01-20 13:35:12",
                "waktu_activity": "2023-01-31",
                "lokasi": "rumahgw",
                "tipe_activity": "Virtual",
                "status_publish": "published",
                "status": "Pending",
                "created_at": "2023-01-06 13:35:12",
                "updated_at": "2023-01-12 00:42:11",
                "deleted_at": null
            }
        ],
        "user": [
            {
                "id": 3,
                "photo": null,
                "name": "Developer Peduly",
                "status_akun": "Verified",
                "role": "Admin",
                "tipe": "Individu"
            }
        ],
        "total_volunteer": [
            {
                "total_volunteer": 1
            }
        ],
        "volunteer": [
            {
                "id": 3,
                "photo": null,
                "name": "Developer Peduly",
                "nomor_hp": "081081081081",
                "created_at": "2023-01-06T07:27:22.000000Z"
            }
        ],
        "tugas": [],
        "kriteria": [],
        "is_mine": false
    }
}
```

***Status Code:*** 200

### 5. Publish Aktivitas

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/create/publish
```

***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| category_id | 1 |  |
| judul_activity | judulempat |  |
| foto_activity | Image Object |  |
| judul_slug | slug-4-tes |  |
| detail_activity | detailx4 |  |
| batas_waktu | 30 |  |
| waktu_activity | 2000-01-01 |  |
| lokasi | kantor |  |
| tipe_activity | Virtual |  |
| tasks[] | testask1 |  |
| tasks[] | testatsk2 |  |
| criterias[] | testcriterias333 |  |

***Response:***
```js
{
    "data": {
        "category_id": 1,
        "user_id": 3,
        "judul_activity": "judulempat",
        "judul_slug": "slug-4-tes",
        "foto_activity": "slug-4-tes.jpg",
        "detail_activity": "detailx4",
        "batas_waktu": "2023-02-11T12:01:12.766214Z",
        "waktu_activity": "2000-01-01",
        "lokasi": "kantor",
        "tipe_activity": "Virtual",
        "status_publish": "published",
        "status": "Pending",
        "updated_at": "2023-01-12T12:01:12.000000Z",
        "created_at": "2023-01-12T12:01:12.000000Z",
        "id": 30,
        "tasks": [
            "testask1",
            "testatsk2"
        ],
        "criterias": [
            "testcriterias333"
        ],
        "user": {
            "id": 3,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Developer Peduly",
            "role": "Admin",
            "tipe": "Individu",
            "username": null,
            "email": "developer@peduly.com",
            "email_verified_at": "2022-12-14T06:42:38.000000Z",
            "status_akun": "Verified",
            "no_telp": "081333544085",
            "usia": "32",
            "jenis_kelamin": "Pria",
            "alamat": "rumahrumahrumah",
            "provinsi": 0,
            "kabupaten": 0,
            "kecamatan": 0,
            "tempat_lahir": "rumahrumahrumah",
            "tanggal_lahir": "1990-01-01",
            "pekerjaan": "Pendeta",
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": "Mandiri",
            "no_rek": "999999",
            "created_at": "2022-12-14T06:41:14.000000Z",
            "updated_at": "2022-12-14T06:42:38.000000Z",
            "deleted_at": "-000001-11-29T16:52:48.000000Z"
        }
    }
}
```

***Status Code:*** 201

### 6. Draft Aktivitas

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/create/draft
```

***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| category_id | 1 |  |
| judul_activity | judul555 |  |
| foto_activity | Image Object |  |
| judul_slug | slug5 |  |
| detail_activity | detaillima |  |
| batas_waktu | 1 |  |
| waktu_activity | 2023-05-02 |  |
| lokasi | btul |  |
| tipe_activity | In-Person |  |
| tasks[] | testask99 |  |
| tasks[] | testatsk999 |  |
| criterias[] | testcriterias9 |  |

***Response:***
```js
{
    "data": {
        "category_id": 1,
        "user_id": 3,
        "judul_activity": "judul555",
        "judul_slug": "slug5",
        "foto_activity": "slug5.jpg",
        "detail_activity": "detaillima",
        "batas_waktu": "2023-01-13T12:20:20.656956Z",
        "waktu_activity": "2023-05-02",
        "lokasi": "btul",
        "tipe_activity": "In-Person",
        "status_publish": "drafted",
        "status": "Pending",
        "updated_at": "2023-01-12T12:20:20.000000Z",
        "created_at": "2023-01-12T12:20:20.000000Z",
        "id": 31,
        "tasks": [
            "testask99",
            "testask999"
        ],
        "criterias": [
            "testcriterias9"
        ],
        "user": {
            "id": 3,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Developer Peduly",
            "role": "Admin",
            "tipe": "Individu",
            "username": null,
            "email": "developer@peduly.com",
            "email_verified_at": "2022-12-14T06:42:38.000000Z",
            "status_akun": "Verified",
            "no_telp": "081333544085",
            "usia": "32",
            "jenis_kelamin": "Pria",
            "alamat": "rumahrumahrumah",
            "provinsi": 0,
            "kabupaten": 0,
            "kecamatan": 0,
            "tempat_lahir": "rumahrumahrumah",
            "tanggal_lahir": "1990-01-01",
            "pekerjaan": "Pendeta",
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": "Mandiri",
            "no_rek": "999999",
            "created_at": "2022-12-14T06:41:14.000000Z",
            "updated_at": "2022-12-14T06:42:38.000000Z",
            "deleted_at": "-000001-11-29T16:52:48.000000Z"
        }
    }
}
```

***Status Code:*** 201

### 7. Update Aktivitas

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/{id}/update
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| _method | PUT |  |
| status_publish | published |  |
| judul | gantilagi |  |

***Response:***
```js
{
    "data": {
        "id": 1,
        "category_id": 1,
        "user_id": 3,
        "judul_activity": "gantilagi",
        "judul_slug": "tes_slug",
        "foto_activity": "tes_slug.jpg",
        "detail_activity": "tesdetailll",
        "batas_waktu": "2023-01-20 13:35:12",
        "waktu_activity": "2023-01-31",
        "lokasi": "rumahgw",
        "tipe_activity": "Virtual",
        "status_publish": "published",
        "status": "Pending",
        "created_at": "2023-01-06T06:35:12.000000Z",
        "updated_at": "2023-01-12T12:26:27.000000Z",
        "deleted_at": null,
        "user": {
            "id": 3,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Developer Peduly",
            "role": "Admin",
            "tipe": "Individu",
            "username": null,
            "email": "developer@peduly.com",
            "email_verified_at": "2022-12-14T06:42:38.000000Z",
            "status_akun": "Verified",
            "no_telp": "081333544085",
            "usia": "32",
            "jenis_kelamin": "Pria",
            "alamat": "rumahrumahrumah",
            "provinsi": 0,
            "kabupaten": 0,
            "kecamatan": 0,
            "tempat_lahir": "rumahrumahrumah",
            "tanggal_lahir": "1990-01-01",
            "pekerjaan": "Pendeta",
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": "Mandiri",
            "no_rek": "999999",
            "created_at": "2022-12-14T06:41:14.000000Z",
            "updated_at": "2022-12-14T06:42:38.000000Z",
            "deleted_at": "-000001-11-29T16:52:48.000000Z"
        }
    }
}
```

***Status Code:*** 201

### 8. Delete Aktivitas

***Endpoint:***
```bash
Method: DELETE
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/{id}/delete
```

***Response:***
```js
{
    "message": "berhasil menghapus activity"
}
```

***Status Code:*** 200

### 9. Is Exist Aktivitas

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/aktivitas/isExist/{slug}
```

***Response:***
```js
{
    "isExist": true
}
```

***Status Code:*** 200

## Kriteria

### 1. Create Kriteria

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/kriteria/{activity}
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| deskripsi | tescreate |  |

***Response:***
```js
{
    "activity_id": 30,
    "deskripsi": "tescreate",
    "updated_at": "2023-01-17T05:03:19.000000Z",
    "created_at": "2023-01-17T05:03:19.000000Z",
    "id": 9
}
```

***Status Code:*** 200

### 2. Tampilkan Kriteria

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/kriteria/{activity}
```

***Response:***
```js
[
    {
        "id": 6,
        "activity_id": 34,
        "deskripsi": "testcriterias333"
    }
]
```

***Status Code:*** 200

### 3. Update Kriteria

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/kriteria/{id}
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| _method | PUT |  |
| deskripsi | ppp |  |

***Response:***
```js
{
    "data": {
        "id": 5,
        "activity_id": 33,
        "deskripsi": "ppp",
        "created_at": "2023-01-17T04:12:35.000000Z",
        "updated_at": "2023-01-17T04:34:02.000000Z"
    }
}
```

***Status Code:*** 200

### 4. Delete Kriteria

***Endpoint:***
```bash
Method: DELETE
Type: 
URL: http://127.0.0.1:8000/api/kriteria/{id}
```

***Response:***
```js
{
    "message": "Berhasil menghapus data",
    "id": "3",
    "error": false
}
```

***Status Code:*** 200

## Tugas

### 1. Create Tugas
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/tugas/{activity}
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| deskripsi | testcreate |  |

***Response:***
```js
{
    "activity_id": 30,
    "deskripsi": "testcreate",
    "updated_at": "2023-01-17T05:04:50.000000Z",
    "created_at": "2023-01-17T05:04:50.000000Z",
    "id": 13
}
```

***Status Code:*** 200

### 2. Tampilkan Tugas

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/tugas/{activity}
```

***Response:***
```js
[
    {
        "id": 5,
        "activity_id": 31,
        "deskripsi": "oksip"
    },
    {
        "id": 6,
        "activity_id": 31,
        "deskripsi": "testask999"
    }
]
```

***Status Code:*** 200

### 3. Update Tugas

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/tugas/{id}
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| _method | PUT |  |
| deskripsi | testcreate |  |

***Response:***
```js
{
    "data": {
        "id": 5,
        "activity_id": 31,
        "deskripsi": "oksip",
        "created_at": "2023-01-12T12:20:20.000000Z",
        "updated_at": "2023-01-17T04:36:28.000000Z"
    }
}
```

***Status Code:*** 200

### 4. Delete Tugas

***Endpoint:***
```bash
Method: DELETE
Type: 
URL: http://127.0.0.1:8000/api/tugas/{id}
```

***Response:***
```js
{
    "message": "Berhasil menghapus data",
    "id": "13",
    "error": false
}
```

***Status Code:*** 200

## Partisipasi

### 1. Submit Partisipasi

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/participation
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| activity_id | 2 |  |
| nomor_hp | 081234567890 |  |
| akun_linkedin | nihil |  |
| pesan | tes123 |  |

***Response:***
```js
{
    "data": {
        "activity_id": "2",
        "user_id": 3,
        "nomor_hp": "081234567890",
        "akun_linkedin": "nihil",
        "pesan": "tes123",
        "updated_at": "2023-01-10T17:12:18.000000Z",
        "created_at": "2023-01-10T17:12:18.000000Z",
        "id": 6
    }
}
```

***Status Code:*** 200

### 2. Specific Partisipan

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/participation/{id}/participants
```

***Response:***
```js
{
    "data": [
        {
            "id": 3,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Developer Peduly",
            "role": "Admin",
            "tipe": "Individu",
            "username": null,
            "email": "developer@peduly.com",
            "email_verified_at": "2022-12-14 13:42:38",
            "password": "$2y$10$UuBPq/csIpzwoWQUZSS/ZuQNpj432mFRdLStFrO3qL61P1IXuczDe",
            "status_akun": "Verified",
            "no_telp": "081333544085",
            "usia": "32",
            "jenis_kelamin": "Pria",
            "alamat": "rumahrumahrumah",
            "provinsi": 0,
            "kabupaten": 0,
            "kecamatan": 0,
            "tempat_lahir": "rumahrumahrumah",
            "tanggal_lahir": "1990-01-01",
            "pekerjaan": "Pendeta",
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": "Mandiri",
            "no_rek": "999999",
            "remember_token": null,
            "created_at": "2022-12-14 13:41:14",
            "updated_at": "2022-12-14 13:42:38",
            "deleted_at": "0000-00-00"
        }
    ]
}
```

***Status Code:*** 200

----------

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

### 6. Donation Balance

***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/donation/balance
```

***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| nominal | 10000 |  |
| metode | balance |  |
| nama_lengkap | Juan%20Angela%20Alma |  |
| alamat_email | juan@gmail.com |  |
| nomor_ponsel | 83111064482 |  |
| kode_referensi | FR05 |  |
| pesan_baik |  |  |
| user_id | 1 |  |
| campaign_id | 1059 |  |
| bank_name | bni |  |

***Response:***

```json
{
    "data": {
        "donasi": {
            "id": 1960,
            "user_id": 1,
            "nama": "Juan Alma",
            "campaign_id": 1059,
            "judul_slug": null,
            "biaya_persen": 15,
            "donasi": "10000",
            "kode_donasi": "INVD16673696428346",
            "prantara_donasi": null,
            "metode_pembayaran": "Dompet Peduly",
            "nomor_va": null,
            "bank_name": null,
            "emoney_name": null,
            "qr_code": null,
            "email": "juanangelaalma@gmail.com",
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
            "deadline": "2022-11-03 13:14:02",
            "tanggal_donasi": "2022-11-02",
            "created_at": "2022-11-02T06:14:02.000000Z",
            "updated_at": null,
            "campaign": {
                "id": 1059,
                "user_id": 2189,
                "judul_campaign": "Peduly Jatim",
                "judul_slug": "peduly-jatim-indonesia",
                "foto_campaign": null,
                "nominal_campaign": 6000000,
                "tag_campaign": null,
                "regencies": "Surabaya",
                "batas_waktu_campaign": "2023-06-23",
                "detail_campaign": "Ini detail",
                "update_campaign": null,
                "kategori_campaign": "kesehatan",
                "status": "Pending",
                "penerima": "bpk haji samsudin",
                "tujuan": "Untuk anak yatim",
                "alamat_lengkap": "Gubeng Surabaya",
                "rincian": "",
                "created_at": "2022-08-09T04:47:18.000000Z",
                "updated_at": "2022-08-09T04:47:18.000000Z",
                "deleted_at": null
            }
        }
    },
    "status": 201,
    "msg": "success"
}
```

***Status Code:*** 200

### 7. Detail Transaksi Donasi

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/donation/transaction/INVD16632279336825
```

***Response:***
```json
{
    "data": {
        "nama": "Juan Angela Alma",
        "donasi": "10000",
        "kode_donasi": "INVD16632279336825",
        "metode_pembayaran": "bank_transfer",
        "email": "juan@gmail.com",
        "nomor_telp": "83111064482",
        "komentar": null,
        "bank_name": "bni",
        "user_id": 1,
        "deadline": "2022-09-16 14:45:33",
        "tanggal_donasi": "2022-09-15",
        "status_donasi": "Approved",
        "nomor_va": "9886726007314274",
        "updated_at": "2022-09-15T07:45:57.000000Z",
        "created_at": "2022-09-15T07:45:57.000000Z",
        "id": 1931
    }
}
```

***Status Code:*** 200

<br>

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

### 6. Ringkasan User

***Endpoint:***

```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/fundraiser/ringkasan
```

***Response:***

```json
{
    "nama": "Juan Alma",
    "kode_referal": "FR04",
    "total_komisi": 1500,
    "semua": 10000,
    "total_donasi_hari_ini": 0,
    "uang_terkumpul_hari_ini": 0,
    "transaksi_terakhir": []
}
```

***Status Code:*** 200

### 7. Detail Donasi

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/fundraiser/donations/1931/details
```

***Response:***

```json
{
    "message": "successfully fetching donation detail",
    "data": {
        "id": 1931,
        "foto_campaign": null,
        "nama": "Juan Angela Alma",
        "email": "juan@gmail.com",
        "kode_donasi": "INVD16632279336825",
        "judul_campaign": "Peduly Jatim",
        "donasi": "10000",
        "metode_pembayaran": "bank_transfer",
        "status_donasi": "Approved",
        "created_at": "2022-09-15 14:45:57",
        "deadline": "2022-09-16 14:45:33"
    },
    "error": false
}
```

***Status Code:*** 200

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
***Response:***

``` json
{
    "data": {
        "campaign": [
            {
                "id": 1053,
                "user_id": 2196,
                "judul_campaign": "Bantu Panti Asuhan Al-Hasan untuk tumbuh",
                "judul_slug": "bantu-panti-asuhan-al-hasan-untuk-tumbuh",
                "foto_campaign": "170620221807.jpg",
                "nominal_campaign": 10000000,
                "tag_campaign": null,
                "regencies": "kota surabaya",
                "batas_waktu_campaign": "2022-08-17",
                "detail_campaign": "<p>Panti Asuhan Al-Hasan Merupakan panti yang memiliki tujuan untuk memenuhi kebutuhan anak Yatim Piatu dari segi kehidupan sehari-hari  dan juga pendidikan. Kini Panti Asuhan sedang mengasuh kurang lebih 35 anak yatim yang bermukim di pondok agar pendidikan agamanya terpenuhi. Saat ini Panti Asuhan Al Hasan Surabaya perlu biaya untuk meneruskan hidup bagi 35 anak yatim yang sedang diasub dari  segi pendidikan formalnya. </p>",
                "update_campaign": null,
                "kategori_campaign": "Panti Asuhan",
                "status": "Approved",
                "penerima": "",
                "tujuan": "",
                "alamat_lengkap": "",
                "rincian": "",
                "created_at": "2022-06-17 18:05:55",
                "updated_at": "2022-06-17 18:05:55",
                "deleted_at": null
            }
        ],
        "user": [
            {
                "id": 2196,
                "photo": null,
                "name": "Viera",
                "status_akun": "Not Verified",
                "role": "Fundraiser",
                "tipe": "Individu"
            }
        ],
        "current_donation": [
            {
                "current_donation": "20360000"
            }
        ],
        "jumlah_donatur": {
            "jumlah_donatur": 8
        },
        "doa_donatur": [
            {
                "komentar": "Semangat yaa :)",
                "nama": "Juan Angela Alma",
                "photo": null,
                "id": 1
            }
        ],
        "kabar_terbaru": [
            {
                "id": 1,
                "judul": "Selamat yaa",
                "body": "<p>hello wordl</p>",
                "tanggal_dibuat": "2022-08-09 13:34:50",
                "user_id": 1,
                "name": "Anonim",
                "photo": null,
                "status_akun": "Verified",
                "role": "User",
                "tipe": "pribadi"
            }
        ],
        "donatur": [
            {
                "id": 1,
                "donasi": "50000",
                "photo": null,
                "nama": "Cornavianti Yarvenda",
                "created_at": "2022-06-17T11:27:24.000000Z"
            },
            {
                "id": 1,
                "donasi": "20000",
                "photo": null,
                "nama": "Intan Iswara",
                "created_at": "2022-06-20T12:58:26.000000Z"
            },
            {
                "id": 1,
                "donasi": "10000",
                "photo": null,
                "nama": "Dira fanesa",
                "created_at": "2022-06-20T13:06:26.000000Z"
            },
            {
                "id": 1,
                "donasi": "30000",
                "photo": null,
                "nama": "Muhammad Fatih A",
                "created_at": "2022-06-20T13:07:56.000000Z"
            },
            {
                "id": 1,
                "donasi": "15000",
                "photo": null,
                "nama": "Erika Putri",
                "created_at": "2022-06-20T16:54:26.000000Z"
            },
            {
                "id": 1,
                "donasi": "20000",
                "photo": null,
                "nama": "Resy Kayona",
                "created_at": "2022-06-26T08:16:55.000000Z"
            },
            {
                "id": 2196,
                "donasi": "215000",
                "photo": null,
                "nama": "Viera",
                "created_at": "2022-07-13T04:23:26.000000Z"
            },
            {
                "id": 1,
                "donasi": "20000000",
                "photo": null,
                "nama": "Juan Angela Alma",
                "created_at": "2022-08-09T06:31:07.000000Z"
            }
        ]
    }
}
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

### 5. Buat Campaign sebagai Urgent

***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/galangdana/1059/asurgent
```

***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Accept | application/json |  |

***Response:***

```json
{
    "data": [
        {
            "id": 1,
            "campaign_id": 1059,
            "created_at": "2022-10-31T06:44:11.000000Z",
            "updated_at": "2022-10-31T06:44:11.000000Z"
        }
    ]
}
```

***Status Code:*** 200

### 6. Campaign Milik User

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/galangdanasaya
```

***Response:***
```json
{
    "data": [
        {
            "id": 1064,
            "judul_campaign": "Peduly Jatim",
            "judul_slug": "peduly-jatim-3",
            "foto_campaign": "peduly-jatim-3.png",
            "nominal_campaign": 6000000,
            "batas_waktu_campaign": "2023-06-23",
            "created_at": "2022-08-09T07:02:20.000000Z",
            "total_donasi": "0",
            "donations_count": "0"
        },
        {
            "id": 1063,
            "judul_campaign": "Peduly Jatim",
            "judul_slug": "peduly-jatim-2",
            "foto_campaign": "peduly-jatim-2.png",
            "nominal_campaign": 6000000,
            "batas_waktu_campaign": "2023-06-23",
            "created_at": "2022-08-09T07:00:03.000000Z",
            "total_donasi": "0",
            "donations_count": "0"
        },
        {
            "id": 1060,
            "judul_campaign": "Peduly Jatim",
            "judul_slug": "peduly-jatim",
            "foto_campaign": "peduly-jatim.png",
            "nominal_campaign": 6000000,
            "batas_waktu_campaign": "2023-06-23",
            "created_at": "2022-08-09T04:47:56.000000Z",
            "total_donasi": "0",
            "donations_count": "0"
        },
        {
            "id": 1059,
            "judul_campaign": "Peduly Jatim",
            "judul_slug": "peduly-jatim-indonesia",
            "foto_campaign": null,
            "nominal_campaign": 6000000,
            "batas_waktu_campaign": "2023-06-23",
            "created_at": "2022-08-09T04:47:18.000000Z",
            "total_donasi": "200000",
            "donations_count": "19"
        }
    ]
}
```

***Status Code:*** 200

### 7. Laporkan Galang Dana

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/galangdana/{campaign}/report
```

***Expected Response:***
```json
{
    "message": "Berhasil melaporkan galang dana",
    "campaign_id": 1060,
    "user_id": 2189,
    "error": false
}
```

***Status Code:*** 200

### 8. Batalkan Laporan Galang Dana

***Endpoint:***
```bash
Method: DELETE
Type: 
URL: http://127.0.0.1:8000/api/galangdana/{campaign}/report
```

***Expected Response:***
```json
{
    "message": "Berhasil batalkan laporan galang dana",
    "campaign_id": 1060,
    "user_id": 2189,
    "error": false
}
```

***Status Code:*** 200

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

### 7. Detail User

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/user
```

***Response:***

```json
{
    "user": {
        "id": 2189,
        "socialite_id": null,
        "socialite_name": null,
        "name": "Juan Alma",
        "role": "Fundraiser",
        "tipe": "organisasi",
        "username": "juanalma",
        "email": "juanangelaalma@gmail.com",
        "email_verified_at": null,
        "status_akun": "Verified",
        "no_telp": null,
        "usia": null,
        "jenis_kelamin": "Pria",
        "alamat": "Kauman",
        "provinsi": 0,
        "kabupaten": 0,
        "kecamatan": 0,
        "tempat_lahir": null,
        "tanggal_lahir": "2001-06-18",
        "pekerjaan": "Programmer",
        "jenis_organisasi": "Yayasan",
        "tanggal_berdiri": "2001-12-12",
        "photo": "http://127.0.0.1:8000/images/images_profile/1662467584.png",
        "foto_ktp": null,
        "bank": null,
        "no_rek": null,
        "created_at": "2022-06-16T08:29:00.000000Z",
        "updated_at": "2022-09-06T13:54:23.000000Z",
        "deleted_at": "-000001-11-29T16:52:48.000000Z",
        "balance": {
            "id": 1,
            "user_id": 2189,
            "amount": 86000,
            "status": "active",
            "created_at": "2022-08-16T10:01:18.000000Z",
            "updated_at": "2022-10-27T04:42:39.000000Z"
        }
    }
}
```

***Status Code:*** 200

### 8. Ganti Password

***Endpoint:***
```bash
Method: PUT
Type: 
URL: http://127.0.0.1:8000/api/user/change_password
```

***Body:***
```json
{
    "old_password": "cpktnwt1234",
    "new_password": "cpktnwt123"
}
```

***Response:***
```json
{
    "message": "Password updated successfully."
}
```

***Status Code:*** 200

### 9. Kode Referal User

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/user/kode_referal
```

***Response:***
```json
{
    "data": {
        "kode_referal": "FR04"
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

## Kabar Terbaru

### 1. Upload

***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/kabar_terbaru/upload
```

***Body:***


| Key | Value | Description |
| --- | ------|-------------|
| file | Image Object |  |

***Response:***

```json
{
    "location": "/storage/kabar_terbaru/test.jpg"
}
```

***Status Code:*** 200

### 2. Store

***Endpoint:***

```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/kabar_terbaru/store
```

***Body:***
```json
{
    "judul": "Ini adalah judul",
    "campaign_id": 1058,
    "body": "ini adaah body"
}
```

***Response:***

```json
{
    "data": {
        "judul": "Ini adalah judul",
        "body": "ini adaah body",
        "user_id": 2189,
        "campaign_id": 1058,
        "updated_at": "2022-11-02T04:16:45.000000Z",
        "created_at": "2022-11-02T04:16:45.000000Z",
        "id": 2
    },
    "error": false
}
```

***Status Code:*** 201

<br>

 ## Wishlist
 
 ### 1. Get Wishlist
 
 ***Endpoint:***
 ```bash
 Method: GET
 Type: 
 URL: http://127.0.0.1:8000/api/wishlists
 ```
 
 ***Responses***
 ```json
 {
    "data": [
        {
            "id": 3,
            "user_id": 2189,
            "campaign_id": 1056,
            "created_at": "2022-08-08T04:45:47.000000Z",
            "updated_at": "2022-08-08T04:45:47.000000Z"
        }
    ]
}
```

***Status Code:*** 200

### 2. Buat Wishlist

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/wishlists/create
```

***Body:***
```json
{
    "campaign_id": 1055
}
```

***Response:***
```json
{
    "message": "successfully created wishlist",
    "data": {
        "campaign_id": 1055,
        "user_id": 2189,
        "updated_at": "2022-11-04T06:29:06.000000Z",
        "created_at": "2022-11-04T06:29:06.000000Z",
        "id": 5
    }
}
```

***Status Code:*** 201

### 3. Hapus Wishlist

***Endpoint:***
```bash
Method: DELETE
Type: 
URL: http://127.0.0.1:8000/api/wishlists/5/delete
```

***Response:***
```json
{
    "message": "successfully deleted wishlist"
}
```

***Status Code:*** 200

<br>

## Slider

### 1. Buat Slider

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/slides/create
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| url | https://google.com |  |
| image | Image Object | |

***Response:***
```json
{
    "message": "Slider Created Successfully"
}
```

***Status Code:*** 201

***More example Requests/Responses***

#### I. Example request:

***Body:*** 
| Key | Value | Description |
| --- | ------|-------------|
| url | https://youtube.com |  |
| image | Image Object | |

#### I. Example response
```json
{
    "message": "Slider Created Successfully"
}
```

***Status Code:*** 201

### 2. All Slider

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/slides
```

***Response:***
```json
{
    "data": [
        {
            "id": 1,
            "url": "https://google.com",
            "image": "http://localhost/images/images_carousel/1667547107.jpg",
            "created_at": "2022-11-04T07:31:47.000000Z",
            "updated_at": "2022-11-04T07:31:47.000000Z"
        },
        {
            "id": 2,
            "url": "https://youtube.com",
            "image": "http://localhost/images/images_carousel/1667547489.png",
            "created_at": "2022-11-04T07:38:09.000000Z",
            "updated_at": "2022-11-04T07:38:09.000000Z"
        }
    ]
}
```

***Status Code:*** 200

### 3. Ubah Slider

***Endpoint:***
```bash
Method: PUT
Type: 
URL: http://127.0.0.1:8000/api/slides/2/update
```

***Body:***
```json
{
    "url": "https://facebook.com"
}
```

***Response:***
```json
{
    "message": "Slider Updated Successfully"
}
```

***Status Code:*** 200

### 4. Hapus Slider

***Endpoint:***
```bash
Method: DELETE
Type: 
URL: http://127.0.0.1:8000/api/slides/2/update
```

***Response:***
```json
{
    "message": "Slider Deleted Successfully"
}
```

***Status Code:*** 200

<br>

## Topup

### 1. Topup Emoney

### 2. Detail Topup

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/topup/73/details"
```
***Response:***
```json
{
    "error": false,
    "message": "success",
    "data": {
        "id": 73,
        "user_id": 2189,
        "balance_id": 1,
        "invoice_id": "INVT16655049852862",
        "amount": 100000,
        "payment_method": "emoney",
        "payment_name": "shopeepay",
        "qr_code": "https://api.sandbox.midtrans.com/v2/gopay/1a93aff0-1463-49a2-ad8d-6ecadf88af81/qr-code",
        "va_number": null,
        "deadline": "2022-10-12 23:16:25",
        "status": "pending",
        "created_at": "2022-10-11T16:16:25.000000Z",
        "updated_at": "2022-10-11T16:16:25.000000Z"
    }
}
```

<br>

## Feeds

### 1. All Feeds

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/feeds
```

***Response:***
```json
[
    {
        "id": 3,
        "user_id": 1,
        "content": "Semoga lekas sembuh yaa:)",
        "insertion_link": "https://demo.peduly.com/campaign/peduly-jatim-indonesia",
        "insertion_link_title": "Peduly Jatim",
        "created_at": "2022-10-11T16:08:26.000000Z",
        "updated_at": "2022-10-11T16:08:26.000000Z",
        "likes_count": 0,
        "user": {
            "id": 1,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Anonim",
            "role": "User",
            "tipe": "pribadi",
            "username": "anonim",
            "email": "anonim@peduly.com",
            "email_verified_at": "2019-11-04T03:33:21.000000Z",
            "status_akun": "Verified",
            "no_telp": null,
            "usia": null,
            "jenis_kelamin": null,
            "alamat": null,
            "provinsi": null,
            "kabupaten": null,
            "kecamatan": null,
            "tempat_lahir": null,
            "tanggal_lahir": null,
            "pekerjaan": null,
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": null,
            "no_rek": null,
            "created_at": "2019-09-26T22:34:41.000000Z",
            "updated_at": "2019-09-26T22:34:41.000000Z",
            "deleted_at": "-000001-11-29T16:52:48.000000Z"
        }
    },
    {
        "id": 2,
        "user_id": 1,
        "content": null,
        "insertion_link": "https://demo.peduly.com/campaign/peduly-jatim-indonesia",
        "insertion_link_title": "Peduly Jatim",
        "created_at": "2022-10-11T15:59:52.000000Z",
        "updated_at": "2022-10-11T15:59:52.000000Z",
        "likes_count": 0,
        "user": {
            "id": 1,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Anonim",
            "role": "User",
            "tipe": "pribadi",
            "username": "anonim",
            "email": "anonim@peduly.com",
            "email_verified_at": "2019-11-04T03:33:21.000000Z",
            "status_akun": "Verified",
            "no_telp": null,
            "usia": null,
            "jenis_kelamin": null,
            "alamat": null,
            "provinsi": null,
            "kabupaten": null,
            "kecamatan": null,
            "tempat_lahir": null,
            "tanggal_lahir": null,
            "pekerjaan": null,
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": null,
            "no_rek": null,
            "created_at": "2019-09-26T22:34:41.000000Z",
            "updated_at": "2019-09-26T22:34:41.000000Z",
            "deleted_at": "-000001-11-29T16:52:48.000000Z"
        }
    },
    {
        "id": 1,
        "user_id": 1,
        "content": null,
        "insertion_link": "https://demo.peduly.com/campaign/peduly-jatim-indonesia",
        "insertion_link_title": "Peduly Jatim",
        "created_at": "2022-10-11T15:58:45.000000Z",
        "updated_at": "2022-10-11T15:58:45.000000Z",
        "likes_count": 0,
        "user": {
            "id": 1,
            "socialite_id": null,
            "socialite_name": null,
            "name": "Anonim",
            "role": "User",
            "tipe": "pribadi",
            "username": "anonim",
            "email": "anonim@peduly.com",
            "email_verified_at": "2019-11-04T03:33:21.000000Z",
            "status_akun": "Verified",
            "no_telp": null,
            "usia": null,
            "jenis_kelamin": null,
            "alamat": null,
            "provinsi": null,
            "kabupaten": null,
            "kecamatan": null,
            "tempat_lahir": null,
            "tanggal_lahir": null,
            "pekerjaan": null,
            "jenis_organisasi": null,
            "tanggal_berdiri": null,
            "photo": null,
            "foto_ktp": null,
            "bank": null,
            "no_rek": null,
            "created_at": "2019-09-26T22:34:41.000000Z",
            "updated_at": "2019-09-26T22:34:41.000000Z",
            "deleted_at": "-000001-11-29T16:52:48.000000Z"
        }
    }
]
```

### 2. Menyukai Feed

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/feeds/{id}/like
```

***Response:***
```json
{
    "message": "Berhasil menyukai feed",
    "feed_id": 1,
    "user_id": 2189,
    "error": false
}
```

***Status Code:*** 200

### 3. Batalkan Menyukai Feed

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/feeds/{id}/like
```

***Response:***
```json
{
    "message": "Berhasil batalkan menyukai feed",
    "feed_id": 1,
    "user_id": 2189,
    "error": false
}
```

***Status Code:*** 200

<br>

## Ada Yang Baru

### 1. All Ada Yang Baru

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/adayangbaru
```

***Response:***
```json
[
    {
        "id": 1,
        "judul": "tes123",
        "tanggal": "2022-11-09",
        "deskripsi": "testestes",
        "created_at": "2022-11-09T06:56:49.000000Z",
        "updated_at": "2022-11-09T06:56:49.000000Z"
    },
    {
        "id": 3,
        "judul": "tes125",
        "tanggal": "2022-11-09",
        "deskripsi": null,
        "created_at": "2022-11-09T07:37:44.000000Z",
        "updated_at": "2022-11-09T07:37:44.000000Z"
    },
    {
        "id": 2,
        "judul": "tes124",
        "tanggal": "2022-11-01",
        "deskripsi": "testestes2",
        "created_at": "2022-11-09T07:01:02.000000Z",
        "updated_at": "2022-11-09T07:01:02.000000Z"
    }
]
```

***Status Code:*** 200

### 2. Buat Ada Yang Baru

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/adayangbaru/create
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| judul | tes126 |  |
| tanggal | 2022-11-10 | |
| deskripsi | testestes4 | |

***Response:***
```json
{
    "message": "Berhasil menambahkan data",
    "data": {
        "judul": "tes126",
        "tanggal": "2022-11-10",
        "deskripsi": "testestes4",
        "updated_at": "2022-11-14T04:24:47.000000Z",
        "created_at": "2022-11-14T04:24:47.000000Z",
        "id": 8
    },
    "error": false
}
```

***Status Code:*** 200

### 3. Ubah Ada Yang Baru

***Endpoint:***
```bash
Method: POST
Type: 
URL: http://127.0.0.1:8000/api/adayangbaru/{id}
```

***Body:***
| Key | Value | Description |
| --- | ------|-------------|
| \_method | PUT | |
| judul | tes127 | |
| tanggal | 2000-01-01 | |
| deskripsi | testestes5 | |

***Response:***
```json
{
    "message": "Berhasil mengubah data",
    "data": {
        "id": 8,
        "judul": "tes127",
        "tanggal": "2000-01-01",
        "deskripsi": "testestes5",
        "created_at": "2022-11-14T04:24:47.000000Z",
        "updated_at": "2022-11-14T04:24:47.000000Z"
    },
    "error": false
}
```

***Status Code:*** 200

### 4. Hapus Ada Yang Baru

***Endpoint:***
```bash
Method: DELETE
Type: 
URL: http://127.0.0.1:8000/api/adayangbaru/{id}
```

***Response:***
```json
{
    "message": "Berhasil menghapus data",
    "id": "8",
    "error": false
}
```

***Status Code:*** 200



## Admin

### 1. Get Users
***Note***
data ini hanya bisa diakses oleh user yang mempunyai role **Admin**

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/admin/users
```

***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Authorization | Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYzODg2ODM5MSwiZXhwIjoxNjM4ODcxOTkxLCJuYmYiOjE2Mzg4NjgzOTEsImp0aSI6IjByS1AwSFVncVpudHBjaEMiLCJzdWIiOjIxMTEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.KYUHlQ0fUEwQp6jjKQp3XqhFfMpR8H5lFJWuV_ZsTXM |  |

***Response:***
```json
{
    "data": [
        {
            "name": "Satoshi 00ZX",
            "username": "Satoshi",
            "email": "ronaldisaya@gmail.com",
            "no_telp": "085938594838",
            "role": "User",
            "tanggal_dibuat": "29/11/2022 08:17"
        },
        {
            "name": "DeRev",
            "username": "derin",
            "email": "rizkinuranfalah@gmail.com",
            "no_telp": "085938594838",
            "role": "User",
            "tanggal_dibuat": "29/11/2022 00:52"
        },
        {
            "name": "Sulaiman Adi Wijaya",
            "username": null,
            "email": "sulaimanadiwijaya@gmail.com",
            "no_telp": null,
            "role": "User",
            "tanggal_dibuat": "28/11/2022 21:26"
        },
        {
            "name": "Rihhadati Aisy",
            "username": "riggadati",
            "email": "rihhaisy88@gmail.com",
            "no_telp": null,
            "role": "User",
            "tanggal_dibuat": "27/11/2022 14:18"
        },
    ]
}
```

***Status Code:*** 200

### 2. Galang Dana

***Endpoint:***
```bash
Method: GET
Type: 
URL: http://127.0.0.1:8000/api/admin/galangdana
```

***Expected Response:***
```json
{
    "data": [
        {
            "id": 1071,
            "judul_campaign": "jeje",
            "name": "jeje",
            "nominal_campaign": 1000000,
            "total_donasi": "0",
            "sisa_waktu": "25 hari",
            "status": "Pending"
        },
        {
            "id": 1063,
            "judul_campaign": "Peduly Jatim",
            "name": "Juan Alma",
            "nominal_campaign": 6000000,
            "total_donasi": "0",
            "sisa_waktu": "198 hari",
            "status": "Pending"
        },
        {
            "id": 1059,
            "judul_campaign": "Peduly Jatim",
            "name": "Juan Alma",
            "nominal_campaign": 6000000,
            "total_donasi": "200000",
            "sisa_waktu": "198 hari",
            "status": "Pending"
        },
        {
            "id": 1056,
            "judul_campaign": "Bantu Wujudkan Rumah Yatim",
            "name": "Viera",
            "nominal_campaign": 350000000,
            "total_donasi": "0",
            "sisa_waktu": "24 hari",
            "status": "Approved"
        },
        {
            "id": 1038,
            "judul_campaign": "Bantu siti asnatun ibu satu anak hadapi stroke (lumpuh kaki kiri )",
            "name": "siti asnatun",
            "nominal_campaign": 75000000,
            "total_donasi": "0",
            "sisa_waktu": "-",
            "status": "Approved"
        }
    ]
}
```

***Status Code:*** 200

<br>

___
[Back to top](#peduly)
> Made with &#9829; by [thedevsaddam](https://github.com/thedevsaddam) | Generated at: 2021-10-19 11:55:52 by [docgen](https://github.com/thedevsaddam/docgen)
