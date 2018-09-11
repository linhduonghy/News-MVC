<?php
/**
 * Created by PhpStorm.
 * User: Dương Văn Linh
 * Date: 21-08-2018
 * Time: 12:44 PM
 */
session_start();
include "controller/news_controller.php";
    $news = new news_controller();
    $menu = $news->queryMenu();

    $id_type = $_GET['id_type'];
    /*Lấy Tiêu đề loại tin*/
    $type_title = $news->queryTypeByIdType($id_type);
    //print_r($type_title);

    /*Lấy tin tức bởi id loại tin kết hợp phân trang*/
    $news_by_id_type = $news->queryAllNewsByIdTypeWithPagination($id_type);
    $news_by_id = $news_by_id_type['query_news'];
    //print_r($news_by_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$type_title->Ten?></title>

    <!-- Bootstrap Core CSS -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="public/css/shop-homepage.css" rel="stylesheet">
    <link href="public/css/my.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.public/js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"> Tin Tức</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav pull-right">
                <?php
                if (isset($_SESSION['name'])) {
                    ?>
                        <li>
                            <a>
                                <span class ="glyphicon glyphicon-user"></span>
                                <?=$_SESSION['name']?>
                            </a>
                        </li>

                        <li>
                            <a href="logout.php">Đăng xuất</a>
                        </li>
                    <?php
                } else {
                    ?>
                        <li>
                            <a href="register.php">Đăng ký</a>
                        </li>
                        <li>
                            <a href="login.php">Đăng nhập</a>
                        </li>
                    <?php
                }
                ?>
            </ul>
        </div>



        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-3 ">
            <ul class="list-group" id="menu">
                <li href="#" class="list-group-item menu1 active">
                    Menu
                </li>
                <?php
                    foreach ($menu as $mn) {
                        ?>
                            <li href="#" class="list-group-item menu1">
                                <?=$mn->Ten?>
                            </li>
                            <ul>
                            <?php
                                $loaitin = explode(',',$mn->LoaiTin);
                                foreach($loaitin as $lt) {
                                    list($id, $ten, $tenkhongdau) = explode(':', $lt);
                                    ?>
                                        <li class="list-group-item">
                                            <a href="type.php?id_type=<?=$id?>"><?=$ten?></a>
                                        </li>
                                    <?php
                                }
                            ?>
                            </ul>
                        <?php
                    }
                ?>

            </ul>
        </div>

        <div class="col-md-9 ">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#337AB7; color:white;">
                    <h4><b><?=$type_title->Ten?></b></h4>
                </div>
                <?php
                    foreach($news_by_id as $newsid) {
                        ?>
                            <div class="row-item row">
                                <div class="col-md-3">

                                    <a href="detail.php?type=<?=$type_title->TenKhongDau?>&id_news=<?=$newsid->id?>">
                                        <br>
                                        <img width="200px" height="200px" class="img-responsive" src="public/image/tintuc/<?=$newsid->Hinh?>" alt="">
                                    </a>
                                </div>

                                <div class="col-md-9">
                                    <h3><?=$newsid->TieuDe?></h3>
                                    <p><?=$newsid->TomTat?></p>
                                    <a class="btn btn-primary" href="detail.php?type=<?=$type_title->TenKhongDau?>&id_news=<?=$newsid->id?>">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                                <div class="break"></div>
                            </div>
                        <?php
                    }
                ?>


                <!-- Pagination -->
                    <div><?=$news_by_id_type['paginationHTML']?></div>
                <!-- /.row -->

            </div>
        </div>

    </div>

</div>
<!-- end Page Content -->

<!-- Footer -->
<hr>
<footer>
    <div class="row">
        <div class="col-md-12">
            <p>Copyright &copy; Your Website 2014</p>
        </div>
    </div>
</footer>
<!-- end Footer -->
<!-- jQuery -->
<script src="public/js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/my.js"></script>

</body>

</html>

