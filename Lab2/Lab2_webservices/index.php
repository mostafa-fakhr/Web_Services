<?php
require_once("vendor/autoload.php");

$conn = new MainDatabase;
$table_columns_items = array();
$fields = ["id", "PRODUCT_code", "Photo", "product_name"];
$items = array();

$page = isset($_GET["page"]) ? $_GET["page"] : 0;

if (($_SERVER["REQUEST_METHOD"] == "GET") && isset($_GET["click"])) {

    if ($_GET["click"] == "prev") {
        if ($page > 0) {
            $page -= 5;
            if ($page < 0) $page = 0;
        }
    } else if ($_GET["click"] == "next") {
        $page += 5;
    }
}


if ($conn->connect()) {
    $items = $conn->get_data($fields, $page);
    $item = new Items();
    $table_columns_items = $item->getTableColumns();
}



// search function
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["submit_search"])) {
    if (isset($_POST["key_search"]) && isset($_POST["search"]))
        $items = $conn->search_by_column($_POST["key_search"], $_POST["search"]);
}

$conn->disconnect();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>
<?php if (!empty($items)) { ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- value -->
        <input type="text" placeholder="Search.." name="search">
        <!-- column name -->
        <select name="key_search" id="key_search">
            <?php foreach ($table_columns_items as $field) { ?>
                <option value="<?php echo $field ?>"><?php echo $field ?></option>
            <?php  } ?>
        </select>
        <button type="submit" name="submit_search">Search</button>
        <a href="<?php echo 'addItems.php/' ?>">Add</a>
    </form>
    <table>
        <tr>
            <?php foreach ($fields as $field) { ?>
                <th> <?php echo $field ?> </th>
            <?php } ?>
        </tr>


        <?php foreach ($items as $item) { ?>
            <tr>
                <?php foreach ($fields as $field) { ?>
                    <td> <?php echo $item->$field ?> </td>
                <?php } ?>
                <td><a href="<?php echo 'glasses_info.php/?id=' . $item->id ?>">More</a></td>
            </tr>
        <?php } ?>
    </table>

    <a style='margin-right:10px' href="<?php echo "?click=prev&page=" . $page ?>">Prev</a>
    <a href="<?php echo "?click=next&page=" . $page ?>">Next</a>
<?php } else {
    echo "product not found";
} ?>