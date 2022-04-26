<?php
require "db.php";

/**
* get students **/
$sql = "SELECT id, name FROM student_info";
$st = $mysqli->query($sql);
$students = array();
if ($st->num_rows > 0) 
{
	// output data of each row
	while($row = $st->fetch_assoc()) 
	{
		$students[] = $row;
	}
}

/**
* get jobs **/
$sql2 = "SELECT id, name FROM job_info";
$jb = $mysqli->query($sql2);
$jobs = array();
if ($jb->num_rows > 0) 
{
	// output data of each row
	while($row = $jb->fetch_assoc()) 
	{
		$jobs[] = $row;
	}
}

$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Dummy</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
    color: #404E67;
    background: #F5F7FA;
    font-family: 'Open Sans', sans-serif;
}
.table-wrapper {
    width: 100%;
    margin: 30px auto;
    background: #fff;
    padding: 20px;	
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
    padding-bottom: 10px;
    margin: 0 0 10px;
}
.table-title h2 {
    margin: 6px 0 0;
    font-size: 22px;
}
.table-title .add-new {
    float: right;
    height: 30px;
    font-weight: bold;
    font-size: 12px;
    text-shadow: none;
    min-width: 100%;
    border-radius: 50px;
    line-height: 13px;
}
.table-title .add-new i {
    margin-right: 4px;
}
table.table {
    table-layout: fixed;
}
table.table tr th, table.table tr td {
    border-color: #e9e9e9;
}
table.table th i {
    font-size: 13px;
    margin: 0 5px;
    cursor: pointer;
}
table.table th:last-child {
    width: 15%;
}
table.table td a {
    cursor: pointer;
    display: inline-block;
    margin: 0 5px;
    min-width: 24px;
}    
table.table td a.add {
    color: #27C46B;
}
table.table td a.edit {
    color: #FFC107;
}
table.table td a.delete {
    color: #E34724;
}
table.table td i {
    font-size: 19px;
}
table.table td a.add i {
    font-size: 24px;
    margin-right: -1px;
    position: relative;
    top: 3px;
}    
table.table .form-control {
    height: 32px;
    line-height: 32px;
    box-shadow: none;
    border-radius: 2px;
}
table.table .form-control.error {
    border-color: #f50000;
}
table.table td .add {
    display: none;
}
.grades {
    margin: 0;
    padding: 0;
}
input.form-control.grade {
    width: 10%;
}

