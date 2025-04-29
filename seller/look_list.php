<?php
include 'config.php';

$query = "SELECT * FROM looks";
$result = mysqli_query($conn, $query);
?>

<h2>Daftar Look</h2>
<div style="display: flex; flex-wrap: wrap;">
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div style="margin: 10px; text-align: center;">
        <a href="look_detail.php?id=<?php echo $row['id']; ?>">
            <img src="../uploads/look/<?php echo $row['look_image']; ?>" alt="<?php echo $row['look_name']; ?>" style="width: 200px; height: auto;">
        </a>
        <p><?php echo $row['look_name']; ?></p>
    </div>
<?php } ?>
</div>
