<?php
  if($_FILES["zip"]["error"]>0){
    echo "upload zip file error";
  }else{
    $qpkg_id = time();
    $qpkg_name = pathinfo($_FILES["zip"]["name"], PATHINFO_FILENAME);
    move_uploaded_file($_FILES["zip"]["tmp_name"], '../qpkg/'.$qpkg_id.'.zip');
    passthru('/mnt/ext/opt/apache/bin/php ../bin/build.php ../qpkg/'.$qpkg_id.'.zip ../qpkg/'.$qpkg_id.'.qpkg '.$qpkg_name);//.' > /dev/null &'
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>QPM tools</title>
    <meta name="description" cossntent="">
    <meta name="viewport" content="width=device-width">
    <!--[if lt IE 9]>
    <script src="bower_components/es5-shim/es5-shim.js"></script>
    <script src="bower_components/json3/lib/json3.min.js"></script>
    <![endif]-->
    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <script src="bower_components/jquery/jquery.min.js"></script>
    <!-- <link href="css/qpm.css" rel="stylesheet"> -->
    <script>
      setTimeout(function(){
        $('#button').text('編譯完成，下載QPKG');
        $('#button').addClass('btn btn-default');
        $('#button').on('click',function(){
          window.open('./api/qpkg.php?a=download&qpkg_id=<?php echo $qpkg_id?>&qpkg_name=<?php echo $qpkg_name?>');
        });
      },6000);
    </script>
  </head>
  <body>
    <div class="header">
      <nav class="navbar navbar-default navbar-static-top">
        <div class="container"><a href="#" class="navbar-brand">QPM</a>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Direct build a QPKG</a></li>
            <li class="active"><a href="#">Web interface</a></li>
            <li><a href="#">Executable on cli</a></li>
            <li><a href="#">Background service</a></li>
            <li><a href="#">Advanced</a></li>
          </ul>
        </div>
      </nav>
    </div>
    <div class="container">
      <div class="jumbotron">
        QPKG ID: <?php echo $qpkg_id?><br />
        QPKG NAME: <?php echo $qpkg_name?><br />
        <span id="button">等待編譯中...</button>
      </div>
      <div class="footer">
        <p>&copy; Company 2013</p>
      </div>
    </div>
  </body>
</html>