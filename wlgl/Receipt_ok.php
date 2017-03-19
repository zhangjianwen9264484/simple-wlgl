<?php
	header("Content-type:text/html;charset=utf8");
	require "conn/conn.php";
	session_start();
	if (isset($_POST["Invoice_id"])) {
		$stmt = $pdo->prepare("select invoice_id from invoice");
		$stmt ->execute();
		$rows =$stmt ->fetchALL(PDO::FETCH_ASSOC);
		for ($i=0; $i < @count($rows); $i++) { 
			$invoice_id["id"][] =$rows["$i"]["invoice_id"];
		}

		if(in_array($_POST["Invoice_id"], $invoice_id["id"]) ){
			$_SESSION["In_id"] = $_POST["Invoice_id"];
			$stmt = $pdo ->prepare("select * from invoice where invoice_id='$_POST[Invoice_id]'");
			$pdo ->query("set names utf8;");
			$stmt ->execute();
			@list($id,$invoice_id,$send_name,$send_number,$send_address,$pay,$goods_desc,$received_name,$received_phone,$received_address,$deal,$instructe) = $stmt->fetch(PDO::FETCH_NUM);
			
			$stmt =$pdo ->prepare("select car_number,car_phone from car where invoice_id='$_POST[Invoice_id]'");
			$pdo ->query("set names utf8;");
			$stmt ->execute();
			@list($car_number,$car_phone) =$stmt ->fetch(PDO::FETCH_NUM);	
		}else{
			echo "<script>alert('发货单号不存在!');location.href='index.php?lmbs=回执发货确认'</script>";
		}
	}

	if(isset($_POST["Receipt_ok"])){
		@$stmt = $pdo ->prepare("update invoice set deal ='已处理' where invoice_id='$_SESSION[In_id]'");
		$pdo ->query("set names utf8;");
		$stmt ->execute();
		if($stmt->rowcount() >0){
			echo "<script>alert('确认成功！');</script>";
		}else{
			echo "<script>alert('确认失败！')</script>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>物流配送信息网</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="body">
		<div class="header">
			<div class="login">
				<input type="button" value="加入收藏" class="button">
				<input type="button" value="退出登录" class="button">
			</div>
			<div class="flash"></div>
		</div>
		<div class="conter">
			<div class="left">
				<ul>
					<li style="margin-top:30px;"><a href="index.php?lmbs=车源信息查询">车源信息查询</a></li>
					<li><a href="index.php?lmbs=发货单">发货单</a></li>
					<li><a href="index.php?lmbs=回执发货确认">回执发货单确认</a></li>
					<li><a href="index.php?lmbs=发货单查询">发货单查询</a></li>
					<li><a href="index.php?lmbs=客户信息管理">客户信息管理</a></li>
					<li><a href="index.php?lmbs=车源信息管理">车源信息管理</a></li>
					<li><a href="index.php?lmbs=修改密码">修改密码</a></li>
				</ul>
			</div>
			<div class="right">
				<?php
				@$lmbs=$_GET["lmbs"];
					switch ($lmbs) {
						case "车源信息查询":
							include "car_select.php";
							break;
						case "发货单":
							include "Invoice_add.php";
						 	break;
						case '回执发货确认':
							include "Receipt_management.php";
							break;
						case '发货单查询':
							include "Invoice_select.php";
							break;
						// case '客户信息管理';
						// 	include "";
						// 	break;
						// case '车源信息管理'
						// 	include "";
						// 	break;
						// case '修改密码'
						// 	include "";
						// 	break;
						default:
							//include "car_select.php";
							break;
					}				
				?>
				<table border="1" cellspacing="0" style="width:706px;text-align:center;">	
					<tr>
						<td style="width:100px;height:40px">发货单编号：</td>
						<td style="width:150px;"><input type="text" name="Invoice_id" value="<?php echo @$invoice_id;?>" style="width:148px;"></td>
						<td style="width:220x;">车牌号码：<input type="text" name="Car_number" value="<?php echo @$car_number; ?>"style="width:149px;"></td>
						<td style="width:220px">车主电话：<input type="text" nmae="Driver_telephone" value="<?php echo @$car_phone; ?> "style="width:143px;"></td>
					</tr>
					<tr>
						<td style="height:40px;">发货人:</td>
						<td><input type="text" name="Consignor" value="<?php echo @$send_name; ?>" style="width:148px;"></td>
						<td>发货人电话：<input type="text" name="Con_telephone" value="<?php echo @$send_number; ?>" style="width:134px;"></td>
						<td>
							付款方式：
							<select name="Pay_method" style="width:143px;">
								<option value="value='<?php echo @$pay; ?>'">货到付款</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>货物描述：</td>
						<td colspan="3"><textarea name="Goods_intruduce" id="" cols="30" rows="10" style="width: 598px; height: 50px;"><?php echo @$goods_desc; ?></textarea></td>
					</tr>
					<tr>
						<td>发货地址：</td>
						<td colspan="3"><textarea name="Shiping_address" id="" cols="30" rows="10" style="width: 598px; height: 50px;"><?php echo @$send_address; ?></textarea></td>
					</tr>
					<tr>
						<td style="height:40px;">收货人：</td>
						<td><input type="text" name="Consignee" value="<?php echo @$received_name; ?>" style="width:148px;"></td>
						<td colspan="2">收货人电话：<input type="text" name="Consignee_phone" value="<?php echo @$received_phone; ?>"style="width:150px;"></td>
					</tr>		
					<tr>
						<td>收货地址：</td>
						<td colspan="3"><textarea type="text" name="Receipt_address"  style="width: 598px; height: 50px;"><?php echo @$received_address; ?></textarea></td>
					</tr>
					<tr>
						<td>发货单处理：</td>
						<td><?php echo @$deal; ?></td>
					</tr>
					<tr>
						<td>说明：</td>
						<td colspan="3"><textarea name="explain" id="" cols="30" rows="10" style="width: 598px; height: 50px;"><?php echo @$instructe; ?></textarea></td>
					</tr>	
				</table>
				<form action="" method="post">
					<input type="submit" value="回执发货单确认" name="Receipt_ok" style="width:125px;margin:15px 30px 0 200px;">
				</form>
			</div>
		</div>
		<div class="footer"></div>
	</div>
</body>
</html>