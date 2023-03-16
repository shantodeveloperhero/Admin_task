<?php 
include_once '../lib/Database.php';
include_once '../helpers/Format.php';
?>

<?php 
class Category{
    private $db;
    private $fm;

    public function __construct(){
      $this->db = new Database();
      $this->fm = new Format();
    }

    public function catInsert($catName){
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        if (empty($catName)) {
            $msg = "Category Field must not be empty !";
            return $msg;
        } else {
            $query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
            $catinsert = $this->db->insert($query);
            if ($catinsert) {
                $msg = "Category Inserted Succesfully !";
            return $msg;
            }else {
             $msg = "Category Not Inserted !";
            return $msg;
            }
        }
    }

    public function getAllCat(){
        $query = "SELECT * FROM tbl_category ORDER BY catId";
        $result = $this->db->select($query);
        return $result;
    }
    public function getCat(){
        $query = "SELECT * FROM tbl_category  ORDER BY catId";
        $result = $this->db->select($query);
        return $result;
    }
}
?>