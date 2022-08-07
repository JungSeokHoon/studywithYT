<!DOCTYPE html>
<html>
  <head>
    <title>Study with Youtube</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/viewwrite_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12">
                <h3>동영상 추가</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-2 col-xs-2 col-sm-2 col-md-2">
                <button type="button" class="btn btn-default no-padding">videoID</button>
            </div>
            <div class="col-2 col-xs-2 col-sm-2 col-md-2">
                <textarea type="text" class="no-padding text-center" style="padding:1% 0; width:100%;"></textarea>
            </div>
            <div class="col-2 col-xs-2 col-sm-2 col-md-2">
                <button type="button" class="btn btn-default no-padding">title</button>
            </div>
            <div class="col-6 col-xs-6 col-sm-6 col-md-6">
                <textarea type="text" class="no-padding text-center" style="padding:1% 0; width:100%;"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-2 col-xs-2 col-sm-2 col-md-2">
                <button name="script" type="button" class="btn btn-default no-padding" style="height:30px;">스크립트 추가</button>
            </div>
            <div class="col-2 col-xs-2 col-sm-2 col-md-2">
                <button name="nomal" type="button" class="btn btn-default no-padding" style="height:30px;">일반 추가</button>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('button[name="script"]').onclick = function(){
            var videoID = document.querySelectorAll('textarea')[0].value;
            var title = document.querySelectorAll('textarea')[1].value;
            if(videoID) window.location.href = "write.php?type=1&videoid="+videoID+"&title="+title;
            else alert("url을 입력해주세요.");
        }
        document.querySelector('button[name="nomal"]').onclick = function(){
            var videoID = document.querySelectorAll('textarea')[0].value;
            var title = document.querySelectorAll('textarea')[1].value;
            if(videoID) window.location.href = "write.php?type=0&videoid="+videoID+"&title="+title;
            else alert("url을 입력해주세요.");
        }
    </script>
  </body>
</html>

