{assign var=membership value=$clanmember->getCurrentMembership()}
{if $membership}
    <dl>
        <dt>Join Date</dt>
        <dd>{$membership->joinDate}</dd>
    </dl>
    Active Clan Member
{else}
    Not an active Clan Member
{/if}