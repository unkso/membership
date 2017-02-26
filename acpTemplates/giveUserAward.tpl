{include file='header' pageTitle='wcf.acp.award.assign.title.'|concat:$action}

<script data-relocate="true">
    WCF.Search.Award = WCF.Search.Base.extend({
        _className: 'wcf\\data\\award\\action\\AwardAction'
    });

    //<![CDATA[
    $(function() {
        new WCF.Date.Time();
        WCF.Date.Picker.init();
        new WCF.Search.Award("#awardName", null, false);
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
				<dt><label for="awardName">{lang}wcf.acp.award.assign.award{/lang}</label></dt>
				<dd>
					<input id="awardName" name="awardName" {if $action == 'edit'}readonly{/if} type="text" class="medium" value="{$awardName}" />
                    {if $errorField == 'award'}
						<small class="innerError">
                            {lang}wcf.global.form.error.{$errorType}{/lang}
						</small>
                    {/if}
				</dd>
			</dl>

			<dl>
				<dt><label for="awardedNumber">{lang}wcf.acp.award.assign.awardedNumber{/lang}</label></dt>
				<dd>
					<input id="awardedNumber" name="awardedNumber" type="number" class="short" value="{$awardedNumber}" />
					<small>{lang}wcf.acp.award.assign.awardedNumber.description{/lang}</small>
                    {if $errorField == 'awardedNumber'}
						<small class="innerError">
							{if $errorType == 'outofrange'}
                                {lang}wcf.acp.award.assign.awardedNumber.exception.outofrange{/lang}
							{else}
                                {lang}wcf.global.form.error.{$errorType}{/lang}
							{/if}
						</small>
                    {/if}
				</dd>
			</dl>

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