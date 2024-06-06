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

            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="{$conf->action_url}adminHome" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item"><a href="#about" class="pure-menu-link">About</a></li>

                <li class="pure-menu-item menu-item-divided pure-menu-selected">
                    <a href="{$conf->action_root}personList" class="pure-menu-link">Lista</a>
                </li>

                <li class="pure-menu-item"><a href="#contact" class="pure-menu-link">Contact</a></li>
            </ul>
        </div>
    </div>

{/block}

{block name=content}
    
<div class="bottom-margin">
<form class="pure-form pure-form-stacked" action="{$conf->action_url}personList">
	<legend>Opcje wyszukiwania</legend>
	<fieldset>
		<input type="text" placeholder="nazwisko" name="sf_surname" value="{$searchForm->surname}" /><br />
		<button type="submit" class="pure-button pure-button-primary">Filtruj</button>
	</fieldset>
</form>
</div>	

{/block}

{block name=bottom}


<table id="tab_people" class="pure-table pure-table-bordered">
<thead>
	<tr>
		<th>kurs</th>
		<th>poziom</th>
		<th>Data Rozpoczęcia</th>
                <th>Data zakończenia</th>
                <th>kursant</th>

	</tr>
</thead>
<tbody>
{foreach $courses as $u}
{strip}
	<tr>
		<td>{$u["name"]}</td>
		<td>{$u["level"]}</td>
		<td>{$u["start_date"]}</td>
                <td>{$u["end_date"]}</td>
                <td>{$u["user_id"]}</td>
            		<td>
			<a class="button-small pure-button button-secondary" href="{$conf->action_url}courseEdit/{$u['course_id']}">Edytuj</a>
			&nbsp;
			<a class="button-small pure-button button-warning" href="{$conf->action_url}courseDelete/{$u['course_id']}">Usuń</a>
		</td>
	</tr>
{/strip}
{/foreach}
</tbody>
</table>

{/block}
