<style>
	@import url('https://fonts.googleapis.com/css2?family=Comic+Neue&display=swap');
	*{
		font-family: 'Comic Neue', cursive;
	}
	#id-col{
		
	}
</style>
<p>Crawled from https://linkneverdie.vip/ - using 'simple_html_dom.php'</p>
		<table id="data-table">
			<tr>
				<td id="id-col"><strong>ID</strong></td>
				<td><strong>|</strong></td>
				<td id="title-col"><strong>Title</strong></td>
				<td><strong>|</strong></td>
				<td id="price-col"><strong>Price</strong></td>
			</tr>
			<tr>
				<td id="id-col"><strong>--------</strong></td>
				<td><strong>|</strong></td>
				<td id="title-col"><strong>---------------------------------------------------------------------------</strong></td>
				<td><strong>|</strong></td>
				<td id="price-col-col"><strong>-------------------------</strong></td>
			</tr>
<?php
	include 'simple_html_dom.php';
	for($page = 1;$page<10;$page++){
		$html = file_get_html("https://linkneverdie.vip/?page=$page");
?>
<?php
		for($i = 1;$i<=36;$i++){
			$title = $html->find('.title',$i - 1)->innertext;
			$id = (36 * ($page - 1)) + $i;
			echo "<tr>";
			echo "	<td id='id-col'>$id</td>";
			echo "	<td><strong>|</strong></td>";
			echo "	<td id='title-col'>$title</td>";
			echo "	<td><strong>|</strong></td>";
			$price = number_format(round(rand(100000, 1499000)/1000)*1000, 0, ",", ".");
			echo "	<td id='price-col'>$price VND</td>";
			echo "</tr>
						<tr>
							<td id='id-col'><strong>--------</strong></td>
							<td><strong>|</strong></td>
							<td id='title-col'><strong>---------------------------------------------------------------------------</strong></td>
							<td><strong>|</strong></td>
							<td id='title-col'><strong>-------------------------</strong></td>
						</tr>";
		}
?>
<?php
	}
?>
		</table>