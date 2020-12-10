<!doctype html>

<?php
    session_start();
    
    if(!isset($_SESSION['login']) or ($_SESSION['type'] != "user")){
            header('Location:dashboard');
            exit();
    }
    elseif($_SESSION['type'] == "user"){
        if($_SESSION['userpass'] == "NO")
        {
            header('Location:index_');  
            exit();
        }
    }
?>
<html lang="en">
	<head>
		<title>Home</title>	
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="scripts/Chart.bundle.min.js"></script>
	</head>
		
	<body class="" style="background-image: url('img/bg_test.png'); background-repeat: auto; background-size: 1920px 1080px;">
        <div class="container-fluid">
		    <div class="row">
			    <div class="col-sm-3">
				    <?php require_once("nav.php"); ?>
			    </div>
                <div class="col-sm-9" style="margin:auto;">
                    <div class="row" style=" margin-top:1%; width:100%;">
                        <div class="card border-0 col-sm-12" style=" margin-bottom:1%; background: rgba(134,142,150,0.6);"> <!-- USER PROFILE -->
                            <div class="card-body">
                                <div class="row" >
                                    <h4 class="text-light" style="margin:auto; ">User Dashboard</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12" style="background: rgba(134,142,150,0.6); border-radius:5px !important">
                        <div class="col-sm-6" style="margin:auto; ">  
                            <div class="container">
                                <div class="card border-0 " style="background: rgba(134,142,150,0); margin-bottom:1%;"> <!-- COURSES PROGRESS -->
                                    <div class="card-body " style="padding-bottom:8%; padding-top:5%;">
                                        <div class="row">
                                            <h4 class="text-light" style="margin:auto; margin-top:2%; ">Courses Progress</h4>
                                        </div>
                                        <?php
                                            $server='localhost';
                                            $user='root';
                                            $password='P@rtyboy1.';
                                            $baza='labdatabase';
                                            $connect = mysqli_connect($server, $user, $password, $baza);
                                            $sql = "Select courses_assignments.ID, uzytkownicy.login,   courses_repo.Name, courses_repo.Topics_amount, COUNT(course_content.status) as status from courses_assignments
                                            JOIN uzytkownicy on uzytkownicy.ID = courses_assignments.user_ID
                                            JOIN courses_repo on courses_repo.ID = courses_assignments.course_ID
                                            JOIN course_content on course_content.course_ID = courses_assignments.course_ID
                                            WHERE  (courses_assignments.user_ID = course_content.user_ID) and status = 'yes' and login = '".$_SESSION['login']."' GROUP BY courses_assignments.course_ID";


                                            $result = $connect->query($sql);
                                            
                                            $d = 100;

                                            while($row = mysqli_fetch_array($result))
                                            {
                                
                                                    $status = $row['status']; 
                                                    $amount =  $row['Topics_amount'];
                                                    $course = $row['Name'];
                                            
                                                    if ($status > 0)
                                                    {
                                                        $color = "#4f4f4e";
                                                    }
                                                    else $color = "black;";
                                                    echo'<div class="row">
                                                            <h6 class ="text-light" style="margin-top:3%; margin-right:auto; margin-left:auto; color:#d1411d; ">'.$course.'</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="progress" style="width:70%; margin:auto;">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'.$status.'" aria-valuemin="0" aria-valuemax="'.$amount.' " style="width: '.($status / $amount)*$d.'%; background-color:#b1de35; color:'.$color.';">';
                                                                    if ($status > 0) echo'<span>'.$status.'/'.$amount.'</span>';
                                                        echo'</div>';
                                                        if ($status == 0) echo'<span style="margin-left:2%; color:#696968;">'.$status.'/'.$amount.'</span>';
                                                            echo'</div>
                                                        </div>';
                                                        
                                                
                                            }
                                            $sql = "Select courses_assignments.ID, uzytkownicy.login,   courses_repo.Name, courses_repo.Topics_amount, COUNT(course_content.status) as status from courses_assignments
                                            JOIN uzytkownicy on uzytkownicy.ID = courses_assignments.user_ID
                                            JOIN courses_repo on courses_repo.ID = courses_assignments.course_ID
                                            JOIN course_content on course_content.course_ID = courses_assignments.course_ID
                                            WHERE (courses_assignments.user_ID = course_content.user_ID) and status = 'NO' and login = '".$_SESSION['login']."' GROUP BY courses_assignments.course_ID";


                                            $result = $connect->query($sql);
                                            
                                            $d = 100;

                                            while($row = mysqli_fetch_array($result))
                                            {
                                
                                                $status = $row['status']; 
                                                $amount =  $row['Topics_amount'];
                                                $course = $row['Name'];
                                            
                                                $color = "black;";
                                                if($status == $amount){
                                                echo'<div class="row">
                                                        <h6 class ="text-light" style="margin-top:3%; margin-right:auto; margin-left:auto; color:#d1411d; ">'.$course.'</h6>
                                                    </div>
                                                    <div class="row">
                                                        <div class="progress" style="width:70%; margin:auto;">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="'.$amount.' " style="width: '.(0 / $amount)*$d.'%; background-color:#b1de35; color:'.$color.';">';
                                                            
                                                        echo'</div>';
                                                        echo'<span style="margin-left:2%; color:#696968;">0/'.$amount.'</span>';
                                                        echo'</div>
                                                    </div>';
                                                }
                    
                    
                                                }
                                                        
                                                
                                            
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 container-fluid" style="margin:auto;  ">
                            <div class="container">                        
                                <div class="card border-0"  style=" background: rgba(134,142,150,0); margin-bottom:1%; "> <!-- WYKRES POKAZUJACY TO W JAKIM KIERUNKU USER SIE ROZWIJA -->
                                    <?php
                                        $server='localhost';
                                        $user='root';
                                        $password='P@rtyboy1.';
                                        $baza='labdatabase';
                                        $connect = mysqli_connect($server, $user, $password, $baza);
                                        $sql = "SELECT Name FROM courses_repo";
                                        $finished = array();
                                        $i = 0;
                                        $result = $connect->query($sql);
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $finished[$i] = (string)$row[0];
                                            $i = $i + 1;   
                                        }

                                        $finishedvalues = array();
                                        foreach ($finished as $finish) 
                                        {
                                        $finishedvalues[$finish] = 0;
                                        }

                                        $sql = "Select uzytkownicy.login,   courses_repo.Name, courses_repo.Topics_amount, COUNT(course_content.status) as status from courses_assignments
                                                    JOIN uzytkownicy on uzytkownicy.ID = courses_assignments.user_ID
                                                    JOIN courses_repo on courses_repo.ID = courses_assignments.course_ID
                                                    JOIN course_content on course_content.course_ID = courses_assignments.course_ID
                                                    WHERE  (courses_assignments.user_ID = course_content.user_ID) and status = 'yes' and login = '".$_SESSION['login']."' GROUP BY courses_assignments.course_ID";

                                        $result = $connect->query($sql);
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $finishedvalues[$row[1]] = (int)$row[3];
                                        
                                        }
                                    ?>
                                    <div class="card-body" style="padding-bottom:8%; padding-top:5%;">
                                        <script>
                                    
                                            $(document).ready(function() {
                                                var ctx = $("#chart-line");
                                                var myLineChart = new Chart(ctx, 
                                                {
                                                    type: 'radar',
                                                    data:
                                                    {
                                                
                                                    labels: <?=json_encode($finished);?>,
                                                
                                                        datasets: [
                                                    //{ 
                                                            //data: [], //DANE POWINNY BYC ZACIAGANE Z BAZY DANYCH
                                                            //label: "Learning", //LIBRARY DATA SET
                                                            
                                                            //pointBackgroundColor:'#4287f5',
                                                            //backgroundColor: 'rgba(66, 135, 245, .6)',
                                                            //borderColor: 'rgba(66, 135, 245, .6)',
                                                           // borderWidth: 1,
                                                           // fill: true,
                                                            
                                                   // },
                                                    {
                                                            data: <?=json_encode(array_values($finishedvalues));?>, //ZACIAGNIETE Z BAZY DANYCH LABORATORIA
                                                            pointBackgroundColor:'#b1de35',
                                                            label: "Finished Courses", //LAB DATA SET
                                                            borderColor: 'rgba(177, 222, 53, .7)',
                                                            borderWidth: 2,
                                                            fill: true,
                                                            backgroundColor:'rgba(177, 222, 53, .7)',
                                                            
                                                    }]
                                                    },
                                                    options:
                                                    {
                                                        legend:{
                                                            display:true,
                                                            position:'bottom',
                                                            
                                                            labels:
                                                            {
                                                                fontColor:'white',
                                                                boxWidth:10,
                                                                fontSize:20,
                                                                
                                                            },

                                                        },
                                                        title:
                                                        {
                                                            display: false,
                                                            text: 'Title',
                                                        },
                                                        scale:
                                                        {
                                                            gridLines:
                                                            { 
                                                                
                                                                color: 'white',
                                                            
                                                                // borderColor: 'white'
                                                            },
                                                            
                                                            angleLines:
                                                            {
                                                                color: 'white',
                                                            },
                                                            
                                                            ticks:
                                                            {
                                                                beginAtZero: true,
                                                                Min: 0,
                                                                Max: 20,
                                                                stepSize:1,
                                                                display:false,
                                                                fontSize:10,
                                                            },
                                                            
                                                            pointLabels:
                                                            {
                                                                    fontColor:'white',
                                                                    fontSize:11,
                                                            },
                                                        },
                                                    }, //OPTIONS
                                                }); //myLineChart
                                            });
                                        </script>
                                        <div class="row">
                                            <canvas id="chart-line"  class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fixed-bottom container-fluid" style="margin:auto;">
                <?php 
                    require_once("footer.php"); 
                ?>
            </div>
        </div>  
	</body>
</html>