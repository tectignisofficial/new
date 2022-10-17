<?php
ini_set('display_errors', 1);
$date = date('Y-m-d H:i:s');
//$conn = new mysqli("localhost","mokashi","mokashi@123","mokashi");
$conn = new mysqli("localhost","GoBestDentist","Admin@123","Gobestdentist");

if(isset($_POST) && !empty($_POST)){
	$id = mysqli_real_escape_string($conn,$_POST['blogId']);
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $short = mysqli_real_escape_string($conn,$_POST['shortDesc']);
    $detail = mysqli_real_escape_string($conn,$_POST['detailDesc']);
    $metaTitle = mysqli_real_escape_string($conn,$_POST['metaTitle']);
    $metadesc = mysqli_real_escape_string($conn,$_POST['metadesc']);
    if(isset($_FILES) && !empty($_FILES["imgBanner"]["name"])){
		$targetDir = "blogimage/";
		$fileName = basename($_FILES["imgBanner"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

	    $allowTypes = array('jpg','png','jpeg','gif');
	    if(in_array($fileType, $allowTypes)){
	        // Upload file to server
	        if(!move_uploaded_file($_FILES["imgBanner"]["tmp_name"], $targetFilePath)){
	            echo json_encode(array('status' => 515,'message' => 'Something Went Wrong.')); 
	        }
	    }else{
	    	echo json_encode(array('status' => 515,'message' => "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload."));
	    }
	}else{
		$fileName = $_POST['bannerImg'];
	}
	if($id != 0){
		$sql = "UPDATE blogs SET title = '$title', shortdesc = '$short', detaildesc = '$detail', banner = '$fileName', meta_title = '$metaTitle', meta_desc = '$metadesc' WHERE id='$id'";
	}else{
        $sql = "INSERT INTO blogs (title, shortdesc, detaildesc, banner,meta_title, meta_desc, is_delete,created_at)VALUES (
        '".$title."', '".$short."', '".$detail."','".$fileName."','".$metaTitle."','".$metadesc."','0','".$date."')";
        //echo $sql;
    }
	if ($conn->query($sql) === TRUE) {
	  header("location:blogs.php");
	} else {
	  echo json_encode(array('status' => 515,'message' => "Error: " . $sql . "<br>" . $conn->error));
	}
}
?>
