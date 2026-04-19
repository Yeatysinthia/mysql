<?php 

$connect = mysqli_connect("localhost","root","","batch_70");

if($connect){
    echo("success");
}else{
    echo "error";
}

if(isset($_POST['submit'])) {
    // $id = $_POST['id'];
    $uname = $_POST['name'];

    $connect->query("CALL call_users('$uname')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
</head>
<body>

<form method="POST" action="#">
    <!-- <label>ID:</label>
    <input type="text" name="id" required><br><br> -->

    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <button type="submit" name="submit">Insert</button>
</form>

</body>
</html>
