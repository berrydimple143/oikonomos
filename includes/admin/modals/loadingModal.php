<div id="loadingModal" class="fixed inset-0 z-999999 flex items-center justify-center hidden">
    <div 
        x-show="isLoading" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md"
        style="display: none;">
        
        <!-- Modal Content Card -->
        <div 
            x-show="isLoading"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-4"
            class="relative w-full max-w-sm rounded-2xl bg-slate-900/90 border border-slate-800 p-8 shadow-2xl shadow-indigo-500/10 text-center overflow-hidden">
            
            <!-- Ambient Background Glow -->
            <div class="absolute -top-12 -left-12 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Animated Loader Graphic -->
            <div class="relative flex items-center justify-center w-20 h-20 mx-auto mb-6">
            <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 animate-spin blur-xs opacity-75"></div>
            <div class="absolute inset-1 rounded-full bg-slate-900"></div>
            <!-- Center Icon / Pulsing Dot -->
            <div class="relative w-4 h-4 bg-indigo-400 rounded-full animate-ping"></div>
            </div>

            <!-- Text Content -->
            <h3 class="text-xl font-semibold text-slate-100 tracking-wide mb-2">
            Processing the chart
            </h3>
            <p class="text-sm text-slate-400">
            Please wait while we sync your details. This won't take long.
            </p>

        </div>
    </div>
</div>