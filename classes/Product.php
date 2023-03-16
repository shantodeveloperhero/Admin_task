<?php 
include_once '../lib/Database.php';
include_once '../helpers/Format.php';
?>

<?php
 class Product{
    private $db;
    private $fm;

    public function __construct(){
      $this->db = new Database();
      $this->fm = new Format();
    }
    public function productInsert($data, $file){
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $catId = mysqli_real_escape_string($this->db->link, $data['catId']);

    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;
     
    if ($productName == "" || $catId == "") {
        $msg = "Fields must not be empty !";
            return $msg;
       }elseif ($file_size >1048567) {
        echo "<span class='error'>Image Size should be less then 1MB!</span>";
       } elseif (in_array($file_ext, $permited) === false) {
        echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";  
       }else {
        move_uploaded_file($file_temp, $uploaded_image);
        $query = "INSERT INTO tbl_product(productName,catId,image) VALUES('$productName','$catId','$uploaded_image')";
        $inserted_row = $this->db->insert($query);
            if ($inserted_row) {
                $msg = "Product Inserted Succesfully !";
            return $msg;
            }else {
             $msg = "Product Not Inserted !";
            return $msg;
            }
    }
    }

    public function getAllProduct(){
        $query = "SELECT tbl_product.*, tbl_category.catName
                  FROM tbl_product
                  INNER JOIN tbl_category
                  ON tbl_product.catId = tbl_category.catId
                 ORDER BY tbl_product.productId";
        $result = $this->db->select($query);
        return $result;
    }

    public function getFeatured(){
        $query = "SELECT * FROM tbl_product  ORDER BY productId";
        $result = $this->db->select($query);
        return $result;
    }
 }
?>