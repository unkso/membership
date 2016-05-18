{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.overview{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' title='wcf.page.personnel.overview'|language}

{include file='userNotice'}

This is the list of all current members

<div class="alert alert-info">
    <h3>User history example</h3>
    <p><code>UserHistoryFactory::makeHistory(1)->getDescription();</code></p>
    <p>{$historyExample}</p>
</div>

{include file='footer'}
</body>
</html>