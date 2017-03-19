<?php
	require "conn/conn.php";
	$stmt = $pdo ->prepare("select invoice_id from invoice ");
	$stmt ->execute();
	$rows = $stmt ->fetchALL(PDO::FETCH_ASSOC);
	for ($i=0; $i < @count($rows); $i++) { 
		$invoice_id["id"][] =$rows["$i"]["invoice_id"];
	}
	if(isset($_POST["submit"])){
		// in_array(value,arrname，type) 判断数组中是否有某值
		if ( in_array($_POST["Invoice_id"],$invoice_id["id"]) ){
				echo "<script>alert('快递单号已存在！');location.href='index.php?lmbs=发货单';</script>";
			
		}else{
			$stmt = $pdo ->prepare("insert into invoice(id,invoice_id,send_name,send_number,send_address,pay,goods_desc,received_name,received_phone,received_address,deal,instructe)
				value('','$_POST[Invoice_id]','$_POST[Consignor]','$_POST[Con_telephone]','$_POST[Shiping_address]','$_POST[Pay_method]','$_POST[Goods_desc]','$_POST[Consignee]','$_POST[Consignee_phone]',
					'$_POST[Receipt_address]','未处理','$_POST[explain]')");
			$pdo ->query("set names utf8;");
			$stmt ->execute();
			if($stmt->rowcount() >0){
				echo "<script>alert('提交成功！');</script>";
				}else{
				echo "<script>alert('提交失败！');location.href='index.php?lmbs=发货单';</script>";
			}
		}
		
	 }
	 //修改车源信息
	if(isset($_POST["Car_number"])){
		$time =date('Y-m-d H:i:s');
		$stmt =$pdo ->prepare("update car set invoice_id='$_POST[Invoice_id]',car_log='$time',car_isuse='使用中' where car_number='$_POST[Car_number]'");
		$pdo ->query("set names utf8;");
		$stmt ->execute(); 
	}
?>
<form action="" method="post">
	<table border="1" cellspacing="0" style="width:706px;margin-top:20px;text-align:center;">	
		<tr>
			<td style="width:100px;height:40px">发货单编号：</td>
			<td style="width:150px;"><input type="text" name="Invoice_id" style="width:148px;"></td>
			<td style="width:220x;">车牌号码：<input type="text" name="Car_number" style="width:149px;"></td>
			<td style="width:220px">车主电话：<input type="text" nmae="Driver_telephone" style="width:143px;"></td>
		</tr>
		<tr>
			<td style="height:40px;">发货人:</td>
			<td><input type="text" name="Consignor" style="width:148px;"></td>
			<td>发货人电话：<input type="text" name="Con_telephone" style="width:134px;"></td>
			<td>
				付款方式：
				<select name="Pay_method" style="width:143px;">
					<option value="收货人付款">收货人付款</option>
					<option value="发货人付款">发货人付款</option>
					<option value="第三方付款">第三方付款</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>货物描述：</td>
			<td colspan="3"><textarea name="Goods_desc" id="" cols="30" rows="10" style="width: 598px; height: 50px;"></textarea></td>
		</tr>
		<tr>
			<td>发货地址：</td>
			<td colspan="3"><textarea name="Shiping_address" id="" cols="30" rows="10" style="width: 598px; height: 50px;"></textarea></td>
		</tr>
		<tr>
			<td style="height:40px;">收货人：</td>
			<td><input type="text" name="Consignee" style="width:148px;"></td>
			<td colspan="2">收货人电话：<input type="text" name="Consignee_phone" style="width:150px;"></td>
		</tr>		
		<tr>
			<td>收货地址：</td>
			<td colspan="3"><textarea type="text" name="Receipt_address" style="width: 598px; height: 50px;"></textarea></td>
		</tr>
		<tr>
			<td>说明：</td>
			<td colspan="3"><textarea type ="text" name="explain" id="" cols="30" rows="10" style="width: 598px; height: 50px;"></textarea></td>
		</tr>	
	</table>
	<input type="submit" value="提交" name="submit" style="width:60px;margin:15px 30px 0 200px;">
	<input type="reset" value="重置" style="width:60px; margin-right:30px;">
	<img src="images/dl_033.gif" alt="打印">
</form>