{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.overview{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' title='wcf.page.personnel.overview'|language}

{include file='userNotice'}

This is the list of all current members

{$historyExample}

{include file='footer'}
</body>
</html>