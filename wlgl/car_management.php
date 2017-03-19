<?php
	include "conn/conn.php";
	//session_start();
	if(isset($_POST["select"])){ 
		$stmt = $pdo -> prepare("select * from car where  car_number='$_POST[car]' ");
		$pdo -> query(" set  names utf8;");
		$stmt-> execute();
		if($stmt->rowcount() > 0){
			@list($id,$user,$car_number,$car_phone,$card_id,$car_desc,$address,$car_line,$car_log,$car_isuse) = $stmt->fetch(PDO::FETCH_NUM);
				@$_SESSION["arg"] = array($id,$user,$car_number,$car_phone,$card_id,$car_desc,$address,$car_line,$car_log,$car_isuse);
				$_SESSION['id'] = $id;
				$_SESSION['card_id'] = $card_id; //要变成全局变量
				
		}else{
			echo "<script>alert('该车没有注册，请注册')</script>";
		}
	}

	if(isset($_POST["submit"])){
			if(@$_POST["card_id"] !== @$_SESSION["card_id"] ){
				$stmt = $pdo ->prepare("insert into car(id,car_user,car_number,car_phone,card_id,car_desc,address,car_line,car_isuse) 
				values ('','$_POST[car_user]','$_POST[car_number]','$_POST[phone]','$_POST[card_id]','$_POST[car_desc]','$_POST[address]','$_POST[car_line]','未使用')");
				$pdo -> query(" set  names utf8;");
				$stmt->execute();
				if($stmt ->rowcount() > 0){
					echo "<script>alert('注册成功')</script>";
				}else{
					echo "<script>alert('注册失败')</script>";
				}
			}else{
				echo "<script>alert('用户已存在')</script>";
		} 
	}

	if (isset($_POST["update"])){
		//表单提交的	
		@$_SESSION["arg1"] = array("$_SESSION[$id]","$_POST[car_user]","$_POST[car_number]","$_POST[phone]","$_POST[card_id]","$_POST[car_desc]",
			"$_POST[address]","$_POST[car_line]","$_POST[$car_log]","$_POST[$car_isuse]");
		
		if(@$_SESSION["arg"] !== $_SESSION["arg1"]){
				$arr = $_SESSION["arg"];
				$arr1 = $_SESSION["arg1"];
					 
				$stmt = $pdo -> prepare("update car set car_user ='$arr1[1]',car_number ='$arr1[2]',car_phone ='$arr1[3]', card_id ='$arr1[4]', car_desc ='$arr1[5]', 
					address ='$arr1[6]', car_line ='$arr1[7]', car_log ='$arr1[8]', car_isuse ='$arr1[9]'  where id= '$arr[0]'");
				
				$pdo -> query("set  names utf8;");
				$stmt ->execute();
				if ($stmt -> rowcount() >0) {
				echo "<script>alert('修改成功')</script>";
				}else{
					 echo "<script>alert('修改失败')</script>";
				}
			}else{
				echo "<script>alert('信息一致，未更改')</script>";
		}
	}

	if(isset($_POST["delete"] )){
		$stmt = $pdo ->prepare("delete from car where id = '$_SESSION[id]'");
		$stmt -> execute();
		if($stmt ->rowcount() >0){
				echo "<script>alert('删除成功！');</script>";	
		}else{
				echo "<script>alert('删除失败，请重试！');</script>";
		}
	}
	//session_destroy();
?>

<table cellspacing="0" border="1">
	<form action="" method="post">
		<tr>
			<td style="width:280px;text-align:right">车源信息管理：</td>
			<td style="width: 200px;text-align:center;"><input type="text" name="car"  value="车牌号"></td>
			<td style="width:200px;"><input type="submit" name="select" value="提交" ></td>
		</tr>
	</form>
</table>
<table cellspacing="0" border="1" style="margin-top:20px;text-align:center;">
	<form action="" method="post">
		<tr>
			<td style="width:125px;">姓名：</td>
			<td><input type="text" name="car_user" value='<?php  echo @$user; ?>'> </td>
			<td style="width:125px;">车牌号码：</td>
			<td><input type="text" name="car_number" style="width:260px;" value='<?php echo @$car_number; ?>'></td>
		</tr>
		<tr>
			<td>身份证号：</td>
			<td><input type="text" name="card_id" value="<?php echo @$card_id; ?>"></td>
			<td rowspan="2">车辆描述：</td>
			<td rowspan="2"><textarea name="car_desc" id="" cols="30" rows="10" style="height:100px;" value=""><?php echo @$car_desc; ?></textarea></td>
		</tr>
		<tr>
			<td>电话：</td> 
			<td><input type="text" name="phone" value="<?php echo @$car_phone; ?>" ></td>
		</tr>
		<tr>
			<td>地址：</td>
			<td><textarea name="address" id="" cols="30" rows="10" style="height:100px;width:160px;" value=""><?php  echo @$address; ?></textarea></td>
			<td>运输路线：</td>
			<td><textarea name="car_line" id="" cols="30" rows="10" style="height:100px;" value=""><?php echo @$car_line; ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit"  name="submit" value="注册" style="float:right;"></td>
			<td><input type="submit" name="update" value="修改"></td>
			<td><input type="submit" name="delete" value="删除" style="float:left;"></td>
		</tr>
	</form>
</table>