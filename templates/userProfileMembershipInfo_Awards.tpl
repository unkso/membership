{userAwards assign='awards' userID=$user->userID}

{if !$awards|count}
    <div class="alert alert-info">
        This member has not earned any awards so far.
    </div>
{/if}
{foreach from=$awards item=tier}
    <div class="row" style="margin-bottom:20px;">
        <div class="col-md-2 text-center">
            <img src="{$tier->ribbonURL}"><br>
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