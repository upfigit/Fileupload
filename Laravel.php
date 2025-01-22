<?php
require_once 'vendor/autoload.php'; // Pastikan Anda memuat autoload Laravel

use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan model User sudah sesuai dengan namespace yang Anda gunakan

// Mengambil pengguna dengan peran administrator
$adminUser = User::where('role', 'administrator')->first();

if ($adminUser) {
    // Melakukan login sebagai administrator
    Auth::login($adminUser);

    // Mengalihkan ke dashboard admin Laravel
    $redirectTo = url('/admin/dashboard'); // Ganti dengan URL dasbor admin Anda
    header("Location: $redirectTo");
    exit();
} else {
    // Jika tidak ada pengguna administrator
    echo "Tidak ada pengguna administrator yang ditemukan.";
}
?>
