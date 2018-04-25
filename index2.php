<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "horses";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if(isset($_REQUEST['searchsn'])){
    var_dump($_POST);
    $myArray = array_filter($_POST['sn']);
$str = join('", "', $myArray);
header('location:index.php?hname="'.$str.'"');
}

if(isset($_REQUEST['hname'])){
$sql = "SELECT *, MIN(time) minimumtime,AVG(time) avgtime FROM data WHERE `name` IN (".$_REQUEST['hname'].") GROUP BY name,`distance`";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datatable responsive with mysql</title>
<link rel="stylesheet" id="font-awesome-style-css" href="http://phpflow.com/code/css/bootstrap3.min.css" type="text/css" media="all">
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
	 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/1.0.3/css/dataTables.responsive.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/1.0.3/js/dataTables.responsive.js"></script>

	
	<div class="container">
      <div class="">
        <h1>Horse Data</h1>
        <div class="">
		<table id="employee_grid" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>name</th>
                <th>length</th>
				        <th>condition</th>
                <th>distance</th>
                 <th>weight</th>
                  <th>Minimum Time</th>
                 
                     <th>Average</th>
            </tr>
        </thead>
 <tbody>
   <?php
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"]. "</td><td>" . $row["length"]. "</td><td>" . $row["condition"]. "</td><td>" . $row["distance"]. "</td><td>" . $row["weight"]. "</td><td>" . $row["minimumtime"]. "</td><td>" . $row["avgtime"]. "</td></tr>";
    }
} else {
    echo "0 results";
}
$conn->close();

?>
 </tbody>
        <tfoot>
            <tr>
                <th>name</th>
                <th>length</th>
                <th>condition</th>
                <th>distance</th>
                 <th>weight</th>
                  <th>Minimum Time</th>
                 
                     <th>Average</th>
            </tr>
        </tfoot>
    </table>
    </div>
      </div>

    </div>

<script type="text/javascript">
$( document ).ready(function() {
$('#employee_grid').DataTable({
			
		 "responsive": true,
             });   
});
</script>
<?php } 

$file = fopen("test.txt","r"); 
while(! feof($file))
  {
    echo fgets($file). "<br />";
      }

      fclose($file);

?>

<form method="POST" name="searchvanita" class="searchvanita" id="searchvanita">
<div class="clear"></div>
<div class="c_one"> <label>Horse 1</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 2</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 3</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 4</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 5</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 6</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 7</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 8</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 9</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 10</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 11</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 12</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 13</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 14</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 15</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 16</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>
<div class="c_one"> <label>Horse 17</label> <input name="sn[]" type="text" id="sn" tabindex="1" class="sm-form-c" placeholder="Horse Name" autocomplete="off" />  </div>

<div class="col_one_fifth"> <br/> <input type="submit" name="searchsn" value="Search Horses"  tabindex="9" class="button button-3d nomargin" />
</div>
</form>
