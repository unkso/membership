{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.management{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
    {include file='header' title='wcf.page.personnel.management.title'|language}

    <div class="container marginBottom-30">
        {include file='userNotice'}

        <div class="alert alert-warning">
            <strong>Please be careful!</strong> Thanks!!
        </div>

        <ul>
            <input id="user">
        </ul>
    </div>

    <script data-relocate="true">
        new WCF.Search.User("#user", function(user) {
            getUserTemplate(user.objectID);
        }, false);

        function getUserTemplate(id) {
            var _proxy = new WCF.Action.Proxy({
                showLoadingOverlay: true,
                data: {
                    actionName: 'getUserManagementTemplate',
                    className: 'wcf\\action\\UserManagementAction',
                    parameters: {
                        userID: id
                    }
                },
                success: $.proxy( function(data, textStatus, jqXHR) {
                    console.log(data);
                    console.log(textStatus);
                }, this)
            });
            _proxy.sendRequest();
        }
    </script>

    {include file='footer' skipBreadcrumbs=true}
</body>
</html>