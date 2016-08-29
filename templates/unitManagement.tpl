{include file='documentHeader'}
<head>
    <title>{lang}wcf.page.personnel.management.unit{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
    {include file='header' title='wcf.page.personnel.management.unit.title'|language paddingBottom=30 light=true}

    <div class="container">
        {include file='userNotice'}

        {if $deleted|isset}
            <div class="alert alert-success">The unit has successfully been deleted.</div>
        {/if}

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
                            {assign var=positions value=$unit->getPositions()}
                            <form method="post" action="{link controller='UnitManagement'}{/link}">
                                <input type="hidden" name="unitID" value="{$unit->unitID}">

                                {if $success|isset && $unit->unitID == $activeAccordionID}
                                    <div class="alert alert-success">Your changes have been successfully saved.</div>
                                {/if}

                                <div class="well">
                                    <h4 class="big marginBottom">Current information</h4>

                                    <dl>
                                        <dt>Internal ID</dt>
                                        <dd>{$unit->unitID}</dd>
                                    </dl>

                                    <dl>
                                        <dt style="line-height:24px;">Hierarchy</dt>
                                        <dd>
                                            <ul class="breadcrumb no-style">
                                                {foreach from=$unit->getHierarchy() item=parent}<li>{$parent->name}</li>{/foreach}
                                            </ul>
                                        </dd>
                                    </dl>

                                    <dl>
                                        <dt style="line-height:24px;">Positions</dt>
                                        <dd>
                                            <ul class="list-inline comma-separated">
                                                {if $positions|count}
                                                    {foreach from=$positions item=position}
                                                        <li>{$position->title}</li>
                                                    {/foreach}
                                                {else}
                                                    <li>-</li>
                                                {/if}
                                            </ul>
                                        </dd>
                                    </dl>
                                </div>

                                <fieldset class="mediumMarginTop">

                                    <dl>
                                        <dt style="line-height:30px;">
                                            <label for="name">Name</label>
                                        </dt>
                                        <dd>
                                            <input type="text" id="name" name="name" value="{$unit->name}">
                                        </dd>
                                    </dl>

                                    <dl>
                                        <dt style="line-height:24px;">
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
                                        <dt style="line-height:24px;">
                                            <label for="type">Unit Type</label>
                                        </dt>
                                        <dd>
                                            <select name="type" id="type">
                                                {foreach from=$unit->supportedTypes() item=display key=key}
                                                    <option value="{$key}" {if $unit->type == $key}selected{/if}>{$display}</option>
                                                {/foreach}
                                            </select>
                                            <small>If you change the type of this unit, all additional data entered below will be deleted.</small>
                                        </dd>
                                    </dl>

                                    <dl>
                                        <dt style="line-height:30px;">
                                            <label>Actions</label>
                                        </dt>
                                        <dd>
                                            <button class="btn btn-default btn-sm" name="action-positions">Manage Positions</button>
                                            <button class="btn btn-default btn-sm" name="action-members">Manage Members</button>
                                            <button class="btn btn-danger btn-sm" name="action-delete">Delete Unit</button>
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

        <form method="post" action="{link controller='UnitManagement'}{/link}">
            <div class="formSubmit">
                <button type="submit" class="btn btn-secondary" name="action-new">Add new unit</button>
                {@SECURITY_TOKEN_INPUT_TAG}
            </div>
        </form>

    </div>

    {include file='footer' skipBreadcrumbs=true}
</body>
</html>