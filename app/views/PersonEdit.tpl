{extends file="main.tpl"}

{block name=top}
    
    <div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_url}logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
	<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
    </div>
    
{/block}

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
        {if $user->role == 'admin'}
            <div class="pure-control-group">
            <label for="userName">login</label>
            <input id="userName" type="text" placeholder="login" name="userName" value="{$form->userName}">
        </div>
                <div class="pure-control-group">
                <label for="role">Wybierz role:</label>
                <select id="role" name="role">
                <option value="admin">admin</option>
                <option value="uczeń">uczeń</option>
                <option value="instruktor">instruktor</option>
                </select>   
        </div>
            <div class="pure-control-group">
            <label for="password">hasło</label>
            <input id="password" type="text" placeholder="hasło" name="password" value="{$form->password}">
        </div>
        {else}
            <div class="pure-control-group">
            <label for="userName">login</label>
            <input id="userName" type="text"  name="userName" value="{$form->userName}" readonly>
        </div>
                <div class="pure-control-group">
                <label for="role">Wybierz role:</label>
                <input type="text" name="role" value="{$form->role}" readonly>
        </div>
            <div class="pure-control-group">
            <label for="password">hasło</label>
            <input id="password" type="text" name="password" value="{$form->password}" readonly>
        </div>            
        {/if}    
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
			<a class="pure-button button-secondary" href="{$conf->action_root}home">Powrót</a>
		</div>
	</fieldset>
    <input type="hidden" name="id" value="{$form->id}">

</form>	
</div>

{/block}
