{foreach from=$awards item=issue}
    {assign var='award' value=$issue->getAward()}

    <div class="row" style="margin-bottom:20px;">
        <div class="col-md-2 text-center">
            <img src="{$issue->getRibbonURL()}" style="margin-bottom:15px;"><br>
            {if $award->getMedalURL()}
                <img src="{$award->getMedalURL()}">
            {/if}
        </div>
        <div class="col-md-10">
            <h3 class="big">{$award->title}{if $issue->awardedNumber > 1}<small style="margin-left:10px;">(issued {$issue->awardedNumber} times)</small>{/if}</h3>

            <p class="marginTopSmall"><strong>Description:</strong></p>
            <p>{@$award->description}</p>

            <p class="marginTopSmall"><strong>Issue Reason:</strong></p>
            <p>{@$issue->description}</p>

            <p class="marginTopSmall"><strong>Issue Date:</strong></p>
            <p>{$issue->date}</p>
        </div>
    </div>
{/foreach}