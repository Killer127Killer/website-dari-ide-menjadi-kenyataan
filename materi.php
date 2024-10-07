<?php
// Mulai sesi untuk melacak pengunjung
session_start();

// Buat folder 'uploads/materi' jika belum ada
if (!is_dir('uploads/materi')) {
    mkdir('uploads/materi', 0777, true);
}

// Proses unggah file
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $target_file = 'uploads/materi/' . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        echo "File berhasil diunggah. <a href='about.html'>Kembali ke halaman Materi</a>";
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}

// Fungsi untuk menambah jumlah pengunjung
function increment_visitor_count($file_name) {
    $counter_file = 'uploads/materi/' . $file_name . '.count';
    if (!file_exists($counter_file)) {
        file_put_contents($counter_file, 0);
    }
    $visitor_count = (int) file_get_contents($counter_file);
    $visitor_count++;
    file_put_contents($counter_file, $visitor_count);
    return $visitor_count;
}

// Melacak file yang dikunjungi
if (isset($_GET['file'])) {
    $file_name = $_GET['file'];
    increment_visitor_count($file_name);
    header('Location: uploads/materi/' . $file_name);
    exit();
}
?>
