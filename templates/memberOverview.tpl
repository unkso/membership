{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.overview{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
    {include file='header' title='wcf.page.personnel.overview'|language}

    <div class="container">
        {include file='userNotice'}

        This is the list of all current members

        <ul>
            {foreach from=$members item=member}
                <li>{$member->getDisplayableUsername()}</li>
            {/foreach}
        </ul>
    </div>

    {include file='footer'}
</body>
</html>