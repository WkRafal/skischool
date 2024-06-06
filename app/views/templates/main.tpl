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
{*<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#company">SKI School</a>

            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="#home" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item"><a href="#about" class="pure-menu-link">About</a></li>

                <li class="pure-menu-item menu-item-divided pure-menu-selected">
                    <a href="#" class="pure-menu-link">Services</a>
                </li>

                <li class="pure-menu-item"><a href="#contact" class="pure-menu-link">Contact</a></li>
            </ul>
        </div>
    </div>*}
    
 <div class="header">
    
	<h1>{$page_title|default:"Tytuł domyślny"}</h1>
	<h2>{$page_header|default:"Tytuł domyślny"}</h1>
	<p>
		{$page_description|default:"Opis domyślny"}
	</p>
</div>

{block name=top} {/block}

<div class="content">
{block name=content} Domyślna treść zawartości .... {/block}
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
