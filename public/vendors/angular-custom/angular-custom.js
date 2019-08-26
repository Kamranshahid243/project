(function () {
    angular.module('CustomAngular', ['toaster']).filter('month', MonthFilter);

    function MonthFilter() {
        return function (input, format) {
            var MonthsFull = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            var MonthsShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            if (parseInt(input).isBetween(1, 12)) {
                if (format == 'short')
                    return MonthsShort[input - 1];
                return MonthsFull[input - 1];
            }

            return "";
        }
    }

    angular.module('CustomAngular').filter('nvdDate', function ($filter) {
        var standardDateFilterFn = $filter('date');
        return function (dateToFormat, format, timeZone) {
            dateToFormat = Date.parse(dateToFormat);
            return standardDateFilterFn(dateToFormat, format, timeZone);
        };
    });
})();
(function () {
    'use strict';
    var app = angular.module("CustomAngular");

    app.component('croppie', {
        bindings: {
            src: '<',
            ngModel: '=',
            options: '<'
        },
        controller: function ($scope, $element) {
            var ctrl = this;

            var options = angular.extend({
                viewport: {
                    width: 200,
                    height: 200
                }
            }, ctrl.options);

            options.update = function () {
                c.result('canvas').then(function (img) {
                    $scope.$apply(function () {
                        ctrl.ngModel = img;
                    });
                });
            };

            var c = new Croppie($element[0], options);

            ctrl.$onChanges = function (changesObj) {
                var src = changesObj.src && changesObj.src.currentValue;
                if (src) {
                    // bind an image to croppie
                    c.bind({
                        url: src
                    });
                }
            };
        }
    });

    app.directive('profilePic', function ($http, toaster) {
        return {
            restrict: 'EA',
            templateUrl: '/vendors/angular-custom/profile-pic-template.html',
            scope: {
                ppSrc: '@', // src of the pp image to show
                ppBeforeSave: '&',
                ppUploadTo: '@' // url to post data to
            },
            link: function (scope, elem, attrs) {
                scope.cropped = {
                    source: scope.ppSrc,
                    image: scope.ppSrc
                };
                scope.saving = false;
                scope.showPicSelector = false;

                elem.find('.pp-img').on('click', function () {
                    var input = document.createElement('input');
                    input.type = "file";
                    input.accept = "image/*";
                    // Assign blob to component when selecting a image
                    $(input).on('change', function () {
                        var input = this;
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                // bind new Image to Component
                                scope.$apply(function () {
                                    scope.cropped.previousImage = scope.cropped.image;
                                    scope.cropped.source = e.target.result;
                                    scope.showPicSelector = true;
                                });
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    });
                    input.click();
                });

                scope.save = function () {
                    if (scope.saving) return;
                    scope.saving = true;
                    var data = {img: scope.cropped.image};
                    scope.ppBeforeSave({$data: data});
                    $http.post(scope.ppUploadTo, data).then(function (res) {
                        toaster.pop('success', '', res.data);
                        scope.showPicSelector = false;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while saving picture', res.data);
                    }).then(function () {
                        scope.saving = false;
                    });
                };

                scope.cancel = function () {
                    if (scope.cropped.previousImage) scope.cropped.image = scope.cropped.previousImage;
                    scope.showPicSelector = false;
                };
            }
        };
    });

    app.directive('uiSelectUrl', function ($http, toaster, $parse) {
        return {
            require: 'uiSelect',
            link: function (scope, element, attrs, $select) {
                var url = attrs.uiSelectUrl;
                var remoteDataModel = $parse(attrs.remoteDataModel);
                $select.$loadingData = true;
                return $http.get(url, {cache: true}).then(function (res) {
                    $select.$remoteData = res.data;
                    if (remoteDataModel.assign) {
                        remoteDataModel.assign(scope, res.data);
                    }
                }).catch(function (res) {
                    toaster.pop('error', 'Error while loading remote data', res.data);
                }).then(function () {
                    $select.$loadingData = false;
                });
            }
        };
    });

    app.directive('focusFlag', ['$timeout', '$parse', function ($timeout, $parse) {
        return {
            link: function (scope, element, attrs) {
                var model = $parse(attrs.focusFlag);
                scope.$watch(model, function (value) {
                    if (value === true) {
                        element[0].focus();
                        // ui select focuses using focus-on
                        if (attrs.focusOn) {
                            scope.$broadcast(attrs.focusOn);
                        }
                    }
                });
                // on blur event:
                element.bind('blur', function () {
                    model.assign(scope, false);
                });
            }
        };
    }]);

    app.directive('uibDatepickerPopup', function () {
        return {
            require: ['?uibDatepickerPopup'],
            link: function ($scope, $elem, $attrs) {
                var iScope = angular.element($elem).isolateScope();
                $elem.on('click', function () {
                    iScope.$apply(function () {
                        iScope.isOpen = true;
                    });
                });
            }
        };
    });

    app.factory('TagService', function ($http, $q, toaster) {
        var tag = {};

        tag.onTagAdding = function ($url, $tag) {
            var d = $q.defer();
            $http.post($url, $tag).then(
                function (response) {
                    var data = response.data;
                    if (data.hasOwnProperty('id'))
                        $tag.id = data.id;
                    toaster.pop('success', '', "Successfully added.");
                    d.resolve(true);
                },
                function (response) {
                    toaster.pop('error', '', response.data);
                    d.resolve(false);
                }
            );
            return d.promise;
        };

        tag.onTagRemoving = function ($url) {
            var d = $q.defer();
            $http.delete($url).then(
                function (response) {
                    toaster.pop('info', '', response.data);
                    d.resolve(true);
                },
                function (response) {
                    toaster.pop('error', '', response.data);
                    d.resolve(false);
                }
            );
            return d.promise;
        };

        return tag;
    });

    angular.module("CustomAngular").factory('PageState', PageState);

    function PageState() {
        var state = {};

        state.params = {
            sort: 'id',
            sortType: 'asc',
            perPage: 10,
            page: 1
        };

        state.sortBy = function (column) {
            if (column == state.params.sort)
                state.params.sortType = (state.params.sortType == 'asc') ? 'desc' : 'asc';
            else {
                state.params.sort = column;
                state.params.sortType = 'asc';
            }
        };

        return state;
    }

    app.factory('socketIo', function ($rootScope) {
        var service = {};
        service.init = function (server) {
            service.socket = io(server);
        };
        service.bind = function (event, callback) {
            service.socket.on(event, function (data) {
                $rootScope.$apply(function () {
                    callback(data);
                });
            });
        };
        return service;
    });

    app.directive('httpRequest', function ($http, toaster) {
        return {
            restrict: 'A',
            scope: {
                method: '@httpRequest',
                url: '@url',
                data: '=data',
                onSuccess: '&onSuccess',
                onError: '&onError'
            },
            link: function (scope, elem, attrs) {
                elem.click(function () {
                    if (!scope.url || !scope.data) {
                        toaster.pop('error', 'Error', 'No data to post.');
                        return;
                    }

                    var prevText = elem.text();
                    elem.text('Working...');
                    elem.attr('disabled', 'disabled');

                    $http({
                        method: scope.method,
                        url: scope.url,
                        data: scope.data
                    })
                        .then(function (res) {
                            toaster.pop('success', 'Success', res.data);
                            scope.onSuccess({$response: res});
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error', res.data);
                            scope.onError({$response: res});
                        })
                        .then(function () {
                            elem.text(prevText);
                            elem.removeAttr('disabled');
                        });
                });
            }
        };
    });
})();
/**
 * Created by  Naveed-ul-Hassan Malik on 8/27/2015.
 */
