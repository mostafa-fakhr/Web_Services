<?php
require_once("vendor/autoload.php");
$table_columns_items = array();
$conn = new MainDatabase;
if ($conn->connect()) {
    $table_columns_items = (new Items())->getTableColumns();
}



if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["submit"])) {
    $item = new Items();
    $res_upload_img = upload_image("Photo");
    echo $res_upload_img;
    if (!empty($res_upload_img)) {
        foreach ($table_columns_items as $new_item) {
            if ($new_item == "Photo") $item->$new_item = $res_upload_img;
            else
                $item->$new_item = $_POST["$new_item"];
        }
        $item->save();
    }
}

function upload_image($name_column)
{
    $file_name = "";
    $target_dir = "images/";
    // images/(image.jpg) => (image.jpg) => .jpg
    $target_file = $target_dir . basename($_FILES[$name_column]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    if ($_FILES[$name_column]["size"] > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES[$name_column]["tmp_name"], $target_file)) {
            $file_name = htmlspecialchars(basename($_FILES[$name_column]["name"]));
            echo "The file " . $file_name . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    return $file_name;
}



$conn->disconnect();

/*
    

*/

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Glasses</title>
    <style>
        .main,
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .button {
            background-color: #04AA6D;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        input {
            padding: 6px;
            margin-top: 8px;
            font-size: 17px;
        }
    </style>
</head>
<html>

<body>
    <div class="main">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <?php
            // id product_name photo date
            foreach ($table_columns_items as $item) {
                if ($item != "Photo" && $item != "date") {
            ?>
                    <div>
                        <label for="<?php echo $item  ?>"><?php echo $item  ?></label>
                        <input type="text" name="<?php echo $item ?>" id="<?php echo $item  ?>">
                    </div>
                <?php
                } elseif ($item == "date") {

                ?>
                    <div>
                        <label for="<?php echo $item  ?>"><?php echo $item  ?></label>
                        <input type="date" name="<?php echo $item ?>" id="<?php echo $item  ?>">
                    </div>
                <?php
                } else {

                ?>
                    <div>
                        <label for="<?php echo $item  ?>"><?php echo $item  ?></label>
                        <input type="file" name="<?php echo $item  ?>" id="<?php echo $item  ?>">
                    </div>
            <?php
                }
            }
            ?>

            <input class="button" type="submit" value="submit" name="submit">
        </form>
    </div>
</body>

</html>