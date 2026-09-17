<div x-show="page === 'income'">
    <div
    class="overflow-hidden rounded-md border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-2"
    >
    <div
        class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <div class="flex flex-wrap items-center justify-center gap-2">
            <h3 class="text-lg font-semibold text-gray-300 dark:text-white/90">
                List of Income
            </h3>
            <select @change.prevent="initIncomes" name="incomeYear" id="incomeYear" x-model="incomeYear" class="inline-flex items-center text-white border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-md text-sm px-3 py-0.5 cursor-pointer" placeholder="Select year here">
                <template x-for="yr in yearSelection" :key="yr">
                    <option class="text-gray-800" :value="yr" x-text="yr"></option>
                </template>
            </select>
            <select @change.prevent="initIncomes" name="incomeMonth" id="incomeMonth" x-model="incomeMonth" class="inline-flex items-center text-white border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-md text-sm px-3 py-0.5 cursor-pointer" placeholder="Select month here">
                <option class="text-gray-800" value="">All Months</option>
                <template x-for="item in graphSelection" :key="item.month">
                    <option class="text-gray-800" :value="item.month" x-text="item.month"></option>
                </template>
            </select>
            <select @change.prevent="initIncomes" name="incomeSource" id="incomeSource" x-model="incomeSource" class="inline-flex items-center text-white border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-md text-sm px-3 py-0.5 cursor-pointer" placeholder="Select source here">
                <option class="text-gray-800" value="">All Sources</option>
                <template x-for="src in incomeSources" :key="src">
                    <option class="text-gray-800" :value="src" x-text="src"></option>
                </template>
            </select>
        </div>

        <div class="flex items-center gap-3">
        
        <div class="relative">
            <span class="absolute top-1/2 left-2 -translate-y-1/2 hover:cursor-pointer">
              
                <?php includeWithArgs('../images/icons/magnify.php', ['color' => '#fff', 'class' => 'w-4 h-4', 'view' => '0 0 20 20']); ?>

            </span>
            <input
                type="text"
                placeholder="Search here ..."
                id="search-input" 
                x-model="searchQuery" 
                @input="currentPage = 1"  
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-100 focus:ring-brand-200/10 dark:focus:border-brand-400 h-8 w-full rounded-lg border border-gray-200 bg-transparent py-1.5 pr-14 pl-8 text-sm text-white placeholder:text-white focus:ring-1 focus:outline-hidden lg:w-[250px] dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30"
            />

            <button
                id="search-button"             
                class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-md border border-gray-200 bg-transparent px-[3px] py-[1.5px] text-xs -tracking-[0.2px] text-white dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400"
            >
                <span>⌘</span>
                <span>F</span>
            </button>
        </div>  
              
        <button @click.prevent="navigate('income_form')" type="button" class="inline-flex items-center  text-[#04ea13] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-md text-sm px-3 py-0.5  cursor-pointer">                                
            <?php includeWithArgs('../images/icons/add.php', ['color' => '#04ea13', 'class' => 'w-4 h-4 mr-1', 'view' => '0 0 24 24']); ?>
                ADD INCOME
            </button>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table class="min-w-full">
        <!-- table header start -->
        <thead class="text-gray-100 text-center text-theme-xs dark:text-gray-100">
            <tr class="border-gray-100 border-y dark:border-gray-800">
                <th class="py-2 w-[3%] h-auto"><div class="flex items-center"><p>#</p></div></th>
                <th class="py-2 h-auto">
                    <div class="flex items-center">
                    <p>
                        Source
                    </p>
                    </div>
                </th>
                <th class="py-2 h-auto">
                    <div class="flex items-center">
                    <p>
                        Amount
                    </p>
                    </div>
                </th class="py-2 h-auto">
                <th class="py-2">
                    <div class="flex items-center">
                    <p>
                        Date Received
                    </p>
                    </div>
                </th>
                <th class="py-2">
                    <div class="flex items-center">
                    <p>
                        Received From
                    </p>
                    </div>
                </th>
                <th class="py-2 w-[12%] h-auto">
                    <div class="flex items-center justify-center col-span-2">
                        <p>Action</p>
                    </div>
                </th>
            </tr>
        </thead>
        <!-- table header end -->

        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            <template x-for="(inc, index) in paginatedItems" :key="inc.id">
                <tr class="text-sm text-gray-100 text-theme-sm dark:text-white/90">
                    <td class="py-2">
                        <div class="flex items-center gap-3">
                            <div><p x-text="(currentPage - 1) * pageSize + index + 1"></p></div>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center gap-3">
                            <div><p x-text="inc.source"></p></div>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center">
                        <p x-text="currencyFormatter(inc.amount, currency)" class="text-gray-100 text-theme-sm dark:text-gray-400"></p>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center">
                        <p x-html="inc.received_on">
                        </p>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center">
                        <p x-html="inc.received_from">
                        </p>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center justify-center">
                            
                                <button type="button" @click="editIncome(inc)" class="inline-flex items-center text-[#fae62c] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-base text-sm px-2 py-1 focus:outline-none cursor-pointer">
                                <?php includeWithArgs('../images/icons/edit.php', ['color' => '#fae62c', 'class' => 'w-4 h-4 mr-1', 'view' => '0 0 494.936 494.936']); ?>
                                    Edit
                                </button>         
                                
                                <button @click.prevent="deleteIncomeConfirm(inc.id)" type="button" class="inline-flex items-center text-[#ff8904] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-base text-sm px-2 py-1  cursor-pointer">                                
                                <?php includeWithArgs('../images/icons/delete.php', ['color' => '#ff8904', 'class' => 'w-4 h-4 mr-1', 'view' => '0 0 24 24']); ?>
                                    Delete
                                </button>

                                <button @click.prevent="viewIncome(inc)" type="button" class="inline-flex items-center text-[#23ddfa] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-base text-sm px-2 py-1  cursor-pointer">
                                <?php includeWithArgs('../images/icons/magnify.php', ['color' => '#23ddfa', 'class' => 'w-3 h-3 mr-1', 'view' => '0 0 20 20']); ?>
                                    View
                                </button>

                        </div>
                    </td>
                </tr>
            </template>            
            <template x-if="incomes.length === 0">
                <tr class="border-b border-gray-200">
                    <td colspan="6" class="text-center text-gray-100">
                        No data found yet ...
                    </td>
                </tr>
            </template>
        </tbody>
        <tfoot>        
            <tr>                
                <td colspan="6">                
                    <div class="flex items-center justify-between">
                        <!-- Pagination Container -->
                        <div class="flex items-center space-x-1 p-2 bg-transparent box-border">                    
                                <!-- Summary Information Indicator -->
                                <span class="text-lg text-white mr-2">
                                    Page <span class="font-semibold" x-text="currentPage"></span> of <span class="font-semibold" x-text="totalPages"></span>
                                </span>
                                
                                <!-- First & Previous Buttons -->
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold" 
                                    @click="currentPage = 1" 
                                    :disabled="currentPage === 1"
                                    :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    «
                                </button>
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                    @click="currentPage--" 
                                    :disabled="currentPage === 1"
                                    :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    ‹
                                </button>

                                <!-- Truncated Page Numbers -->
                                <template x-for="page in visiblePages" :key="page">
                                    <button 
                                        class="px-3 py-1 font-bold border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border"
                                        @click="currentPage = page" 
                                        x-text="page"
                                        :class="currentPage === page ? 'px-4 py-2 bg-gradient-to-t from-slate-400 via-slate-600 to-slate-400 text-white' : 'text-gray-400 cursor-pointer'">
                                    </button>
                                </template>

                                <!-- Next & Last Buttons -->
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                    @click="currentPage++" 
                                    :disabled="currentPage === totalPages"
                                    :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    ›
                                </button>
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                    @click="currentPage = totalPages" 
                                    :disabled="currentPage === totalPages"
                                    :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    »
                                </button>                    
                        </div>
                        <div class="flex items-center justify-center space-x-1">
                            <div class="p-2 bg-transparent text-white border-1 border-gray-100 box-border">
                                Total Income: <span x-text="incomeTotal"></span>
                            </div>
                            <div class="p-2 bg-transparent text-white border-1 border-gray-100 box-border">
                                # of Entry: <span x-text="incomes.length"></span>
                            </div>
                        </div>                        
                    </div>
                </td>
            </tr>
        </tfoot>    
        </table>
    </div>
    </div>
</div>