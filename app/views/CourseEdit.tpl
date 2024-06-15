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

<div class="bottom-margin">
<form action="{$conf->action_root}courseSave" method="post" class="pure-form pure-form-aligned">
	<fieldset>
		<legend>Dane kursu</legend>
        
                <div class="pure-control-group">
                <label for="nazwa">Wybierz lekcje:</label>
                <select id="nazwa" name="nazwa">
                <option value="narty">narty</option>
                <option value="snowboard">snowboard</option>
                <option value="skituring">skituring</option>
                </select>
        </div>
		<div class="pure-control-group">
                <label for="level">Wybierz poziom:</label>
                <select id="level" name="level">
                <option value="początkujący">początkujący</option>
                <option value="Sredniozaawansowany">Sredniozaawansowany</option>
                <option value="zaawansowany">zaawansowany</option>
                </select>
        </div>
		<div class="pure-control-group">
            <label for="startDate">początek</label>
            <input id="startDate" type="date" placeholder="yyyy-mm-dd" name="startDate" value="{$form->startDate}">
        </div>
                <div class="pure-control-group">
            <label for="endDate">koniec</label>
            <input id="endDate" type="date" placeholder="yyyy-mm-dd" name="endDate" value="{$form->endDate}">
        </div>
{*              <div class="pure-control-group">
            <label for="teacher">nauczyciel</label>
            <input id="teacher" type="text" placeholder="" name="teacher" value="{$form->teacher}">
        </div>*}
		<div class="pure-controls">
			<input type="submit" class="pure-button pure-button-primary" value="Zapisz"/>
			<a class="pure-button button-secondary" href="{$conf->action_root}home">Powrót</a>
		</div>
	</fieldset>
    <input type="hidden" name="id" value="{$form->id}">
   <input type="hidden" name="teacher" value="{$form->teacher}">
</form>	
</div>

{/block}
