{if $action == 'edit'}
    <div id="membershipForm" class="container containerPadding tabMenuContent hidden">
        {foreach from=$memberships item=membership}
            <fieldset>
                <legend>Member from {$membership->joinDate} - {if $membership->dischargeDate}{$membership->dischargeDate}{else}now{/if}</legend>

                <dl>
                    <dt><label>Join date</label></dt>
                    <dd>
                        <p>{$membership->joinDate}</p>
                        <small>That is {$membership->daysInClan()} days.</small>
                    </dd>
                </dl>

                {if $membership->dischargeDate}
                    <dl>
                        <dt><label>Discharge date</label></dt>
                        <dd>
                            <p>{$membership->dischargeDate}</p>
                        </dd>
                    </dl>

                    <dl>
                        <dt><label>Discharge type</label></dt>
                        <dd>
                            <p>{$membership->dischargeType}</p>
                        </dd>
                    </dl>

                {else}

                    <dl>
                        <dt><label>Current status</label></dt>
                        <dd>
                            <p>{$membership->currentStatus}</p>
                        </dd>
                    </dl>

                {/if}

                <dl>
                    <dt><label>{if $membership->dischargeDate}Rank at discharge{else}Current rank{/if}</label></dt>
                    <dd>
                        <p>{$membership->getRank()->prefix} ({$membership->getRank()->branch->name})</p>
                    </dd>
                </dl>

                {event name='membershipFields'}
            </fieldset>
        {/foreach}
    </div>
{/if}