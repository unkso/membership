{if $action == 'edit'}
    <div id="avatarForm" class="container containerPadding tabMenuContent hidden">
        <fieldset>
            <legend>{lang}wcf.user.avatar{/lang}</legend>

            {foreach from=wcf\data\membership\Membership::getAllMembershipsForUser($user) item=membership}
                Membership
            {/foreach}
        </fieldset>
    </div>
{/if}