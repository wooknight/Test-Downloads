<?php
/*
 * while next link is not nil
 * read page
 * get MP3 link on the page
 * save file under downloads using page name.MP3 as the name
 * 
 * */

while (nextLink($currentPage))
{
	$nextPage = readPage($currentPage);
	$mp3File = nameOfCurrentPage($currentPage).".mp3";
	saveFile($mp3File);
}

function nameOfCurrentPage($currentPage)
{
	//1. The Billionaire's Brain &amp; Jennifer Lopez's Voice
	//div.title
	//<div class="title" align="left">1. The Billionaire's Brain &amp; Jennifer Lopez's Voice</div>
// .note_ques.download > ul:nth-child(3)
//li.clearfix:nth-child(1) > span:nth-child(2)
// 	li.clearfix:nth-child(2) > span:nth-child(2)
}

function nextLink($currentPage)
{
// 	<div class="nextLesson">Upcoming:</div> , 
// <div class="dis_table">
//                     <h4><a href="http://www.tailopez.com/cp/Millionaire-Mentor-Academy/The-67-Steps/picassos-rising-tide-the-law-of-33&amp;pid=single">4. Picasso's Rising Tide &amp; The Law of 33%</a> </h4>
                    
//                                             <i class="blue-star icon-star-medium a-star-medium-5"></i><span class="lesson-rating-count">(501)</span>
//                                         <p><a href="http://www.tailopez.com/cp/Millionaire-Mentor-Academy/The-67-Steps/picassos-rising-tide-the-law-of-33&amp;pid=single">Using mentors to shave years off the learning curve.</a></p>
//                 </div>
// 	div.notes:nth-child(5) > div:nth-child(2) > h4:nth-child(1) > a:nth-child(1)
}