{include file='header' pageTitle='wcf.acp.menu.link.clan.membership.import'}

<script data-relocate="true">
    //<![CDATA[
    $(function() {
        WCF.TabMenu.init();
        $('.username').each(function () {
            new WCF.Search.User("#" + $(this).attr('id'));
        });
    });
    //]]>
</script>

<header class="boxHeadline">
    <h1>{lang}wcf.acp.menu.link.clan.membership.import{/lang}</h1>
</header>

{include file='formError'}

{if !$jsonError|empty}
    <p class="error">The provided JSON file is not valid: {$jsonError}</p>
{/if}

<form method="post" action="{link controller='ImportMemberships'}{/link}" enctype="multipart/form-data">
    <div class="container containerPadding marginTop">

        <fieldset>
            <legend>Input</legend>

            <dl{if $errorField == 'json'} class="formError"{/if}>
                <dt><label for="json">JSON import</label></dt>
                <dd>
                    <textarea id="json" name="json" cols="40" rows="10">{@$json}</textarea>

                    {if $errorField == 'json'}
                        <small class="innerError">
                            {lang}wcf.acp.smiley.aliases.error.{@$errorType}{/lang}
                        </small>
                    {/if}
                </dd>
            </dl>
        </fieldset>

        {if $importers|count}
            <p class="info">Your import has been parsed. Please adjust the usernames associated to each import below, and hit the "Import" button.</p>

            <fieldset>
                <legend>Adjust imported items</legend>

                {foreach from=$importers key=key item=importer}
                    {if $importer->getImportedName()}
                        <dl>
                            <dt><label for="username">{lang}wcf.user.username{/lang} for <b>"{$importer->getImportedName()}"</b></label></dt>
                            <dd>
                                <input type="text" id="username_{$key}" name="username[]" value="{if $importer->user}{$importer->getImportedName()}{/if}" class="medium username" />
                            </dd>
                        </dl>
                    {/if}
                {/foreach}
            </fieldset>
        {/if}

    <div class="formSubmit">
        <input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
        {if $importers|count}
            <input type="submit" value="Import" name="run-import" accesskey="i" />
        {/if}
        {@SECURITY_TOKEN_INPUT_TAG}
    </div>
</form>


{include file='footer'}