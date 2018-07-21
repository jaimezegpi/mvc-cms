<?php
// This code needed in all your pages
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
?>
<?php get_head(); ?>
<?php get_header(); ?>
<!-- This is an external image from my server -->
		<svg class="svg_logo" stroke-width="0.501" stroke-linejoin="bevel" fill-rule="evenodd" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" overflow="visible"  viewBox="0 0 228.75 98.25">
		 <g id="Document" fill="none" stroke="black" font-family="Times New Roman" font-size="16" transform="scale(1 -1)">
		  <g id="Spread" transform="translate(0 -98.25)">
		   <g id="MouseOff">
		    <path d="M 226.875,2.625 L 161.999,2.625 L 161.999,97.875 L 226.875,97.875" fill="none" stroke="#ffffff" stroke-linejoin="round" stroke-width="0.75" stroke-linecap="round" stroke-miterlimit="79.8403193612775"/>
		    <path d="M 82.007,97.875 L 114.257,2.625 L 146.507,97.875" fill="none" stroke="#ffffff" stroke-width="0.75" stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="79.8403193612775"/>
		    <path d="M 0.375,2.999 L 0.375,97.501 L 32.625,2.625 L 64.875,97.875 L 64.875,2.999" fill="none" stroke="#ffffff" stroke-width="0.75" stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="79.8403193612775"/>
		   </g>
		  </g>
		 </g>
		</svg>
		<p> - 40kb - </p>
<?php get_footer(); ?>