{userAwards assign='awards' userID=$user->userID}

{if $awards|count}
    <div class="heading heading-border heading-middle-border marginTop">
        <h3 class="big"><span class="inverted inverted-quaternary">This member's</span> awards</h3>
    </div>

    {foreach from=$awards item=issue}
        {assign var='tier' value=$issue->getTier()}

        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-2 text-center">
                <img src="{$tier->ribbonURL}" style="margin-bottom:15px;"><br>
                {if $tier->getAward()->awardURL}
                    <img src="{$tier->getAward()->awardURL}">
                {/if}
            </div>
            <div class="col-md-10">
                <h3 class="big">{$tier->getAward()->title}{$tier->levelSuffix}</h3>

                <p class="marginTopSmall"><strong>Description:</strong></p>
                <p>{$tier->getAward()->description}</p>

                <p class="marginTopSmall"><strong>Issue Reason:</strong></p>
                <p>Reason</p>

                <p class="marginTopSmall"><strong>Issue Date:</strong></p>
                <p>Date</p>
            </div>
        </div>
    {/foreach}
{/if}