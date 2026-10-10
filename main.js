/**
 * OGP Theme Main JavaScript
 * Single root script handling navigation and taxonomy table search/sort
 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initTaxonomyTables();
    });

    /**
     * Interactive Taxonomy Tables (Live Search & Sort)
     */
    function initTaxonomyTables() {
        const containers = document.querySelectorAll('.taxonomy-table-container');
        if (!containers.length) return;

        containers.forEach(function(container) {
            const searchInput = container.querySelector('.taxonomy-search-input');
            const tableBody = container.querySelector('.taxonomy-table-body');
            const sortButtons = container.querySelectorAll('.sort-btn');
            const countSummary = container.querySelector('.visible-count');
            const emptyMessage = container.querySelector('.taxonomy-empty-message');

            if (!tableBody) return;

            let rows = Array.from(tableBody.querySelectorAll('tr'));
            if (!rows.length) return;

            // Update row numbers for visible rows
            function updateRowNumbers() {
                let currentNum = 1;
                rows.forEach(function(row) {
                    if (row.style.display !== 'none') {
                        const numCell = row.querySelector('.col-num');
                        if (numCell) {
                            numCell.textContent = currentNum++;
                        }
                    }
                });
            }

            // Quick search filtering
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim().toLowerCase();
                    let visibleCount = 0;

                    rows.forEach(function(row) {
                        const termName = row.dataset.name || row.textContent.toLowerCase();
                        if (!query || termName.indexOf(query) !== -1) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    if (countSummary) {
                        countSummary.textContent = visibleCount;
                    }

                    if (emptyMessage) {
                        emptyMessage.style.display = (visibleCount === 0) ? 'block' : 'none';
                    }

                    updateRowNumbers();
                });
            }

            // Sorting handler
            if (sortButtons.length) {
                sortButtons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const sortType = this.dataset.sort;   // 'count' or 'name'
                        const sortOrder = this.dataset.order; // 'asc' or 'desc'

                        sortButtons.forEach(function(b) { b.classList.remove('active'); });
                        this.classList.add('active');

                        rows.sort(function(a, b) {
                            if (sortType === 'count') {
                                const countA = parseInt(a.dataset.count, 10) || 0;
                                const countB = parseInt(b.dataset.count, 10) || 0;
                                return sortOrder === 'asc' ? countA - countB : countB - countA;
                            } else if (sortType === 'name') {
                                const nameA = (a.dataset.name || '').toLowerCase();
                                const nameB = (b.dataset.name || '').toLowerCase();
                                const cmp = nameA.localeCompare(nameB);
                                return sortOrder === 'asc' ? cmp : -cmp;
                            }
                            return 0;
                        });

                        // Re-append sorted rows to table body
                        rows.forEach(function(row) {
                            tableBody.appendChild(row);
                        });

                        updateRowNumbers();
                    });
                });
            }
        });
    }
})();
