{extends file="main.tpl"}

{block name=top}
    
    <div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_url}logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
	<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
    </div>
    
{/block}
{if $user->role == 'admin'}
{block name=border}
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#company">SKI School</a>

            <ul class="pure-menu-list">
                
                <li class="pure-menu-item"><a href="{$conf->action_root}teacherList" class="pure-menu-link">Instruktorzy</a></li>
                <li class="pure-menu-item"><a href="{$conf->action_root}studentList" class="pure-menu-link">Kursanci</a></li>
                <li class="pure-menu-item"><a href="{$conf->action_root}personList"" class="pure-menu-link">Lista wszystkich</a></li>
{*                <li class="pure-menu-item menu-item-divided pure-menu-selected">
                    <a href="{$conf->action_root}personList" class="pure-menu-link">Lista</a>
                </li>*}
                <li class="pure-menu-item"><a href="{$conf->action_root}courseList" class="pure-menu-link">Lista kursów</a></li>
            </ul>
        </div>
    </div>

{/block}
{/if}


{if $user->role == 'uczeń'}
{block name=border}
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#company">SKI School</a>

            <ul class="pure-menu-list">
                
                {*<li class="pure-menu-item"><a href="{$conf->action_root}teacherList" class="pure-menu-link">Instruktorzy</a></li>
                <li class="pure-menu-item"><a href="{$conf->action_root}studentList" class="pure-menu-link">Kursanci</a></li>
                <li class="pure-menu-item"><a href="{$conf->action_root}personList"" class="pure-menu-link">Lista wszystkich</a></li>*}
{*                <li class="pure-menu-item menu-item-divided pure-menu-selected">
                    <a href="{$conf->action_root}personList" class="pure-menu-link">Lista</a>
                </li>*}
                <li class="pure-menu-item"><a href="{$conf->action_root}courseList" class="pure-menu-link">Lista kursów</a></li>
            </ul>
        </div>
    </div>

{/block}
{/if}

{if $user->role == 'instruktor'}
{block name=border}
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#company">SKI School</a>

            <ul class="pure-menu-list">
                
                <li class="pure-menu-item"><a href="{$conf->action_root}courseList/{$user->login}" class="pure-menu-link">Moje propozycje</a></li>
                {*<li class="pure-menu-item"><a href="{$conf->action_root}studentList" class="pure-menu-link">Kursanci</a></li>
                <li class="pure-menu-item"><a href="{$conf->action_root}personList"" class="pure-menu-link">Lista wszystkich</a></li>*}
{*                <li class="pure-menu-item menu-item-divided pure-menu-selected">
                    <a href="{$conf->action_root}personList" class="pure-menu-link">Lista</a>
                </li>*}
{*                <li class="pure-menu-item"><a href="{$conf->action_root}courseList" class="pure-menu-link">Lista kursów</a></li>*}
            </ul>
        </div>
    </div>

{/block}
{/if}



