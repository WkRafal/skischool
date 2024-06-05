{extends file="main.tpl"}

{block name=content}

<div class="bottom-margin">
<form action="{$conf->action_root}personSave" method="post" class="pure-form pure-form-aligned">
	<fieldset>
		<legend>Dane osoby</legend>
		<div class="pure-control-group">
            <label for="firstName">imię</label>
            <input id="firstName" type="text" placeholder="imię" name="firstName" value="{$form->firstName}">
        </div>
		<div class="pure-control-group">
            <label for="lastName">nazwisko</label>
            <input id="lastName" type="text" placeholder="nazwisko" name="lastName" value="{$form->lastName}">
        </div>
		<div class="pure-control-group">
            <label for="userName">login</label>
            <input id="userName" type="text" placeholder="login" name="userName" value="{$form->userName}">
        </div>
                <div class="pure-control-group">
            <label for="role">rola</label>
            <input id="role" type="text" placeholder="rola" name="role" value="{$form->role}">
        </div>
                <div class="pure-control-group">
            <label for="password">hasło</label>
            <input id="password" type="text" placeholder="hasło" name="password" value="{$form->password}">
        </div>
                <div class="pure-control-group">
            <label for="email">email</label>
            <input id="email" type="text" placeholder="email" name="email" value="{$form->email}">
        </div>
                <div class="pure-control-group">
            <label for="phone">telefon</label>
            <input id="phone" type="text" placeholder="telefon" name="phone" value="{$form->phone}">
        </div>
		<div class="pure-controls">
			<input type="submit" class="pure-button pure-button-primary" value="Zapisz"/>
			<a class="pure-button button-secondary" href="{$conf->action_root}personList">Powrót</a>
		</div>
	</fieldset>
    <input type="hidden" name="id" value="{$form->id}">
</form>	
</div>

{/block}
