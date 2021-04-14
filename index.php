<?php

use Webloper\Gravatar\Gravatar;

/**
 * This file is only used for demo purpose.
 *
 * @package     Gravatar
 * @author         Ravi Kumar
 * @version     0.1.0
 * @copyright     Copyright (c) 2014, Ravi Kumar
 * @license     https: //github.com/webloper/gravatar/blob/master/LICENSE MIT
 **/

include_once 'vendor/autoload.php';

$email = 'webloper@gmail.com';

$gravatar = new Gravatar($email);

$url = $gravatar->setSize(200)->url();

$profile = $gravatar->profile('xml');

$name = 'Gravatar Image';
$xml = $profile->xpath('//entry/name/formatted');
if (is_array($xml) && isset($xml[0])) {
    $name = (string) $xml[0];
}

$img = $gravatar->img(array('alt' => $name));
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Gravatar</title>
		<style>
			body { font: 1em "Trebuchet MS", sans-serif; }
			.comments { width: 100%; }
			.comment { padding: 10px 10px 0 10px; }
			.comment:after { content: ' '; display: table; clear: both; }
			.comment-image { width: 65px; }
			.comment-image img { width: 50px; border-radius: 50px; }
			.comment-image, .comment-body { float: left; }
			.comment-body { width: 80%; }
			.comment-body p { margin-top: 10px; }
			.comment-info { font-weight: bold; }
			.comment-reply { margin-left: 5%; }
		</style>
	</head>
	<body>

 		<div class="comments">
			<div class="comment">
				<div class="comment-image">
					<?php echo $img; ?>
				</div>
				<div class="comment-body">
					<div class="comment-info">Ravi said 2 min ago</div>
					<p>Toffee chupa chups <a href="<?php echo $url; ?>">Gravatar Url</a>  gummi bears wafer topping macaroon icing. Ice cream apple pie carrot cake sesame snaps marshmallow halvah unerdwear.com cheesecake. Lollipop dragée candy canes bonbon gummies. Candy candy sweet dragée pastry. Powder jujubes jelly beans carrot cake unerdwear.com sesame snaps sweet dragée.</p>
				</div>
			</div>
			<div class="comment comment-reply">
				<div class="comment-image">
					<?php echo $img; ?>
				</div>
				<div class="comment-body">
					<div class="comment-info">Ravi said 2 min ago</div>
					<p>Toffee chupa chups unerdwear.com gummi bears wafer topping macaroon icing. Ice cream apple pie carrot cake sesame snaps marshmallow halvah unerdwear.com cheesecake. Lollipop dragée candy canes bonbon gummies. Candy candy sweet dragée pastry. Powder jujubes jelly beans carrot cake unerdwear.com sesame snaps sweet dragée.</p>
				</div>
			</div>
		</div>

	</body>
</html>
