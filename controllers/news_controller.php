<?php
/**
 * Created by PhpStorm.
 * User: Dương Văn Linh
 * Date: 21-08-2018
 * Time: 2:33 PM
 */
include model_path."/news_model.php";
include model_path."/paginate.php";
class news_controller {
    function querySlide() {
        $news_controller = new news_model();
        $slide_controller = $news_controller->getSlide();
        return $slide_controller;
    }
    function queryMenu() {
        $news_controller = new news_model();
        $category_controller = $news_controller->getMenu();
        return $category_controller;
    }
    function queryTypeByIdType($id_type) {
        $news_controller = new news_model();
        $type_controller = $news_controller->getTypeByIdType($id_type);
        return $type_controller;
    }
    function queryAllNewsByIdTypeWithPagination($id_type) {
        $news_controller = new news_model();
        $news_by_id_controller = $news_controller->getAllNewsById($id_type);
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pagination = new paginate(count($news_by_id_controller), 5, 5, $current_page);
        $paginationHTML = $pagination->paginate();
        $limit = $pagination->getItemOnPage();
        $start = ($current_page - 1) * $limit;
        $query_news = $news_controller->getAllNewsByIdTypeWithPagination($id_type, $start, $limit);
        return array("paginationHTML"=>$paginationHTML, "query_news"=>$query_news);
    }
    function queryNewsByIdNews($id_news) {
        $news_controller = new news_model();
        $news_by_id_news = $news_controller->getNewsbyIdNews($id_news);
        return $news_by_id_news;
    }
    function queryRelatedNewsByIdType($id_type) {
        $news_controller = new news_model();
        $related_news = $news_controller->getRelatedNewsByIdType($id_type);
        return $related_news;
    }
    function queryHotNewsByIdType($id_type) {
        $news_controller = new news_model();
        $hot_news = $news_controller->getHotNewsByIdType($id_type);
        return $hot_news;
    }
    function queryCommentByIdNews($id_news) {
        $news_controller = new news_model();
        $comment_by_id_news = $news_controller->getCommentByIdNews($id_news);
        return $comment_by_id_news;
    }
    function queryUserByIdUser($id_user) {
        $news_controller = new news_model();
        $user_by_id = $news_controller->getUserByIdUser($id_user);
        return $user_by_id;
    }
    function addComment_controller($id_user, $id_news, $noidung, $created_at = '', $updated_at = '') {
        $news_controller = new news_model();
        $comment = $news_controller->addComment_model($id_user, $id_news, $noidung, $created_at, $updated_at);
        if ($comment > 0) {
            $_SESSION['comment_success'] = "Thêm bình luận thành công";
            if (isset($_SESSION['comment_fail'])) {
                unset($_SESSION['comment_fail']);
            }
            header('location:'.$_SERVER['HTTP_REFERER']);
        }
        else {
            $_SESSION['comment_fail'] = "Thêm bình luận thất bại";
        }
    }
}
?>