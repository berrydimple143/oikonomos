<section id="experiencePage" class="bg-slate-900 py-24 text-slate-100">
  <div class="mx-auto max-w-4xl px-6">
    <!-- Header -->
    <div class="text-center mb-16">
      <p class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">Professional Experience</p>
    </div>

    <!-- Timeline Container -->
    <div class="relative border-l border-slate-700/60 ml-4 md:ml-32 space-y-12">
      <template x-for="exp in experiences" :key="exp.id">

          <!-- Experience Item 1 -->
          <div class="relative pl-8 sm:pl-12 group">
            <!-- Node Marker -->
            <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-slate-900 border-2 border-indigo-500 group-hover:border-indigo-400 group-hover:scale-125 transition-all duration-300 shadow-[0_0_10px_rgba(99,102,241,0.5)]">          
            </div>
            
            <!-- Date Label (Left Positioned on Desktop) -->
            <div class="md:absolute md:-left-67 md:top-1 md:w-60 md:text-right text-sm font-medium text-slate-400 mb-2 md:mb-0">
              <span x-text="exp.start_date"></span> - <span x-text="exp.end_date"></span>
            </div>

            <!-- Content Card -->
            <div class="bg-slate-800/40 border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/80 hover:border-slate-600 transition-all duration-300 shadow-xl shadow-slate-950/20">

              <div class="flex items-center gap-4 mb-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20 text-indigo-400 font-bold" x-text="exp.company.substring(0, 1)"></div>
                <div>
                  <h3 class="text-lg font-bold text-white group-hover:text-indigo-300 transition-colors" x-text="exp.role"></h3>
                  <p class="text-sm text-slate-400"><span x-text="exp.company"></span> ·· <span x-text="exp.employment_type"></span> ·· <span x-text="exp.work_setup"></span></p>
                </div>
              </div>
              <p class="text-sm text-slate-300 leading-relaxed" x-html="exp.description"></p>
              <div class="mt-4 flex flex-wrap gap-2">
                <template x-if="checkComma(exp.experience_techs)">
                  <template x-for="tc in exp.experience_techs.split(',')">
                      <span class="text-xs px-2.5 py-1 bg-slate-700/50 rounded-md text-slate-300 border border-slate-600/30" x-text="tc"></span>
                  </template>
                </template>
              </div>
            </div>
          </div>
      </template>
    </div>
  </div>
</section>