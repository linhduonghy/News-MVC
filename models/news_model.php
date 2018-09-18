<?php
/**
 * Created by PhpStorm.
 * User: Dương Văn Linh
 * Date: 21-08-2018
 * Time: 2:33 PM
 */
include "database.php";
class news_model extends database{
    function getSlide() {
        $sql = "SELECT * FROM slide";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    function getMenu() {
        $sql = "SELECT tl.*, GROUP_CONCAT(DISTINCT lt.id, ':', lt.Ten, ':', lt.TenKhongDau) AS LoaiTin,
                tt.id as idTin, tt.TieuDe as TieuDeTin, tt.Hinh as HinhTin, tt.TomTat as TomTatTin, tt.TieuDeKhongDau as TieuDeTinKhongDau, tt.idLoaiTin as idLoaiTin
                FROM theloai tl INNER JOIN loaitin lt ON tl.id=lt.idTheLoai
                INNER JOIN tintuc tt ON lt.id = tt.idLoaiTin GROUP BY tl.id";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }
    function getTypeByIdType($id_type) {
        $sql = "SELECT id, Ten, TenKhongDau FROM loaitin WHERE id = '$id_type'";
        $this->setQuery($sql);
        return $this->loadRow(array($id_type));
    }
    function getAllNewsById($id_type) {
        $sql = "SELECT * FROM tintuc WHERE idLoaiTin = '$id_type'";
        $this->setQuery($sql);
        return $this->loadAllRows(array($id_type));
    }
    function getAllNewsByIdTypeWithPagination($id_type, $start, $limit) {
        $sql = "SELECT * FROM tintuc WHERE idLoaiTin = '$id_type' LIMIT $start,$limit";
        $this->setQuery($sql);
        return $this->loadAllRows(array($id_type));
    }
    function getNewsbyIdNews($id_news) {
        $sql = "SELECT * FROM tintuc WHERE id='$id_news'";
        $this->setQuery($sql);
        return $this->loadRow(array($id_news));
    }
    function getRelatedNewsByIdType($id_type) {
        $sql = "SELECT * FROM tintuc WHERE idLoaiTin = '$id_type' LIMIT 2, 6";
        $this->setQuery($sql);
        return $this->loadAllRows(array($id_type));
    }
    function getHotNewsByIdType($id_type) {
        $sql = "SELECT * FROM tintuc WHERE NoiBat = '1' LIMIT 2,6";
        $this->setQuery($sql);
        return $this->loadAllRows(array($id_type));
    }
    function getCommentByIdNews($id_news) {
        $sql = "SELECT * FROM comment WHERE idTinTuc = '$id_news'";
        $this->setQuery($sql);
        return $this->loadAllRows(array($id_news));
    }
    function addComment_model($id_user, $id_news, $noidung, $created_at = '', $updated_at = '') {
        $sql = "INSERT INTO comment(idUser, idTinTuc, NoiDung, created_at, updated_at)
                VALUES(?,?,?,?,?)";
        $this->setQuery($sql);
        $result = $this->execute(array($id_user, $id_news, $noidung, $created_at, $updated_at));
        if ($result) {
            return $this->getLastId();
        }
        else {
            return false;
        }
    }
    function getUserByIdUser($id_user) {
        $sql = "SELECT name FROM users WHERE id = '$id_user'";
        $this->setQuery($sql);
        return $this->loadRow(array($id_user));
    }
}
?>