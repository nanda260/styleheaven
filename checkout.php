<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Harap login terlebih dahulu!'); window.location.href='index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $nama_penerima = $_POST['nama_penerima'];
    $alamat_pengiriman = $_POST['alamat'];
    $total_harga = $_POST['total_harga'];
    $status = 'Pending';
    $tanggal_pesanan = date("Y-m-d H:i:s");

    $bukti_transfer = null;
    if (!empty($_FILES["bukti"]["name"])) {
        $target_dir = "bukti_transfer/";
        $file_name = time() . "_" . basename($_FILES["bukti"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
            $bukti_transfer = $file_name;
        } else {
            echo "<script>alert('Gagal mengupload bukti transfer!'); window.history.back();</script>";
            exit();
        }
    }

    $conn->begin_transaction();

    try {
        // Simpan pesanan ke tabel orders
        $sql = "INSERT INTO orders (user_id, total_harga, status, tanggal_pesanan, nama_penerima, bukti_transfer, alamat_pengiriman) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idsssss", $user_id, $total_harga, $status, $tanggal_pesanan, $nama_penerima, $bukti_transfer, $alamat_pengiriman);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // Ambil data dari keranjang termasuk size
        $sql_cart = "SELECT product_id, quantity, size FROM cart WHERE user_id = ?";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param("i", $user_id);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();

        while ($row = $result_cart->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $size = $row['size'];

            // Ambil harga produk
            $sql_harga = "SELECT harga FROM produk WHERE id = ?";
            $stmt_harga = $conn->prepare($sql_harga);
            $stmt_harga->bind_param("i", $product_id);
            $stmt_harga->execute();
            $result_harga = $stmt_harga->get_result();

            if ($row_harga = $result_harga->fetch_assoc()) {
                $harga_satuan = $row_harga['harga'];
            } else {
                throw new Exception("Produk dengan ID $product_id tidak ditemukan.");
            }

            // Kurangi stok produk
            $sql_update_stok = "UPDATE produk SET stok = stok - ? WHERE id = ? AND stok >= ?";
            $stmt_update_stok = $conn->prepare($sql_update_stok);
            $stmt_update_stok->bind_param("iii", $quantity, $product_id, $quantity);
            $stmt_update_stok->execute();

            if ($stmt_update_stok->affected_rows == 0) {
                throw new Exception("Stok produk tidak mencukupi atau produk tidak ditemukan.");
            }

            // Simpan ke tabel order_items termasuk size
            $sql_item = "INSERT INTO order_items (order_id, product_id, harga_satuan, quantity, size) 
                         VALUES (?, ?, ?, ?, ?)";
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param("iidis", $order_id, $product_id, $harga_satuan, $quantity, $size);
            $stmt_item->execute();
        }

        // Hapus data cart
        $sql_delete_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt_delete_cart = $conn->prepare($sql_delete_cart);
        $stmt_delete_cart->bind_param("i", $user_id);
        $stmt_delete_cart->execute();

        $conn->commit();

        echo "<script>alert('Pesanan berhasil dibuat!'); window.location.href='cart.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
