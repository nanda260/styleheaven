<?php
include 'config.php';

$sql = "SELECT * FROM produk ORDER BY stok ASC";
$products = [];
$result = mysqli_query($conn, $sql);
while ($product = mysqli_fetch_assoc($result)) {
    $products[] = $product;
}

if (isset($_POST['submit-product'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    // file upload
    $namaFile = $_FILES['gambar']['name'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    $uniqueName = uniqid() . '_' . $namaFile;
    $targetDir = '../uploads/';
    $targetFile = $targetDir . $uniqueName;

    if (move_uploaded_file($tmpName, $targetFile)) {
        $qr = "INSERT INTO produk (nama, harga, stok, kategori, deskripsi, gambar) 
               VALUES ('$nama', $harga, $stok, '$kategori', '$deskripsi', '$uniqueName')";

        if (mysqli_query($conn, $qr)) {
            header('Location: manage_product.php');
            echo "<script>alert('Succes, product successfully added.')</script>";
            exit;
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Gagal mengunggah gambar.')</script>";
    }
}

//EDIT
if (isset($_POST['submit-edit'])) {
    $id = $_POST['submit-edit'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $gambarBaru = '';
    if (!empty($_FILES['gambar']['name'])) {
        $namaFile = $_FILES['gambar']['name'];
        $tmpName = $_FILES['gambar']['tmp_name'];
        $uniqueName = uniqid() . '_' . $namaFile;
        $targetDir = '../uploads/';
        $targetFile = $targetDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $gambarBaru = $uniqueName;
        } else {
            echo "<script>alert('Gagal mengunggah gambar baru.')</script>";
        }
    }

    $qr = "UPDATE produk SET nama = '$nama', harga = $harga, stok = $stok, kategori = '$kategori', deskripsi = '$deskripsi'";

    if ($gambarBaru) {
        $qr .= ", gambar = '$gambarBaru'";
    }

    $qr .= " WHERE id = $id";

    if (mysqli_query($conn, $qr)) {
        echo "<script>alert('Product updated successfully.'); window.location.href = 'manage_product.php';</script>";
        exit;
    } else {
        echo "Database Error saat update: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/mng_product.css">
    <style>
        .btn-addlook {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            font-size: 14px;
            font-family: Poppins, static;
            text-decoration: none;
            padding: 8px 15px;
            cursor: pointer;
            border: 1px solid #000;
            transition: 0.3s ease-in-out;

            &:hover {
                background-color: #000000;
                color: #ffffff;
            }

            i {
                padding-right: 2px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Manage Product</h2>
        <button id="openForm" class="btn-add"><i class="bi bi-bag-plus-fill"></i> Add Product</button>
        <a href="add_look.php" class="btn-addlook"><i class="bi bi-person-lines-fill"></i> Add Look
        </a>
        <div class="overlay" id="overlayForm">
            <div class="form-container">
                <span class="close-btn" id="closeForm">&times;</span>
                <h3>Add Product</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama" placeholder="Product Name" required>

                    <input type="number" name="harga" placeholder="Price" required>

                    <div class="row">
                        <input type="number" name="stok" placeholder="Stock" required>
                        <select name="kategori" required>
                            <option value="" disabled selected>Category</option>
                            <option value="Kids">Kids</option>
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                    </div>

                    <textarea name="deskripsi" placeholder="Description" rows="3" required></textarea>
                    <input type="file" name="gambar" required>
                    <button type="submit" name="submit-product">Add Product</button>
                </form>
            </div>
        </div>

        <div class="products-box">
            <?php foreach ($products as $p) { ?>
                <div class="box-product">
                    <img src="../uploads/<?= $p['gambar']; ?>" alt="<?= $p['nama'] ?>" class="image">
                    <div class="text">
                        <ul>
                            <li style="font-weight: 500;"><?php $words = explode(" ", $p['nama']);
                                                            $nama = count($words) > 3 ? implode(" ", array_slice($words, 0, 3)) . "..." : $p['nama'];
                                                            echo $nama; ?></li>
                            <li style="color:rgba(255, 0, 0, 0.81);">Rp <?= number_format($p['harga'], 0, ',', '.'); ?> <span style="color: black;"> | </span><span style="color:rgb(86, 86, 86);"><?= $p['stok']; ?> pieces</span></li>
                            <li style="margin-top: 10px;"><button class="openEditForm" data-id="<?= $p['id'] ?>"><i class="bi bi-pencil-square"></i></button>

                                <a href="deleteproduk.php?id=<?= $p['id'] ?>"
                                    onclick="return confirm('Yakin hapus <?= htmlspecialchars($p['nama'], ENT_QUOTES) ?>?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </li>
                        </ul>
                        <p class="kategori"><?= $p['kategori']; ?></p>
                    </div>
                </div>

                <div class="overlay editOverlay" id="editOverlay-<?= $p['id'] ?>">
                    <div class="form-container">
                        <span class="close-btn closeEditForm" data-id="<?= $p['id'] ?>">&times;</span>
                        <h3>Edit Product</h3>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="text" name="nama" value="<?= htmlspecialchars($p['nama']) ?>" required>
                            <input type="number" name="harga" value="<?= $p['harga'] ?>" required>

                            <div class="row">
                                <input type="number" name="stok" value="<?= $p['stok'] ?>" required>
                                <select name="kategori" required>
                                    <option value="" disabled>Category</option>
                                    <option value="Kids" <?= $p['kategori'] == 'Kids' ? 'selected' : '' ?>>Kids</option>
                                    <option value="Men" <?= $p['kategori'] == 'Men' ? 'selected' : '' ?>>Men</option>
                                    <option value="Women" <?= $p['kategori'] == 'Women' ? 'selected' : '' ?>>Women</option>
                                </select>
                            </div>

                            <textarea name="deskripsi" rows="3" required><?= htmlspecialchars($p['deskripsi']) ?></textarea>
                            <input type="file" name="gambar">
                            <button type="submit" name="submit-edit" value="<?= $p['id'] ?>">Save Changes</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        const openForm = document.getElementById('openForm');
        const closeForm = document.getElementById('closeForm');
        const overlayForm = document.getElementById('overlayForm');

        openForm.addEventListener('click', () => {
            overlayForm.style.display = 'flex';
        });

        closeForm.addEventListener('click', () => {
            overlayForm.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === overlayForm) {
                overlayForm.style.display = 'none';
            }
        });

        // Buka modal edit
        document.querySelectorAll('.openEditForm').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const overlay = document.getElementById(`editOverlay-${id}`);
                if (overlay) overlay.style.display = 'flex';
            });
        });

        // Tutup modal edit
        document.querySelectorAll('.closeEditForm').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const overlay = document.getElementById(`editOverlay-${id}`);
                if (overlay) overlay.style.display = 'none';
            });
        });

        // Tutup modal saat klik di luar form
        window.addEventListener('click', (e) => {
            document.querySelectorAll('.editOverlay').forEach(overlay => {
                if (e.target === overlay) {
                    overlay.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>