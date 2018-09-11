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
    /*
     * get tin tức bởi id_news
    */
    $id_news = $_GET['id_news'];
    $news_by_id = $news->queryNewsByIdNews($id_news);
    //print_r($news_by_id);
    /*
     * get tin tức liên quan và nổi bật theo cùng loại tin
    */
    $id_type = $news_by_id->idLoaiTin;
    $typenews = $news->queryTypeByIdType($id_type);
    //print_r($typenews);
    $related_news = $news->queryRelatedNewsByIdType($id_type);
    $hot_news = $news->queryHotNewsByIdType($id_type);
    //print_r($hot_news);
    /*
     * get Comment by id_news
    **/
    $comment = $news->queryCommentByIdNews($id_news);
    //print_r($comment);
    /*
     *  add Comment
     * */
    if (isset($_POST['comment'])) {
        $id_user = $_SESSION['id'];
        $id_news = $_GET['id_news'];
        $noidung = $_POST['text'];
        $timezone = date_default_timezone_set('Asia/Ho_Chi_Minh');
        $created_at = date('Y-m-d h:i:sa');
        $news->addComment_controller($id_user, $id_news, $noidung, $created_at, '');
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$news_by_id->TieuDe?></title>

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
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">Giới thiệu</a>
                </li>
                <li>
                    <a href="#">Liên hệ</a>
                </li>
            </ul>

            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>

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

        <!-- Blog Post Content Column -->
        <div class="col-lg-9">

            <!-- Blog Post -->

            <!-- Title -->
            <h1><?=$news_by_id->TieuDe?></h1>

            <!-- Author -->
            <p class="lead">
                by <a href="#">Huong Huong</a>
            </p>

            <!-- Preview Image -->
            <img class="img-responsive" src="public/image/tintuc/<?=$news_by_id->Hinh?>" alt="">

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span><?=$news_by_id->created_at?></p>
            <hr>

            <!-- Post Content -->
            <p class="lead"><?=$news_by_id->TomTat?>
            <p class="lead"><?=$news_by_id->NoiDung?>
            <hr>

            <!-- Blog Comments -->

            <!-- Comments Form -->
            <div class="well">
                <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
                <form role="form" method="post" action="#">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name="text"></textarea>
                    </div>
                    <button type="submit" name="comment" class="btn btn-primary">Gửi</button>
                </form>
            </div>
            <?php
                if (isset($_SESSION['comment_fail'])) {
                    ?>
                        <p class="success"><?=$_SESSION['comment_fail']?></p>
                    <?php
                }
            ?>

            <hr>

            <!-- Posted Comments -->
            <?php
                for($i = count($comment) - 1; $i >= 0; $i--){
                    $id_user = $comment[$i]->idUser;
                    $user = $news->queryUserByIdUser($id_user);
                    ?>
                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"> <?=$user->name?>
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                <?=$comment[$i]->NoiDung?>
                            </div>
                        </div>
                    <?php
                }
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-heading"><b>Tin liên quan</b></div>
                    <div class="panel-body">
                    <?php
                        for($i = 0; $i < count($related_news); $i++) {
                            ?>

                                    <!-- item -->
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-5">
                                            <a href="detail.php?type=<?=$typenews->TenKhongDau?>&id_news=<?=$related_news[$i]->id?>">
                                                <img class="img-responsive" src="public/image/tintuc/<?=$related_news[$i]->Hinh?>" alt="">
                                            </a>
                                        </div>
                                        <div class="col-md-7">
                                            <a href="detail.php?type=<?=$typenews->TenKhongDau?>&id_news=<?=$related_news[$i]->id?>"><b><?=$related_news[$i]->TieuDe?></b></a>
                                        </div>
                                        <div class="break"></div>
                                    </div>
                                    <!-- end item -->

                            <?php
                        }
                    ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><b>Tin nổi bật</b></div>
                <div class="panel-body">
                    <?php
                        foreach ($hot_news as $hotnews) {
                            ?>
                                <!-- item -->
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-md-5">
                                        <a href="detail.php?type=<?=$typenews->TenKhongDau?>&id_news=<?=$hotnews->id?>">
                                            <img class="img-responsive" src="public/image/tintuc/<?=$hotnews->Hinh?>" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-7">
                                        <a href="detail.php?type=<?=$typenews->TenKhongDau?>&id_news=<?=$hotnews->id?>""><b><?=$hotnews->TieuDe?></b></a>
                                    </div>
                                    <div class="break"></div>
                                </div>
                                <!-- end item -->
                            <?php
                        }
                    ?>

                </div>
            </div>

        </div>

    </div>
    <!-- /.row -->
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
