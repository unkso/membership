{include file='header' pageTitle='wcf.acp.award.assign.title'}

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		new WCF.Date.Time();
		WCF.Date.Picker.init();
		new WCF.Search.User("#user", null, false);
	});
	//]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.award.assign{/lang}</h1>
</header>

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>
{/if}

<p class="info">You are about to give the award "{$award->title}" to a user. Please make sure to fill out all fields correctly before submitting.</p>

<div class="contentNavigation">
	<nav>
		<ul>
			<li><a href="{link controller='AwardList'}{/link}" class="button"><span class="icon icon16 icon-list"></span> <span>{lang}wcf.acp.menu.link.clan.award.list{/lang}</span></a></li>

			{event name='contentNavigationButtons'}
		</ul>
	</nav>
</div>

<form method="post" action="{link controller='AssignAward' id=$award->awardID}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.acp.award.action.general{/lang}</legend>

			<dl>
				<dt><label for="username">{lang}wcf.acp.award.assign.username{/lang}</label></dt>
				<dd>
					<input id="user" name="username" value="{$username}" type="text" class="medium" />
					{if $errorField == 'username'}
						<small class="innerError">
							{lang}wcf.global.form.error.{$errorType}{/lang}
						</small>
					{/if}
				</dd>
			</dl>

			<dl>
				<dt><label for="tierID">{lang}wcf.acp.award.assign.tier{/lang}</label></dt>
				<dd>
					<select name="tierID" id="tierID">
						{assign var=tiers value=$award->getTiers()}
						{foreach from=$tiers item=tier}
							<option value="{@$tier->tierID}"{if $tier->tierID == $tierID} selected="selected"{/if}>{$award->title}{$tier->levelSuffix}</option>
						{/foreach}
					</select>
					<small>{lang}wcf.acp.award.assign.tier.description{/lang}</small>
					{if $errorField == 'tierID'}
						<small class="innerError">
							{lang}wcf.global.form.error.{$errorType}{/lang}
						</small>
					{/if}
				</dd>
			</dl>

			<dl>
				<dt><label for="awardDescription">{lang}wcf.acp.award.assign.description{/lang}</label></dt>
				<dd>
					<textarea id="awardDescription" name="description" cols="40" rows="5">{$description}</textarea>
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

			<dl>
				<dt></dt>
				<dd>
					<label><input type="checkbox" name="notify" value="1"{if $notify} checked="checked"{/if} /> {lang}wcf.acp.award.assign.notify{/lang}</label>
					<small>{lang}wcf.acp.award.assign.notify.description{/lang}</small>
				</dd>
			</dl>

			<div class="formSubmit">
				<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
				{@SECURITY_TOKEN_INPUT_TAG}
			</div>

			{event name='fieldsets'}
		</fieldset>
	</div>
</form>

{include file='footer'}