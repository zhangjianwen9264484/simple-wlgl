<?php
	require "conn/conn.php";
	if(isset($_POST["submit"])){
		if ( strlen($_POST["customer_name"]) !== 0 ){
			
			$stmt = $pdo ->prepare("insert into customer(id,name,phone,address) values ('','$_POST[customer_name]','$_POST[telephone]','$_POST[address]')");
			$pdo -> query("set names utf8;");
			$stmt ->execute();
				if($stmt ->rowcount() >0 ) {
					echo "<script>alert('提交成功！');</script>";

				 }else{
					echo "<script> alert('提交失败！');</script>";
				}
		}else{
			echo "<script>alert('用户名不能为空，请重试！');</script>";
		}
	}
	
?>
<table cellspacing="0" border="1" style="width:705px">
	<form action="" method="post">
		<tr>
			<td colspan="2" style="width:300px;text-align:center;">客户信息管理</td>
		</tr>
		<tr>
			<td>客户姓名：</td>
			<td><input type="text" name="customer_name"></td>
		</tr>
		<tr>
			<td>电话：</td>
			<td><input type="text" name="telephone">
			</td>
		</tr>
		<tr>
			<td>联系地址：</td>
			<td><textarea name="address"cols="30" rows="10" style="width: 220px; height: 40px;"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="提交"></td>
		</tr>
</table>
<table cellspacing="0" border="1" style="width:705px;margin-top:30px; text-algin:center;">
	<tr>
		<th>客户姓名</th>
		<th>电话</th>
		<th>联系地址</th>
		<th>操作</th>
	</tr>
	<?php
		$stmt = $pdo ->prepare("select * from customer id limit 0,10");
		$pdo ->query("set names utf8;");
		$stmt -> execute();
		$rows= $stmt ->fetchALL(PDO::FETCH_ASSOC); 
		for($i=0; $i < count($rows); $i++){
			$id = $rows["$i"]['id'];
			echo "<tr>";
				echo "<td>".@$rows["$i"]['name']."</td>";
				echo "<td>".@$rows["$i"]['phone']."</td>";
				echo "<td>".@$rows["$i"]['address']."</td>";
				echo '<td>';
				echo "<a href='delete.php?id=$id'>删除</a>";
				echo '</td>';
			echo "</tr>";
		}
		//session_destroy();
	?>
	</form>
</table>