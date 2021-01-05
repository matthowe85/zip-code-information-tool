<?php 
// GETTING ZIPCODE INFORMATION
// Only 10 requests per hour for this free api
if ($_POST){
	
	$zip = $_POST['zipcode'];

	$key = 'KAc5HYgQYLBsrySqHNP9TDlyzmLkAKI7rejrEcMzF4hYjDxXq92wVevLhI89Tprc';
	$url = "https://www.zipcodeapi.com/rest/$key/info.json/$zip/degrees";
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_TIMEOUT, 5);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$data = curl_exec($ch);
	curl_close($ch);
	$location = json_decode($data , true);    


	$lon = $location['lng'];
	$lon = preg_replace('/[a-zA-Z()]/','',$lon);
	$lat = $location['lat'];
	$lat = preg_replace('/[a-zA-Z()]/','',$lat);
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Zipcode Information Finder</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container space">
	<h1>Zipcode Information Finder</h1>
	<p class="space-sm">Enter Zipcode:</p>
	<form class="space-sm" method="post">
		<input type="text" class="form-control" class="space-sm" id="zipcode" name="zipcode" maxlength = "5">
		<button type='submit' class="btn btn-primary space-sm">Search</button>
	</form>
	<?php if ($_POST) { ?>
		<a href="/">Back</a>
		<div class="info space">
		<h2 class="welcome">Welcome to <?php echo $location['city'] . ", " . $location['state'] . "!"?></h2>
		<table class="space">
			<tr>
				<td><div class="title">City:</div><?php echo $location['city'];?></td>
				<td><div class="title">State:</div><?php echo $location['state'];?></td>
			</tr>
			<tr>
				<td><div class="title">Coordinates: </div><?php echo $lon . " Longtitide"?></br><?php echo $lat . " Lattitude";?></td>
				<td><div class="title">Timezone: </div><?php echo $location["timezone"]['timezone_abbr'];?></td>
			</tr>
			<tr>
				<td><div class="title">Area Code: </div><?php echo $location['area_codes'][0];?></td>
				<td><div class="title"><a href="https://www.zillow.com/homes/<?php echo $zip?>/">Search Homes on Zillow</a></div></td>
			</tr>
		</table>
		<div class="map space">
			<div style="width: 100%"><iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=<?php echo $zip.','.$location['state'];?>+(My%20Business%20Name)&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
		</div>
	</div>
	<?php } ?>
	<footer class="space">
		<p>Matthew Howe <?php echo date('Y');?></p>
	</footer>
	</div>
</body>
</html>