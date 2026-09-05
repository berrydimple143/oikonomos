<div id="viewDetailsModal" class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-gray-900 p-5 hidden">     
        <div class="rounded-lg p-8 fade-in modal-content">            
            
 
            <div class="flex flex-col bg-slate-800/40 border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/80 hover:border-slate-600 transition-all duration-300 shadow-xl shadow-slate-950/20 max-w-2xl mx-auto">
                <div class="relative h-48 mb-4 flex items-center justify-center">
                <img class="w-[500px] h-auto bg-transparent" :src="detailImage" alt="Project snapshot" />
                </div>
                <div class="flex-1 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex flex-wrap text-slate-300 text-xs font-medium gap-1 mb-3">
                        <template x-for="tc in detailTechs.split(',')">
                            <span class="bg-slate-800 border border-slate-700/50 rounded-sm p-1" x-text="tc"></span>
                        </template>
                        </div>
                        <h3 class="text-xl font-bold text-blue-300 dark:text-white" x-text="detailTitle"></h3>
                        <p class="mt-2 text-xs text-slate-200 line-clamp-6 text-justify" x-text="detailDescription"></p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="mt-6 flex items-center justify-between gap-4">
                            <a :href="detailCode" target="_blank" class="inline-flex items-center text-sm font-semibold text-blue-500 hover:text-blue-600 dark:text-white dark:hover:text-blue-400">
                            View Code &rarr;
                            </a>
                        </div>
                        <button @click.prevent="closeView" class="rounded-full bg-gradient-to-t from-blue-700 via-blue-600 to-blue-500 border-b border-gray-300 text-gray-100 p-2 w-30 mt-6">Close</button>
                    </div>
                    
                </div>
            </div>

        </div>
</div>
