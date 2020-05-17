<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta name="referrer" content="no-referrer"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
<title>0x77图床</title>
<link href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://cdn.bootcss.com/jquery/3.4.0/jquery.min.js" type="text/javascript"></script>
<style type="text/css">
      body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
          "Helvetica Neue", Arial, sans-serif;
        background: #333;
      }
      @font-face {
        font-family: webfont_2;
      }
      .text-center {
        text-align: center;
      }
      .text-white {
        color: #fff;
      }
      .footer,
      .header {
        margin: 30px;
        color: #fff;
      }
      .title1 {
        font-size: 20px;
      }
      .title2 {
        font-size: 24px;
        font-family: webfont_2 !important;
      }
      .jumbotron {
        margin: auto;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.3);
      }
      .jumbotron input[type="file"] {
        opacity: 0;
        width: 102px;
        height: 31px;
        position: absolute;
        display: inline-block;
      }
      .preview {
        color: #fff;
      }
      .preview img {
        max-width: 10%;
      }
      .preview p {
        word-break: break-all;
        word-wrap: break-word;
        font-size: 13px !important;
      }
</style>
<?php
// start the session
session_start();

if (isset($_COOKIE['username'])) {
		$_SESSION['username'] = $_COOKIE['username'];
		$_SESSION['islogin'] = 1;
          
	}
	if (isset($_SESSION['islogin'])) {
	        //header('refresh:3; url=https://minibox.tk');
                //header("Location:home.php");
		//echo "您未登录,系统将在3秒后跳转到登录界面,请重新填写登录信息!";
		//exit();
	} else {
		header('refresh:3; url=https://img.0x77.ml');
                echo "您未登录,系统将在3秒后跳转到登录界面,请重新填写登录信息!";
		exit;
	}
	
?>
</head>
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12 header text-center">
			<p class="title2">
				0x77图床
			</p>
		</div>
		<div class="col-md-8 col-xs-10 jumbotron" style="margin: auto;">
			<div class="mselector">
				<input type="file" name="upimage" id="upload_file" accept="image/*"/>
				<button class="btn btn-primary btn-sm" type="button">
              选择本地图片
				</button>
			</div>
			<hr/>
			<div class="textarea_con">
				<textarea class="form-control" id="url-res-txt" style="margin-top: 10px;background-color: #ececec;" rows="3"></textarea>
			</div>
			<div class="preview">
				<hr/>
			</div>
		</div>
		<div class="footer text-center">
			<p style="color: #ececec;">
            仅支持单文件,大小限制5MB,上传完毕后可能需要等待一会儿图片URL才能访问!
			</p>
		</div>
	</div>
</div>
<div tabindex="-1" class="modal fade" id="url_upload_model" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<textarea name="urls" class="form-control" id="urls" rows="8"></textarea>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
      $("input[type='file']").change(function(e) {
        gen_base64();
      });
      function $_(id) {
        return document.getElementById(id);
      }
      function gen_base64() {
        var file = $_("upload_file").files[0];
        if (!/image\/\w+/.test(file.type)) {
          alert("请确保文件为图像类型");
          return false;
        }
        r = new FileReader(); //本地预览
        r.onload = function() {
          let formdata=new FormData; //创建FormData对象,代表文件传输
          formdata.append("pic", file);
          $.ajax({
            type: "post",
            url: "up.php",
            processData:false, //不让指定数据处理方式
            contentType:false, //不让指定传输格式
            dataType: "json",
            data: formdata,
            async: true,
            success: function(res) {
              if (res.code == 'success') {
                $(".container-fluid .row-fluid .textarea_con").html(
                  '<textarea id="url-res-txt" class="form-control" rows="8" style="margin-top: 10px;background-color: #ececec;">' + document.getElementById("url-res-txt").value +
                    res.data.url + "\n" +
                    "</textarea>"
                );
              } else {
                alert("fail");
              }
            },
            error: function(a) {
              alert("失败");
            }
          });
        };
        r.readAsDataURL(file); //Base64
      }
      window.onload = function() {
        if (typeof FileReader === "undefined") {
          alert("抱歉，你的浏览器不支持 FileReader，请使用现代浏览器操作！");
          $_("upload_file").disabled = true;
        }
      };
    </script>
</body>
</html>