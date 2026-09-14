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
                <template x-for="(inc, index) in incomeDetails" :key="inc.date_received">
                    <tr class="text-sm text-gray-100 text-theme-sm dark:text-white/90">
                        <td class="py-2">
                            <div class="flex items-center gap-3">
                                <div><p x-text="index+1"></p></div>
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="flex items-center">
                                <div><p x-text="inc.source"></p></div>
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="flex items-center">
                            <p x-text="currencyFormatter(inc.amount, 'PHP')"></p>
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
            <tfoot>
                <tr>                
                    <td colspan="5">                
                        <div class="flex items-center justify-between">
                            <!-- Pagination Container -->
                            <div class="flex items-center space-x-1 p-2 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] box-border">                    
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
                                    Total Income: <span x-text="incomeDetailsTotal"></span>
                                </div>
                                <div class="p-2 bg-transparent text-white border-1 border-gray-100 box-border">
                                    # of Entry: <span x-text="incomeDetails.length"></span>
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