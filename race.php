<?php
include('constant.php');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$meetingid = $_REQUEST['meetingid'];
//$sql = "SELECT *, MIN(time) minimumtime,AVG(time) avgtime FROM data WHERE `name` IN (";
$sql = "SELECT *  FROM races WHERE meeting_id =" . $meetingid." ORDER by race_number";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Horses Data</title>
        <link rel="stylesheet" id="font-awesome-style-css" href="http://phpflow.com/code/css/bootstrap3.min.css" type="text/css" media="all">
        <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/1.0.3/css/dataTables.responsive.css">
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/1.0.3/js/dataTables.responsive.js"></script>


    <div class="container">
        <div class="">
            <h1>Race Data</h1>
            <div class="">
                <table id="employee_grid" class="display" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Race</th>
                            <th>Race No.</th>
                            <th>Race Schedule</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>"
        . "<td>" . $row["race_title"] . "</td>"
        . "<td><a href=horses.php?raceid=" . $row['race_id'] . ">" . $row["race_number"] . "</a></td>"
        . "<td>" . $row["race_schedule_time"] . "</td>"
        . "</tr>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Race</th>
                            <th>Race No.</th>
                            <th>Race Schedule</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#employee_grid').DataTable({

                "responsive": true,
            });
        });
    </script>

