
document.addEventListener('DOMContentLoaded', function() {
    const monthFilter = document.getElementById('monthFilter');
    const applyFilter = document.getElementById('applyFilter');
    const resetFilter = document.getElementById('resetFilter');
    const tableContainer = document.querySelector('.table-responsive');
    const paginationContainer = document.querySelector('.mt-4');

    function updateFilterState() {
        const month = monthFilter.value;
        resetFilter.style.display = month ? 'inline-block' : 'none';
        document.querySelector('h3.card-title').innerHTML = `Brands <span class="badge badge-light-primary">${month ? 'Filtered' : 'All'}</span>`;
    }

    function loadBrands(month = '') {
        const url = new URL(window.location);
        if (month) {
            url.searchParams.set('month', month);
        } else {
            url.searchParams.delete('month');
        }
        url.searchParams.delete('page'); // Reset page for new filter

        tableContainer.style.opacity = '0.6';
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.querySelector('.table');
                const newPagination = doc.querySelector('.mt-4');
                
                if (newTable) tableContainer.querySelector('table').replaceWith(newTable);
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
                tableContainer.style.opacity = '1';
                
                // Re-bind pagination clicks
                document.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const pageUrl = new URL(this.href);
                        loadBrands(monthFilter.value);
                    });
                });
            })
            .catch(error => {
                console.error('Filter error:', error);
                tableContainer.style.opacity = '1';
            });
    }

    if (applyFilter) {
        applyFilter.addEventListener('click', () => loadBrands(monthFilter.value));
    }
    if (resetFilter) {
        resetFilter.addEventListener('click', () => loadBrands(''));
    }
    if (monthFilter) {
        monthFilter.addEventListener('change', updateFilterState);
        updateFilterState();
    }

    // Pagination AJAX
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const month = monthFilter.value;
            loadBrands(month);
        }
    });
});
