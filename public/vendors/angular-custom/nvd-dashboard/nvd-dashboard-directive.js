angular.module('nvdDashboard', [
    'toaster',
    'ui.bootstrap',
    'xeditable',
    'gridster',
    'CustomAngular'
]).directive('nvdDashboard', function (nvdDashboardService) {
    return {
        restrict: 'E',
        templateUrl: '/vendors/angular-custom/nvd-dashboard/nvd-dashboard.html',
        scope: {
            config: '=',
            parentLoader:'@'
        },
        link: function (scope, elem, attrs) {
            var service = scope.service = nvdDashboardService;
            service.init(scope.config);
            scope.$watch('service.config.tabs', service.saveConfig, true);
        }
    };
});
angular.module('nvdDashboard').factory('nvdDashboardService', function ($http, toaster, $timeout, $q) {
    var service = {
        config: {
            tabs: [
                {
                    title: 'Dashboard',
                    numWidgets: 0,
                    widgets: []
                }
            ],
            syncGetUrl: null,
            syncPostUrl: null,
            gridsterOpts: {}
        },
        loadingConfig: false,
        pendingRequests: [],
        ongoingRequest: null,
        activeTab: null,
        defaultConfig: {}
    };

    service.init = function (config) {
        service.loadingConfig = true;
        service.defaultConfig = angular.copy(service.config);
        if (config && config.syncGetUrl) {
            angular.merge(service.defaultConfig, config);
            $http.get(config.syncGetUrl).then(function (res) {
                var configToApply = (res.data && res.data.tabs)? res.data : service.defaultConfig;
                service.applyConfig(configToApply);
            }).catch(function (res) {
                toaster.pop('error', 'Error while loading dashboard config', res.data);
            }).then(function () {
                service.loadingConfig = false;
            });
        } else {
            service.applyConfig(service.defaultConfig);
            service.loadingConfig = false;
        }
    };

    service.applyConfig = function (config) {
        angular.merge(service.config, config);
        service.activeTab = 0;

        for (var i = 0; i < service.config.tabs.length; i++) {
            var tab = service.config.tabs[i];
            tab.numWidgets = tab.widgets.countWhere(function (widget) {
                return widget.enabled;
            });
        }
    };

    service.reset = function () {
        if (confirm('Are you sure to load the default configuration?')) {
            service.applyConfig(service.defaultConfig);
        }
    };

    service.addWidget = function (widget, tab) {
        widget.enabled = true;
        tab.numWidgets ++;
    };

    service.removeWidget = function (widget, tab) {
        widget.enabled = false;
        tab.numWidgets --;
    };

    service.addTab = function () {
        var tab = {
            title: 'Dashboard-'+ (service.config.tabs.length + 1),
            numWidgets: 0,
            widgets: []
        };
        var widgets = service.config.tabs[0].widgets;
        for (var i = 0; i < widgets.length; i++) {
            var widget = angular.extend({}, widgets[i]);
            widget.enabled = false;
            tab.widgets.push(widget);
        }
        service.config.tabs.push(tab);
    };

    service.removeTab = function (tab) {
        service.config.tabs.remove(tab);
    };

    service.saveConfig = function () {
        if (service.loadingConfig) return;

        // clear all pending requests
        for (var i = 0; i < service.pendingRequests.length; i++) {
            var promise = service.pendingRequests[i];
            $timeout.cancel(promise);
        }
        service.pendingRequests = [];

        // make request
        service.savingConfig = true;
        var req = $timeout(function () {
            // cancel previous ongoing request
            if (service.ongoingRequest) {
                service.canceller.resolve();
            }
            // make new request
            service.canceller = $q.defer();
            var data = {config: service.config};
            var url = service.config.syncPostUrl;
            if (!url) {
                service.savingConfig = false;
                return;
            }
            service.ongoingRequest = $http.post(url, data, {timeout: service.canceller}).then(function (res) {
                console.log('config saved');
            }).catch(function (res) {
                toaster.pop('error', 'Error while saving dashboard config', res.data);
            }).then(function () {
                service.ongoingRequest = null;
                service.savingConfig = false;
            });
        }, 3000);
        service.pendingRequests.push(req);
    };

    return service;
});

angular.module('nvdDashboard').directive('nvdDashboardWidget', function (nvdDashboardService) {
    return {
        restrict: 'EA',
        templateUrl: '/vendors/angular-custom/nvd-dashboard/nvd-dashboard-widget.html',
        scope: {
            widget: '=',
            tab: '='
        },
        link: function (scope, elem, attrs) {
            var service = scope.service = nvdDashboardService;
        }
    };
});