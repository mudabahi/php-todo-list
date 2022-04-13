<?php

include "conn.php";
$todo = '';
$msg = "";

if (isset($_POST['add'])) {
    $todo_name = $conn->real_escape_string($_POST['todo']);

    $sql = "SELECT * FROM todo WHERE todo = '$todo_name'";

    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $msg = '<p class="alert alert-danger">Todo is alerady exist!</p>';
    } else {
        $sql = "INSERT INTO todo (todo) VALUES ('$todo_name')";
        $res = $conn->query($sql);
        if ($res) $msg = '<p class="alert alert-success">Todo Added Successfully.</p>';
    }
}

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $record =  "SELECT * FROM todo WHERE id=$id";
    $res = $conn->query($record);

    if ($res->num_rows > 0) {
        $row = $res->fetch_array();
        $todo = $row['todo'];
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $todo = $_POST['todo'];

    $sql = "UPDATE `todo` SET todo='$todo'  WHERE id = $id";
    $conn->query($sql);
    $msg = '<p class="alert alert-success">Todo Updated Successfully.</p>';
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];

    $sql = "DELETE FROM todo WHERE id = $id";
    $res = $conn->query($sql);

    if ($res) $msg = '<p class="alert alert-success">Todo Deleted Successfully.</p>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Todo list in php</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8 mt-5">
                <table class="table bg-light border">
                    <?php
                    $sql = "SELECT * FROM todo";
                    $res = $conn->query($sql);
                    if ($res->num_rows > 0) {
                        $counter = 1;
                        while ($row = $res->fetch_array()) {
                    ?>

                            <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $row['todo']; ?></td>
                                <td>
                                    <button class="btn btn-success text-light"><a href="index.php?edit_id=<?php echo $row['id'] ?>" class="text-light text-decoration-none">Edit</a></button>
                                    <button class="btn btn-danger"><a href="index.php?del_id=<?php echo $row['id'] ?>" class="text-light text-decoration-none">Delete</a></button>
                                </td>
                            </tr>
                    <?php
                            $counter++;
                        }
                    }
                    ?>
                </table>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8 bg-light border">
                <form class="border p-5 m-5" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!-- <input type="hidden" name="id" value="<?php echo $id; ?>">
             -->
                    <?php
                    echo $msg;
                    ?>
                    <h3 class="text-success border-bottom py-3">TODO LIST</h3>

                    <div class="mb-3 ">
                        <?php if (isset($_GET['edit_id'])) { ?>
                            <input name="id" hidden value="<?php echo $_GET['edit_id'];  ?>" />
                        <?php } ?>
                        <label for="exampleInputPassword1" class="form-label">User Today todo</label>
                        <input type="text" name="todo" value="<?php echo $todo ?>" class="form-control" id="exampleInputPassword1">
                    </div>
                    <?php if (isset($_GET['edit_id'])) { ?>
                        <button class="btn" type="submit" name="update" style="background: #556B2F;">update</button>
                    <?php } ?>
                    <button type="submit" name="add" class="btn btn-primary">Add</button>
                    <a class="btn btn-primary" onclick="toastr.primary('Added Successfully.');">dfasdf</a>

                </form>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</body>

</html>