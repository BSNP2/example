<?php

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt');
	$con=mysqli_connect("localhost","root","","rental");

$page_limit=5;
if(isset($_POST['page']))
{
$pn=$_POST['page'];

 }
 else{
 	$pn=1;
 }
   
   $start_from=($pn-1)*$page_limit;
   $sql="select * from emp_image limit $start_from,$page_limit";
   $result=mysqli_query($con,$sql);

   



$path = 'uploads1/'; 
if(isset($_POST["action"]))
	{
	
			if($_POST["action"]=="fetch")
			{
				//$sql="insert into emp_image(email,first_name,last_name,address,image)values('');"
				//$sql="select id,email,first_name,last_name,address,image from emp_image";
				//$result=mysqli_query($con,$sql);

				
				$output ='

				<table id="user_data" class="table table-bordered tables-striped">
				<thead>
					<tr>
						<th col>id</th>
						<th>Email</th>
						<th>First name</th>
						<th>Last name</th>
					
						<th><select class="table-filter" id="filter1">
							<option selected>Address</option>
							<option value="chennai">chennai</option>
							<option value="coimbatore">coimbatore</option>
							<option value="madurai">madurai</option>
							
						</select>
       						
          				</th>


						<th>image</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
					<tbody>';

						while($row=mysqli_fetch_assoc($result))
				{
						$output.='

								<tr>
									<td>'.$row["id"].' </td>
									<td>'.$row["email"].'</td>
									<td>'.$row["first_name"].'</td>
									<td>'.$row["last_name"].'</td>
									<td>'.$row["address"].'</td>
									<td>
										<img src="'.$row["image"].'"  height="60" width="75" class="img-thumbnail" />

									</td>
										<td>
											<button type="button" class="btn btn-success edit" dataid='.$row['id'].' />edit</td>
											<td> 
											<button type="button" class="btn btn-danger delete" dataid='.$row['id'].' />delete</td>

										</td>


								</tr>	';

						
				}
				$output.='

					</tbody>
				</table>';

				echo $output;
			

?>
<ul class="pagination">
<?php
$sql = "SELECT COUNT(*) FROM emp_image";
        $rs_result = mysqli_query($con,$sql);
        $row = mysqli_fetch_row($rs_result);
        $total_records = $row[0];
        
        // Number of pages required.
        $total_pages = ceil($total_records / $page_limit);
        $pagLink = "";                      
        for ($i=1; $i<=$total_pages; $i++) {
        if ($i==$pn) {
            $pagLink .= "<li class='active'><a href='index.php?page="
                                                .$i."'>".$i."</a></li>";
        }           
        else {
            $pagLink .= "<li><a href='index.php?page=".$i."'>
                                                ".$i."</a></li>";
        }
        };
        echo $pagLink;
        ?>
 }
</ul>
<?php
if($_POST["action"]=="fetchsinglerow")
{
	if(isset($_POST["id"]))
	{

	$sql="select * from emp_image where id='".$_POST['id']."'";
	$res=mysqli_query($con,$sql);
 while ($row = mysqli_fetch_assoc($res)) {
        
        echo json_encode($row);
 	echo "data inserted";
    }

}
}

if($_POST["action"]=="address_drop")
{

	$sval=$_POST["sval"];
	$sql="select * from emp_image where address='$sval'";
	$res=mysqli_query($con,$sql);
	while($row1=mysqli_fetch_assoc($res))
	{
		echo json_encode($row1);
	}


}




if($_POST["action"]=="update")
{

//extract($_POST);
if(isset($_FILES['image']))
{


	$image_id=$_POST['image_id'];
	$email=$_POST['email'];
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$address=$_POST['address'];


$img = $_FILES['image']['name'];
					$tmp = $_FILES['image']['tmp_name'];
					// get uploaded file's extension
					$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
					// can upload same image using rand function
					$final_image = rand(1000,1000000).$img;
					// check's valid format
											if(in_array($ext, $valid_extensions)) 
						{ 
						$path = $path.strtolower($final_image); 
						if(move_uploaded_file($tmp,$path)) 
						{

	


	$sql="update emp_image set id='$image_id',email='$email',first_name='$first_name',last_name='$last_name',address='$address',image='$path' where id='$image_id'";
}

}

	else
	{
		$image=$_FILES['image']['name'];
		$sql="update emp_image set id='$image_id',email='$email',first_name='$first_name',last_name='$last_name',address='$address',image='$image' where id='$image_id'";
}

$result=mysqli_query($con,$sql);
redirect('location:index.php');


	}
	


}




				if($_POST["action"]=="delete" && isset($_POST['id1']) )
				{
					
						
					$sql="delete from emp_image where id='".$_POST['id1']."'";
					print_r($sql);
				$res1=mysqli_query($con,$sql);

				echo json_encode($res1);
				//echo "delete deleted";
			//echo json_encode($res1);

				}
				


			if($_POST["action"]=="insert")
			{


				
					if (isset($_FILES['image']))
					{



					$img = $_FILES['image']['name'];
					$tmp = $_FILES['image']['tmp_name'];
					// get uploaded file's extension
					$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
					// can upload same image using rand function
					$final_image = rand(1000,1000000).$img;
					// check's valid format
											if(in_array($ext, $valid_extensions)) 
						{ 
						$path = $path.strtolower($final_image); 
						if(file_exists($path))
						{
							echo "file is already exists";
							return;
						}
						if(move_uploaded_file($tmp,$path)) 
						{
						//echo "<img src='$path' />";
						$email = $_POST['email'];

						$name = $_POST['first_name'];
						$lname=$_POST['last_name'];
						$address=$_POST['address'];
						$sql="insert into emp_image(email,first_name,last_name,address,image) values('$email','$name','$lname','$address','$path')";
						

							//echo json_encode($res);


						}
						}
						$res=mysqli_query($con,$sql);
						}

	

}
			

}



	


}
?>