{if $membership}
    <div class="heading heading-border heading-middle-border marginTop">
        <h3 class="big"><span class="inverted inverted-quaternary">Clan Membership</span> Information</h3>
    </div>

    <div class="tabs tabs-vertical tabs-left tabs-quaternary">
        <ul class="nav nav-tabs col-sm-3">
            <li class="active">
                <a href="#training" data-toggle="tab"><span class="fa fa-graduation-cap"></span> Training</a>
            </li>
            <li>
                <a href="#membership" data-toggle="tab"><span class="fa fa-group"></span> Membership</a>
            </li>
            <li>
                <a href="#awards" data-toggle="tab"><span class="fa fa-trophy"></span> Awards</a>
            </li>
            <li>
                <a href="#filerecords" data-toggle="tab"><span class="fa fa-book"></span> File records</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="training" class="tab-pane">
                {include file='userProfileMembershipInfo_Training'}
            </div>
            <div id="membership" class="tab-pane active">
                {include file='userProfileMembershipInfo_Membership'}
            </div>
            <div id="awards" class="tab-pane">
                {include file='userProfileMembershipInfo_Awards'}
            </div>
            <div id="filerecords" class="tab-pane">
                {include file='userProfileMembershipInfo_Files'}
            </div>
        </div>
    </div>
{/if}