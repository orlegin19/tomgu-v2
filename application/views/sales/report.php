<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
table{
  border-collapse:collapse; width:100%; font-size:14px;margin-top: 10px;
}
 .left{
 float: left;
 }
 td.w-10{
 width: 10%;
 }
 td.w-40{
 width: 40%;
 }
 td.w-100{
 width: 100%;
 }
 td.w-33{
 width: 33%;
 }
 table, td, th
  
 {
  
 border:none;
  
 }
  
 th{ font-weight:normal; text-align:center;
 padding:5px 5px 0px 5px; background-repeat:repeat-x; height:25px;font-size: 16px;font-weight: bold; 
 border:1px solid #000;}
  
 td
  
 {padding:16px 3px 3px 3px;border:1px solid #000; }
  
</style>
<?php 
	
	$sales = $this->db->query("SELECT * FROM sales")
	
?>
<body>
<center><h1>Sales Report</h1></center>
	<table>
		<thead>
			<tr>
            <td class="text-center">#</td>
                        <td class="text-center">Referrence #</td>
                        <td class="text-center">Date</td>
                        <td class="text-center">Amount</td>
						
			</tr>
		</thead>
		<tbody>
			<?php 
			$items = $this->db->query("SELECT * FROM sales ORDER BY `sales`.`ref_id` ASC");
				foreach($items->result_array() as $row):
			?>
			<tr>
				<td><?php echo number_format($row['id']) ?></td>
				<td><?php echo ($row['ref_id'])?></td>
			    <td class="text-right"><?php echo date("M-d-Y") ?></td>
				<td class="text-right"><?php echo number_format($row['total_amount'],2) ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" align="right" class="text-left"><b>Total Sales: &nbsp;</b></td>
				<td class="text-right"><?php echo number_format($row['total_amount'],2) ?></td>
			</tr>
		</tfoot>
	</table>
	<p>Generated by: Tomgu Square</p>
</body>
</html>