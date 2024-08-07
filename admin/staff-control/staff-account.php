﻿<?php
require "../../function/connection.php";
session_start();
if ($_SESSION["admin"] == null) {
    header('location: ../index.php');
}
$name  =    $_SESSION["admin"];
$date  =    $_SESSION["date"];
$id    =    $_SESSION['id'];
$cdate = date('d-M-Y');
$query = "SELECT * FROM `admin` WHERE `id`='$id'";
$resulty = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($resulty)) {
    $fname   =   $row['username'];
}
?>
<?php
if (isset($_POST['logout'])) {
    $query = "UPDATE `admin` SET `date`='$cdate' WHERE  `id`='$id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        session_destroy();
        header("location: ../index.php");
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT `Role` FROM `admin` where id = $id";
    $data =  mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($data);
    $staff = $data['Role'];

    $query = "delete from `admin` where id = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('$staff Removed');window.location= 'staff-account.php'</script>";
    } else {
        echo "<script>alert('User not deleted')</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin-user-control</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../adminpanel.php"><?= $name ?></a>
            </div>
            <div style="color: white;
 padding: 15px 50px 5px 50px;
 float: right;
 font-size: 16px;">
                <form method="post">Last access : <?= $date ?>&nbsp;&nbsp;<button name="logout" type="submit" class="btn btn-danger square-btn-adjust">Logout</button> </form>
            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="../assets/imgs/find_user.png" class="user-image img-responsive" />
                    </li>


                    <li>
                        <a href="../adminpanel.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                    <?php if($_SESSION["admin"] == 'Staff' or $_SESSION["admin"] == 'Receptionist'){
                            echo '<li>    
                                    <a class="active-menu"  href="../staff-control/staff-account.php"><i class="fa fa-users fa-3x"></i> Staff Accounts</a>
                                 </li>'; 
                    }else if($_SESSION["admin"] == 'Admin'){
                         echo '<li>
                                   <a href="../users-control/users-account.php"><i class="fa fa-user fa-3x"></i> User Accounts</a>
                               </li>';
                         echo '<li>    
                                   <a class="active-menu" href="../staff-control/staff-account.php"><i class="fa fa-users fa-3x"></i> Staff Accounts</a>
                               </li>';  
                         echo '<li>
                                   <a href="../inventory/inventory.php"><i class="fa fa-qrcode fa-3x"></i> Inventory</a>
                              </li>';   
                   }

                   if($_SESSION["admin"] == 'Receptionist'){
                       echo '<li>
                              <a href="../inventory/inventory.php"><i class="fa fa-qrcode fa-3x"></i> Inventory</a>
                          </li>';}
               ?>
           </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Staff-Control</h2>
                        <h5>Welcome <?= $fname ?> , Love to see you back. </h5>

                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <?php if($_SESSION["admin"] == 'Admin'){
                 echo '<a href="staff-add.php" class="btn btn-danger" style="margin-bottom: 10px;"><i class="fa fa-pencil"></i>ADD STAFF</a>';
                }
                ?>
                <div class="row">

                <?php if($_SESSION["admin"] == 'Staff'){
                    echo '<div class="col-md-12">
                    <!-- Advanced Tables -->
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Staffs
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Join Date</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                        $query = "SELECT * FROM `admin` WHERE `id` = '$id'";
                                        $data =  mysqli_query($con, $query);
                                        while ($result = mysqli_fetch_assoc($data)) {
                                            echo "<tr>";
                                            echo "<td>" . $result['id'] . "</td>";
                                            echo "<td>" . $result['username'] . "</td>";
                                            echo "<td>" . $result['email'] . "</td>";
                                            echo "<td>" . $result['Role'] . "</td>";
                                            echo "<td>" . $result['join_date'] . "</td>";
                                            echo "<td>" . '<a href="staff-update.php?id=' . $result['id'] . '">Update</a>' . "</td>";
                                            echo "</tr>";
                                        }  
                                    echo '</tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>';
                                    // End Advanced Tables

                    }else if($_SESSION["admin"] == 'Admin'){
                        echo '<div class="col-md-12">
                        <!-- Advanced Tables -->
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Staffs
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Join Date</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            $query = "SELECT * FROM `admin`";
                                            $data =  mysqli_query($con, $query);
                                            while ($result = mysqli_fetch_assoc($data)) {
                                                echo "<tr>";
                                                echo "<td>" . $result['id'] . "</td>";
                                                echo "<td>" . $result['username'] . "</td>";
                                                echo "<td>" . $result['email'] . "</td>";
                                                echo "<td>" . $result['Role'] . "</td>";
                                                echo "<td>" . $result['join_date'] . "</td>";
                                                echo "<td>" . '<a href="staff-update.php?id=' . $result['id'] . '">Update</a>' . "</td>";
                                                echo "<td>" . '<a href="staff-account.php?id=' . $result['id'] . '">delete</a>' . "</td>";
                                                echo "</tr>";
                                            }  
                                        echo '</tbody>
                                    </table>
                                </div>
    
                            </div>
                        </div>
                    </div>';
                    }elseif($_SESSION["admin"] == 'Receptionist'){
                        echo '<div class="col-md-12">
                        <!-- Advanced Tables -->
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Staffs
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Join Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            $query = "SELECT * FROM `admin` Where `role` != 'Admin'";
                                            $data =  mysqli_query($con, $query);
                                            while ($result = mysqli_fetch_assoc($data)) {
                                                echo "<tr>";
                                                echo "<td>" . $result['id'] . "</td>";
                                                echo "<td>" . $result['username'] . "</td>";
                                                echo "<td>" . $result['email'] . "</td>";
                                                echo "<td>" . $result['Role'] . "</td>";
                                                echo "<td>" . $result['join_date'] . "</td>";
                                                echo "</tr>";
                                            }  
                                        echo '</tbody>
                                    </table>
                                </div>
    
                            </div>
                        </div>
                    </div>';
                    }
                    ?>

                </div>

            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTables').dataTable();
        });        $(document).ready(function() {
            $('#ddataTables').dataTable();
        });        $(document).ready(function() {
            $('#dddataTables').dataTable();
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>

</body>

</html>