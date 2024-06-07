{extends file="main.tpl"}


{block name=content}

<div class="bottom-margin">
<form action="{$conf->action_root}courseSave" method="post" class="pure-form pure-form-aligned">
	<fieldset>
		<legend>Dane kursu</legend>

		<div class="pure-control-group">
            <label for="startDate">początek</label>
            <input id="startDate" type="text" placeholder="yyyy-mm-dd" name="startDate" value="{$form->startDate}">
        </div>
                <div class="pure-control-group">
            <label for="endDate">koniec</label>
            <input id="endDate" type="text" placeholder="yyyy-mm-dd" name="endDate" value="{$form->endDate}">
        </div>
{*              <div class="pure-control-group">
            <label for="teacher">nauczyciel</label>
            <input id="teacher" type="text" placeholder="" name="teacher" value="{$form->teacher}">
        </div>*}
		<div class="pure-controls">
			<input type="submit" class="pure-button pure-button-primary" value="Zapisz"/>
			<a class="pure-button button-secondary" href="{$conf->action_root}personList">Powrót</a>
		</div>
	</fieldset>
    <input type="hidden" name="id" value="{$form->id}">
   <input type="hidden" name="teacher" value="{$form->teacher}">
</form>	
</div>

{/block}
