<div show-loader="loadingRecords">
<div class="box-footer box-comments online-users-list">
    <div class="box-comment conversation-item"
         ng-repeat="admin in admins">
        <img class="img-circle img-sm" ng-src="@{{ admin.photo }}" alt="User Image">
        <div class="comment-text">
            <span class="username">
                @{{admin.name}}
                <span class="text-muted pull-right">
                    <i ng-if="admin.browserInfo.isDesktop" class="fa fa-desktop"></i>
                    <i ng-if="admin.browserInfo.isTablet" class="fa fa-tablet"></i>
                    <i ng-if="admin.browserInfo.isMobile" class="fa fa-mobile"></i>
                    @{{ admin.browserInfo.browserFamily }}
                    <span ng-if="admin.browserInfo.browserVersionMajor">
                        @{{admin.browserInfo.browserVersionMajor}}.@{{admin.browserInfo.browserVersionMinor}}
                    </span>
                    on @{{admin.browserInfo.platformName}}
                </span>
            </span>
            @{{admin.email}}
            <span class="pull-right">@{{admin.lastActive | timeAgo}} from @{{admin.ip}}</span>
        </div>
    </div>
</div>
</div>