# Membuat REST API

## Membuat REST Controller

Untuk membuat REST Controller kita hanya perlu membuat controller pada folder api/ di dalam module.

```
modules/
- post/
  - controllers/
    - admin/
    - api/
      - Post.php
```

Adapun struktur REST controller tidak berbeda jauh dari controller pada umumnya di CodeIgniter, hanya dia perlu `extends REST_Controller`.

```php
class Post extends REST_Controller 
{
	public function index()
	{
		$data = [
			'status'=>'success', 
			'data' => ['name' => 'Ahmad Oriza']
		];

		$this->response($data);
	}
}
```

Controller di atas dapat dipanggil dengan endpoint `domain.test/api/post`.

Bila kamu perlu mengembalikan status code selain 200, maka passing pada parameter kedua method response():

```php
$this->response($data, 401);
```

Atau kamu dapat menggunakan konstanta response code

```php
$this->response($data, self::HTTP_UNAUTHORIZED);
```

Adapun konstanta response code yang dapat kamu gunakan dapat dilihat di [bagian paling akhir halaman ini](#http-response-code).

Atau bila kamu ingin memberikan custom status code text, kamu dapat menggunakan method `setStatusCode()`:

```php
$this->setStatusCode(404, 'data tidak ditemukan')->response($data);
```

Untuk saat ini format output yang didukung baru JSON saja :)

## Endpoint API

Default route sudah didefinisikan di dalam application/config/routes.php. Format endpointnya seperti ini: 

```
domain.test/api/[module]/[rest_controller]/[method]/[params]
```

Bila nama REST controller sama dengan nama module maka pemanggilannya cukup 

```
domain.test/api/[rest_controller]/[method]/[params]
```

Untuk format endpoint custom, kamu mendefinisikan custom route pada file berikut
secara hirarkis:

- mein/routes/api.php
- public/shared/routes/api.php
- public/sites/[foldersite]/routes/api.php

Simpanlah custom route kamu di tempat yang sesuai dengan dimana modulenya disimpan.

Btw, custom route kita sudah mendukung http verbs, seperti ini:

```php
Route::get('from', 'to');
Route::post('from', 'to');
Route::put('from', 'to');
Route::delete('from', 'to');
Route::head('from', 'to');
Route::patch('from', 'to');
Route::options('from', 'to');
```

## JSON Web Token

JSON Web Token atau JWT pada MeinCMS digunakan sebagai pengganti session pada sistem PHP monolytic. Dan pada REST API di MeinCMS digunakan untuk mengidentifikasi user yang sudah login. Jadi, bila kamu ingin membuat endpoint API yang hanya boleh diakses oleh user yang sudah login, gunakan JWT ini untuk mengecek session user.

JWT sudah terintegrasi pada API login dari module user. Bila rekues login user berhasil, maka endpoint akan mengirimkan response berupa JWT.

```rest
POST https://codepolitan.test/api/user/auth/login
param:
- email
- password
```

Bila berhasil login, outputnya akan seperti ini:

```json
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMzYxIiwidXNlcm5hbWUiOiJ5bGx1bWkiLCJlbWFpbCI6InRvaGEuc2FtYmFAZ21haWwuY29tIiwicGhvbmUiOiIwODk4NjgxODc4MCIsInJvbGVfbmFtZSI6IlN1cGVyIiwidGltZXN0YW1wIjoxNTczMDIxMzU3fQ.JnTyyce1gQEPg6YzoCwck9OsSV4LuF1gsbzE_OtsFyE"}
```

Untuk selanjutnya kamu dapat menyimpan dan menggunakan token ini untuk mengirim request lain yang membutuhkan session user login. Adapun di sisi API, kamu dapat mengecek token melalui passing header Authorization ataupun postdata biasa. Bila token dipassing lewat header Authorization, kamu dapat mengecek menggunakan method bawaan REST Controller seperti ini:

```php
// Check JWT
$this->user = $this->checkToken();
```

Method `checkToken()` akan mengembalikan array data token yang sudah didecode bila pengecekan signature lolos (token valid). Bila token tidak valid, method ini akan mengembalikan response string "Unauthorized" dengan status code 401.


## HTTP Response Code {#http-response-code}