.grades li {
    display: inline;
}
.form-control {
    display: inline;
	    vertical-align: sub;
		height: 18px !important;
}
</style>
<script>
function genCharArray(charA, charZ) 
{
	var a = [], i = charA.charCodeAt(0), j = charZ.charCodeAt(0);
	for (; i <= j; ++i) 
	{
		a.push(String.fromCharCode(i));
	}
	return a;
}
$(document).ready(function()
{
	$('[data-toggle="tooltip"]').tooltip();

	$(document).on("click", ".delete", function()
	{
        $(this).parents("tr").remove();
		$(".add-new").removeAttr("disabled");
    });
	
	var mainArr = [];
	var indexsas = "";
	$(document).on("click","#submitstudent",function()
	{
		var rows = "";
		var arr = [];
		//var selectedStudents = $(".src-table1 input:checked").parents("tr").clone();
		var valujes = $('input[name="check[]"]').val();
		
		$('input[name="check[]"]:checked').each(function(index, item) 
		{
			 arr.push(this.value);
			 indexsas = $(item).attr('data-row-id');
		});

		if(arr.length == 1)
		{
			rows = "";
			var student = $("#check_"+indexsas).attr('data-name-'+indexsas);
			var sid = $("#check_"+indexsas).attr('data-tr-id_'+indexsas);

			rows+= '<tr><td style="width:10%;"><input type="checkbox" name="check" class="form-control check" /></td><td>'+sid+'</td><td>'+student+' <br /> <button type="button" class="btn btn-primary mybutton" data-toggle="modal" data-target="#exampleModal2" data-student="'+sid+'">Job Info</button></td><td style="width:50%;"><ul class="grades"><li><input type="radio" name="grade" class="form-control grade" /> E </li><li><input type="radio" name="grade" class="form-control grade" /> G </li><li><input type="radio" name="grade" class="form-control grade" /> C </li><li><input type="radio" name="grade" class="form-control grade" /> D </li><li><input type="radio" name="grade" class="form-control grade" /> B </li></ul></td><td><a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a></td></tr><tr id="job_description_'+sid+'"></tr>';
		}else if(arr.length > 1){
			for (i = 0; i < arr.length; ++i)
			{
				var student = $("#check_"+i).attr('data-name-'+i);
				var sid = $("#check_"+i).attr('data-tr-id_'+i);

				rows+= '<tr><td style="width:10%;"><input type="checkbox" name="check" class="form-control check" /></td><td>'+sid+'</td><td>'+student+' <br /> <button type="button" class="btn btn-primary mybutton" data-toggle="modal" data-target="#exampleModal2" data-student="'+sid+'">Job Info</button></td><td style="width:50%;"><ul class="grades"><li><input type="radio" name="grade" class="form-control grade" /> A </li><li><input type="radio" name="grade" class="form-control grade" /> B </li><li><input type="radio" name="grade" class="form-control grade" /> C </li><li><input type="radio" name="grade" class="form-control grade" /> D </li><li><input type="radio" name="grade" class="form-control grade" /> E </li></ul></td><td><a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a></td></tr><tr id="job_description_'+sid+'"></tr>';
			}
		}else{
			for (i = 0; i < arr.length; ++i)
			{
				var student = $("#check_"+i).attr('data-name-'+i);
				var sid = $("#check_"+i).attr('data-tr-id_'+i);

				rows+= '<tr><td style="width:10%;"><input type="checkbox" name="check" class="form-control check" /></td><td>'+sid+'</td><td>'+student+' <br /> <button type="button" class="btn btn-primary mybutton" data-toggle="modal" data-target="#exampleModal2" data-student="'+sid+'">Job Info</button></td><td style="width:50%;"><ul class="grades"><li><input type="radio" name="grade" class="form-control grade" /> A </li><li><input type="radio" name="grade" class="form-control grade" /> B </li><li><input type="radio" name="grade" class="form-control grade" /> C </li><li><input type="radio" name="grade" class="form-control grade" /> D </li><li><input type="radio" name="grade" class="form-control grade" /> E </li></ul></td><td><a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a></td></tr><tr id="job_description_'+sid+'"></tr>';
			}
		}
		
		$(".target-table tbody").append(rows);
	});
	
	$(document).on("click","#submitjob",function()
	{
		var stId = $(this).attr("data-studentid");
		var rows = "";
		var arr = [];
		var rowids = [];
		//var selectedStudents = $(".src-table1 input:checked").parents("tr").clone();
		var valujes = $('input[name="jobcheck[]"]').val();
		$('input[name="jobcheck[]"]:checked').each(function(index, item) {
			arr.push(this.value);
			rowids.push($(item).attr('data-row-id'));
			indexsas = $(item).attr('data-row-id');
		});
		console.log(rowids);
		//var selectedJobs = $(".src-table2 input:checked").parents("tr").clone();
		var alphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
		if(arr.length == 1)
		{
			rows = "";
			var job = $("#jobinfo_"+indexsas).attr('data-name-'+indexsas);
			var jid = $("#jobinfo_"+indexsas).attr('data-tr-id_'+indexsas);

			rows+= '<td></td><td>'+alphabet[0].toUpperCase()+'</td><td>'+job+' </td> <td><ul class="grades"><li><input type="radio" name="grade" class="form-control grade" /> A </li><li><input type="radio" name="grade" class="form-control grade" /> B </li><li><input type="radio" name="grade" class="form-control grade" /> C </li><li><input type="radio" name="grade" class="form-control grade" /> D </li><li><input type="radio" name="grade" class="form-control grade" /> E </li></ul></td><td></td>';
		}else if(arr.length > 1){
			for (j = 0; j < arr.length; ++j)
			{
				var job = $("#jobinfo_"+j).attr('data-name-'+j);
				var jid = $("#jobinfo_"+j).attr('data-tr-id_'+j);

				rows+= '<td></td><td>'+alphabet[j].toUpperCase()+'</td><td>'+job+' </td> <td><ul class="grades"><li><input type="radio" name="grade" class="form-control grade" /> A </li><li><input type="radio" name="grade" class="form-control grade" /> B </li><li><input type="radio" name="grade" class="form-control grade" /> C </li><li><input type="radio" name="grade" class="form-control grade" /> D </li><li><input type="radio" name="grade" class="form-control grade" /> E </li></ul></td><td></td>';
			}
		}else{
			for (j = 0; j < arr.length; ++j)
			{
				var job = $("#jobinfo_"+j).attr('data-name-'+j);
				var jid = $("#jobinfo_"+j).attr('data-tr-id_'+j);

				rows+= '<td></td><td>'+alphabet[j].toUpperCase()+'</td><td>'+job+' </td> <td><ul class="grades"><li><input type="radio" name="grade" class="form-control grade" /> A </li><li><input type="radio" name="grade" class="form-control grade" /> B </li><li><input type="radio" name="grade" class="form-control grade" /> C </li><li><input type="radio" name="grade" class="form-control grade" /> D </li><li><input type="radio" name="grade" class="form-control grade" /> E </li></ul></td><td></td>';
			}
		}
		$("#job_description_"+stId).append(rows);
	});
	
	$( document ).on("click", ".mybutton", function(){
		var studentId = $(this).attr("data-student");
		$("#submitjob").attr("data-studentid", studentId);
	});
});

