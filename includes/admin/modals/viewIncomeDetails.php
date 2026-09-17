<div id="viewIncomeDetails" class="fixed inset-0 z-999999 flex items-center justify-center p-4 sm:p-0 hidden">  
  <!-- Backdrop Layer -->
    <div class="fixed inset-0 bg-gray-900/90 transition-opacity" aria-hidden="true"></div>

    <!-- Modal Wrapper -->
    <div class="relative flex items-start justify-start transform overflow-hidden rounded-lg border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] px-4 pt-2 pb-4 shadow-xl transition-all sm:my-4 sm:w-full sm:max-w-2xl sm:p-4 z-10">
        
        <div class="w-full overflow-x-auto">
            <div class="flex items-center justify-center text-2xl text-gray-100 mb-2"><span x-text="infoTitle"></span></div>
            <table class="min-w-full">
            <!-- table header start -->
            <thead class="text-gray-100 text-center text-theme-xs dark:text-gray-100">
                <tr class="border-gray-100 border-y dark:border-gray-800">
                    <th class="py-2 w-[5%] h-auto"><div class="flex items-center"><p>#</p></div></th>
                    <th class="py-2 h-auto"><div class="flex items-center"><p>Source</p></div></th>
                    <th class="py-2 h-auto"><div class="flex items-center"><p>Amount</p></div></th>
                    <th class="py-2 h-auto"><div class="flex items-center"><p>Date Received</p></div></th>
                    <th class="py-2 h-auto"><div class="flex items-center"><p>Received From</p></div></th>
                </tr>
            </thead>
            <!-- table header end -->

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <template x-for="(inc, index) in detailsPaginatedItems" :key="inc.id">
                    <tr class="text-sm text-gray-100 text-theme-sm dark:text-white/90">
                        <td class="py-2">
                            <div class="flex items-center gap-3">
                                <div><p x-text="(detailsCurrentPage - 1) * detailsPageSize + index + 1"></p></div>
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="flex items-center">
                                <div><p x-text="inc.source"></p></div>
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="flex items-center">
                            <p x-text="currencyFormatter(inc.amount, currency)"></p>
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="flex items-center">
                            <p x-text="inc.date_received"></p>
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="flex items-center">
                            <p x-text="inc.received_from"></p>
                            </div>
                        </td>                        
                    </tr>
                </template>
            </tbody>          
            <tfoot class="border-t border-gray-100">
                <tr>                
                    <td colspan="5">                
                        <div class="flex items-center justify-between">
                            <!-- Pagination Container -->
                            <div class="flex items-center space-x-1 p-2 bg-transparent box-border">                    
                                    <!-- Summary Information Indicator -->
                                    <span class="text-lg text-white mr-2">
                                        Page <span class="font-semibold" x-text="detailsCurrentPage"></span> of <span class="font-semibold" x-text="detailsTotalPages"></span>
                                    </span>
                                    
                                    <!-- First & Previous Buttons -->
                                    <button 
                                        class="px-2.5 py-0.5 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold" 
                                        @click="detailsCurrentPage = 1" 
                                        :disabled="detailsCurrentPage === 1"
                                        :class="detailsCurrentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                        «
                                    </button>
                                    <button 
                                        class="px-2.5 py-0.5 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                        @click="detailsCurrentPage--" 
                                        :disabled="detailsCurrentPage === 1"
                                        :class="detailsCurrentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                        ‹
                                    </button>

                                    <!-- Truncated Page Numbers -->
                                    <template x-for="page in detailsVisiblePages" :key="page">
                                        <button 
                                            class="px-2.5 py-0.5 font-bold border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border"
                                            @click="detailsCurrentPage = page" 
                                            x-text="page"
                                            :class="detailsCurrentPage === page ? 'px-4 py-2 bg-gradient-to-t from-slate-400 via-slate-600 to-slate-400 text-white' : 'text-gray-400 cursor-pointer'">
                                        </button>
                                    </template>

                                    <!-- Next & Last Buttons -->
                                    <button 
                                        class="px-2.5 py-0.5 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                        @click="detailsCurrentPage++" 
                                        :disabled="detailsCurrentPage === detailsTotalPages"
                                        :class="detailsCurrentPage === detailsTotalPages ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                        ›
                                    </button>
                                    <button 
                                        class="px-2.5 py-0.5 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                        @click="detailsCurrentPage = detailsTotalPages" 
                                        :disabled="detailsCurrentPage === detailsTotalPages"
                                        :class="detailsCurrentPage === detailsTotalPages ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                        »
                                    </button>                    
                            </div>
                            <div class="flex items-center justify-center space-x-1">
                                <div class="p-2 bg-transparent text-white border-1 border-gray-100 box-border">
                                    Total: <span x-text="incomeDetailsTotal"></span>
                                </div>
                                <div class="p-2 bg-transparent text-white border-1 border-gray-100 box-border">
                                    Entry: <span x-text="incomeDetails.length"></span>
                                </div>
                            </div>                        
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <button @click.prevent="closeChartIncomeDetails" type="button" class="w-[80px] justify-center inline-flex items-center p-1 text-sm font-semibold rounded-md shadow-md text-[#ef9014] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                            <?php includeWithArgs('../images/icons/close.php', ['color' => '#ef9014', 'class' => 'w-4 h-4 mr-2', 'view' => '0 0 24 24']); ?>
                            Close          
                        </button>
                    </td>
                </tr>
            </tfoot>  
            </table>
        </div>
    </div>
</div>