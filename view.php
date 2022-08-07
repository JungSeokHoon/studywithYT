<!-- dababase 연결확인-->
<?php
	require_once("dbconfig.php");
?>
<!-- 동영상 제목, videoID, 게시일-->
<?php
$viewid = $_GET['viewid'];
$videoid = NULL;
$title = NULL;
$date = NULL;

$sql = 'select * from board where viewid='.$viewid;
$result = $db->query($sql);
$row = $result->fetch_assoc();

$videoid=$row['videoid'];
$title=$row['title'];
$date=$row['date'];
?>

<?php
$subid_list = [];
$time_list = [];
$sub_list = [];
$note_list = [];

$sql = 'select * from subtitle where viewid='.$viewid;
$result = $db->query($sql);
while($row = $result->fetch_assoc()){
    array_push($subid_list,$row['subid']);
    array_push($time_list,$row['time']);
    array_push($sub_list,$row['sub']);
    array_push($note_list,$row['note']);
}
$len=(int)(count($subid_list));
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
    <!--container-->
    <div class="main">
        <div class="container" style="width: 100%">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="YTplayer container" style="width: 100%; max-height:95vh;">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12">
                                <!--youtube player-->
                                <div id="player"></div>
                                <script>
                                    // 2. This code loads the IFrame Player API code asynchronously.
                                    var tag = document.createElement('script');

                                    tag.src = "https://www.youtube.com/iframe_api";
                                    var firstScriptTag = document.getElementsByTagName('script')[0];
                                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                                    // 3. This function creates an <iframe> (and YouTube player)
                                    //    after the API code downloads.
                                    var player;
                                    function onYouTubeIframeAPIReady() {
                                    player = new YT.Player('player', {
                                        height: '900px',
                                        width: '100%',
                                        videoId: '<?php echo $videoid; ?>',
                                    });
                                    }

                                    // 4. The API will call this function when the video player is ready.
                                    function onPlayerReady(event) {
                                    event.target.playVideo();
                                    }

                                    // 5. The API calls this function when the player's state changes.
                                    //    The function indicates that when playing a video (state=1),
                                    //    the player should play for six seconds and then stop.
                                    var done = false;
                                    function onPlayerStateChange(event) {
                                    if (event.data == YT.PlayerState.PLAYING && !done) {
                                        setTimeout(stopVideo, 6000);
                                        done = true;
                                    }
                                    }
                                    function stopVideo() {
                                    player.stopVideo();
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <!--table header-->
                    <div class="tittle-header">
                        <div class="row">
                            <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                                <button type="button" id="sqlsave" class="btn btn-default">save</button>
                            </div>
                            <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                                <button type="button" id="filesave" class="btn btn-default">excel_save</button>
                            </div>
                            <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                                <button type="button" id="fileload" onclick="openCSVFile();" class="btn btn-default">excel_load</button>
                            </div>
                        </div>    
                    </div>
                    <!--table-->
                    <div class="subtable container" style="width: 100%; max-height:80vh; overflow-x:hidden; overflow-y:auto;">
                        <?php
                        $i = 0;
                        while($i < $len){
                        ?>
                        <div class="tab">
                            <div class="row">
                                <div class="col-1 col-xs-2 col-sm-1 col-md-1">
                                    <button
                                        type="button"
                                        name="timeline_button" class="btn btn-default no-padding">time</button>
                                </div>
                                <div class="col-1 col-xs-2 col-sm-1 col-md-1">
                                    <textarea type="text" name="str_timeline[]" class="no-padding text-center"><?php echo $time_list[$i];?></textarea>
                                </div>
                                <div class="col-1 col-xs-2 col-sm-1 col-md-1">
                                    <button
                                        type="button"
                                        name="subtittle_button"
                                        class="btn btn-default no-padding">sub</button>
                                </div>
                                <div class="col-9 col-xs-6 col-sm-9 col-md-9">
                                    <textarea name="subtittle[]" class="no-padding"><?php echo $sub_list[$i];?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1 col-xs-2 col-sm-1 col-md-1">
                                    <button
                                        type="button"
                                        name="note_button"
                                        class="btn btn-default no-padding">note</button>
                                </div>
                                <div class="col-9 col-xs-8 col-sm-9 col-md-9">
                                    <textarea name="note[]" style="white-space:pre-line;" class="no-padding"><?php echo $note_list[$i];?></textarea>
                                </div>
                                <div class="col-1 col-xs-1 col-sm-1 col-md-1">
                                    <button
                                        type="button"
                                        name="add_button"
                                        class="btn btn-default no-padding">+</button>
                                </div>
                                <div class="col-1 col-xs-1 col-sm-1 col-md-1">
                                    <button
                                        type="button"
                                        name="del_button"
                                        class="btn btn-default no-padding">-</button>
                                </div>
                            </div>
                        </div>
                        <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12">
                            <button type="button" class="btn btn-default" onclick="window.location.href='board.php'">back to board</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
        // 영상, 자막 가져오기
        var table_reset = function(){
            // reset the table
            $('textarea[name="str_timeline[]"]').val("");
            $('textarea[name="subtittle[]"]').val("");
            $('textarea[name="note[]"]').val("");
            $('.tab').each(function(index){$
                if(index){$(this).remove();}
            });
        }

        // 타임라인 이동
        $(document).on('click','button[name="timeline_button"]',function(){
			var timeline = $(this)[0].parentElement.parentElement.parentElement.querySelector('textarea').value;
            player.seekTo(get_time(timeline));
        });
        // 타임 얻기
        function get_time(timeline) {
            var secArray = timeline.split(':');
            if (secArray.length == 2) {
                return 60 * parseInt(secArray[0]) + parseInt(secArray[1]);
            }
            if(secArray.length == 3) {
                return 60 * 60 * parseInt(secArray[0]) + 60 * parseInt(secArray[1]) + parseInt(secArray[2]);
            }
        }
		// 타임라인 얻기
        function get_timeline(time){
			var sec = "" + parseInt(time%60);
			var min = "" + parseInt((time - parseInt(time/3600)*3600)/60);
			var hour = "" + parseInt(time/3600);
			sec = ('00' + sec).slice(-2);
            if (time < 60) {
                return "00:" + sec;
            }
            else if(time < 60*60) {
                return "" + min + ":" + sec;
            }
			else{
				min = ('00' + min).slice(-2);
				return "" + hour + ":" + min + ":" + sec;
			}
        }

        // 문자열 \n 변형
        function addslashes(string) {
            return string
                .replace(/\n/g, '\\n')
				.replace(',', '\\d')
        }
        function removeslashes(string) {
            return string
                .replace(/\\n/g, '\n')
				.replace(/\\d/g, ',')
        }

        // 파일 저장, 불러오기
        $("#filesave").click(function () {
            let filename = "<?php echo $title?>.csv";
            getCSV(filename);
        });
        function getCSV(filename) {
            var csv = [];
            var row = [];

            //1열에는 컬럼명
            row.push("no", "timeline", "subtittle", "text", "<?php echo $videoid?>");

            csv.push(row.join(","));

            var id_list = [];
            for (let i = 1; i <= document.getElementsByName("str_timeline[]").length; ++i) {
                id_list.push(i);
            }
            var timeline_list = document.getElementsByName("str_timeline[]");
            var subtittle_list = document.getElementsByName("subtittle[]");
            var note_list = document.getElementsByName("note[]");

            for(var i=0; i<id_list.length; i++){
                if(!timeline_list[i].value && !subtittle_list[i].value && !note_list[i].value) continue;
                else{
                    row = [id_list[i], timeline_list[i].value, addslashes(subtittle_list[i].value),addslashes(note_list[i].value)];
                    csv.push(row.join(","));
                }
            }
            downloadCSV(csv.join("\n"), filename);
        }
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            //한글 처리를 해주기 위해 BOM 추가하기
            const BOM = "\uFEFF";
            csv = BOM + csv;

            csvFile = new Blob([csv], {type: "text/csv"});
            downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window
                .URL
                .createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document
                .body
                .appendChild(downloadLink);
            downloadLink.click();
        }
        function openCSVFile() {
            var input = document.createElement("input");
            input.type = "file";
            input.accept = "text/csv"; // 확장자가 xxx, yyy 일때, ".xxx, .yyy"
            input.onchange = function (event) {
                processFile(event.target.files[0]);
            };
            input.click();
        }
        function processFile(file){
            var reader = new FileReader();
            reader.onload = function () {
                table_reset();
                //load subtittle & timeline
                var list = reader.result.split('\n');
                list.forEach(function(item, index){
                    // get videoId
                    if(index==0){
                        var link = item.split(',')[4];
                        if(link != "<?php echo $videoid?>") {
                            alert("videoID가 일치하지 않습니다.")
                            return false;
                        }
                    }
                    // get table
                    else{
                        var tb_list = item.split(',');
                        $('textarea[name="str_timeline[]"]')[0].value = tb_list[1];
                        $('textarea[name="subtittle[]"]')[0].value = removeslashes(tb_list[2]);
                        $('textarea[name="note[]"]')[0].value = removeslashes(tb_list[3]);
                        document.querySelector('.subtable').append(document.querySelector('.tab').cloneNode(true));
                    }
                });
                $('.tab')[0].remove();
            }
            reader.readAsText(file,"euc-kr");
        }   
        // 자막 편집 기능
        // 자막 추가
        $(document).on('click','button[name="add_button"]',function(e){
                var sub = $(this).parent().parent().parent();
                sub.after(sub.clone());
            });
        // 자막 삭제
        $(document).on('click','button[name="del_button"]', function(e){
            if($('.tab').length > 1){
                var sub = $(this).parent().parent().parent();
                sub.remove();
            }
        });
        // sub 버튼 누르면 시간 자동 추가
           $(document).on('click','button[name="subtittle_button"]',function(e){
                var sub = $(this).parent().parent().parent()[0];
                sub.querySelector('[name="str_timeline[]"]').value = get_timeline(player.getCurrentTime());
            });

		var prev_playtime = 0;
		var new_playtime, focus, active;

		var autoPlay = function(){
            // 동영상이 재생 중 일 때
			new_playtime = parseInt(player.getCurrentTime());
            if(prev_playtime != new_playtime){
				//prev_playtime 갱신
				prev_playtime = new_playtime;
				
				// 스크롤 이동 & 색상 표시
				$("textarea[name=\'str_timeline[]\']").each(function (index, item) {
					if(get_time(item.value) == new_playtime){
						if(document.querySelectorAll('.active').length > 0){
							active = document.querySelector('.active');
							focus.setAttribute('style', '');
							active.classList.remove('active');
						}
						focus = item.parentElement.parentElement.parentElement;
						focusTime = item.parentElement.parentElement.parentElement.offsetTop;
						document.querySelector(".subtable").scrollTop = focusTime - 200;
						focus.setAttribute('style', 'background-color:#91D7FF;');
						focus.classList.add('active');
					};
				});
            }
        }
		setInterval(function(){autoPlay();},100);

        document.querySelector('#sqlsave').onclick = function(){
            const form = document.createElement('form');
            form.method = "post";
            form.action = "write.php";
            document.body.appendChild(form);

            var viewid = "<?php echo $viewid;?>";
            var timeSTR = "";
            var timelineList = document.querySelectorAll("textarea[name='str_timeline[]']");
            for(var t of timelineList){
                timeSTR += ("#" + encodeURI(t.value));
            }
            var subSTR = "";
            var subList = document.querySelectorAll("textarea[name='subtittle[]']");
            for(var s of subList){
                subSTR += ("#" + encodeURI(s.value));
            }
            var noteSTR = "";
            var noteList = document.querySelectorAll("textarea[name='note[]']");
            for(var n of noteList){
                noteSTR += ("#" + encodeURI(n.value));
            }

            const viewidinput = document.createElement('input');
            viewidinput.type = 'hidden';
            viewidinput.name = "viewid";
            viewidinput.value = viewid;
            form.appendChild(viewidinput);

            const timeinput = document.createElement('input');
            timeinput.type = 'hidden';
            timeinput.name = "time";
            timeinput.value = timeSTR;
            form.appendChild(timeinput);

            const subinput = document.createElement('input');
            subinput.type = 'hidden';
            subinput.name = "sub";
            subinput.value = subSTR;
            form.appendChild(subinput);

            const noteinput = document.createElement('input');
            noteinput.type = 'hidden';
            noteinput.name = "note";
            noteinput.value = noteSTR;
            form.appendChild(noteinput);

            form.submit();
        }
    </script>
  </body>
</html>

