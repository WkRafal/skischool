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
                <li class="pure-menu-item"><a href="{$conf->action_url}home" class="pure-menu-link">Home</a></li>
            </ul>
        </div>
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
                <th>imie instruktora</th>
                <th>nazwisko</th>
                <th>telefon</th>
                <th>cena</th>
                <th>status</th>
	</tr>
</thead>
<tbody>
{foreach $enrollments as $u}
{strip}
	<tr>
		<td>{$u["name"]}</td>
		<td>{$u["level"]}</td>
		<td>{$u["start_date"]}</td>
                <td>{$u["end_date"]}</td>
                <td>{$u["first_name"]}</td>
                <td>{$u["last_name"]}</td>
                <td>{$u["phone"]}</td>
                <td>
                    {if $user-> role == 'instruktor'}
                        <form action="{$conf->action_root}priceSet/{$u['enrollment_id']}" method="post" class="pure-form pure-form-aligned">
                        <div class="pure-control-group">
                        <input id="price" type="text" name="price" value="{$u["price"]}">
                        <input type="submit" class="pure-button pure-button-primary" value="Zapisz"/>
                        </div>
                        </form>
                    {else}
                        {$u["price"]}</td>
                    {/if}
                                          
                <td>{$u["status"]}</td>
            		<td>
			<a class="button-small pure-button button-warning" href="{$conf->action_url}enrollmentDelete/{$u['enrollment_id']}">Usuń</a>
                        {if $user->role == 'instruktor'}
                            &nbsp;
			<a class="button-small pure-button button-warning" href="{$conf->action_url}enrollmentOK/{$u['enrollment_id']}">Zatwierdź</a>
                        {/if}
		</td>
	</tr>
{/strip}
{/foreach}
</tbody>
</table>

{/block}

