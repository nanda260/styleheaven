document.addEventListener("DOMContentLoaded", function () {
    const quantityButtons = document.querySelectorAll(".quantity-btn");

    quantityButtons.forEach(button => {
        button.addEventListener("click", function () {
            const cartId = this.dataset.id;
            const action = this.classList.contains("increment") ? "increment" : "decrement";
            const parent = this.closest(".cart-item");
            const quantitySpan = parent.querySelector(".quantity-number");

            fetch("update_quantity.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${cartId}&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    quantitySpan.textContent = data.new_quantity;
                    location.reload(); // Untuk refresh subtotal dan total
                } else {
                    alert(data.error || "Terjadi kesalahan");
                }
            })
            .catch(() => {
                alert("Gagal memperbarui kuantitas");
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', () => {
            const cartId = button.getAttribute('data-id');

            if (confirm("Yakin ingin menghapus item ini dari keranjang?")) {
                fetch('hapus_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${cartId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan!');
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('checkout-overlay');
    const closeBtn = document.querySelector('.close-overlay');
    const checkoutBtn = document.querySelector('.checkout-btn');

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            overlay.classList.remove('hidden');
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            overlay.classList.add('hidden');
        });
    }

    document.getElementById('submit-checkout').addEventListener('click', () => {
        const alamat = document.getElementById('alamat').value;
        const file = document.getElementById('bukti-transfer').files[0];

        if (!alamat || !file) {
            alert('Harap isi alamat dan upload bukti transfer!');
            return;
        }

        // Kirim data ke server jika perlu, contoh:
        // let formData = new FormData();
        // formData.append('alamat', alamat);
        // formData.append('bukti', file);

        alert('Checkout berhasil! Data akan diproses.');
        overlay.classList.add('hidden');
    });
});
