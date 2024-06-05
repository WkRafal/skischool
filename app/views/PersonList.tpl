{extends file="main.tpl"}

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

<div class="bottom-margin">
<a class="pure-button button-success" href="{$conf->action_root}personNew">+ Nowa osoba</a>
</div>	

<table id="tab_people" class="pure-table pure-table-bordered">
<thead>
	<tr>
		<th>imię</th>
		<th>nazwisko</th>
		<th>login</th>
                <th>rola</th>
                <th>email</th>
                <th>telefon</th>
		<th>opcje</th>
	</tr>
</thead>
<tbody>
{foreach $users as $u}
{strip}
	<tr>
		<td>{$u["first_name"]}</td>
		<td>{$u["last_name"]}</td>
		<td>{$u["username"]}</td>
                <td>{$u["role"]}</td>
                <td>{$u["email"]}</td>
                <td>{$u["phone"]}</td>
{*		<td>
			<a class="button-small pure-button button-secondary" href="{$conf->action_url}personEdit/{$p['idperson']}">Edytuj</a>
			&nbsp;
			<a class="button-small pure-button button-warning" href="{$conf->action_url}personDelete/{$p['idperson']}">Usuń</a>
		</td>*}
	</tr>
{/strip}
{/foreach}
</tbody>
</table>

{/block}
