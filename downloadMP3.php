<?php
include_once("Lib/LIB_parse.php");               # include parse library
include_once("Lib/LIB_http.php");                # include curl library
include_once("Lib/LIB_resolve_addresses.php");   # include address resolution library
include_once("Lib/LIB_download_images.php");   # include address resolution library

/*
 * while next link is not nil
 * read page
 * get MP3 link on the page
 * save file under downloads using page name.MP3 as the name
 * 
 * */
$listOfPages=array();
login();
$currentPage = "http://www.tailopez.com/cp/5/104/433";
$i = 0;
$old = ini_set('memory_limit', -1);
do
{
	$currentPage = get_attribute($listOfPages[$i],  $attribute="href");
	download_Media_for_page($currentPage);
	$i++;
}while ($i<count($listOfPages));

function login()
{
	global  $listOfPages;
	
// <form id="loginForm" name="loginForm" action="/member.php" method="post">
// <input id="ioBlackBox" name="ioBlackBox" type="hidden">
// <div class="form-text">
// <input name="ID" class="textbox" type="text">
// </div>
// <div class="form-password">
// <input name="Password" class="textbox" type="password">
// </div>
// <input id="cookie_check" value="" name="cookie_check" type="hidden">
// <input id="browser_info" value="" name="browser_info" type="hidden">
// <input value="true" name="form_submit" type="hidden">
// <input name="" class="btn_submit" value="Submit" type="submit">
// <a href="#" data-toggle="modal" data-target="#forgot_popup" class="forgot" aria-hidden="true" data-dismiss="modal">Forgot your Login or password?</a>
// </form>
	$action = "http://www.tailopez.com/member.php";
	$method="POST";
	$ref="";
	$data_array["ID"] = "rameshnaidu@gmail.com";
	$data_array["Password"] = "a8460b";
	$response = http($target=$action, $ref, $method, $data_array, EXCL_HEAD);	
	# Download the web page
	$web_page = http_get("http://www.tailopez.com/cp/Millionaire-Mentor-Academy/The-67-Steps/67-steps-overview&pid=1", $referer="");
	
	# Update the target in case there was a redirection
	$target = $web_page['STATUS']['url'];
// 	var_dump($web_page['FILE']);
	$listOfPages = parse_array($web_page['FILE'], "<h4><a href=\"http://www.tailopez.com", "</a>");
}

