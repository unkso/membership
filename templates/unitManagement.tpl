{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.management.unit{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
    {include file='header' title='wcf.page.personnel.management.unit.title'|language paddingBottom=30 light=true}

    <div class="container">
        {include file='userNotice'}

        <form method="post" action="{link controller='UnitManagement'}{/link}">

        </form>
    </div>

    {include file='footer' skipBreadcrumbs=true}
</body>
</html>