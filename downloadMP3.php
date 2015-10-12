<?php
include_once("Lib/LIB_parse.php");               # include parse library
include_once("Lib/LIB_http.php");                # include curl library
include_once("Lib/LIB_resolve_addresses.php");   # include address resolution library
/*
 * while next link is not nil
 * read page
 * get MP3 link on the page
 * save file under downloads using page name.MP3 as the name
 * 
 * */
$currentPage = "http://www.tailopez.com/cp/5/104/433";
download_Media_for_page($currentPage);
exit();
do
{
	$nextPage = readPage($currentPage);
	$mp3File = nameOfCurrentPage($currentPage).".mp3";
	saveFile($mp3File);
}while (nextLink($currentPage));

function nameOfCurrentPage($currentPage)
{
	//1. The Billionaire's Brain &amp; Jennifer Lopez's Voice
	//div.title
	//<div class="title" align="left">1. The Billionaire's Brain &amp; Jennifer Lopez's Voice</div>
// .note_ques.download > ul:nth-child(3)
//li.clearfix:nth-child(1) > span:nth-child(2)
// 	li.clearfix:nth-child(2) > span:nth-child(2)
}

function nextLink(&$currentPage)
{
// 	<div class="nextLesson">Upcoming:</div> , 
// <div class="dis_table">
//                     <h4><a href="http://www.tailopez.com/cp/Millionaire-Mentor-Academy/The-67-Steps/picassos-rising-tide-the-law-of-33&amp;pid=single">4. Picasso's Rising Tide &amp; The Law of 33%</a> </h4>
                    
//                                             <i class="blue-star icon-star-medium a-star-medium-5"></i><span class="lesson-rating-count">(501)</span>
//                                         <p><a href="http://www.tailopez.com/cp/Millionaire-Mentor-Academy/The-67-Steps/picassos-rising-tide-the-law-of-33&amp;pid=single">Using mentors to shave years off the learning curve.</a></p>
//                 </div>
// 	div.notes:nth-child(5) > div:nth-child(2) > h4:nth-child(1) > a:nth-child(1)
}
function download_Media_for_page($target)
{
	echo "target = $target\n";

	# Download the web page
	$web_page = http_get($target, $referer="");

	# Update the target in case there was a redirection
	$target = $web_page['STATUS']['url'];

	# use 	//div.title as page base
	$page_base_array= parse_array($web_page['FILE'], "<title", ">");
	$page_base = $page_base_array[0];
	# Identify the directory where iamges are to be saved
	$save_image_directory = "saved_media";
var_dump($web_page['FILE']);
			# Parse the image tags
$img_tag_array = parse_array($web_page['FILE'], "<div class=\"download\">", "</div>");
// <div class="download">
// <h3>DOWNLOAD</h3>
// <p>You may need to right-click the following links and select "Save Link As" to download the file to your computer.</p>

// <ul>
// <li class="clearfix"><span class="icon"><img alt="" src="/controller/themes/magzine/images/icons/mp3.png" height="49" width="42"></span><span class="dis_table"><a href="http://5d9e9f5f927e41e7a64c-de8da85d2ccee5de1292ed7f6f96d59a.r86.cf1.rackcdn.com/medialib/1434583332.be1e763c6e85a5e4ae80e9b0c92e2426.mp3" target="_blank">Download Audio Version:  The Billionaire’s Brain &amp; Jennifer Lopez’s Voice MP3</a></span></li><li class="clearfix"><span class="icon"><img alt="" src="/controller/themes/magzine/images/icons/doc.png" height="49" width="42"></span><span class="dis_table"><a href="http://5d9e9f5f927e41e7a64c-de8da85d2ccee5de1292ed7f6f96d59a.r86.cf1.rackcdn.com/medialib/1407206506.95092b1f3ff343b52e9da12c26edce6b.docx" target="_blank">Download The Worksheet: The Billionaire’s Brain &amp; Jennifer Lopez’s Voice</a></span></li>
// </ul>
var_dump($img_tag_array);

if(count($img_tag_array)==0)
{
		echo "No images found at $target\n";
		exit;
		}

		# Echo the image source attribute from each image tag
		for($xx=0; $xx<count($img_tag_array); $xx++)
			{
			$image_path = get_attribute($img_tag_array[$xx],  $attribute="src");
			echo " image: ".$image_path;
			$image_url = resolve_address($image_path, $page_base);
			if(get_base_domain_address($page_base) == get_base_domain_address($image_url))
			{
			# Make image storage directory for image, if one doesn't exist
	$directory = substr($image_path, 0, strrpos($image_path, "/"));
	$directory = str_replace(":", "-", $directory );
	$image_path = str_replace(":", "-", $image_path );

	clearstatcache(); // clear cache to get accurate directory status
	if(!is_dir($save_image_directory."/".$directory))
	mkpath($save_image_directory."/".$directory);

	# Download the image, report image size
	$this_image_file =  download_binary_file($image_url, $ref="");
	echo " size: ".strlen($this_image_file);

	# Save the image
	if(stristr($image_url, ".jpg") || stristr($image_url, ".gif") || stristr($image_url, ".png"))
	{
	$fp = fopen($save_image_directory."/".$image_path, "w");
	fputs($fp, $this_image_file);
	fclose($fp);
	echo "\n";
			}
			}
			else
				{
				echo "\nSkipping off-domain image.\n";
			}
	}
}
function saveFile($mp3file)
{
	
}