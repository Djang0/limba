<?php
/**
* File : securimage_show2.php
 * @author  Ludovic Reenaers
 * @since 16 nov. 2010
* lreenaers@hotmail.com
*/
include 'securimage.php';

$img = new securimage();

//Change some settings
$img->image_width = 180;
$img->image_height = 50;
$img->perturbation = 0.6;
$img->code_length = rand(5,6);
$img->image_bg_color = new Securimage_Color("#ffffff");
$img->use_transparent_text = true;
$img->text_transparency_percentage = 75; // 100 = completely transparent
$img->num_lines = 7;
$img->image_signature = '';
$img->text_color = new Securimage_Color("#000000");
$img->line_color = new Securimage_Color("#cccccc");

$img->show(''); // alternate use:  $img->show('/path/to/background_image.jpg');

?>