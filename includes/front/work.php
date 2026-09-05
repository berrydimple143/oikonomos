<section id="projectPage" class="bg-slate-900 text-slate-100 py-16 px-4 sm:px-6 lg:px-8 dark:bg-slate-900">
  <div class="max-w-7xl mx-auto">
    
    <!-- Section Header -->
    <div class="text-center max-w-3xl mx-auto mb-16">      
      <p class="mt-2 text-3xl font-extrabold text-slate-100 tracking-tight sm:text-4xl dark:text-white">
        Projects
      </p>
      <p class="mt-4 text-lg text-slate-200 dark:text-slate-400">
        Explore how I build and develop intuitive digital experiences that drive business growth.
      </p>
    </div>
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">      
      <template x-for="prj in projects" :key="prj.id">
          <div class="flex flex-col bg-slate-800/40 border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/80 hover:border-slate-600 transition-all duration-300 shadow-xl shadow-slate-950/20">
            <div class="relative h-48 overflow-hidden">
              <img class="w-[500px] h-auto bg-transparent" :src="`${projectDirectory}${prj.image}`" alt="Project snapshot" />
            </div>
            <div class="flex-1 p-6 flex flex-col justify-between">
              <div>
                <div class="flex flex-wrap text-slate-300 text-xs font-medium gap-1 mb-3">
                  <template x-for="tc in prj.technology.split(',')">
                      <span class="bg-slate-800 border border-slate-700/50 rounded-sm p-1" x-text="tc"></span>
                  </template>
                </div>
                <h3 class="text-xl font-bold text-blue-300 dark:text-white" x-text="prj.title"></h3>
                <p class="mt-2 text-xs text-slate-200 line-clamp-6 text-justify" x-text="smartTruncate(prj.description, 260)"></p>
              </div>
              <div class="mt-6 flex items-center justify-between gap-4">
                <a :href="prj.code" target="_blank" class="inline-flex items-center text-sm font-semibold text-blue-500 hover:text-blue-600 dark:text-white dark:hover:text-blue-400">
                  View Code &rarr;
                </a>
                <a @click.prevent="viewDetail(prj.image, prj.technology, prj.title, prj.description, prj.code)" class="inline-flex items-center text-sm font-semibold text-blue-500 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 cursor-pointer">
                  Read more &rarr;
                </a>
              </div>
            </div>
          </div>
      </template>
    </div>
  </div>
</section>
