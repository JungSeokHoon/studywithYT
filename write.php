<!-- dababase 연결확인-->
<?php
	require_once("dbconfig.php");
?>
<!-- 동영상 제목, videoID, 게시일-->
<?php
$note = $_POST['note'];
$time = $_POST['time'];
$sub = $_POST['sub'];
$viewid = $_POST['viewid'];

$timelist = explode('#', $time);
$notelist = explode('#', $note);
$sublist = explode('#', $sub);

$sql = "DELETE FROM subtitle WHERE viewid=".$viewid;
if (!mysqli_query($db,$sql))die('Error: ' . mysqli_error($db));

$i = 1;
while($i < count($timelist)){
    $sql = "INSERT INTO subtitle (viewid, time, sub, note) VALUES(".$viewid.", '".urldecode($timelist[$i])."', '".addslashes(urldecode($sublist[$i]))."', '".addslashes(urldecode($notelist[$i]))."')";
    echo $sql."<br>";
    if (!mysqli_query($db,$sql))die('Error: ' . mysqli_error($db));
    $i++;
}
?>