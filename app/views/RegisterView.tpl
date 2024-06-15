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

        </div>
    </div>

{/block}

{block name=content}
    

<form action="{$conf->action_root}register" method="post" class="pure-form pure-form-aligned bottom-margin">
	<legend>Rejstracja</legend>
	<fieldset>
        <div class="pure-control-group">
			<label for="id_login">login: </label>
			<input id="id_login" type="text" name="login" value="{$form->userName}"/>
		</div>
        <div class="pure-control-group">
			<label for="id_pass">hasło: </label>
			<input id="id_pass" type="password" name="pass" /><br />
		</div>
        <div class="pure-control-group">
			<label for="id_pass">powtórz hasło: </label>
			<input id="id_pass" type="password" name="replaypass" /><br />
		</div>
		<div class="pure-controls">
			<input type="submit" value="rejstracja" class="pure-button pure-button-primary"/>
                        <a class="pure-button button-secondary" href="{$conf->action_root}Login">Logowanie</a>
		</div>
	</fieldset>
</form>	
{/block}
