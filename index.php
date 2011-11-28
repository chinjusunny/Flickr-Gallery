<?php
$api_key= "95462f70bd2e57c72a093bc74a8b90df";
$api_secret= "7ca92cd8e474e98a";
//$photoset_id ="72157628142873867";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Flickr Gallery </title>
<script type="text/javascript" src="jquery/jquery.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pagination.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/paginate.js"></script>
</head>
<body>
<input type='hidden' id='current_page' />  
<input type='hidden' id='show_per_page' /> 
<div id="wrapper">
<?php include 'includes/header.php';?>
<div id="data">
<FIELDSET class="search_field">
<LEGEND ALIGN=CENTER>Search Images</LEGEND>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" name="search_form">
<table class="search_table">
<tr><td>
<input type="text" size="30" name="keyword" value="<?php echo $_POST['keyword'];?>"/>
</td><td>
<input type="submit" name="search" value="Search" />
</td></tr>
</table>
</form>
</FIELDSET>
<?php
/*http://farm2.static.flickr.com/1023/1153699093_d1fba451c9.jpg */
if(isset($_POST['search'])){
	$keyword=$_POST['keyword'];
		if($keyword==''){
						echo "<font color='#FF0000'>Please enter a search keyword!!!</font>";
		}
	$keyword = str_replace (" ", "", $keyword);
	
	$per_page=5;
	//URL: http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=09fe5c77606ee3f02dc62537b14722df&tags=bird&extras=url_t&per_page=5&page=1&format=json&nojsoncallback=1

	$url = 'http://api.flickr.com/services/rest/?method=flickr.photos.search';
	$url.= '&api_key='.$api_key;
	$url.= '&tags='.$keyword;
	$url.='&extras=url_t';
	//$url.= '&content_type=1';
	//$url.= '&per_page='.$per_page;
	//$url.='&page=1';
	$url.= '&format=json';
	$url.= '&nojsoncallback=1';
	//echo $url;
	$response = json_decode(file_get_contents($url));
	if($response->stat == 'ok'){
	$photos = $response->photos->photo;
	$total_images=$response->photos->total;
	echo "<p align='center'><font color='#FF0000'>Total ".$total_images." images for this keyword</font></p>";
	echo '</br>';
	echo "<p align='center' class='record'><strong>Displaying first 100 images</strong></p>";
	?>
	<div id="content" align="center">
	<?php
			if(count($photos) > 0){

				foreach($photos as $photo){
											$farm_id = $photo->farm;
											$server_id = $photo->server;
											$id = $photo->id;
											$secret = $photo->secret;
											$title = $photo->title;
											$image_thumb = 'http://farm'.$farm_id.'.static.flickr.com/'.$server_id.'/'.$id.'_'.$secret.'_t.jpg';
											$image_large = 'http://farm'.$farm_id.'.static.flickr.com/'.$server_id.'/'.$id.'_'.$secret.'_b.jpg';
											$image= '<a href="'.$image_large.'" target="_blank">';
											$image.= '<img src="'.$image_thumb.'" alt="'.$title.'">';
											$image.= '</a>';
											echo '<table><tr><td>'.$title.'</td></tr><tr><td>'.$image.'</td></tr></table>';
											
											
				}


			}
			else{
				echo "<font color='#FF0000'>No Results</font>";
			}
	}
	else{
		if($response->message!="Parameterless searches have been disabled. Please use flickr.photos.getRecent instead.")
		{echo '<b>Error : </b>'.$response->message;}
	}
?>
</div>
<div id='page_navigation' align="center"></div>  
<?php }//isset of button?>
</div>
<?php include 'includes/footer.php';?>
</div>
</body>
</html>
