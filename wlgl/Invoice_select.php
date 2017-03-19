<?php
	require "conn/conn.php";
	//session_start('');
	if(isset($_POST["sub"])){
			$stmt = $pdo->prepare("select invoice_id from invoice");
			$stmt ->execute();
			$rows = $stmt ->fetchALL(PDO::FETCH_ASSOC);
			for ($i=0; $i < @count($rows); $i++) { 
				$invoice_id["id"][] =$rows["$i"]["invoice_id"];
			}
		if( in_array($_POST["select_key"], $invoice_id["id"]) ){
				$stmt = $pdo ->prepare("select * from invoice where invoice_id='$_POST[select_key]'");
				$pdo ->query("set names utf8;");
				$stmt ->execute();
				@list($id,$invoice_id,$send_name,$send_number,$send_address,$pay,$goods_desc,$received_name,$received_phone,$received_address,$deal,$instructe) = $stmt->fetch(PDO::FETCH_NUM);
				$_SESSION["id"] = $id;
				
				$stmt =$pdo ->prepare("select car_number,car_phone from car where invoice_id='$_POST[select_key]'");
				$pdo ->query("set names utf8;");
				$stmt ->execute();
				@list($car_number,$car_phone) =$stmt ->fetch(PDO::FETCH_NUM);	
				$_SESSION["car_number"] =$car_number;
				
				}else{
					echo "<script>alert('发货单号不存在!');location.href='index.php?lmbs=发货单查询'</script>";
				}
	}

	if (isset($_POST["delete"])) {
			$stmt = $pdo ->prepare("update car set invoice_id=' ',car_isuse='未使用' where car_number='$_SESSION[car_number]'");
			$pdo ->query("set names utf8;");
			$stmt ->execute();
			$stmt = $pdo ->prepare("delete from invoice where id='$_SESSION[id]'");
			$stmt->execute();
			if($stmt ->rowcount() >0){
				echo "<script>alert('删除成功！');</script>";
			}else{
				echo "<script>alert('删除失败！');</script>";
			}
	}
	//session_destroy();
?>
<form action="" method="post">
	发货单查询：
	<select name="select" >
		<option value="发货单号" >发货单号</option>			
	</select>
	<input type="text" name="select_key" style="width:100px;">
	<input type="submit" name="sub"value="提交">
</form>
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
		<input type="submit" value="删除发货单" name="delete" style="width:100px;margin:15px 30px 0 200px;">
	</form>