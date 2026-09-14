<?php
// Jalankan melalui CLI sebelum Composer/Artisan; tidak memuat Laravel.
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
$root = __DIR__;
$backup = $root . '/storage/app/update-backups/' . date('Ymd-His');
function backupOld(string $source, string $destination): void {
    if (!is_dir(dirname($destination)) && !mkdir(dirname($destination), 0775, true)) {
        throw new RuntimeException('Tidak bisa membuat folder backup.');
    }
    if (!rename($source, $destination)) { throw new RuntimeException('Gagal memindahkan file lama: ' . $source); }
}
// Salinan source di config dapat dimuat sebagai konfigurasi dan menduplikasi class.
if (is_dir($root . '/config/app')) { backupOld($root . '/config/app', $backup . '/config-app'); }
$old = $root . '/app/Models/itemPenjualan.php';
$new = $root . '/app/Models/ItemPenjualan.php';
if (is_file($old) && is_file($new) && realpath($old) !== realpath($new)) {
    backupOld($old, $backup . '/itemPenjualan.php');
}
foreach (['bootstrap/cache/*.php', 'bootstrap/cache/*.tmp', 'storage/framework/views/*.php'] as $pattern) {
    foreach (glob($root . '/' . $pattern) ?: [] as $file) {
        if (!unlink($file)) { throw new RuntimeException('Gagal membersihkan cache: ' . $file); }
    }
}
echo "Persiapan selesai. File lama yang dipindahkan tersedia di storage/app/update-backups.\n";
