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

        <div class="panel-group" id="accordion">
            {foreach from=$objects item=unit}
                {counter name='accordionCount' assign=accordionCount print=false}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{$accordionCount}">
                                {$unit->name} <small>({$unit->getTypeDisplayName()})</small>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse{$accordionCount}" class="accordion-body collapse {if $activeAccordionID == $unit->unitID}in{/if}">
                        <div class="panel-body">
                            {assign var=hierarchy value=$unit->getHierarchy()}
                            <form method="post" action="{link controller='UnitManagement'}{/link}">
                                <input type="hidden" name="unitID" value="{$unit->unitID}">

                                {if $success|isset && $unit->unitID == $activeAccordionID}
                                    <div class="alert alert-success">Your changes have been successfully saved.</div>
                                {/if}

                                <div class="well">
                                    <h4 class="big marginBottom">Current information</h4>

                                    <dl>
                                        <dt>
                                            Internal ID
                                        </dt>
                                        <dd>
                                            {$unit->unitID}
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>
                                            Hierarchy
                                        </dt>
                                        <dd>
                                            <ul class="breadcrumb no-style">
                                                {foreach from=$unit->getHierarchy() item=parent}
                                                    <li>{$parent->name}</li>
                                                {/foreach}
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>

                                <fieldset class="mediumMarginTop">

                                    <dl>
                                        <dt>
                                            <label for="name">Name</label>
                                        </dt>
                                        <dd>
                                            <input type="text" id="name" name="name" value="{$unit->name}">
                                        </dd>
                                    </dl>

                                    <dl>
                                        <dt>
                                            <label for="parentID">Direct parent</label>
                                        </dt>
                                        <dd>
                                            <select name="parentID" id="parentID">
                                                {foreach from=$allUnits item=selectUnit}
                                                    {if $selectUnit->unitID != $unit->unitID}
                                                        <option value="{$selectUnit->unitID}" {if $unit->parentID == $selectUnit->unitID}selected{/if}>{$selectUnit->name}</option>
                                                    {/if}
                                                {/foreach}
                                            </select>
                                        </dd>
                                    </dl>

                                    <dl>
                                        <dt>
                                            <label for="type">Unit Type</label>
                                        </dt>
                                        <dd>
                                            <select name="type" id="type">
                                                {foreach from=$unit->supportedTypes() item=display key=key}
                                                    <option value="{$key}" {if $unit->type == $key}selected{/if}>{$display}</option>
                                                {/foreach}
                                            </select>
                                            <small>If you change the type of this unit, all additional info listed below will be deleted.</small>
                                        </dd>
                                    </dl>

                                    <dl>
                                        <dt>
                                            <label>Actions</label>
                                        </dt>
                                        <dd>
                                            <button class="btn btn-default btn-sm">Manage Positions</button>
                                            <button class="btn btn-default btn-sm">Manage Members</button>
                                            <button class="btn btn-danger btn-sm">Delete Unit</button>
                                        </dd>
                                    </dl>

                                    <div class="formSubmit">
                                        <button type="submit" class="btn btn-primary btn-3d">Save changes</button>
                                        {@SECURITY_TOKEN_INPUT_TAG}
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>

        <div class="formSubmit">
            <button type="submit" class="btn btn-secondary btn-flat">Add new unit</button>
            {@SECURITY_TOKEN_INPUT_TAG}
        </div>

    </div>

    {include file='footer' skipBreadcrumbs=true}
</body>
</html>