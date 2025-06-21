(function ($) {
    "use strict";

    const widgetDataTable = function ($scope, $) {

        var beforeFilter = $scope.find("tbody .tmpcoder-table-row"),
            itemsPerPage = +$scope.find('.tmpcoder-table-inner-container').attr('data-rows-per-page'),
            paginationListItems = $scope.find('.tmpcoder-table-custom-pagination-list-item'),
            initialRows = $scope.find('.tmpcoder-table-inner-container tbody tr'),
            table = $scope.find('.tmpcoder-table-inner-container tbody'),
            pageIndex, value, paginationIndex;

        // Table Custom Pagination
        if ('yes' === $scope.find('.tmpcoder-table-inner-container').attr('data-custom-pagination')) {

            var tableRows = initialRows.filter(function (index) {
                return index < $scope.find('.tmpcoder-table-inner-container').attr('data-rows-per-page');
            });

            table.html(tableRows);

            adjustPaginationList();

            $scope.on('click', '.tmpcoder-table-custom-pagination-list-item', function () {
                paginationListItems.removeClass('tmpcoder-active-pagination-item');
                $(this).addClass('tmpcoder-active-pagination-item');
                adjustPaginationList();
                table.hide();
                pageIndex = +$(this).text();
                itemsPerPage = +$scope.find('.tmpcoder-table-inner-container').attr('data-rows-per-page');

                table.html(initialRows.filter(function (index) {
                    index++;
                    return index > itemsPerPage * (pageIndex - 1) && index <= itemsPerPage * pageIndex;
                }));

                table.show();
                beforeFilter = $scope.find("tbody .tmpcoder-table-row");
                beforeFilter.find('.tmpcoder-table-tr-before-remove').each(function () {
                    $(this).removeClass('tmpcoder-table-tr-before-remove');
                });

                entryInfo();
            });

            $scope.find('.tmpcoder-table-prev-next').each(function () {
                pageIndex = +$scope.find('.tmpcoder-active-pagination-item').text();

                if ($(this).hasClass('tmpcoder-table-custom-pagination-prev')) {

                    $(this).on('click', function () {

                        if (1 < pageIndex) {
                            paginationListItems.removeClass('tmpcoder-active-pagination-item');
                            pageIndex--;

                            paginationListItems.each(function (index) {
                                index++;
                                if (index === pageIndex) {
                                    $(this).addClass('tmpcoder-active-pagination-item');
                                    pageIndex = +$(this).text();
                                }
                            });
                            adjustPaginationList();

                            table.html(initialRows.filter(function (index) {
                                index++;
                                return index > itemsPerPage * (pageIndex - 1) && index <= itemsPerPage * pageIndex;
                            }));

                            beforeFilter = $scope.find("tbody .tmpcoder-table-row");

                            if ('' == value) {
                                table.html(beforeFilter);
                            }
                        }

                        entryInfo();
                    });

                } else {

                    $(this).on('click', function () {

                        if (paginationListItems.length > pageIndex) {
                            paginationListItems.removeClass('tmpcoder-active-pagination-item');
                            pageIndex++;

                            paginationListItems.each(function (index) {
                                index++;
                                if (index === pageIndex) {
                                    $(this).addClass('tmpcoder-active-pagination-item');
                                    pageIndex = +$(this).text();
                                }
                            });
                            adjustPaginationList();

                            table.html(initialRows.filter(function (index) {
                                index++;
                                return index > itemsPerPage * (pageIndex - 1) && index <= itemsPerPage * pageIndex;
                            }));

                            beforeFilter = $scope.find("tbody .tmpcoder-table-row");

                            if ('' == value) {
                                table.html(beforeFilter);
                            }
                        }

                        entryInfo();
                    });
                }

                beforeFilter.find('.tmpcoder-table-tr-before-remove').each(function () {
                    $(this).removeClass('tmpcoder-table-tr-before-remove');
                });

            });

        }

        $scope.find('.tmpcoder-table-inner-container').removeClass('tmpcoder-hide-table-before-arrange');

        entryInfo();

        // Table Live Search
        beforeFilter = $scope.find("tbody .tmpcoder-table-row");
        $scope.find(".tmpcoder-table-live-search").keyup(function () {
            if (this.value !== '') {
                $scope.find('.tmpcoder-table-pagination-cont').addClass('tmpcoder-hide-pagination-on-search');
            } else {
                $scope.find('.tmpcoder-table-pagination-cont').removeClass('tmpcoder-hide-pagination-on-search');
            }
            value = this.value.toLowerCase().trim();

            var afterFilter = [];

            initialRows.each(function (index) {
                // if (!index) return; // TODO: restore if better
                $(this).find("td").each(function () {
                    var id = $(this).text().toLowerCase().trim();
                    var not_found = (id.indexOf(value) == -1);
                    // $(this).closest('tr').toggle(!not_found);
                    // return not_found;
                    if (!not_found) {
                        afterFilter.push($(this).closest('tr'));
                    }
                });
            });

            table.html(afterFilter);

            if ('' == value) {
                table.html(beforeFilter);
            }

            entryInfo();
        });

        // Table Sorting
        if ('yes' === $scope.find('.tmpcoder-table-inner-container').attr('data-table-sorting')) {
            $(window).click(function (e) {
                if (!$(e.target).hasClass('tmpcoder-table-th') && 0 === $(e.target).closest('.tmpcoder-table-th').length) {
                    if (!$(e.target).hasClass('tmpcoder-active-td-bg-color') && 0 === $(e.target).closest('.tmpcoder-active-td-bg-color').length) {
                        $scope.find('td').each(function () {
                            if ($(this).hasClass('tmpcoder-active-td-bg-color')) {
                                $(this).removeClass('tmpcoder-active-td-bg-color');
                            }
                        });
                    }
                }
            });

            $scope.find('th').click(function () {

                var indexOfTr = $(this).index();

                $scope.find('td').each(function () {
                    if ($(this).index() === indexOfTr) {
                        $(this).addClass('tmpcoder-active-td-bg-color');
                    } else {
                        $(this).removeClass('tmpcoder-active-td-bg-color');
                    }
                });

                $scope.find('th').each(function () {
                    $(this).find('.tmpcoder-sorting-icon').html('<i class="fas fa-sort" aria-hidden="true"></i>');
                });

                var table = $(this).parents('table').eq(0);
                var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))

                this.asc = !this.asc
                if ($scope.hasClass('tmpcoder-data-table-type-custom') ? !this.asc : this.asc) {
                    if ($scope.hasClass('tmpcoder-data-table-type-custom')) {
                        $(this).find('.tmpcoder-sorting-icon').html('<i class="fas fa-sort-down" aria-hidden="true"></i>');
                    } else {
                        $(this).find('.tmpcoder-sorting-icon').html('<i class="fas fa-sort-up" aria-hidden="true"></i>');
                    }
                    rows = rows.reverse()
                }

                if ($scope.hasClass('tmpcoder-data-table-type-custom') ? this.asc : !this.asc) {

                    if ($scope.hasClass('tmpcoder-data-table-type-custom')) {
                        $(this).find('.tmpcoder-sorting-icon').html('<i class="fas fa-sort-up" aria-hidden="true"></i>');
                    } else {

                        $(this).find('.tmpcoder-sorting-icon').html('<i class="fas fa-sort-down" aria-hidden="true"></i>');
                    }
                }

                for (var i = 0; i < rows.length; i++) {
                    table.append(rows[i])
                }

                beforeFilter.find('.tmpcoder-table-tr-before-remove').each(function () {
                    $(this).closest('.tmpcoder-table-row').next('.tmpcoder-table-appended-tr').remove();
                    $(this).removeClass('tmpcoder-table-tr-before-remove');
                });
            });
        }

        if ($scope.find('.tmpcoder-table-inner-container').attr('data-row-pagination') === 'yes') {
            $scope.find('.tmpcoder-table-head-row').prepend('<th class="tmpcoder-table-th-pag" style="vertical-align: middle;">' + '#' + '</th>')
            initialRows.each(function (index) {
                $(this).prepend('<td class="tmpcoder-table-td-pag" style="vertical-align: middle;"><span style="vertical-align: middle;">' + (index + 1) + '</span></td>')
            })
        }

        if ($scope.find('.tmpcoder-table-export-button-cont').length) {
            var exportBtn = $scope.find('.tmpcoder-table-export-button-cont .tmpcoder-button');;
            exportBtn.each(function () {
                if ($(this).hasClass('tmpcoder-xls')) {
                    $(this).on('click', function () {
                        let table = $scope.find('table');
                        TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
                            name: `export.xlsx`, // fileName you could use any name
                            sheet: {
                                name: 'Sheet 1' // sheetName
                            }
                        });
                    });
                } else if ($(this).hasClass('tmpcoder-csv')) {
                    $(this).on('click', function () {
                        htmlToCSV('why-this-arg?', "placeholder.csv", $scope.find('.tmpcoder-data-table'));
                    });
                }
            });
        }

        function entryInfo() {

            if ('yes' !== $scope.find('.tmpcoder-table-inner-container').attr('data-entry-info')) {
                return;
            }

            var entryPage = +$scope.find('.tmpcoder-active-pagination-item').text(),
                lastEntry = itemsPerPage * entryPage - (itemsPerPage - $scope.find('tbody tr').length),
                firstEntry = lastEntry - $scope.find('tbody tr').length + 1;

            $scope.find('.tmpcoder-entry-info').html('Showing ' + firstEntry + ' to ' + lastEntry + ' of ' + initialRows.length + ' Entries.');
        }

        function adjustPaginationList() {

            paginationIndex = $scope.find('.tmpcoder-active-pagination-item').index();
            paginationListItems.each(function (index) {
                if (index == 0 || index == paginationListItems.length - 1 || index <= paginationIndex && index >= paginationIndex - 2) {
                    $(this).css('display', 'flex');
                } else {
                    $(this).css('display', 'none');
                }
            });
        }

        function comparer(index) {
            return function (a, b) {
                var valA = getCellValue(a, index), valB = getCellValue(b, index)
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
            }
        }

        function getCellValue(row, index) {
            return $(row).children('td').eq(index).text()
        }

        function htmlToCSV(html, filename, view) {
            var data = [];
            var rows = view.find(".tmpcoder-table-row");

            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll(".tmpcoder-table-text");

                for (var j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }

                data.push(row.join(","));
            }

            downloadCSVFile(data.join("\n"), filename);
        }

        function downloadCSVFile(csv, filename) {
            var csv_file, download_link;

            csv_file = new Blob([csv], { type: "text/csv" });

            download_link = document.createElement("a");

            download_link.download = filename;

            download_link.href = window.URL.createObjectURL(csv_file);

            download_link.style.display = "none";

            document.body.appendChild(download_link);

            download_link.click();
        } // Data Table CSV export        
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-data-table.default",
            widgetDataTable);
    });
})(jQuery);