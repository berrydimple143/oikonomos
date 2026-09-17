<?php require_once '../src/Functions/helpers.php'; ?>
<div x-show="page === ''" class="border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] box-border">     
              
        <!-- Label Toggle Buttons (Show/Hide Filter) -->
        <div class="flex flex-wrap items-center justify-between gap-2 mb-1 pb-1">
            <div class="flex items-center justify-center gap-1">
                <span class="text-xs font-semibold text-white ml-5">Filter By:</span>
                <template x-for="label in allLabels" :key="label">
                    <button 
                    @click="toggleLabel(label)"
                    :class="visibleLabels.includes(label) ? 'bg-slate-700 border-indigo-500 text-white shadow-sm' : 'bg-slate-900/50 border-slate-800 text-white opacity-60 line-through'"
                    class="flex items-center gap-1 px-2 py-1 rounded-md border text-xs font-medium transition-all duration-200 active:scale-95">
                    <span 
                        class="w-2.5 h-2.5 rounded-full transition-opacity"
                        :class="visibleLabels.includes(label) ? 'opacity-100' : 'opacity-20'"
                        :style="`background-color: ${getLabelColor(label)}`"></span>
                    <span x-text="label"></span>
                    </button>
                </template>
            </div>
            <div class="flex items-center space-x-4">                    
                <!-- Year Selector -->
                <div class="flex items-center gap-2">
                    <label for="selectedYear" class="text-xs font-semibold text-white">Year:</label>
                    <select @change.prevent="selectYearMonth" id="selectedYear" x-model="selectedYear" class="bg-slate-900 border border-slate-700 text-sm text-white rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <template x-for="yr in yearSelection" :key="yr">
                            <option :value="yr" x-text="yr"></option>
                        </template>
                    </select>                    
                </div>       
                <!-- Month Selector -->
                <div class="flex items-center gap-2">
                    <label for="selectedMonth" class="text-xs font-semibold text-white">Month:</label>
                    <select @change.prevent="selectYearMonth" id="selectedMonth" x-model="selectedMonth" class="bg-slate-900 border border-slate-700 text-sm text-white rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="all">All Months</option>
                        <template x-for="item in graphSelection" :key="item.abbr">
                            <option :value="item.abbr" x-text="item.month"></option>
                        </template>
                    </select>
                </div>       
                <!-- Currency Selector -->
                <div class="flex items-center gap-2">
                    <label for="currency" class="text-xs font-semibold text-white">Currency:</label>
                    <select @change.prevent="selectCurrency" id="currency" x-model="currency" class="bg-slate-900 border border-slate-700 text-sm text-white rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <template x-for="curr in currencyList" :key="curr.id">
                            <option class="text-lg" :value="curr.id" x-text="curr.symbol"></option>
                        </template>
                    </select>                    
                </div>   
            </div>
    </div>    

    <!-- Chart Container -->
    <div class="relative w-full overflow-hidden">
      <div x-ref="canvas" class="w-full"></div>
      
      <!-- Empty State Warning -->
      <div x-show="visibleLabels.length === 0" class="absolute inset-0 flex items-center justify-center bg-slate-800/80 backdrop-blur-sm">
        <p class="text-white text-sm font-medium">Please select at least one metric label to display data.</p>
      </div>

      <!-- Tooltip -->
      <div x-ref="tooltip" class="absolute opacity-0 pointer-events-none bg-slate-950 text-white text-xs px-3 py-2 rounded-lg shadow-2xl border border-slate-700 transition-all duration-100 backdrop-blur-md z-10"></div>
    </div>
</div>
