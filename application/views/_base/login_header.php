<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= isset($page_title) ? $page_title : 'Suresy'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Stylesheets (<?= isset($stylesheets) ? count($stylesheets) : '0' ?>) -->
  <?php if(isset($stylesheets)) : foreach($stylesheets as $stylesheet) : ?>
  <link type="text/css" rel="stylesheet" href="<?= $stylesheet ?>" media="screen" />
  <?php endforeach; endif; ?>
  <!-- Javascripts (<?= isset($scripts) ? count($scripts) : '0' ?>) -->
  <?php if(isset($scripts)) : foreach($scripts as $script) : ?>
  <script type="text/javascript" src="<?= $script ?>"></script>
  <?php endforeach; endif; ?>

  <?php if(isset($css) && count($css)) : ?>
  <!-- Inline CSS -->
  <style type='text/css'>
    <?php foreach($css as $inline_css) : ?>
      <?= $inline_css; ?>
    <?php endforeach; ?>
  </style>
  <?php endif; ?>
    
  <?php if(isset($javascript) && count($javascript)) : ?>
    <!-- Inline Javascript -->
    <script type='text/javascript'>
     <?php foreach($javascript as $js) : ?>
      <?= $js; ?>
     <?php endforeach; ?>  
    </script>
  <?php endif; ?>
  
    <!-- Facebook Pixel Code -->
	<script>
	  !function(f,b,e,v,n,t,s)
	  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	  n.queue=[];t=b.createElement(e);t.async=!0;
	  t.src=v;s=b.getElementsByTagName(e)[0];
	  s.parentNode.insertBefore(t,s)}(window, document,'script',
	  'https://connect.facebook.net/en_US/fbevents.js');
	  fbq('init', '168848453795078');
	  fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	  src="https://www.facebook.com/tr?id=168848453795078&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119330820-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	
	  gtag('config', 'UA-119330820-1');
	</script>
</head>
<body class="<?= isset($body_class) ? $body_class : ''; ?>">
  <div id="wrapper">
    <section class="hero login-hero is-fullheight">