Berikut ini daftar konstanta yang dapat kamu gunakan sebagai referensi untuk mempermudah mengembalikan status code pada request

```php
// Informational
const HTTP_CONTINUE = 100;
const HTTP_SWITCHING_PROTOCOLS = 101;
const HTTP_PROCESSING = 102; // RFC2518

// Success
/**
 * The request has succeeded
 */
const HTTP_OK = 200;

/**
 * The server successfully created a new resource
 */
const HTTP_CREATED = 201;
const HTTP_ACCEPTED = 202;
const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;

/**
 * The server successfully processed the request, 
 * though no content is returned
 */
const HTTP_NO_CONTENT = 204;
const HTTP_RESET_CONTENT = 205;
const HTTP_PARTIAL_CONTENT = 206;
const HTTP_MULTI_STATUS = 207; // RFC4918
const HTTP_ALREADY_REPORTED = 208; // RFC5842
const HTTP_IM_USED = 226; // RFC3229

// Redirection
const HTTP_MULTIPLE_CHOICES = 300;
const HTTP_MOVED_PERMANENTLY = 301;
const HTTP_FOUND = 302;
const HTTP_SEE_OTHER = 303;

/**
 * The resource has not been modified since the last request
 */
const HTTP_NOT_MODIFIED = 304;
const HTTP_USE_PROXY = 305;
const HTTP_RESERVED = 306;
const HTTP_TEMPORARY_REDIRECT = 307;
const HTTP_PERMANENTLY_REDIRECT = 308; // RFC7238

// Client Error
/**
 * The request cannot be fulfilled due to multiple errors
 */
const HTTP_BAD_REQUEST = 400;

/**
 * The user is unauthorized to access the requested resource
 */
const HTTP_UNAUTHORIZED = 401;
const HTTP_PAYMENT_REQUIRED = 402;

/**
 * The requested resource is unavailable at this present time
 */
const HTTP_FORBIDDEN = 403;

/**
 * The requested resource could not be found
 *
 * Note: This is sometimes used to mask if there was an UNAUTHORIZED (401) or
 * FORBIDDEN (403) error, for security reasons
 */
const HTTP_NOT_FOUND = 404;

/**
 * The request method is not supported by the following resource
 */
const HTTP_METHOD_NOT_ALLOWED = 405;

/**
 * The request was not acceptable
 */
const HTTP_NOT_ACCEPTABLE = 406;
const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
const HTTP_REQUEST_TIMEOUT = 408;

/**
 * The request could not be completed due to a conflict with the current state
 * of the resource
 */
const HTTP_CONFLICT = 409;
const HTTP_GONE = 410;
const HTTP_LENGTH_REQUIRED = 411;
const HTTP_PRECONDITION_FAILED = 412;
const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
const HTTP_REQUEST_URI_TOO_LONG = 414;
const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
const HTTP_EXPECTATION_FAILED = 417;
const HTTP_I_AM_A_TEAPOT = 418; // RFC2324
const HTTP_UNPROCESSABLE_ENTITY = 422; // RFC4918
const HTTP_LOCKED = 423; // RFC4918
const HTTP_FAILED_DEPENDENCY = 424; // RFC4918
const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425; // RFC2817
const HTTP_UPGRADE_REQUIRED = 426; // RFC2817
const HTTP_PRECONDITION_REQUIRED = 428; // RFC6585
const HTTP_TOO_MANY_REQUESTS = 429; // RFC6585
const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431; // RFC6585

// Server Error
/**
 * The server encountered an unexpected error
 *
 * Note: This is a generic error message when no specific message
 * is suitable
 */
const HTTP_INTERNAL_SERVER_ERROR = 500;

/**
 * The server does not recognise the request method
 */
const HTTP_NOT_IMPLEMENTED = 501;
const HTTP_BAD_GATEWAY = 502;
const HTTP_SERVICE_UNAVAILABLE = 503;
const HTTP_GATEWAY_TIMEOUT = 504;
const HTTP_VERSION_NOT_SUPPORTED = 505;
const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506; // RFC2295
const HTTP_INSUFFICIENT_STORAGE = 507; // RFC4918
const HTTP_LOOP_DETECTED = 508; // RFC5842
const HTTP_NOT_EXTENDED = 510; // RFC2774
const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;
```