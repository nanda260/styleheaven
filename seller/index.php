<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/index.css">
    <title>StyleHeaven - Seller</title>
    <style>
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><h2>STYLEHEAVEN</h2></li>
            <li><a href="dashboard.php" target="frame" class="list-side"><i class="bi bi-file-earmark-bar-graph"></i> Dashboard</a></li>
            <li><a href="manage_product.php" target="frame" class="list-side"><i class="bi bi-box-seam-fill"></i> Manage Product</a></li>
            <li><a href="manage_orders.php" target="frame" class="list-side"><i class="bi bi-card-checklist"></i> Manage Orders</a></li>

        </ul>
    </div>
    <div class="iframe-container">
        <iframe src="dashboard.php" frameborder="0" name="frame"></iframe>
    </div>
    <script>
    const links = document.querySelectorAll('.list-side');

    function removeActiveClasses() {
        links.forEach(link => {
            link.style.backgroundColor = ''; 
            link.style.color = ''; 
        });
    }
    links.forEach(link => {
        link.addEventListener('click', function () {
            removeActiveClasses();
            this.style.backgroundColor = 'white';
            this.style.color = 'black';
        });
    });

    window.addEventListener('load', function () {
        const iframe = document.querySelector('iframe');
        if (iframe && iframe.src.includes('dashboard.php')) {
            const dashboardLink = document.querySelector('a[href="dashboard.php"]');
            dashboardLink.style.backgroundColor = 'white';
            dashboardLink.style.color = 'black';
        }
    });

    const iframe = document.querySelector('iframe');    
    // Saat link sidebar diklik
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetUrl = this.getAttribute('href');
            iframe.src = targetUrl;

            // Simpan ke localStorage
            localStorage.setItem('iframeSrc', targetUrl);

            // Ganti style aktif
            links.forEach(l => {
                l.style.backgroundColor = '';
                l.style.color = '';
            });
            this.style.backgroundColor = 'white';
            this.style.color = 'black';
        });
    });

    // Saat halaman dimuat kembali
    window.addEventListener('load', () => {
        const savedUrl = localStorage.getItem('iframeSrc');
        if (savedUrl) {
            iframe.src = savedUrl;

            // Tandai link aktif
            links.forEach(link => {
                if (link.getAttribute('href') === savedUrl) {
                    link.style.backgroundColor = 'white';
                    link.style.color = 'black';
                } else {
                    link.style.backgroundColor = '';
                    link.style.color = '';
                }
            });
        }
    });
</script>

</script>

</body>

</html>