<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Responsive Side Menu &ndash; Layout Examples &ndash; Pure</title>
<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css" integrity="sha384-UQiGfs9ICog+LwheBSRCt1o5cbyKIHbwjWscjemyBMT9YCUMZffs6UqUTd0hObXD" crossorigin="anonymous">
        <link rel="stylesheet" href="{$conf->app_url}/css/styles.css"
</head>
<body>
    
{block name=border} {/block}

    
 <div class="header">
    
	<h1>{$page_title|default:""}</h1>
	<h2>{$page_header|default:""}</h1>
	<p>
		{$page_description|default:""}
	</p>
</div>

{block name=top} {/block}

<div class="content">
{block name=content} {/block}
</div><!-- content -->

{block name=messages}

{if $msgs->isMessage()}
<div class="messages bottom-margin">
	<ul>
	{foreach $msgs->getMessages() as $msg}
	{strip}
		<li class="msg {if $msg->isError()}error{/if} {if $msg->isWarning()}warning{/if} {if $msg->isInfo()}info{/if}">{$msg->text}</li>
	{/strip}
	{/foreach}
	</ul>
</div>
{/if}

{/block}
    
{block name=bottom} {/block}
    
</div>

<script src="/js/ui.js"></script>

</body>
</html>
