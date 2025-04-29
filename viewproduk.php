<?php
session_start();
include 'config.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
$v = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style Heaven - <?= htmlspecialchars($v['nama']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/view.css">
    <script src="js/functions.js"></script>
    <script src="js/add-to-cart.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="container">
            <div class="image">
                <a href="uploads/<?= htmlspecialchars($v['gambar']); ?>" data-lightbox="produk" data-title="<?= htmlspecialchars($v['nama']) ?>" rel="lightbox">
                    <img src="uploads/<?= htmlspecialchars($v['gambar']); ?>" alt="<?= htmlspecialchars($v['nama']); ?>" width="300">
                </a>
            </div>

            <div class="masuk-keranjang">
                <ul>
                    <li class="nama-produk">
                        <?= htmlspecialchars($v['nama']); ?>
                    </li>       
                    <li>
                        <p class="rp">Rp <?= number_format($v['harga'], 0, ',', '.'); ?></p>
                    </li>
                    <li>
                        <textarea name="deskripsi" id="deskripsi" class="deskripsi-box" readonly><?= $v['deskripsi']; ?></textarea>
                    </li>

                    <li class="size">
                        <label>Select Size:</label>
                        <div class="size-options">
                            <?php $sizes = ["S", "M", "L", "XL", "XXL"]; ?>
                            <?php foreach ($sizes as $size) : ?>
                                <button class="size-btn" data-size="<?= $size; ?>"><?= $size; ?></button>
                            <?php endforeach; ?>
                        </div>
                    </li>

                    <li>
                        <label>Quantity:</label>
                        <div class="quantity-selector">
                            <table cellspacing="0">
                                <td style="background-color:rgb(215, 215, 215);"><button class="qty-btn" id="decrease">-</button></td>
                                <td><input type="number" class="num-input" id="quantity" name="quantity" value="1" min="1" max="<?= $v['stok']; ?>"></td>
                                <td style="background-color:rgb(215, 215, 215);"><button class="qty-btn" id="increase">+</button> </td>
                            </table>
                            <span><?= $v['stok']; ?> pieces left</span>
                        </div>
                    </li>

                    <li>
                        <button class="add-to-cart" data-id="<?= $v['id']; ?>">ADD TO CART</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="wa">
            <a href="https://wa.me/6281350060514" target="_blank"><i class="bi bi-whatsapp"></i></a>
        </div>
    </main>
    <footer>
        <p>Copyright &copy; 2025 Style Heaven. All rights reserved.</p>
    </footer>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const addToCartBtn = document.querySelector(".add-to-cart");
        const quantityInput = document.getElementById("quantity");
        const stockLeft = <?= (int)$v['stok']; ?>;

        if (stockLeft <= 0) {
            addToCartBtn.disabled = true;
            addToCartBtn.style.cursor = "not-allowed";
            addToCartBtn.textContent = "OUT OF STOCK";

            addToCartBtn.addEventListener("click", function () {
                alert("Stok habis. Silakan pilih produk lain.");
            });
        }
    });
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js" defer></script>
</body>

</html>