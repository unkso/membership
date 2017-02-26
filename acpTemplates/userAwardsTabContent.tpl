{if $action == 'edit'}
    <script data-relocate="true">
        //<![CDATA[
        $(function() {
            new WCF.Action.Delete('wcf\\data\\award\\issued\\IssuedAwardAction', '.jsTemplateRow');
        });
        //]]>
    </script>

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
                        <th class="columnTitle columnNumber">{lang}wcf.user.option.category.awards.number{/lang}</th>
                        <th class="columnDate columnDate">{lang}wcf.user.option.category.awards.date{/lang}</th>

                        {event name='columnHeads'}
                    </tr>
                </thead>

                <tbody>
                {foreach from=$awards item=issue}
                    <tr class="jsTemplateRow">
                        <td class="columnIcon">
                            {if $canAssignAwards}
                                <a href="{link controller='EditGivenAward' id=$issue->issuedAwardID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 icon-pencil"></span></a>
                            {else}
                                <span class="icon icon16 icon-pencil disabled" title="{lang}wcf.global.button.edit{/lang}"></span>
                            {/if}

                            {if $canDeleteAwards}
                                <span class="icon icon16 icon-remove jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$issue->issuedAwardID}" data-confirm-message="{lang issuedAward=$issue}wcf.unkso.acp.award.delete.sure{/lang}"></span>
                            {else}
                                <span class="icon icon16 icon-remove disabled" title="{lang}wcf.global.button.delete{/lang}"></span>
                            {/if}

                            {event name='rowButtons'}
                        </td>
                        <td class="columnID">{$issue->issuedAwardID}</td>
                        <td class="columnTitle columnAwardName">{$issue->getAward()->title}</td>
                        <td class="columnNumber">{$issue->awardedNumber}</td>
                        <td class="columnDate">{$issue->date}</td>

                        {event name='columns'}
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>

    </div>
{/if}