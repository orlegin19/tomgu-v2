<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Receipt</title>
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
	$order = $this->db->query("SELECT * FROM orders where id = $id")->row();
	$sales = $this->db->query("SELECT * FROM sales where order_id = $id")->row();
	$queue = $this->db->query("SELECT * FROM queue_list where order_id = $id")->row();
?>
<body>
<center><h1>General Receipt</h1></center>
<table style="width:40%;" align='right'>
<tr>
<td> Date: &nbsp;</td>
<td><span class="editcontent"><?php echo date("M-d-Y") ?></span></td>
</tr>
<tr>
<td>Reference ID: &nbsp;</td>
<td><span class="editcontent"><?php echo $order->ref_id ?></span></td>
</tr>
<tr>
<td> Queue No. &nbsp;</td>
<td><span class="editcontent"><?php echo $queue->queue ?></span></td>
</tr>
</table>
	<p>Tomgu Square</p>
	<p>Address: Poblacion Madridejos Cebu</p>
<br>
<br>
<br>
<br>
	<table>
		<thead>
			<tr>
			    <th class="text-center">#</th>
				<th class="text-left">QTY</th>
				<th class="text-left">Description</th>
				<th class="text-right">Price</th>
				<th class="text-right">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$items = $this->db->query("SELECT o.*,p.name as pname FROM order_list o inner join product p on p.id = o.product_id where o.order_id = $id");
				foreach($items->result_array() as $row):
			?>
			<tr>
			    <td><?php echo number_format($row['id']) ?></td>
				<td><?php echo number_format($row['qty']) ?></td>
				<td><?php echo ($row['pname'])?></td>
			    <td class="text-right"><?php echo number_format($row['price']) ?></td>
				<td class="text-right"><?php echo number_format($row['total_amount'],2) ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" align="right" class="text-left"><b>Total Amount: &nbsp;</b></td>
				<td class="text-right"><?php echo number_format($order->total_amount,2) ?></td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="text-left"><b>Tendered Amount: &nbsp;</b></td>
				<td class="text-right"><?php echo number_format($sales->amount_tendered,2) ?></td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="text-left"><b>Change: &nbsp;</b></td>
				<td class="text-right"><?php echo number_format($sales->amount_tendered - $order->total_amount,2) ?></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>