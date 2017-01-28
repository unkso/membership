{include file='header' pageTitle='wcf.acp.award.assign.title'}

<script data-relocate="true">
    WCF.Search.Award = WCF.Search.Base.extend({
        _className: 'wcf\\data\\award\\action\\AwardAction',

		_tierInput: null,

		_awardList: [],

        init: function(searchInput, tierInput, callback, excludedSearchValues) {
            this._tierInput = $(tierInput);

            this._super(searchInput, callback, excludedSearchValues, false);
        },

		_clearList: function(clearSearchInput) {
            this._awardList = [];
        	this._super(clearSearchInput);
        },

        _createListItem: function(item) {
            var $listItem = this._super(item);
            this._awardList.push(item);

            return $listItem;
        },

        _executeCallback: function(event) {
            var $listItem = $(event.currentTarget);

            var award = null;
            $.each(this._awardList, function(i, object) {
                if (object.objectID == $listItem.data('objectID')) {
                    award = object;
                }
            });

            var input = this._tierInput;
            input.prop('disabled', false).find('option').remove();
            $.each(award.tiers, function(i, tier) {
                input.append('<option value="' + tier.objectID + '">' + tier.title + '</option>');
            });

            this._super(event);
        }
    });

    //<![CDATA[
    $(function() {
        new WCF.Date.Time();
        WCF.Date.Picker.init();
        new WCF.Search.Award("#award", "#tier", null, false);
    });
    //]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.award.assign{/lang}</h1>
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

<form method="post" action="{link controller='GiveUserAward' id=$user->getUserID()}{/link}">
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
					<input id="award" name="award" type="text" class="medium" {if $tier}value="{$tier->getAward()->title}"{/if} />
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
					<select id="tier" name="tierID" {if !$tier}disabled{/if}>
						{if $tier}
							{foreach from=$tier->getAward()->getTiers() item=$object}
								<option value="{$object->tierID}" {if $object->tierID == $tier->tierID}selected{/if}>{$object->getName()}</option>
							{/foreach}
						{/if}
					</select>
					<small>You will need to select an award above before available tiers are shown.</small>
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