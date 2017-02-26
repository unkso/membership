{include file='header' pageTitle='wcf.acp.award.assign.title.'|concat:$action}

<script data-relocate="true">
    WCF.Search.Award = WCF.Search.Base.extend({
        _className: 'wcf\\data\\award\\action\\AwardAction'
    });

    //<![CDATA[
    $(function() {
        new WCF.Date.Time();
        WCF.Date.Picker.init();
        new WCF.Search.Award("#award", null, false);
    });
    //]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.award.assign.{$action}{/lang}</h1>
</header>

{if $success|isset}
	<p class="success">{lang}wcf.global.success.add{/lang}</p>
{/if}

{include file='formError'}

<div class="contentNavigation">
	<nav>
		<ul>
			<li><a href="{link controller='UserEdit' id=$user->getUserID()}{/link}" class="button"><span class="icon icon16 icon-edit"></span> <span>Back to user</span></a></li>

            {event name='contentNavigationButtons'}
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='GiveUserAward' id=$user->getUserID()}{/link}{else}{link controller='EditGivenAward' id=$issuedID}{/link}{/if}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.acp.award.action.general{/lang}</legend>

			<dl>
				<dt><label for="username">{lang}wcf.acp.award.assign.username{/lang}</label></dt>
				<dd>
					<input id="user" name="username" readonly value="{$user->getUsername()}" type="text" class="medium" />
				</dd>
			</dl>

			<dl>
				<dt><label for="award">{lang}wcf.acp.award.assign.award{/lang}</label></dt>
				<dd>
					<input id="award" name="award" {if $action == 'edit'}readonly{/if} type="text" class="medium" {if $tier}value="{$tier->getAward()->title}"{/if} />
                    {if $errorField == 'award'}
						<small class="innerError">
                            {lang}wcf.global.form.error.{$errorType}{/lang}
						</small>
                    {/if}
				</dd>
			</dl>

			<dl>
				<dt><label for="tier">{lang}wcf.acp.award.assign.tier{/lang}</label></dt>
				<dd>
					<select id="tier" name="tierID" {if !$tier || $action == 'edit'}disabled{/if}>
						{if $tier}
							{foreach from=$tier->getAward()->getTiers() item=$object}
								<option value="{$object->tierID}" {if $object->tierID == $tier->tierID}selected{/if}>{$object->getName()}</option>
							{/foreach}
						{/if}
					</select>
                    {if $action == 'add'}<small>You will need to select an award above before available tiers are shown.</small>{/if}
                    {if $errorField == 'tierID'}
						<small class="innerError">
                            {lang}wcf.global.form.tier.error.{$errorType}{/lang}
						</small>
                    {/if}
				</dd>
			</dl>

			{if $confirm|isset && $confirm}
			<dl>
				<dt></dt>
				<dd>
					<label><input type="checkbox" name="confirm" value="1"/> {lang}wcf.acp.award.assign.confirm{/lang}</label>
				</dd>
			</dl>
            {/if}

			<dl>
				<dt><label for="awardDescription">{lang}wcf.acp.award.assign.description{/lang}</label></dt>
				<dd>
					<textarea id="awardDescription" name="description" cols="40" rows="5">{$description}</textarea>
					<small>{lang}wcf.acp.award.assign.description.description{/lang}</small>
                    {if $errorField == 'description'}
						<small class="innerError">
                            {lang}wcf.global.form.error.{$errorType}{/lang}
						</small>
                    {/if}
				</dd>
			</dl>

			<dl>
				<dt><label for="date">{lang}wcf.acp.award.assign.date{/lang}</label></dt>
				<dd>
					<input type="date" id="date" name="date" class="jsDatePicker" value="{$date}" />
					<small>{lang}wcf.acp.award.assign.date.description{/lang}</small>
                    {if $errorField == 'date'}
						<small class="innerError">
                            {lang}wcf.global.form.error.{$errorType}{/lang}
						</small>
                    {/if}
				</dd>
			</dl>

			{if $action == 'add'}
			<dl>
				<dt></dt>
				<dd>
					<label><input type="checkbox" name="notify" value="1"{if $notify} checked="checked"{/if} /> {lang}wcf.acp.award.assign.notify{/lang}</label>
					<small>{lang}wcf.acp.award.assign.notify.description{/lang}</small>
				</dd>
			</dl>
            {/if}

			<div class="formSubmit">
				<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
                {@SECURITY_TOKEN_INPUT_TAG}
			</div>

            {event name='fieldsets'}
		</fieldset>
	</div>
</form>

{include file='footer'}