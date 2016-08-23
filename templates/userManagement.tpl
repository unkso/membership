{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.management{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
    {include file='header' title='wcf.page.personnel.management.title'|language paddingBottom=30 light=true}

    <div class="container">
        {include file='userNotice'}

        {if !$user}
            <div class="alert alert-info">Please type in the user name of the person you want to manage.</div>
        {else}
            <div class="alert alert-warning">You have selected the user <strong>{$user->getUsername()}</strong>.</div>
        {/if}

        <form method="post" action="{link controller='UserManagement'}{/link}">
            <div class="container containerPadding marginTop">
                <fieldset>
                    <legend>{lang}wcf.acp.award.action.general{/lang}</legend>

                    <dl>
                        <dt><label for="username">Username</label></dt>
                        <dd>
                            <input id="username" name="username" {if $user}value="{$user->getUsername()}"{/if}>
                        </dd>
                    </dl>

                    {event name='fieldsets'}
                </fieldset>

                {if $user}
                    <fieldset>
                        <legend>Quick Actions</legend>

                        <div class="text-center">
                            <button type="submit" name="button" class="btn btn-3d">Make clan member</button>
                            <button type="submit" name="button" class="btn btn-3d">Change rank</button>
                        </div>
                    </fieldset>
                {/if}

                <fieldset>
                    <div class="formSubmit">
                        <button type="submit" class="btn btn-3d btn-primary" accesskey="s">{lang}wcf.global.button.submit{/lang}</button>
                        {@SECURITY_TOKEN_INPUT_TAG}
                    </div>
                </fieldset>
            </div>
        </form>

        <script data-relocate="true">
            new WCF.Search.User("#username", null, false);
        </script>

    </div>

    {include file='footer' skipBreadcrumbs=true}
</body>
</html>