<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    // Pastikan folder ada
    if (!file_exists("../uploads/look/")) {
        mkdir("../uploads/look/", 0777, true);
    }

    // Upload file
    move_uploaded_file($tmp, "../uploads/look/" . $gambar);

    // Insert ke tabel looks
    $query = "INSERT INTO looks (look_name, look_image) VALUES ('$judul', '$gambar')";
    if (mysqli_query($conn, $query)) {
        $last_id = mysqli_insert_id($conn);

        // Cek produk yang dipilih
        if (isset($_POST['produk_ids'])) {
            $produk_ids = $_POST['produk_ids'];
            foreach ($produk_ids as $produk_id) {
                $query_produk = "INSERT INTO look_produk (look_id, produk_id) VALUES ('$last_id', '$produk_id')";
                mysqli_query($conn, $query_produk);
            }
        }

        header("Location: look_list.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Look</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        form {
            max-width: 900px;
            margin: auto;
        }

        input[type=text], input[type=file] {
            display: block;
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
        }

        button {
            padding: 12px 30px;
            background: black;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .products-box {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        .box-product {
            display: flex;
            flex-direction: column;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 180px;
            background: #fff;
            position: relative;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .box-product:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .box-product input[type=checkbox] {
            position: absolute;
            top: 10px;
            left: 10px;
            transform: scale(1.3);
            z-index: 2;
        }

        .box-product img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .box-product .text {
            padding: 10px;
        }

        .box-product ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .box-product ul li {
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .box-product .kategori {
            position: absolute;
            bottom: 5px;
            right: 10px;
            font-size: 0.75rem;
            color: #555;
        }

        /* Efek border kalau dipilih */
        .box-product input[type=checkbox]:checked ~ img,
        .box-product input[type=checkbox]:checked ~ .text {
            border-color: #2196F3;
        }

        .box-product input[type=checkbox]:checked ~ .text {
            border-top: 2px solid #2196F3;
        }

        .box-product input[type=checkbox]:checked ~ img {
            border-bottom: 2px solid #2196F3;
        }
    </style>
</head>
<body>

<h2>Tambah Look Baru</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="judul" placeholder="Judul Look" required>
    <input type="file" name="gambar" required>

    <h3>Pilih Produk:</h3>
    <div class="products-box">
        <?php
        $produk = mysqli_query($conn, "SELECT * FROM produk");
        while ($p = mysqli_fetch_assoc($produk)) {
            ?>
            <label class="box-product">
                <input type="checkbox" name="produk_ids[]" value="<?= $p['id'] ?>">
                <img src="../uploads/<?= $p['gambar']; ?>" alt="<?= $p['nama'] ?>">
                <div class="text">
                    <ul>
                        <li style="font-weight: 500;">
                            <?php 
                            $words = explode(" ", $p['nama']);
                            $nama = count($words) > 3 ? implode(" ", array_slice($words, 0, 3)) . "..." : $p['nama'];
                            echo $nama;
                            ?>
                        </li>
                        <li style="color:rgba(255, 0, 0, 0.81);">
                            Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                            <span style="color: black;"> | </span>
                            <span style="color:rgb(86, 86, 86);"><?= $p['stok']; ?> pcs</span>
                        </li>
                    </ul>
                    <p class="kategori"><?= $p['kategori']; ?></p>
                </div>
            </label>
        <?php } ?>
    </div>

    <button type="submit" name="submit">Simpan</button>
    <a href="look_list.php" class="btn-add" ><i class="bi bi-person-lines-fill"></i> Look List
            </a>

</form>

</body>
</html>
