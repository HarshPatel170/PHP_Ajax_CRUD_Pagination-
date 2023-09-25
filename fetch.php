<?php 

$conn = mysqli_connect("localhost","root","","training_sql") or die(mysqli_connect_error($conn));

extract($_POST);



if( isset($_POST['fname']) && isset($_POST['lname']) && 
isset($_POST['class']) && isset($_POST['grade']) 
){
    $fname =$_POST['fname'];
    $lname =$_POST['lname'];
    $class =$_POST['class'];
    $grade =$_POST['grade'];
    $qurey = "INSERT INTO `ajex_crud`(`fname`, `lname`, `class`, `grade`) VALUES ('$fname',
        '$lname','$class','$grade')";
        mysqli_query($conn,$qurey);
    }
    
    if(isset($_POST['read'])){
        $Num_itm_per_page = 2;
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1; 
        $offset = ($page - 1) * $Num_itm_per_page;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }

        $qurey = "SELECT * FROM ajex_crud ORDER BY id  LIMIT $offset, $Num_itm_per_page";
        $result = mysqli_query($conn, $qurey);
        if(mysqli_num_rows($result) > 0)
        {
            $data='<table id="studentdata" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">class</th>
                    <th scope="col">grade</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>';
            $num = 1;
            while($row = mysqli_fetch_array($result)){
                $data .= '<tbody>
                <tr>
                <td>'.$num.'</td>
                <td>'.$row['fname'].'</td>
                <td>'.$row['lname'].'</td>
                <td>'.$row['class'].'</td>
                <td>'.$row['grade'].'</td>
                <td>
                <button onclick="Updateuser('.$row['id'].')" class="badge btn-primary">update</button>
                    <button onclick="DeleteUser('.$row['id'].')" class="badge btn-danger">DELETE</button>
                </td>
            </tr>
            </tbody>';
            $num++;
            }
            $data .='</table>';
            $page="SELECT * FROM ajex_crud";
            $page_record = mysqli_query($conn, $page) or die("error");
            $total_record = mysqli_num_rows($page_record);
            $total_page = ceil($total_record/$Num_itm_per_page);
            $data .='<div class="" id="pagination">';   
            for($i=1; $i <= $total_page; $i++)
            {
                $data .="
                <a class ='active' id='{$i}'  href=''>$i</a>";
            }
            $data .='</div>' ; 
            echo $data; 
        }
    }
//delete user DATA
if(isset($_POST['deleteid'])){
    echo "ghdrsh";
    $uid = $_POST['deleteid'];
    $deletequery = "DELETE FROM `ajex_crud` WHERE `id` = '$uid'";
    //echo $deletequery;
    // "DELETE FROM ajex_crud WHERE `id` = 18"
    // DELETE FROM 'ajex_crud' WHERE id='18'
    //exit;
    mysqli_query($conn,$deletequery);
}

$response = array();
if(isset($_POST['id'])  && $_POST['id'] != "")
{
    $id = $_POST['id'];
    $query = "SELECT * FROM ajex_crud WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if (!$result = mysqli_query($conn, $query)){
        exit(mysqli_error());
    } 

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response = $row;
    }
    }else {
        $response['ststus'] = 200;
        $response['message'] = "date not found";
    }
    echo json_encode($response);

} else {
    $response['ststus'] = 200;
    $response['message'] =  "inavalid";
    echo json_encode($response);
    }


    if (isset($_POST['hidden_user_idup'])){

        $hidden_user_idup = $_POST['hidden_user_idup'];
        $fnameup = $_POST['fnameup'];
        $lnameup = $_POST['lnameup'];
        $classup = $_POST['classup'];
        $gradeup = $_POST['gradeup'];

        $query = "UPDATE `ajex_crud` SET `fname`='$fnameup',`lname`='$lnameup',`class`='$classup',`grade`='$gradeup' WHERE id = '$hidden_user_idup'";
        mysqli_query($conn,$query);
    }
?>