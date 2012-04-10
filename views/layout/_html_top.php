<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1.0, minimum-scale=1, maximum-scale=1, target-densityDpi=device-dpi" />
    <meta name="apple-mobile-web-app-capable" content="yes" /><!-- THIS HIDES THE BROWSER BAR WHEN A SITE IS BOOKMARKED ON THE HOME -->
    <link rel="apple-touch-icon" href="/img/apple-touch-icon.png" /><!-- SETS THE BOOKMARK ICON (iOs) -->
    <link rel="apple-touch-icon-precomposed" href="/img/apple-touch-icon.png" /><!-- SETS THE BOOKMARK ICON (Android) -->
    <meta name="title" content="<?=$title?>" />

	<? if (isset($meta)): ?>
	<!-- Custom Meta Tags -->
	<? foreach ($meta as $mtag): ?>
	<meta<?= isset($mtag['name']) ? ' name="'.$mtag['name'].'"' : '' ?><?= isset($mtag['property']) ? ' property="' . $mtag['property'] . '"' : '' ?> content="<?=$mtag['content']?>" />
	<? endforeach ?>
	<? endif ?>
	
    <title><?=$title?></title>
    <link rel="shortcut icon" href="/img/.ico" />
    
    <? if (isset($css)): ?>
	<? foreach($css as $style): ?>
	<link rel="stylesheet" type="text/css" href="<?= $style ?>" />
	<? endforeach ?>
	<? endif ?>

	<? if (isset($js)): ?>
	<? foreach ($js as $script): ?>
	<script  type="text/javascript" src="<?= $script ?>"></script>
	<? endforeach ?>
	<? endif ?>
    
    <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->	
  </head>
  <body>