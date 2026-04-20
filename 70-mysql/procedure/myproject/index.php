<?php
$conn = new mysqli("localhost", "root", "", "company_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg1 = "";
$msg2 = "";


if (isset($_POST['add_manufacturer'])) {

    $name = $_POST['m_name'];
    $address = $_POST['m_address'];
    $contact = $_POST['m_contact'];

    $stmt = $conn->prepare("CALL insert_manufacturer(?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $contact);

    if ($stmt->execute()) {
        $msg1 = "Manufacturer inserted successfully!";
    } else {
        $msg1 = "Error: " . $stmt->error;
    }

    $stmt->close();
}


if (isset($_POST['add_product'])) {

    $pname = $_POST['p_name'];
    $price = $_POST['price'];
    $mid = $_POST['manufacturer_id'];

    $stmt = $conn->prepare("INSERT INTO Product(name, price, manufacturer_id) VALUES(?, ?, ?)");
    $stmt->bind_param("sii", $pname, $price, $mid);

    if ($stmt->execute()) {
        $msg2 = "Product inserted successfully!";
    } else {
        $msg2 = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manufacturer & Product Form</title>
</head>
<body>

<h2>Manufacturer Form</h2>

<?php if($msg1) echo "<p style='color:green;'>$msg1</p>"; ?>

<fieldset>
<form method="post">
    <input type="text" name="m_name" placeholder="Name" required><br><br>
    <input type="text" name="m_address" placeholder="Address" required><br><br>
    <input type="text" name="m_contact" placeholder="Contact No" required><br><br>

    <button type="submit" name="add_manufacturer">Add Manufacturer</button>
</form>
</fieldset>

<hr>

<h2>Product Form</h2>

<?php if($msg2) echo "<p style='color:green;'>$msg2</p>"; ?>

<fieldset>
<form method="post">
    <input type="text" name="p_name" placeholder="Product Name" required><br><br>
    <input type="number" name="price" placeholder="Price" required><br><br>
  
    <select name="manufacturer_id" required>
        <option value="">Select Manufacturer</option>

        <?php
        $result = $conn->query("SELECT id, name FROM Manufacturer");

        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']} (ID: {$row['id']})</option>";
        }
        ?>
    </select>

    <br><br>

    <button type="submit" name="add_product">Add Product</button>
</form>
</fieldset>

</body>
</html>

<?php $conn->close(); ?>