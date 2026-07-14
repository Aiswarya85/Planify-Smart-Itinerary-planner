<?php
session_start();    
    $userid = $_SESSION['id'] ?? null;
    if (!$userid) {
        header("Location: reg.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Planner Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sortable:hover {
            background-color: #f3f4f6;
            cursor: pointer;
        }
        .sort-icon {
            transition: transform 0.2s;
        }
        .sort-asc .sort-icon {
            transform: rotate(180deg);
        }
        .sort-desc .sort-icon {
            transform: rotate(0deg);
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-gray-200">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-indigo-700">My Travel Plans</h1>
                <p class="text-gray-600">Manage your upcoming adventures</p>
            </div>
            <div class="flex space-x-3">
                <a href="index.php" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition flex items-center">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="logout.php" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition flex items-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </div>

        <!-- Controls -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <h2 class="text-xl font-semibold text-gray-800">Filter Plans</h2>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full md:w-auto">
                    <div class="flex items-center space-x-2">
                        <label for="date-from" class="text-gray-700 whitespace-nowrap">From:</label>
                        <input type="date" id="date-from" name="date-from" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="date-to" class="text-gray-700 whitespace-nowrap">To:</label>
                        <input type="date" id="date-to" name="date-to" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button id="apply-filter" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Apply
                    </button>
                    <button id="clear-filter" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </button>
                </div>
            </div>
        </div>

        <!-- Plans Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden animate-fade-in">
            <div class="overflow-x-auto">
                <table id="data-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" data-sort="id" class="sortable px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    ID
                                    <span class="sort-icon ml-1"><i class="fas fa-sort"></i></span>
                                </div>
                            </th>
                            <th scope="col" data-sort="acid" class="sortable px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    Accommodation
                                    <span class="sort-icon ml-1"><i class="fas fa-sort"></i></span>
                                </div>
                            </th>
                            <th scope="col" data-sort="destid" class="sortable px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    Destination
                                    <span class="sort-icon ml-1"><i class="fas fa-sort"></i></span>
                                </div>
                            </th>
                            <th scope="col" data-sort="date" class="sortable px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    Date
                                    <span class="sort-icon ml-1"><i class="fas fa-sort"></i></span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php

                            include "../Db/connection.php";
                            $plans=mysqli_query($con,"Select * from user_plan where userid='$userid' order by date desc");
                            if (mysqli_num_rows($plans) > 0) {
                                while ($plan = mysqli_fetch_assoc($plans)) {
                                    $acid = $plan['acid'] ?? 'N/A';
                                    $destid = $plan['destid'] ?? 'N/A';
                                    $date = $plan['date'] ?? 'N/A';
                                    $hotel = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM ac_tb WHERE a_id='$acid'"))['name'] ?? 'N/A';
                                    $place = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM dest_tb WHERE id='$destid'"))['destination'] ?? 'N/A';
                                    if($plan['acid']) {
                                        $visitlink=mysqli_fetch_assoc(mysqli_query($con, "SELECT map FROM ac_tb WHERE a_id='$acid'"))['map'] ?? '#';
                                    } else if($plan['destid']) {
                                        $visitlink=mysqli_fetch_assoc(mysqli_query($con, "SELECT map FROM dest_tb WHERE id='$destid'"))['map'] ?? '#';
                                    } else {
                                        $visitlink='#';
                                    }

                                    echo "<tr class='hover:bg-gray-50 transition'>
                                            <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>{$plan['id']}</td>
                                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$hotel}</td>
                                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$place}</td>
                                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$date}</td>
                                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>
                                                <a href='{$visitlink}' target='_blank' class='text-indigo-600 hover:text-indigo-900 flex items-center'>
                                                    <i class='fas fa-external-link-alt mr-1'></i> Visit
                                                </a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr>
                                        <td colspan='5' class='px-6 py-4 text-center text-sm text-gray-500'>
                                            No travel plans found. Start by adding some destinations!
                                        </td>
                                      </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State (hidden by default) -->
        <div id="empty-state" class="hidden bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="fas fa-map-marked-alt text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900">No plans match your filters</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your date range or clear the filters.</p>
            <button id="reset-filters" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition inline-flex items-center">
                <i class="fas fa-times mr-2"></i> Clear Filters
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const table = document.getElementById('data-table');
            const emptyState = document.getElementById('empty-state');
            const sortableHeaders = table.querySelectorAll('th[data-sort]');
            const applyFilterBtn = document.getElementById('apply-filter');
            const clearFilterBtn = document.getElementById('clear-filter');
            const resetFiltersBtn = document.getElementById('reset-filters');
            
            // Current sort state
            let currentSort = {
                key: 'date',
                direction: 'desc'
            };
            
            // Initialize sorting
            initializeSorting();
            
            // Filter functionality
            applyFilterBtn.addEventListener('click', applyDateFilter);
            clearFilterBtn.addEventListener('click', clearDateFilter);
            resetFiltersBtn.addEventListener('click', clearDateFilter);
            
            function initializeSorting() {
                sortableHeaders.forEach(header => {
                    header.addEventListener('click', () => {
                        const sortKey = header.getAttribute('data-sort');
                        const isAscending = currentSort.key !== sortKey ? true : !(currentSort.direction === 'asc');
                        
                        // Update UI
                        sortableHeaders.forEach(h => {
                            h.classList.remove('sort-asc', 'sort-desc');
                            const icon = h.querySelector('.sort-icon i');
                            icon.className = 'fas fa-sort';
                        });
                        
                        header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
                        const icon = header.querySelector('.sort-icon i');
                        icon.className = isAscending ? 'fas fa-sort-up' : 'fas fa-sort-down';
                        
                        // Update state and sort
                        currentSort = {
                            key: sortKey,
                            direction: isAscending ? 'asc' : 'desc'
                        };
                        
                        sortTable();
                    });
                });
            }
            
            function sortTable() {
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                rows.sort((a, b) => {
                    const aValue = a.querySelector(`td:nth-child(${getColumnIndex(currentSort.key) + 1}`).textContent;
                    const bValue = b.querySelector(`td:nth-child(${getColumnIndex(currentSort.key) + 1}`).textContent;
                    
                    if (currentSort.key === 'date') {
                        return currentSort.direction === 'asc' 
                            ? new Date(aValue) - new Date(bValue)
                            : new Date(bValue) - new Date(aValue);
                    } else {
                        return currentSort.direction === 'asc' 
                            ? aValue.localeCompare(bValue, undefined, { numeric: true })
                            : bValue.localeCompare(aValue, undefined, { numeric: true });
                    }
                });
                
                // Re-add rows in sorted order
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            }
            
            function getColumnIndex(sortKey) {
                const headers = Array.from(table.querySelectorAll('th[data-sort]'));
                return headers.findIndex(header => header.getAttribute('data-sort') === sortKey);
            }
            
            function applyDateFilter() {
                const fromDate = document.getElementById('date-from').value;
                const toDate = document.getElementById('date-to').value;
                
                const rows = table.querySelectorAll('tbody tr');
                let visibleRows = 0;
                
                rows.forEach(row => {
                    const rowDate = row.querySelector('td:nth-child(4)').textContent; // Date is in 4th column
                    const showRow = 
                        (!fromDate || rowDate >= fromDate) && 
                        (!toDate || rowDate <= toDate);
                    
                    row.style.display = showRow ? '' : 'none';
                    if (showRow) visibleRows++;
                });
                
                // Show empty state if no rows match
                if (visibleRows === 0) {
                    table.style.display = 'none';
                    emptyState.classList.remove('hidden');
                } else {
                    table.style.display = 'table';
                    emptyState.classList.add('hidden');
                }
            }
            
            function clearDateFilter() {
                document.getElementById('date-from').value = '';
                document.getElementById('date-to').value = '';
                
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => row.style.display = '');
                
                table.style.display = 'table';
                emptyState.classList.add('hidden');
            }
        });
    </script>
</body>
</html>