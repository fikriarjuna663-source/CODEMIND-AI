<?php

/*
|--------------------------------------------------------------------------
| Membersihkan Input
|--------------------------------------------------------------------------
*/

function bersihkan($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/*
|--------------------------------------------------------------------------
| Kompatibilitas Kode Lama
|--------------------------------------------------------------------------
| Jika masih ada file yang memakai clean(),
| otomatis akan menggunakan fungsi bersihkan().
*/

function clean($data)
{
    return bersihkan($data);
}

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

function redirect($url)
{
    header("Location: " . $url);
    exit;
}

/*
|--------------------------------------------------------------------------
| Alert
|--------------------------------------------------------------------------
*/

function alert($pesan)
{
    return "<script>alert('$pesan');</script>";
}

/*
|--------------------------------------------------------------------------
| Alert + Redirect
|--------------------------------------------------------------------------
*/

function sukses($pesan, $url = "")
{
    if (!empty($url)) {
        return "<script>
                    alert('$pesan');
                    window.location='$url';
                </script>";
    }

    return "<script>alert('$pesan');</script>";
}

/*
|--------------------------------------------------------------------------
| Gagal
|--------------------------------------------------------------------------
*/

function gagal($pesan)
{
    return "<script>alert('$pesan');</script>";
}