<?php
	include "conn/conn.php";
	if(isset($_POST["submit"])){
		$stmt = $pdo ->prepare("select * from car where car_line like'%$_POST[start]——$_POST[end]'");
		$pdo ->query("set names utf8;");
		$stmt -> execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
?>
<table border="1" cellspacing="0" style="width:706px;margin-top:40px;">
	<tr>
		<form action="" method="post" >
			<td colspan="3" style="text-align:right;">
			查询<input type="text" name="start" style="width:100px;">
			至<input type="text" name="end" style="width:100px;"></td>
			<td colspan="2"><input type="submit" name ="submit" value="提交" style="width:40px"></td>
		</form>
	</tr>
	<tr>
		<th>车牌号码</th>
		<th>路线</th>
		<th>车辆描述</th>
		<th>使用日志</th>
		<th>是否使用</th>
	</tr>
	<?php
		for($i=0; $i<count(@$rows); $i++){
			echo "<tr>";
				echo "<td>".@$rows["$i"]['car_number']."</td>";
				echo "<td>".@$rows["$i"]['car_line']. "</td>";
				echo "<td>".@$rows["$i"]['car_desc']. "</td>";
				echo "<td>".@$rows["$i"]['car_log']. "</td>";
				echo "<td>".@$rows["$i"]['car_isuse']."</td>";
			echo "</tr>";
		}
	?>
</table>