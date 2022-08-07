<?php
    //dababase 연결확인
	require_once("dbconfig.php");
?>
<?php
$viewid_list = [];
$videoid_list = [];
$title_list = [];
$date_list = [];

$sql = 'select * from board';
$result = $db->query($sql);
while($row = $result->fetch_assoc()){
    array_push($viewid_list,$row['viewid']);
    array_push($videoid_list,$row['videoid']);
    array_push($title_list,$row['title']);
    array_push($date_list,$row['date']);
}
$len=(int)(count($viewid_list));
$num=0;
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Study with Youtube</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/view_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  </head>
  <body>
    <div class="header">
        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12" style="text-align: center;">
                        <h1>Study with Youtube</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="container">
            <div class="row">      
                <div class="col-12 col-sm-12 col-md-12">
                    <div class="tab-content">
                        <div class="tab-panel">
                            <div class="container" style="width:100%;">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12">
                                        <div class="row">
                                            <?php
                                            $i = 0;
                                            while($i < $len){
                                            ?>
                                            <div class="col-6 col-sm-4 col-md-3">
                                                <a href="view.php?viewid=<?php echo $viewid_list[$num]; ?>">
                                                    <div class="container" style="width:100%;">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12">
                                                                <div class="tittle" style="height:40px"><?php echo $title_list[$num]; ?></div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12">
                                                                <img src="https://img.youtube.com/vi/<?php echo $videoid_list[$num]; ?>/mqdefault.jpg" alt="<?php echo $title_list[$num++]; ?> 이미지">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                            $i++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </body>
</html>

