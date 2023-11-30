<?php
include('function.php');
include 'connect.php';
mysqli_set_charset($conn, "utf8");
session_start();
if ((string)$_SESSION['loged'] === '1') {
    $id = $_SESSION['id'];
    $infor = get_list($id, $conn);
    if(isset($_GET['username']))
        $username = $_GET['username'];
} else die(header('Location: login.php'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add' && $_POST['mission'] != null) {
        add_list($id, $_POST['mission'], $conn);
        $url = 'admin.php?username='.$username;
        die(header('Location: '.$url));
    }
}

if (isset($_GET['del'])) {
    $stt = (int)$_GET['del'];
    del_list($stt, $conn);
    $url = 'admin.php?username='.$username;
    die(header('Location: '.$url));
}

if (isset($_GET['edit'])) {
    $stt = (int)$_GET['edit'];
}

if (isset($_POST['action']) && $_POST['action'] === 'ok') {
    $update = $_POST['edit'];
    edit_list($update, $stt, $conn);
    $url = 'admin.php?username='.$username;
    die(header('Location: '.$url));
}

if (isset($_GET['orderby'])) {
    $column = $_GET['orderby'];
    $infor = order_list($column, $id, $conn);
    $username = $_SESSION['username'];
    $hasorder = 1;
    // $url = 'admin.php?username='.$username;
    // die(header('Location: '.$url));
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="page">
        <div class="head">
            <h2>Todolist <?= $username ?></h2>
            <a href="logout.php">
                <button>Logout</button>
            </a>
            <br>
            <?php if (isset($_GET['edit'])) { ?>
                <form action="" method="POST">
                    <input type="text" name="edit" />
                    <button type="submit" name="action" value="ok"> ok </button>
                </form>
            <?php }
            for ($i = 0; $i < count($infor); $i++) { ?>
                <tr>
                    <td> <?php echo $i . '. ' . $infor[$i]['task']; ?> </td> &nbsp;
                    <td>
                        <a href="admin.php?del=<?php echo $infor[$i]['stt'] ?>">Del</a> &nbsp;
                        <a href="edit.php?id=<?php echo $infor[$i]['stt'] ?>">Edit</a>
                        <br>
                    </td>
                </tr>
            <?php
            } ?>
            <a href="admin.php?orderby=task">
                <button>Sap xep</button>
            </a>
            <br>
            <form action="" method="POST">
                <textarea name="mission" id="" cols="30" rows="10"></textarea>
                <button type="submit" name="action" value="add">Add Task</button>
            </form>
            <br>
        </div>
    </div>
</body>

</html>