{userAwards assign='awards' userID=$userProfile->userID}
{counter name='counterCounter' assign=counterCounter print=false}

<div class="userAwards hidden-xs" id="awards-{$counterCounter}">
    {hascontent}
        <dl class="plain dataList">
            <dt><a href="http://clanunknownsoldiers.com/hqdev/search/?types%5B%5D=com.woltlab.wbb.post&amp;userID=1" class="">Awards</a></dt>
        </dl>

    {content}
    {foreach from=$awards item=tier}
        {counter name='displayedAwardCount'|concat:$counterCounter assign=awardCount print=false}
        {if $awardCount <= 9}
            <div class="col-md-4 nopadding award jsTooltip" data-delay="200" title="{$tier->getAward()->title}{$tier->levelSuffix}">
                <img src="{$tier->ribbonURL}" style="width:100%;">
            </div>
        {else}
            {counter name='moreAwardCount'|concat:$counterCounter assign=moreAwards print=false}
            {if $moreAwards|isset && $moreAwards == 1}
                <div class="col-md-12 hiddenAwards nopadding">
            {/if}
            <div class="col-md-4 additional award nopadding jsTooltip" data-delay="200" title="{$tier->getAward()->title}{$tier->levelSuffix}">
                <img src="{$tier->ribbonURL}" style="width:100%;">
            </div>
        {/if}
    {/foreach}
    {/content}

    {if $moreAwards|isset && $moreAwards > 0}
        </div>

        <div class="divider divider-style-4 divider-icon-xs" style="top:10px;">
            <a>
                <i class="fa fa-chevron-down"></i>
            </a>
            <p class="countLabel">(Show {#$moreAwards} more)</p>
            <p class="hideLabel">(Hide last {#$moreAwards})</p>
        </div>

        {assign var=moreAwards value=0}
    {/if}
    {/hascontent}
</div>

<script data-relocate="true">
    $(document).ready(function() {
        $("#awards-{$counterCounter}").on("click", ".divider a", function() {
            $("#awards-{$counterCounter} .hiddenAwards").slideToggle(250);
            $("#awards-{$counterCounter} .divider .fa").toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
            $("#awards-{$counterCounter} .divider .countLabel").toggle();
            $("#awards-{$counterCounter} .divider .hideLabel").toggle();
        });
    });
</script>