
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
    $addnoticesub=htmlentities($_POST['subject'],ENT_QUOTES);
    $addnoticedes=htmlentities($_POST['details'],ENT_QUOTES);
    $image=$_FILES['image']['name'];
        if(!empty($image))
        {
            $r=rand(20,1000);
            $image=$r.$image;
            $tmp_loc=$_FILES['image']['tmp_name'];
            $perm_loc="images/".$image;
            copy($tmp_loc,$perm_loc);   
        }
    $addcategory=htmlentities($_POST['category'],ENT_QUOTES);
    $addreference=htmlentities($_POST['reference'],ENT_QUOTES);

    echo $sql = "INSERT into addnotice (noticesubject,noticedescription,image,category,refer_id, adminId) VALUES ('$addnoticesub','$addnoticedes','$image' ,'$addcategory',$addreference,'$adminid')";
    $data=mysqli_query($link,$sql);

    header("location:ShowNotice.php");
}
if (isset($_POST['images'])){
   $file_name =  $_FILES['file']['name'];
   $file_type = $FILES['file']['type'];
$file_size = $FILES['file']['size'];
$file_tem_loc = $FILES['file']['tmp_name'];  
$file_store = "images/".$file_name;

move_uploaded_file($file_tem_loc, $file_store);
}


?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Notice Board</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <scrip src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></scrip>
    <style>
        .admin{
            /*border: 2px solid #23148b;*/
            margin: 80px auto;
            background-color: #0C1717;
            color: #fff;
        }
    </style>

</head>
<body>
<div class="container">

    <div class="row">
        <div class="col-md-4 admin"style=" opacity: 0.8;filter: alpha(opacity=80);">
            <form method="post">
                <h1>Add New Notice</h1>
                <div class="form-group">
                    <label >Notice Subject</label>
                    <input type="text"  class="form-control" name="subject"  >
                </div>
                   <label >Notice Details </label>
                <div class="form-group">
                    <!-- <textarea name="details"></textarea> -->
                    <textarea name="details" id="" cols="47" rows="5"></textarea>
                </div>
                <div class=""form-group"">
                    <input type="file" name="image" placeholder="image" required="" capture>
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
                    <input type="text" class="form-control" name="reference" >
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 2%;margin-left: 40%;margin-bottom: 15px;">ADD</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>