</script>
</head>
<body>
<div class="container-lg">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Demo<b>Test</b></h2></div>
                    <div class="col-sm-4">
                        
						
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
							Student Info
						</button>
						<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
							Jon Info
						</button> -->
						
						
                    </div>
					<p>&nbsp;</p>
					<table class="table table-bordered target-table">
							<thead>
								<tr> 
									<th style="width: 10%;">#</th>
									<th style="width: 5%;">Id</th>
									<th style="width: 10%;">Name</th>
									<th>Grade</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                </div>
            </div>
            
        </div>
    </div>
	<div class="row">
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Student Info</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-bordered src-table1">
							<thead>
								<tr>
									<th>#</th>
									<th>Id</th>
									<th>Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if(count($students) > 0)
								{
									$totalStudents = count($students);
									$i = 0;
									foreach($students as $student)
									{
										?>
										<tr id="check_<?php echo $i;?>" data-total-record="<?php echo $totalStudents;?>" data-tr-id_<?php echo $i;?>="<?php echo $student['id'];?>" data-name-<?php echo $i;?>="<?php echo $student['name'];?>">
											<td><input type="checkbox" name="check[]" class="form-control check" value="<?php echo $student['name'];?>" data-row-id="<?php echo $i;?>" /></td>
											<td><?php echo $student['id'];?></td>
											<td><?php echo $student['name'];?></td>
											<td>
												<a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
												<a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
												<a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
											</td>
										</tr>
										<?php
										$i++;
									}
								}
								?>
								      
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="submitstudent">Select</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel2">Job Info</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-bordered src-table2">
							<thead>
								<tr>
									<th>#</th>
									<th>ID</th>
									<th>Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if(count($jobs) > 0)
								{
									$j = 0;
									$totalJobs = count($jobs);
									foreach($jobs as $job)
									{
										?>
										<tr id="jobinfo_<?php echo $j;?>" data-total-record="<?php echo $totalJobs;?>" data-tr-id_<?php echo $j;?>="<?php echo $job['id'];?>" data-name-<?php echo $j;?>="<?php echo $job['name'];?>">
											<td><input type="checkbox" name="jobcheck[]" class="form-control jobcheck" value="<?php echo $job['name'];?>" data-row-id="<?php echo $j;?>" /></td>
											<td><?php echo $job['id'];?></td>
											<td><?php echo $job['name'];?></td>
											<td>
												<a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
												<a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
												<a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
											</td>
										</tr>
										<?php
										$j++;
									}
								}
								?>      
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="submitjob" data-studentid="">Select</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
</body>
</html>