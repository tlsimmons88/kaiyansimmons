<?php
$this->load->view('include/DefaultWebPage.class.php');
$webpage = new DefaultWebPage();
$webpage->setActiveNav("Pictures");
$topRightContent = "<div id='fb-root'></div>";
$topRightLink = "";
$html = "";

if($fb_data['userProfile']['id'] > 0)
{
	$topRightContent .= "Welcome ".$fb_data['userProfile']['first_name'];
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='logout/index'>Logout</a>";
}
else
{
	$topRightContent .= "Welcome";
	$topRightContent .= "<br>";
	$topRightContent .= "<a href='".$fb_data['loginUrl']."'>Login</a>";

}
$html .= "<div>
	           <label for='date_taken_from'>From</label>
			   <input type='text' id='date_taken_from' name='date_taken_from'>
			   <label for='date_taken_to'>To</label>
			   <input type='text' id='date_taken_to' name='date_taken_to'>
			   <label for='tags'>Album</label>
			   <input type='text' id='tags' name='tags'>
			   <button type='button' id='submit-btn' onclick='getMedia(1)'>Find Pictures</button>
			   <img src='/images/ajax-loader.gif' id='loading-img' style='display:none;' alt='Please Wait'/>
	      </div><br>";
$html .= "<div id='pictures_gallery'>";

if($error == "")
{
	foreach($media as $picture)
	{
		$html .= "<div class='thumb_container inline'>";
		$html .= "<a class='fancybox' rel='group' href='".base_url($picture['file_location'])."' title='".$picture['file_description']."'>
					<img src='".base_url($picture['thumb_location'])."'>
				  </a>";
		$html .= "</div>";
	}
}
else
{
	$html .= $error;
}

$html .= "</div>";	//End pictures_gallery div
$html .= "<div id='output'></div>";

$webpage->setHeaderRightContent($topRightContent);
$webpage->setHeaderRightLinks($topRightLink);
$webpage->start();
echo $html;
$webpage->end();
?>
