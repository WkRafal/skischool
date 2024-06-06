{extends file="main.tpl"}

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

{*            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="#home" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item"><a href="#about" class="pure-menu-link">About</a></li>

                <li class="pure-menu-item menu-item-divided pure-menu-selected">
                    <a href="#" class="pure-menu-link">Services</a>
                </li>

                <li class="pure-menu-item"><a href="#contact" class="pure-menu-link">Contact</a></li>
            </ul>*}
        </div>
    </div>

{/block}

{block name=content}
    

<form action="{$conf->action_root}login" method="post" class="pure-form pure-form-aligned bottom-margin">
	<legend>Logowanie do systemu</legend>
	<fieldset>
        <div class="pure-control-group">
			<label for="id_login">login: </label>
			<input id="id_login" type="text" name="login" value="{$form->login}"/>
		</div>
        <div class="pure-control-group">
			<label for="id_pass">pass: </label>
			<input id="id_pass" type="password" name="pass" /><br />
		</div>
		<div class="pure-controls">
			<input type="submit" value="zaloguj" class="pure-button pure-button-primary"/>
                        <a class="pure-button button-secondary" href="{$conf->action_root}newLogin">Zarejstruj</a>
		</div>
	</fieldset>
</form>	
{/block}
