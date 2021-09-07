<?php
session_start();
if (!isset($_SESSION['user_type'])) {
    session_destroy();
    header("location:Noticefrontend.php");
}
$link = mysqli_connect('localhost', 'root', '', 'notice');
$adminid = $_SESSION['auth_user']['userid'];

if (preg_match("/^da.*$/",$adminid)) {
    include('DeptAadminAfterlogin.php');
}
elseif (preg_match("/^a.*$/",$adminid)) {
    include('afterlogin.php');
} else{
    echo "";
}


if (!empty($_POST)){
    $id = $_GET['id'];
    //var_dump($_POST); exit;
    $noticesubject=htmlentities($_POST['subject'],ENT_QUOTES);
    //$photo = $_FILES['photo'];
    $category=htmlentities($_POST['category'],ENT_QUOTES);
    $noticedescription=htmlentities($_POST['details'],ENT_QNT_QUOTES);
    $refer_id=htmlentities($_POST['reference'],ENT_QUOTES);
    




     $target_dir = getcwd() . '/uploads/';
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $upload_image_name = basename($_FILES["image"]["name"]);
    $uploadOk1 = 1;
    $uploadMessage11 = "";
    $uploadMessage12 = "";
    $uploadMessage13 = "";
    $uploadMessage14 = "";
    $uploadMessage15 = "";
    $uploadMessage16 = "";
    $uploadMessage17 = "";
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    //
        if(isset($_POST['image'])){
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
           $uploadOk3 = 1;
        } else {
            $uploadMessage11 = "File is not an image. ";
            $uploadOk1 = 0;
        }
        }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadMessage12 = "Sorry, file already exists. ";
        $uploadOk1 = 0;
    }
    // Check file size
    if ($_FILES["image"]["size"] > 1000000) {
        $uploadMessage13 = "Sorry, your file is too large. Must be smaller than 1 Mb. ";
        $uploadOk1 = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadMessage14 = "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk1 = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk1 == 0) {
        $uploadMessage15 = "Sorry, your file was not uploaded. ";
    // if everything is ok, try to upload file
    } else {

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $uploadMessage16 = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            
        } else {
            $uploadMessage17 = "Sorry, there was an error uploading your file.";
        }
    }


    $sql =  $query = "update newnotice set noticesubject = '$noticesubject',noticedescription = '$noticedescription',photo='$upload_image_name',refer_id ='$refer_id',category ='$category'  where id='$id'";


    // $sql = "INSERT into newnotice ($noticesubject,$noticedescription,$photo,$category,$refer_id,$adminid) VALUES 
    // ('subject','details', '$upload_image_name' ,'category','reference', 'adminId') ";
    $data=mysqli_query($link,$sql);
    if(!$data){
        die("Query Failed. " . mysqli_error($link));
    }

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'ShowNotice.php';
    header("Location: http://$host$uri/$extra");
    





}


?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Notice Board</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <style>


        .admin {

            border: 2px solid #23148b;
            margin: 120px auto;

        }

    </style>
</head>
<body>
<div class="container">


    <div class="row">


        <div class="col-md-4 admin ">
            <a href="ShowNotice.php"> <button type="submit" class="btn btn-primary" style="margin-right:5%;margin-top: 2%;">Back</button></a>


            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label >Notice Subject</label>
                    <input type="text"  class="form-control" name="subject" value="" required >
                </div>
                   <label >Notice Details </label>
                <div class="form-group">
                    <!-- <textarea name="details"></textarea> -->
                    <textarea name="details" id="" cols="47" rows="5" required></textarea>
                </div>
               <div class="form-group">
                    <label for="">Upload Image</label>
                    <input class="form-control" type="file" accept="image/*" name="image">




                     <br>
                    <?php 
                        if(!empty($uploadMessage11)){ echo "<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>
                            <span class='badge badge-pill badge-danger'>Failed</span>
                            $uploadMessage11
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>"; }
                        
                         if(!empty($uploadMessage12)){ echo "<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>
                            <span class='badge badge-pill badge-danger'>Failed</span>
                            $uploadMessage12
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>"; }
                        
                         if(!empty($uploadMessage13)){ echo "<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>
                            <span class='badge badge-pill badge-danger'>Failed</span>
                            $uploadMessage13
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>"; }
                        
                         if(!empty($uploadMessage14)){ echo "<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>
                            <span class='badge badge-pill badge-danger'>Failed</span>
                            $uploadMessage14
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>"; }
                        
                         if(!empty($uploadMessage15)){ echo "<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>
                            <span class='badge badge-pill badge-danger'>Failed</span>
                            $uploadMessage15
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>"; }
                        
                         if(!empty($uploadMessage16)){ echo "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show'>
                            <span class='badge badge-pill badge-success'>Success</span>
                             $uploadMessage16
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>"; }
                        
                         if(!empty($uploadMessage17)){ echo "<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>
                            <span class='badge badge-pill badge-danger'>Failed</span>
                            $uploadMessage17
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>"; }
                        
                        ?>


                </div>

                 <div class="form-group">
                    <select  class="form-control" id="" name="category">
                        <option>Select Category</option>
                        <?php
                            //if (preg_match("/^da.*$/",$adminid)) {
                                //$catSql = "SELECT * from category WHERE usertype IN ('3','2')";
                                $catSql = "SELECT * from category WHERE adminid ='$adminid'";
                            //}
                            $res=mysqli_query($link,$catSql);
                            while($row=mysqli_fetch_array($res)){
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['category'];?> </option  >
                        <?php     }  ?>
                    </select>
                                </div>
                


                <div class="form-group">
                    <label >Reference </label>
                    <input type="text" class="form-control" name="reference" required>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 2%;margin-left: 40%;margin-bottom: 15px;">ADD</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>