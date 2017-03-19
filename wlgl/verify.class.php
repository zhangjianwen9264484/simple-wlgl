<?php
	class Vcode{
		private $width;
		private $height;
		private $num;
		private $img;

		function __construct($width=80,$height=20,$num=4){
			$this->width = $width;
			$this->height = $height;
			$this->num  = $num;
		}
		function outimg(){
			$this->code="";
			$str ="ABCEDFGHJKLNQRTY";
			for($i=0; $i<$this->num; $i++){
				$this->code .= $str{rand(0,strlen($str)-1)};
			} 
			$this->img = imagecreatetruecolor($this->width, $this->height);
			$bg = imagecolorallocate($this->img, rand(225,255), rand(225,255), rand(225,255));
			imagefill($this->img, 0, 0, $bg);

			$bordercolor = imagecolorallocate($this->img, 0, 0, 0);
			imagerectangle($this->img, 0, 0, $this->width-1, $this->height-1, $bordercolor);

			//输出字符
			for($i=0; $i<$this->num; $i++){
				$textcolor = imagecolorallocate($this->img, rand(0,128), rand(0,128), rand(0,128));
				$x = 5 +($this->width/$this->num)*$i;
				$y = rand(0,$this->height-20);
				//imagestring($this->img, rand(4,6), rand(0,40), rand(0,10), $this->code, $textcolor);
				imagechar($this->img, 20, $x, $y, $this->code{$i}, $textcolor);
			}
			//画点
			for($i=0;$i<50;$i++){
				$color =imagecolorallocate($this->img, rand(0,255), rand(0,255), rand(0,255));
				imagesetpixel($this->img, rand(1,$this->width-1), rand(1,$this->height-1), $color);
			}
			//画线
			for($i=0; $i<5; $i++){
				$color = imagecolorallocate($this->img, rand(0,255), rand(0,255), rand(0,255));
				imagearc($this->img, rand(0,$this->width), rand(0,$this->height), rand(30,100), rand(30,100), 20, 10, $color);
			}


			if( function_exists ( 'imagegif' )){
			     // 针对 GIF
			     header ( 'Content-Type: image/gif' );

			     imagegif ( $this->img );
			}elseif( function_exists ( 'imagejpeg' )){
			     // 针对 JPEG
			     header ( 'Content-Type: image/jpeg' );

			     imagejpeg ( $this->img );
			}elseif( function_exists ( 'imagepng' )){
			     // 针对 PNG
			     header ( 'Content-Type: image/png' );

			     imagepng ( $this->img );
			}elseif( function_exists ( 'imagewbmp' )){
			     // 针对 WBMP
			     header ( 'Content-Type: image/vnd.wap.wbmp' );

			     imagewbmp ( $this->img );
			}else{
			    die( 'No image support in this PHP server' );
			    imagedestroy($img);
			}
			session_start();
			$_SESSION["codes"] =$this->code;
		}

	}
?>