(function () {
    var app = angular.module('CustomAngular');

    app.directive('filterBtn', function ($http, toaster) {
        return {
            restrict: 'E',
            transclude: true,
            templateUrl: '/vendors/angular-custom/filter-btn.html?v=2019.05.23',
            scope: {
                fieldLabel: '@', // label to be displayed
                fieldName: '@', // name to be sent to onChange() (to the server e.g.)
                optionsUrl: '@', // url to fetch options from
                optionLabelField: '@', // field to be displayed for an option
                optionValueField: '@', // field whose value is to be set for the selected option
                isDateFilter: '=?', //Enable to show date range filter
                searchField: '=?',  //Show search field (passing true will show text field)
                options: '=options', //will be preferred over optionsUrl
                model: '=model'
            },
            controller: function ($scope, $element, $attrs, $filter) {
                $scope.searchField = angular.isDefined($scope.searchField) ? $scope.searchField : false;

                $scope.selectedDateFilter = '';
                $scope.selectedDateValues = {startDate: null, endDate: null};
                $scope.dateFilterOptions = [
                    'Today', 'This Week', 'Last 2 Weeks', 'This Month', 'Last 1 Month', 'Custom Date Range',
                ];
                $scope.handleDateFilter = function (filter, $event) {
                    $scope.selectedDateFilter = filter;
                    var startDate = new Date();
                    var endDate = new Date();
                    switch (filter) {
                        case 'Today':
                            break;
                        case 'This Week':
                            startDate.setDate(startDate.getDate() - 7);
                            break;
                        case 'Last 2 Weeks':
                            startDate.setDate(startDate.getDate() - 14);
                            break;
                        case 'This Month':
                            startDate.setDate(1);
                            break;
                        case 'Last 1 Month':
                            startDate.setMonth(startDate.getMonth() - 1);
                            break;
                        case 'Custom Date Range':
                            $event.stopPropagation();
                            return;
                            break;
                        default:
                            return;
                    }
                    $scope.selectedDateValues = {
                        startDate: startDate,
                        endDate: endDate,
                    };
                };
                $scope.$watch('selectedDateValues', function () {
                    if (!$scope.model) {
                        $scope.model = {};
                    }
                    if ($scope.selectedDateValues.startDate || $scope.selectedDateValues.endDate) {
                        $scope.model[$scope.fieldName] = {
                            startDate: $scope.selectedDateValues.startDate ? $filter('date')($scope.selectedDateValues.startDate, 'yyyy-MM-dd') : '',
                            endDate: $scope.selectedDateValues.endDate ? $filter('date')($scope.selectedDateValues.endDate, 'yyyy-MM-dd') : '',
                        };
                        return;
                    }
                    $scope.model[$scope.fieldName] = null;
                }, true);
            },
            link: function (scope, elem, attrs) {
                scope.filterApplied = function () {
                    return scope.model[scope.fieldName] !== '' && scope.model[scope.fieldName] !== null
                };
                scope.resetFilter = function () {
                    scope.setFilter('');
                    if (scope.isDateFilter) {
                        scope.selectedDateFilter = null;
                        scope.selectedDateValues = {startDate: null, endDate: null};
                    }
                };
                scope.setFilter = function (value) {
                    if (!scope.model) {
                        scope.model = {};
                    }
                    scope.model[scope.fieldName] = value;
                };

                scope.setSort = function (value) {
                    if (!scope.model) {
                        scope.model = {};
                    }
                    scope.model.sort = scope.fieldName;
                    scope.model.sortType = value;
                };

                scope.getSortDir = function () {
                    var filters = scope.model;
                    if (!filters || !filters.sort || filters.sort != scope.fieldName)
                        return "";
                    return filters.sortType;
                };

                scope.loadOptions = function () {
                    if (!scope.optionsUrl || scope.options.length) return;

                    return $http.get(scope.optionsUrl, {cache: true})
                        .then(function (response) {
                            scope.options = response.data;
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while loading filter options for ' + scope.fieldLabel, res.data);
                        });
                };
                scope.loadOptions();
            }
        };
    });

    app.directive('moveOnMouseOver', function () {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs) {
                elem.bind('mouseenter', function () {
                    var domElement = elem[0];
                    if (domElement.style.left !== '0px') { // element is on right side
                        domElement.style.left = '0px';
                        domElement.style.right = 'auto';
                        domElement.style.borderRadius = '0 0 0.125em 0';
                    } else {
                        domElement.style.left = 'auto';
                        domElement.style.right = 0;
                        domElement.style.borderRadius = '0 0 0 0.125em';
                    }
                });
            }
        };
    });

    app.directive('bulkAssigner', function ($http, toaster) {
        return {
            restrict: 'E',
            transclude: true,
            templateUrl: '/vendors/angular-custom/bulk-assigner.html',
            controllerAs: 'bulkAssigner',
            scope: {
                target: '=target',
                extraDataToPost: '=?',
                onSuccess: '&onSuccess',
                url: '@'
            },
            controller: function ($scope, $element, $attrs) {
                var bulkAssigner = this;
                bulkAssigner.fields = [];
                bulkAssigner.selectedField = null;
                bulkAssigner.assigning = false;
                bulkAssigner.selectedItems = function () {
                    return $scope.target.filter(function (item) {
                        return item.$selected;
                    });
                };

                bulkAssigner.selectedItemsCount = function () {
                    return bulkAssigner.selectedItems().length;
                };

                bulkAssigner.assign = function (field) {
                    // get all the $selected items
                    var selectedItems = bulkAssigner.selectedItems();

                    // don't proceed if nothing is $selected
                    if (!selectedItems.length) {
                        toaster.pop('error', 'Error while assigning data', 'Please select some records first.');
                        return;
                    }

                    // make request
                    bulkAssigner.assigning = true;
                    $http.post($scope.url, {field: field, items: selectedItems, params: $scope.extraDataToPost})
                        .then(function (res) {
                            toaster.pop('success', '', res.data);
                            selectedItems.forEach(function (item) {
                                item[field.name] = field.value;
                            });
                            $scope.onSuccess({$response: res, $field: bulkAssigner.selectedField});
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while assigning data', res.data);
                        })
                        .then(function () {
                            bulkAssigner.assigning = false;
                        });
                };
            }
        };
    });

    app.directive('bulkAssignerField', function () {
        return {
            restrict: 'E',
            transclude: true,
            templateUrl: '/vendors/angular-custom/bulk-assigner-field.html',
            require: '^^bulkAssigner',
            scope: {
                field: '=field'
                /*
                 * field = {
                 name: scope.name,
                 label: scope.label,
                 value: scope.value,
                 }
                 * */
            },
            link: function (scope, elem, attrs, bulkAssigner) {
                scope.bulkAssigner = bulkAssigner;
                if (!bulkAssigner.fields.hasItem(scope.field))
                    bulkAssigner.fields.push(scope.field);
            }
        };
    });

    app.directive('bulkAssignerToggleAll', function () {
        return {
            restrict: 'E',
            templateUrl: '/vendors/angular-custom/bulk-assigner-toggle-all.html',
            scope: {
                target: '=target'
            },
            link: function (scope, elem, attrs) {
                scope.selectedItems = function () {
                    return scope.target.filter(function (item) {
                        return item.$selected;
                    });
                };

                scope.selectedItemsCount = function () {
                    return scope.selectedItems().length;
                };

                scope.allSelected = false;

                scope.toggleAll = function () {
                    scope.allSelected = !scope.allSelected;
                    scope.target.forEach(function (item) {
                        item.$selected = scope.allSelected;
                    });
                };
            }
        };
    });

    app.directive('bulkAssignerCheckbox', function () {
        return {
            restrict: 'E',
            templateUrl: '/vendors/angular-custom/bulk-assigner-checkbox.html',
            scope: {
                target: '=target'
            },
            link: function (scope, elem, attrs) {
            }
        };
    });

    app.directive('bulkAssignerDeleteBtn', function ($http, toaster) {
        return {
            restrict: 'E',
            templateUrl: '/vendors/angular-custom/bulk-assigner-delete-btn.html',
            scope: {
                target: '=target',
                url: '@'
            },
            link: function (scope, elem, attrs) {
                scope.deleting = false;

                scope.selectedItems = function () {
                    if (scope.target) {
                        return scope.target.filter(function (item) {
                            return item.$selected;
                        });
                    }
                    return [];

                };

                scope.selectedItemsCount = function () {
                    return scope.selectedItems().length;
                };

                scope.delete = function () {
                    if (!window.confirm("Are you sure you want to delete the selected items?"))
                        return;

                    var selectedItems = scope.selectedItems();
                    scope.deleting = true;
                    return $http.post(scope.url, {items: selectedItems})
                        .then(function (res) {
                            toaster.pop('success', '', res.data);
                            selectedItems.forEach(function (item) {
                                scope.target.remove(item);
                            });
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while deleting items', res.data);
                        })
                        .then(function () {
                            scope.deleting = false;
                        });
                };

            }
        };
    });

    app.directive('toCsv', function () {
        return {
            restrict: 'A',
            scope: {
                data: '=toCsv',
                csvFileName: '@csvFileName',
                csvFields: '=csvFields'
            },
            link: function (scope, element, attrs) {
                function processRow(row) {
                    var finalVal = '';
                    for (var j = 0; j < row.length; j++) {
                        var innerValue = row[j] === null ? '' : row[j].toString();
                        if (row[j] instanceof Date) {
                            innerValue = row[j].toLocaleString();
                        }
                        var result = innerValue.replace(/"/g, '""');
                        if (result.search(/("|,|\n)/g) >= 0)
                            result = '"' + result + '"';
                        if (j > 0)
                            finalVal += ',';
                        finalVal += result;
                    }
                    return finalVal + '\n';
                };

                // logic for the export functionality
                function downloadCsv(filename, csvString) {
                    var blob = new Blob([csvString], {type: 'text/csv;charset=utf-8;'});
                    if (navigator.msSaveBlob) { // IE 10+
                        navigator.msSaveBlob(blob, filename);
                    } else {
                        var link = document.createElement("a");
                        if (link.download !== undefined) { // feature detection
                            // Browsers that support HTML5 download attribute
                            var url = URL.createObjectURL(blob);
                            link.setAttribute("href", url);
                            link.setAttribute("download", filename);
                            link.style.visibility = 'hidden';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                }

                // variables
                var csvFileName = scope.csvFileName || 'csv-data.csv';
                var csvFields = scope.csvFields;
                // bind to click event
                element.bind('click', function () {
                    var csvString = '';
                    // prep headers
                    var headerRow = [];
                    csvFields.forEach(function (field) {
                        headerRow.push(field.label);
                    });
                    csvString += processRow(headerRow);
                    // prep rows
                    for (var i = 0; i < scope.data.length; i++) {
                        var obj = scope.data[i];
                        var row = [];
                        csvFields.forEach(function (field) {
                            row.push(obj[field.name]);
                        });
                        csvString += processRow(row);
                    }

                    downloadCsv(csvFileName, csvString);
                });
            }
        }
    });

    app.directive('toExcel', function ($window) {
        return {
            restrict: 'A',
            scope: {
                filename: '@toExcel',
                tableSelector: '@'
            },
            link: function (scope, elem, attrs) {
                var uri = 'data:application/vnd.ms-excel;base64,',
                    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                    base64 = function (s) {
                        return $window.btoa(unescape(encodeURIComponent(s)));
                    },
                    format = function (s, c) {
                        return s.replace(/{(\w+)}/g, function (m, p) {
                            return c[p];
                        })
                    };
                elem.click(function () {
                    var table = $(scope.tableSelector),
                        ctx = {worksheet: scope.filename, table: table.html()},
                        href = uri + base64(format(template, ctx));
                    location.href = href;
                });
            }
        };
    });

    app.directive('remoteSelect', function ($http) {
        return {
            restrict: 'E',
            templateUrl: '/vendors/angular-custom/remote-select.html',
            scope: {
                url: '@url',
                labelField: '@labelField',
                valueField: '@valueField',
                ngModel: '=ngModel',
                onChange: '&onChange',
                placeholder: '@placeholder'
            },
            link: function (scope, elem, attrs) {
                scope.options = [];

                scope.load = function () {
                    $http.get(scope.url, {cache: true}).then(
                        function (response) {
                            scope.options = response.data;
                        }
                    );
                };

                scope.load();

                scope.handleChange = function (selected) {
                    scope.onChange({$selectedValue: selected});
                }
            }
        };
    });

    app.directive('nEditable', function ($http, $q) {
        return {
            restrict: 'E',
            templateUrl: '/vendors/angular-custom/n-editable.html?v=2019-03-27',
            scope: {
                type: '@type',
                name: '@name',
                value: '=value',
                url: '@url',
                onSuccess: '&onSuccess',
                ddOptionsUrl: '@ddOptionsUrl', // for select only
                ddOptions: '=ddOptions', // for select only (will be preferred over ddOptionsUrl)
                ddValueField: '@ddValueField', // for select only
                ddLabelField: '@ddLabelField', // for select only
                charLimit: '@' // for textarea only
            },
            link: function (scope, elem, attrs) {
                scope.options = scope.ddOptions || [];
                scope.selectedOption = {};
                if (scope.type == 'date' && typeof scope.value == 'string')
                    scope.value = Date.fromStr(scope.value);

                var updateSelectedOption = function () {
                    scope.selectedOption = scope.options.findOne(function (option) {
                        return option[scope.ddValueField] == scope.value;
                    });
                };

                scope.loadOptions = function () {
                    if (!scope.options.length && scope.ddOptionsUrl) {
                        return $http.get(scope.ddOptionsUrl, {cache: true}).then(
                            function (response) {
                                scope.options = response.data;
                            }
                        );
                    }
                    return null;
                };

                scope.save = function (currentValue) {
                    if (scope.type == 'date')
                        currentValue = currentValue.mySqlFormat();

                    var data = {
                        name: scope.name,
                        value: currentValue
                    };
                    var d = $q.defer();
                    $http.put(scope.url, data).then(function (response) {
                        scope.value = currentValue;
                        scope.onSuccess({$response: response});
                        d.resolve(true);
                    }).catch(function (response) {
                        d.resolve(response.data);
                    });
                    return d.promise;
                };
                scope.$watchGroup(['value', 'options'], updateSelectedOption);
                scope.loadOptions();
            }
        };
    });

    app.directive('onEnter', function ($parse) {
        return function (scope, element, attrs) {
            var fn = $parse(attrs.onEnter);
            element.bind('keypress', function (event) {
                if (event.which == 13) {
                    scope.$apply(function () {
                        event.preventDefault();
                        fn(scope, {$event: event});
                    });
                }
            });
        };
    });

    app.directive('ngRightClick', function ($parse) {
        return function (scope, element, attrs) {
            var fn = $parse(attrs.ngRightClick);
            element.bind('contextmenu', function (event) {
                scope.$apply(function () {
                    event.preventDefault();
                    fn(scope, {$event: event});
                });
            });
        };
    });

    app.directive('deleteBtn', function ($http) {
        return {
            restrict: 'E',
            transclude: true,
            scope: {
                action: '@action',
                onSuccess: '&onSuccess',
                onError: '&onError'
            },
            templateUrl: '/vendors/angular-custom/nvd-delete-btn.html',
            controller: function ($scope, $element, $attrs) {
                $scope.beforeSend = function () {
                    return {_method: 'DELETE'};
                };
            }
        };
    });

    app.directive('pagination', function ($http) {
        return {
            restrict: 'E',
            scope: {
                state: '=state', // state object for binding
                recordsInfo: '=recordsInfo' //info like total,next_page_url etc returned by the server
            },
            templateUrl: '/vendors/angular-custom/pagination.html',
            link: function ($scope, $element, $attrs) {
                var state = $scope.state;
                $scope.recordsFrom = function () {
                    return ((state.params.page - 1) * state.params.perPage) + 1;
                };

                $scope.recordsTo = function () {
                    var recsTo = state.params.page * state.params.perPage;
                    if (recsTo > $scope.recordsInfo.total)
                        recsTo = $scope.recordsInfo.total;
                    return recsTo;
                };

            }
        };
    });

    app.directive('sorter', function () {
        return {
            restrict: 'E',
            transclude: true,
            scope: {
                state: '=state',
                field: '@field'
            },
            templateUrl: '/vendors/angular-custom/sorter.html',
            controller: function ($scope, $element, $attrs) {
            }
        };
    });

    app.directive('nvdForm', function ($http, toaster) {
        return {
            restrict: 'E',
            transclude: true,
            scope: {
                model: '=model',
                formAttrs: '=formAttrs',
                retainValues: '=retainValues',
                beforeSend: '&beforeSend',
                onSuccess: '&onSuccess',
                onError: '&onError'
            },
            templateUrl: '/vendors/angular-custom/nvd-form.html',
            controller: function ($scope, $element, $attrs) {
                var ctrl = this;
                ctrl.model = $scope.model;
                $scope.loading = false;

                // apply attributes
                var form = $element.find('form');
                var attrs = $scope.formAttrs;
                for (var attr in attrs) {
                    if (attrs.hasOwnProperty(attr) && typeof attrs[attr] == 'string')
                        form.attr(attr, attrs[attr]);
                }

                $scope.saveForm = function () {
                    $scope.loading = true;
                    delete ctrl.model.errors;
                    $scope.errorResponse = "";
                    var data = $scope.beforeSend();
                    if (!data) data = $scope.model;
                    return $http.post($attrs.action, data)
                        .then(function (response) {
                            if (!$scope.retainValues) $scope.model = {};

                            var data = response.data;
                            if (typeof data == 'string')
                                toaster.pop('success', 'Success', data);

                            $scope.onSuccess({$response: response});
                        })
                        .catch(function (response) {
                            var data = response.data;
                            if (typeof data == 'string')
                                toaster.pop('error', 'Error submitting the form', data);
                            else
                                ctrl.model.errors = data;

                            $scope.onError({$response: response});
                        })
                        .then(function () {
                            $scope.loading = false;
                        });
                };
            }
        };
    });

    app.directive('nvdFormElement', function () {
        return {
            restrict: 'E',
            require: '^^nvdForm',
            transclude: true,
            scope: {},
            templateUrl: '/vendors/angular-custom/nvd-form-element.html',
            link: function (scope, elm, attrs, nvdFormCtrl) {
                scope.errors = null;
                scope.nvdFormCtrl = nvdFormCtrl;
                scope.$watch('nvdFormCtrl.model.errors', function (value) {
                    if (value && value.hasOwnProperty([attrs.field]))
                        scope.errors = value[attrs.field];
                    else
                        scope.errors = "";
                });
            }
        };
    });

    app.directive('showLoader', function () {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs) {
                var loaderMarkup = '<div class="loader overlay"><span class="spinner"><i class="fa fa-sync-alt fa-spin"></i></span></div>';
                scope.$watch(attrs.showLoader, function (value) {
                    if (value) {
                        elem.addClass('loader-parent');
                        elem.append(loaderMarkup);
                    }
                    else {
                        elem.children(".loader").remove();
                    }
                });
            }
        };
    });

    app.directive('nvdQrCode', QrCodeDirective);

    function QrCodeDirective() {
        return {
            restrict: 'E',
            template: '<div id="nvd-qr-code"></div>',
            scope: {
                content: '=content'
            },
            link: function (scope, elem, attrs) {
                scope.$watch('content', function () {
                    var content = scope.content;
                    if (typeof content !== 'string')
                        content = JSON.stringify(scope.content);
                    new QRCode(elem.children().eq(0)[0], content);
                });
            }
        };
    }

    app.directive('domToImg', function () {
        return {
            restrict: 'EA',
            scope: {
                domToImg: '@', // dom id of the element
                fileName: '=' // downloaded filename
            },
            link: function ($scope, elem) {
                elem.on('click', function () {
                    var node = document.getElementById($scope.domToImg);
                    domtoimage.toPng(node).then(function (dataUrl) {
                        var link = document.createElement('a');
                        link.download = $scope.fileName;
                        link.href = dataUrl;
                        link.click();
                    }).catch(function (error) {
                        console.error('oops, something went wrong!', error);
                    });
                });
            }
        };
    });

    app.directive('newSms', function ($http, toaster) {
        return {
            restrict: 'EA',
            scope: {
                text: '=text',
                url: '@'
            },
            templateUrl: '/vendors/angular-custom/new-sms.html',
            link: function ($scope) {
                $scope.smsCount = -1;
                $scope.charsLeft = 0;
                $scope.maxLength = 459;
                var cutStrLength = 0,
                    s = {
                        cut: true,
                        maxSmsNum: 3,
                        interval: 400,
                        lengths: {
                            ascii: [160, 306, 459],
                            unicode: [70, 134, 201]
                        }
                    };

                $scope.updateSmsCount = function () {
                    if (!$scope.text) $scope.text = '';
                    var smsType,
                        smsLength = 0,
                        text = $scope.text,
                        smsCount = -1,
                        charsLeft = 0,
                        isUnicode = false;

                    for (var i = 0; i < text.length; i++) {
                        switch (text[i]) {
                            case "\n":
                            case "[":
                            case "]":
                            case "\\":
                            case "^":
                            case "{":
                            case "}":
                            case "|":
                            case "€":
                                smsLength += 2;
                                break;
                            default:
                                smsLength += 1;
                        }

                        if (text.charCodeAt(i) > 127 && text[i] != "€") isUnicode = true;
                    }

                    if (isUnicode) {
                        smsType = s.lengths.unicode;
                        $scope.maxLength = 201;
                    } else {
                        smsType = s.lengths.ascii;
                        $scope.maxLength = 459;
                    }

                    for (var sCount = 0; sCount < s.maxSmsNum; sCount++) {
                        cutStrLength = smsType[sCount];
                        if (smsLength <= smsType[sCount]) {
                            smsCount = sCount + 1;
                            charsLeft = smsType[sCount] - smsLength;
                            break
                        }
                    }

                    smsCount == -1 && (smsCount = s.maxSmsNum, charsLeft = 0);

                    $scope.smsCount = smsCount;
                    $scope.charsLeft = charsLeft;
                };

                $scope.$watch('text', $scope.updateSmsCount);
            }
        };
    });

})();
angular.module('CustomAngular').directive('nvdNgTree', function () {
    return {
        restrict: 'E',
        templateUrl: '/vendors/angular-custom/nvd-ng-tree.html',
        scope: {
            tree: '=tree'
        },
        link: function (scope, elem, attrs) {
        }
    };
});
angular.module('CustomAngular')
    .factory('NvdNgNodeService', function () {
        var Node = function (data) {
            this.id = null;
            this.label = "";
            this.children = null;
            this.parentId = null;
            this.checked = false;
            this.opened = false;
            this.hasCheckedChildren = false;

            for (var prop in data)
                this[prop] = data[prop];

            if (this.children) {
                this.children = Node.makeNodes(this.children);
                var parentId = this.id;
                this.children.forEach(function (node) {
                    node.parentId = parentId;
                });
            }
        };

        Node.makeNodes = function (items) {
            var collection = [];
            for (var $i = 0; $i < items.length; $i++) {
                collection.push(new Node(items[$i]));
            }
            return collection;
        };

        Node.prototype.toggleOpen = function () {
            this.opened = !this.opened;
        };

        Node.prototype.toggleChecked = function (collection) {
            this.setChecked(!this.checked);
            // update parent status
            this.updateParentCheckedStatus(collection);
        };

        Node.prototype.setChecked = function (value) {
            this.checked = value;
            if (!value) this.hasCheckedChildren = false;
            // toggle-check for all children
            var thisNode = this;
            if (this.children) {
                thisNode.children.forEach(function (childNode) {
                    childNode.setChecked(value);
                });
            }
        };

        Node.prototype.updateParentCheckedStatus = function (collection) {
            var thisNode = this;
            if (thisNode.parentId) {
                var parentNode = thisNode.getParent(collection);
                var allChecked = true;
                var someChecked = false;
                parentNode.children.forEach(function (childNode) {
                    childNode.checked ? someChecked = true : allChecked = false;
                    if (childNode.hasCheckedChildren)
                        someChecked = true;
                });
                parentNode.checked = allChecked;
                parentNode.hasCheckedChildren = someChecked;

                if (parentNode.parentId)
                    parentNode.updateParentCheckedStatus(collection);
            }
        };

        Node.prototype.getParent = function (collection) {
            var thisNode = this;
            var secondaryCollection = [];
            var result = collection.find(function (node) {
                if (node.children)
                    secondaryCollection = secondaryCollection.concat(node.children);
                return node.id == thisNode.parentId;
            });

            if (!result && secondaryCollection)
                return thisNode.getParent(secondaryCollection);

            return result;
        };

        // build the api and return it
        return Node;
    });
angular.module('CustomAngular')
    .factory('NvdNgTreeService', ['NvdNgNodeService', function (Node) {
        var Tree = function (items) {
            this.nodes = Node.makeNodes(items);
            this.updateChecked(this.nodes);
        };

        Tree.prototype.updateChecked = function (nodes) {
            var thisTree = this;
            nodes.forEach(function (node) {
                if (node.children && node.children.length)
                    thisTree.updateChecked(node.children);
                if (node.checked) {
                    node.updateParentCheckedStatus(thisTree.nodes);
                }
            });
        };

        Tree.prototype.getChecked = function () {
            return this.nodes.filter(function (node) {
                return node.checked || node.hasCheckedChildren;
            });
        };

        // build the api and return it
        return Tree;
    }]);

(function () {
    angular.module('CustomAngular')
        .filter('timeAgo', timeAgoFilter)
        .filter('count', countFilter)
        .filter('duration', durationFilter)
        .filter('words', wordsFilter) // converts amount in numbers to words
        .filter('ifDate', ifDateFilter)
        .filter('nl2br', newLineToBrFilter)
        .filter('_2space', underscoreToSpaceFilter)
        .filter('percent', percentFilter)
        .config(config);

    function config($httpProvider) {
        $httpProvider.interceptors.push(function ($q, $window) {
            return {
                request: function (config) {
                    if (config.method == "POST" || config.method == "PUT" || config.method == "DELETE") {
                        var token = document.getElementById('csrf-token').getAttribute('content');
                        var data = {
                            '_token': token
                        };
                        config.data = angular.extend(data, config.data);
                    }
                    return config;
                },
                responseError: function (response) {
                    if (typeof data == 'string' && response.data.match(/logged.*out/)) {
                        if ($window.location.href.match(/administrator/))
                            $window.location.href = '/administrator?logged-out=by-admin';
                        else
                            $window.location.href = '/?logged-out=by-admin';
                    }

                    return $q.reject(response);
                }
            };
        });
    }

    function timeAgoFilter() {
        return function (input, calculateDifference) {
            var seconds = parseInt(input);

            if (calculateDifference) {
                var time = Math.floor(Date.now() / 1000);
                seconds = (time > seconds) ? time - seconds : 0;
            }

            // if in invalid input is given
            if (!seconds && seconds !== 0) return input;

            // if less than a minute
            if (seconds < 5) return "Just now";
            if (seconds < 60) return seconds + " seconds ago";

            var output = "";
            // calculate hours
            if (seconds >= 3600) {
                var h = Math.floor(seconds / 3600);
                var theS = h > 1 ? 's' : '';
                output += h + " hour" + theS + ", ";
            }

            // calculate minutes
            var rem = seconds % 3600;
            var m = Math.floor(rem / 60);
            output += m + " minute";
            if (m > 1) output += "s";

            return output + ' ago';
        };
    }

    function durationFilter() {
        return function (input, format) {
            var seconds = parseInt(input);
            if (!seconds) {
                seconds = 0;
            }

            var h = Math.floor(seconds / 3600);
            if (h < 10) h = "0" + h;

            var rem = seconds % 3600;
            var m = Math.floor(rem / 60);
            if (m < 10) m = "0" + m;

            var s = rem % 60;
            if (s < 10) s = "0" + s;

            return format.replace(/\%h\%/, h).replace(/\%m\%/, m).replace(/\%s\%/, s);
        };
    }

    function countFilter() {
        return function (input, singular, plural) {
            if (!input) return "";

            if (!plural) plural = singular + 's';

            if (input == 1) return input + ' ' + singular;

            return input + ' ' + plural;
        };
    }

    function wordsFilter() {
        function isInteger(x) {
            return x % 1 === 0;
        }

        var th = ['', 'thousand', 'million', 'billion', 'trillion'];
        var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
        var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        function toWords(s) {
            s = s.toString();
            s = s.replace(/[\, ]/g, '');
            if (s != parseFloat(s)) return 'not a number';
            var x = s.indexOf('.');
            if (x == -1) x = s.length;
            if (x > 15) return 'too big';
            var n = s.split('');
            var str = '';
            var sk = 0;
            for (var i = 0; i < x; i++) {
                if ((x - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += tn[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    }
                    else if (n[i] != 0) {
                        str += tw[n[i] - 2] + ' ';
                        sk = 1;
                    }
                }
                else if (n[i] != 0) {
                    str += dg[n[i]] + ' ';
                    if ((x - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }


                if ((x - i) % 3 == 1) {
                    if (sk) str += th[(x - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
            if (x != s.length) {
                var y = s.length;
                str += 'point ';
                for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
            }
            return str.replace(/\s+/g, ' ');
        }

        return function (value) {
            if (value && isInteger(value))
                return toWords(value);
            return value;
        };
    }

    function ifDateFilter($filter) {
        return function (input, key, identifier) {
            if (key.indexOf('date') >= 0 || input instanceof Date || key == identifier) {
                return $filter('date')(input, 'mediumDate');
            } else {
                return input;
            }
        }
    }

    function newLineToBrFilter($sce) {
        return function (input) {
            return $sce.trustAsHtml(input.replace(/\n/g, "<br>"));
        }
    }

    function underscoreToSpaceFilter() {
        return function (input) {
            return input.split("_").join(" ");
        }
    }

    function percentFilter() {
        return function (num, den, precision) {
            if (den > 0) {
                var number = num / den * 100;
                return number.toFixed(precision);
            }

            return 0;
        };
    }
})();

