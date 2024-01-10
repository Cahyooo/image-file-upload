<?php
include_once("header.php");
?>

<?php

if (isset($_POST["submit"])) {
    $check = checkInputAndUpload();

    if ($check) {
        return $check;
    } else {
        header("location: index.php");
    }
}

function checkInputAndUpload()
{
    $conn = new mysqli("localhost", "root", "", "image_upload");

    $judul = $_POST["judul"];
    $body = $_POST["body"];

    //Ambil Informasi File 
    $filename = basename(strtolower(str_replace(' ', '', $_FILES["file"]["name"])));
    $tmpName = $_FILES["file"]["tmp_name"];
    $imageFileType = explode('/', $_FILES["file"]["type"]);
    $size = $_FILES["file"]["size"];

    $imageFileType = $imageFileType[count($imageFileType) - 1];

    // Cek Apakah File merupakan gambar
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    ) {
        return "Hanya Menerima Gambar Berupa JPG,JPEG,PNG!";
    }

    // // Cek apakah file sudah ada (OPTIONAL)
    // if (file_exists($location)) {
    //     return "File tersebut sudah ada,Gunakan gambar lain!";
    // }

    // Cek apakah size file terlalu besar | DALAM BYTE,SAYA ATUR 10MB
    if ($size > 10000000) {
        return "Size File terlalu besar!";
    }

    // Menganti Nama file menjadi random
    $filename = uniqid() . "." . $imageFileType;

    // Menyiapkan tempat untuk menyimpan gambar
    $location = "img/" . $filename;

    //Melakukan Pemindahan File kedalam folder img
    move_uploaded_file($tmpName, $location);

    // Query kedalam database
    $sqlInsert = "INSERT INTO artikel VALUES ('', '$judul', '$body', '$filename')";
    $conn->query($sqlInsert);

    return false;
}

?>

<form action="" class="container-lg mt-5" enctype="multipart/form-data" method="post">
    <?php if (isset($check)) {
        echo $check;
    } ?>

    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" aria-describedby="judul" name="judul">
    </div>

    <div class="mb-3">
        <label for="body" class="form-label">Isi Artikel</label>
        <input type="text" class="form-control" id="body" aria-describedby="body" name="body">
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Upload Gambar</label>
        <input class="form-control" type="file" id="formFile" name="file">
    </div>

    <button type="submit" class="btn btn-primary" name="submit">Submit!</button>

</form>

<?php include_once("footer.php") ?>