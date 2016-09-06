{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.management.unit{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
    {include file='header' title='wcf.page.personnel.management.unit.title'|language paddingBottom=30 light=true}

    <div class="container">
        {include file='userNotice'}

        <div class="alert alert-info">
            Please <strong>always</strong> double-check your changes before saving, as some of the settings cannot be restored once changed.
        </div>

        <div class="tabs">
            <ul class="nav nav-tabs nav-justified">
                <li class="active">
                    <a href="#tab-units" data-toggle="tab" class="text-center"><i class="fa fa-group"></i> Unit Administration</a>
                </li>
                <li>
                    <a href="#tab-scopes" data-toggle="tab" class="text-center">Unit Scopes</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-units" class="tab-pane active">
                    {include file='unitManagementTab_Unit'}
                </div>
                <div id="tab-scopes" class="tab-pane">
                    {include file='unitManagementTab_Scope'}
                </div>
            </div>
        </div>

    </div>

    {include file='footer' skipBreadcrumbs=true}
</body>
</html>