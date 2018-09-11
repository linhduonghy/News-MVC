<?php
/**
 * Created by PhpStorm.
 * User: Dương Văn Linh
 * Date: 22-08-2018
 * Time: 4:58 PM
 */
/**
 * Phân trang by DVL
 */
class paginate {
    private $page = [
        'total_item' => '0',
        'item_on_page' => '0',
        'total_page' => '0',
        'page_show' => '0',
        'current_page' => '0'
    ];
    function __construct($total_intem, $item_on_page = 6, $page_show = 5, $curent_page = 1) {
        $this->page['total_item'] = $total_intem;
        $this->page['item_on_page'] = $item_on_page;
        $this->page['total_page'] = ceil($total_intem / $item_on_page);
        $this->page['page_show'] = ($page_show % 2 == 0) ? ($page_show + 1) : $page_show;
        $this->page['current_page'] = $curent_page;
    }
    function getItemOnPage() {
        return $this->page['item_on_page'];
    }
    function getCurrentPage() {
        return $this->page['current_page'];
    }
    function paginate() {
        if ($this->page['total_page'] > 1) {
            /*
             * Lấy đường dẫn của trang hiện tại
             **/
            $actual_link = isset($_SERVER['HTTPS']) ? "https" : "http" . "://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            if(isset($_GET['page'])) {
                $str = "&page=".$_GET['page'];
                $actual_link = str_replace($str,"", $actual_link);
            }
            /*
             *  Khởi tạo đường dẫn trang đầu tiên, trang trước, trang sau, trang cuối
            **/
            $start = ''; $pre = ''; $next = ''; $end = '';
            if ($this->page['current_page'] > 1) {
                $start = "<li><a href='$actual_link&page=1'>Start</a></li>";
                $pre = "<li><a href='$actual_link&page=".($this->page['current_page'] - 1)."'>Pre</a></li>";
            }
            if ($this->page['current_page'] < $this->page['total_page']) {
                $end = "<li><a href='$actual_link&page=".($this->page['total_page'])."'>End</a></li>";
                $next = "<li><a href='$actual_link&page=".($this->page['current_page'] + 1)."'>Next</a></li>";
            }
            if ($this->page['page_show'] < $this->page['total_page']) {
                if ($this->page['current_page'] == 1) {
                    $start_page = 1;
                    $end_page = $this->page['page_show'];
                } elseif ($this->page['current_page'] == $this->page['total_page']) {
                    $end_page = $this->page['total_page'];
                    $start_page = $this->page['total_page'] - $this->page['page_show'] + 1;
                } else {
                    $start_page = $this->page['current_page'] - ($this->page['page_show'] - 1) / 2;
                    $end_page = $this->page['current_page'] + ($this->page['page_show'] - 1) / 2;
                    if ($start_page < 1) {
                        $start_page = 1;
                        $end_page = $this->page['page_show'];
                    }
                    if ($end_page > $this->page['total_page']) {
                        $end_page = $this->page['total_page'];
                        $start_page = $this->page['total_page'] - $this->page['page_show'] + 1;
                    }
                }
            } else {
                $start_page = 1;
                $end_page = $this->page['total_page'];
            }
            $list_page = '';
            for ($i = $start_page; $i <= $end_page; $i++) {
                if ($i == $this->page['current_page']) {
                    $list_page .= "<li class='active'><a href='$actual_link&page=".$i."'>$i</a></li>";
                }
                else {
                    $list_page .= "<li><a href='$actual_link&page=".$i."'>$i</a></li>";
                }
            }
            $paginationHTML = '<ul class="pagination">'.$start.$pre.$list_page.$next.$end.'</ul>';
        }
        return $paginationHTML;
    }
}
?>