function nextLink(&$currentPage)
{
// <div class="notes">
//                 <div class="img"><a href=""><img src="http://5d9e9f5f927e41e7a64c-de8da85d2ccee5de1292ed7f6f96d59a.r86.cf1.rackcdn.com/medialib/1442211656.8d171becefed78583271d566acbc9e83.jpg" alt="" height="43" width="58"></a></div>
//                 <div class="dis_table">
//                     <h4><a href="http://www.tailopez.com/cp/Millionaire-Mentor-Academy/The-67-Steps/sam-waltons-night-in-a-brazilian-jail-and-stealing-from-mcdonalds-michael-jordan-humility&amp;pid=1">3. Sam Walton's Night In A Brazilian Jail, Stealing From McDonald's &amp; Michael Jordan's Humility</a> </h4>                                        
//                                             <i class="blue-star icon-star-medium a-star-medium-5"></i><span class="lesson-rating-count">(823)</span>
//                                         <p><a href="http://www.tailopez.com/cp/Millionaire-Mentor-Academy/The-67-Steps/sam-waltons-night-in-a-brazilian-jail-and-stealing-from-mcdonalds-michael-jordan-humility&amp;pid=1">The humility it takes to overcome...</a></p>
//                 </div>
//                 <div class="clearfix"></div>
//             </div>


}
function download_Media_for_page($target)
{
	echo "target = $target\n";
	# Download the web page
	$web_page= null;
	$download_tag_array=null;
	
	$web_page = http_get($target, $referer="");

	# Update the target in case there was a redirection
	$target = $web_page['STATUS']['url'];
		
	# use 	//div.title as page base
	$page_base_array= parse_array($web_page['FILE'], "<title", ">");
	$page_base = $page_base_array[0];
	# Identify the directory where iamges are to be saved
	$save_image_directory = "saved_media";
			# Parse the image tags
	$download_tag_array = parse_array($web_page['FILE'], "<div class=\"download\">", "</div>");
	//1. The Billionaire's Brain &amp; Jennifer Lopez's Voice
	//div.title
	//<div class="title" align="left">1. The Billionaire's Brain &amp; Jennifer Lopez's Voice</div>
	// .note_ques.download > ul:nth-child(3)
	//li.clearfix:nth-child(1) > span:nth-child(2)
	// 	li.clearfix:nth-child(2) > span:nth-child(2)
	$title_tag_array = parse_array($web_page['FILE'], "<div class=\"title", "</div>");

	$nameOfCurrentPage = strip_tags($title_tag_array[0]);
	$nameOfCurrentPage = str_replace(":", "-", $nameOfCurrentPage);
	$nameOfCurrentPage = str_replace(";", "-", $nameOfCurrentPage);
	print_r($nameOfCurrentPage);
// <div class="download">
// <h3>DOWNLOAD</h3>
// <p>You may need to right-click the following links and select "Save Link As" to download the file to your computer.</p>

// <ul>
// <li class="clearfix"><span class="icon"><img alt="" src="/controller/themes/magzine/images/icons/mp3.png" height="49" width="42"></span><span class="dis_table"><a href="http://5d9e9f5f927e41e7a64c-de8da85d2ccee5de1292ed7f6f96d59a.r86.cf1.rackcdn.com/medialib/1434583332.be1e763c6e85a5e4ae80e9b0c92e2426.mp3" target="_blank">Download Audio Version:  The Billionaire’s Brain &amp; Jennifer Lopez’s Voice MP3</a></span></li><li class="clearfix"><span class="icon"><img alt="" src="/controller/themes/magzine/images/icons/doc.png" height="49" width="42"></span><span class="dis_table"><a href="http://5d9e9f5f927e41e7a64c-de8da85d2ccee5de1292ed7f6f96d59a.r86.cf1.rackcdn.com/medialib/1407206506.95092b1f3ff343b52e9da12c26edce6b.docx" target="_blank">Download The Worksheet: The Billionaire’s Brain &amp; Jennifer Lopez’s Voice</a></span></li>
// </ul>
	$img_tag_array=null;
	$img_tag_array = parse_array($download_tag_array[0], "<a", "</a>");

	if(count($img_tag_array)==0)
	{
		echo "No images found at $target\n";
		exit;
	}

		# Echo the image source attribute from each image tag
		for($xx=0; $xx<count($img_tag_array); $xx++)
			{
				$image_path = get_attribute($img_tag_array[$xx],  $attribute="href");
				echo " image: ".$image_path;
				$image_url = resolve_address($image_path, $page_base);
				{
					# Make image storage directory for image, if one doesn't exist
					$directory = substr($image_path, 0, strrpos($image_path, "/"));
					$directory = str_replace(":", "-", $directory );
					$image_path = str_replace(":", "-", $image_path );
				
					clearstatcache(); // clear cache to get accurate directory status
					if(!is_dir($save_image_directory."/".$directory))
					mkpath($save_image_directory."/".$directory);
					$nameOfFile = $image_path;
					if (stristr($image_path, "mp3"))
						$nameOfFile = $nameOfCurrentPage.".mp3";
					if (stristr($image_path, "docx"))
						$nameOfFile = $nameOfCurrentPage.".docx";
						
					if (file_exists($save_image_directory."/".$nameOfFile))
						continue;
					# Download the image, report image size
					
					$this_image_file =  download_binary_file($image_url, $ref="");
					echo " size: ".strlen($this_image_file);
				
					# Save the mp3 and Doc file
					{
						$fp = fopen($save_image_directory."/".$nameOfFile, "w");
						fputs($fp, $this_image_file);
						$this_image_file = null;
						fclose($fp);
						echo "\n";
					}
				}
			}
}
