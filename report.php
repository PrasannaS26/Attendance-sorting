<?php

include "db.php";

$query = "

SELECT

students.name,
students.department,

COUNT(attendance.id) AS total_days,

SUM(
CASE
WHEN attendance.status='Present'
THEN 1
ELSE 0
END
) AS present_days,

ROUND(

(
SUM(
CASE
WHEN attendance.status='Present'
THEN 1
ELSE 0
END
)

/

COUNT(attendance.id)

)*100,2

) AS percentage

FROM students

LEFT JOIN attendance

ON students.id = attendance.student_id

GROUP BY students.id

ORDER BY percentage DESC

";

$result = mysqli_query($conn,$query);

$names = [];
$percentages = [];

$result2 = mysqli_query($conn,$query);

while($r=mysqli_fetch_assoc($result2)){

$names[] = $r['name'];

$percentages[] =
$r['percentage'] ? $r['percentage'] : 0;

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Attendance Reports</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
background:#eef2f7;
font-family:Arial;
}

.card{
border-radius:20px;
}

.table th{
background:#212529;
color:white;
}

.progress{
height:25px;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow p-4">

<div class="d-flex justify-content-between">

<h2>
<i class="fa fa-chart-column text-primary"></i>
Attendance Reports
</h2>

<a href="index.php"
class="btn btn-dark">
Dashboard
</a>

</div>

<hr>

<table class="table table-bordered table-hover">

<tr>

<th>Name</th>
<th>Department</th>
<th>Total Days</th>
<th>Present</th>
<th>Percentage</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['department']; ?>
</td>

<td>
<?php echo $row['total_days']; ?>
</td>

<td>
<?php echo $row['present_days']; ?>
</td>

<td>

<div class="progress">

<div
class="progress-bar

<?php

if($row['percentage'] >= 75){
echo "bg-success";
}

elseif($row['percentage'] >= 50){
echo "bg-warning";
}

else{
echo "bg-danger";
}

?>

"

style="width:
<?php echo $row['percentage']; ?>%">

<?php

if($row['percentage']){
echo $row['percentage']."%";
}else{
echo "0%";
}

?>

</div>

</div>

</td>

</tr>

<?php } ?>

</table>

<hr>

<h3 class="mb-4">
Attendance Analytics
</h3>

<canvas id="chart"></canvas>

</div>

</div>

<script>

const ctx =
document.getElementById('chart');

new Chart(ctx,{

type:'bar',

data:{

labels:
<?php echo json_encode($names); ?>,

datasets:[{

label:'Attendance Percentage',

data:
<?php echo json_encode($percentages); ?>,

borderWidth:1

}]
},

options:{

responsive:true,

scales:{
y:{
beginAtZero:true,
max:100
}
}

}

});

</script>

</body>
</html>