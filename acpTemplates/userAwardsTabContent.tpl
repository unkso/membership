{if $action == 'edit'}
    <div id="userAwards" class="container containerPadding tabMenuContent hidden">

        <!-- List of awards -->
        <div id="templateTableContainer" class="tabularBox tabularBoxTitle marginTop">
            <header>
                <h2>This member's awards <span class="badge badgeInverse">{#$awards|count}</span></h2>
            </header>
            <table class="table">
                <thead>
                    <tr>
                        <th class="columnID columnIssuedID" colspan="2">{lang}wcf.global.objectID{/lang}</th>
                        <th class="columnTitle columnAwardName">{lang}wcf.user.option.category.awards.award{/lang}</th>
                        <th class="columnDate columnDate">{lang}wcf.user.option.category.awards.date{/lang}</th>

                        {event name='columnHeads'}
                    </tr>
                </thead>

                <tbody>
                {foreach from=$awards item=issue}
                    <tr class="jsTemplateRow">
                        <td class="columnIcon">
                            {if $canAssignAwards}
                                <span class="icon icon16 icon-pencil disabled" title="{lang}wcf.global.button.edit{/lang} (Not yet functional)"></span>
                                <span class="icon icon16 icon-remove disabled" title="{lang}wcf.global.button.delete{/lang} (Not yet functional)"></span>
                            {else}
                                <span class="icon icon16 icon-pencil disabled" title="{lang}wcf.global.button.edit{/lang}"></span>
                                <span class="icon icon16 icon-remove disabled" title="{lang}wcf.global.button.delete{/lang}"></span>
                            {/if}

                            {event name='rowButtons'}
                        </td>
                        <td class="columnID">{$issue->issuedAwardID}</td>
                        <td class="columnTitle columnAwardName">{$issue->getName()}</td>
                        <td class="columnDate columnDate">{$issue->date}</td>

                        {event name='columns'}
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>

    </div>
{/if}