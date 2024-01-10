<?php include_once("header.php") ?>
<?php
$conn = new mysqli("localhost", "root", "", "image_upload");

$sqlGet = "SELECT * FROM artikel";
$result = $conn->query($sqlGet);
?>

<div class="container-lg">
    <a href="tambah.php" class="d-grid justify-content-center mt-5 mb-3 "><button type="button" class="btn btn-primary" style="margin: auto;">Tambah Data</button></a>

    <div class="d-flex" style="gap: 10px;">
    <?php
    if ($result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
    ?>
            <div class="card" style="width: 18rem;">
                <img src="img/<?= $data['image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $data['judul'] ?></h5>
                    <p class="card-text"><?= $data['body'] ?></p>
                </div>
            </div>
    <?php }
    } ?>
    </div>
</div>

<?php include_once("footer.php") ?>