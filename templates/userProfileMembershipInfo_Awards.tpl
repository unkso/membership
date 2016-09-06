{userAwards assign='awards' userID=$user->userID}

{foreach from=$awards item=tier}
<div class="row" style="margin-bottom:20px;">
    <div class="col-md-2 text-center">
        <img class="img-responsive" src="{$tier->ribbonURL}"><br>
        <img class="img-responsive" src="{$tier->getAward()->awardURL}">
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