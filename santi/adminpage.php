<?php

@include 'config.php';

if(isset($_POST['add_product'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'uploaded_img/'.$product_image;

   if(empty($product_name) || empty($product_price) || empty($product_image)){
      $message[] = 'PLEASE FILL IT ALL OUT';
    }else{
        $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
        $upload = mysqli_query($conn,$insert);
        if($upload){
           move_uploaded_file($product_image_tmp_name, $product_image_folder);
           $message[] = 'NEW PRODUCT ADDED SUCCESSFULLY';
        }else{
           $message[] = 'COULD NOT ADD THE PRODUCT';
        }
     }
};
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:adminpage.php');
};
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gymshark Admin Page</title>
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="C:\xampp\htdocs\santi\Gymshark Official Store - Gym Clothes & Workout Clothes.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
    <body>

        <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '<span class="message">'.$message.'</span>';
                }
            }
        ?>
        <br>
        <div class="topnav">
            <div class="topnav">
                <a href="http://localhost/santi/newfile.php#newfile.php">Home</a>
                <a href="http://localhost/santi/help.php">Help</a>
                <a href="http://localhost/santi/contact.php">Contact</a>
            </div>
        </div>
        <div class="admincrud">
            <div class="adminform">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <h1>add a new product</h1>
                    <input type="text" placeholder="Enter Product Name" name="product_name" class="box">
                    <input type="number" placeholder="Enter Product Price" name="product_price" class="box">
                    <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                    <input type="submit" class="btn" name="add_product" value="Add Product">
                </form>
            </div>
            
            <?php
            $select = mysqli_query($conn, "SELECT * FROM products");
            ?>

        <div class="pdisplay">
            <table class="pdtable">
                <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Action</th>
                    <th>Description</th>
                </tr>
                </thead>
                <?php while($row = mysqli_fetch_assoc($select)){ ?>
                <tr>
                    <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>$<?php echo $row['price']; ?>/-</td>
                    <td>
                        <a href="http://localhost/santi/update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Edit </a>
                        <a href="adminpage.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> Delete </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html> 