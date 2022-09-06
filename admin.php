<?php
include('function.php');
$conn = mysqli_connect('localhost','root','','webb');
mysqli_set_charset($conn,"utf8");
session_start();
if((string)$_SESSION['loged'] === '1'){
    $id = $_SESSION['id'];
    $infor = get_list($id, $conn);
}
else die(header('Location: /login.php'));

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_POST['action'] === 'add' && $_POST['mission']!=null){
        add_list($id,$_POST['mission'],$conn);
        header('Location:/admin.php');
    }
}

if(isset($_GET['del'])){
    $stt = (int)$_GET['del'];
    del_list($stt, $conn);
    header('Location:/admin.php');
} 

if(isset($_GET['edit'])){
    $stt = (int)$_GET['edit'];
}

if(isset($_POST['action']) && $_POST['action'] === 'ok'){
    $update = $_POST['edit'];
    edit_list($update, $stt, $conn);
    header('Location:/admin.php');
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
            <h3>To do list</h3>
            <?php if(isset($_GET['edit'])) {?>
                <form action="" method="POST">
                    <input type="text" name="edit"/>
                    <button type="submit" name="action" value="ok"> ok </button>  
                </form>  
            <?php } ?>
            <?php
            for($i = 0; $i<count($infor); ) {?>
            <tr>
                <td> <?php echo $i.'. '.$infor[$i]['task']; ?> </td> &nbsp;
                <td> 
                    <a href="admin.php?del= <?php echo $infor[$i]['stt']?>">Del</a> &nbsp;
                    <a href="admin.php?edit= <?php echo $infor[$i]['stt']?>">Edit</a>   
                    <br>
                </td>
            </tr>
            <?php $i++; } ?>
            <br>
            <form action="" method="POST">
                <input type="text" name="mission"/>
                <button type="submit" name="action" value="add">Add Task</button>
            </form>
            <br>    
            <a href="logout.php">
                <button>Logout</button>
            </a>
        </div>
    </div>
</body>
</html>