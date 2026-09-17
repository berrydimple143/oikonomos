<div x-show="page === 'attendance'">
    <div
    class="overflow-hidden rounded-md border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-2"
    >
    <div
        class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <div class="flex flex-wrap items-center justify-center gap-2">
            <h3 class="text-2xl font-semibold text-gray-300 dark:text-white/90">
                List of Attendance
            </h3>
            <select @change.prevent="initAttendances" name="attendanceYear" id="attendanceYear" x-model="attendanceYear" class="inline-flex items-center text-white border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-md text-sm px-4 py-1.5  cursor-pointer" placeholder="Select year here">
                <template x-for="yr in yearSelection" :key="yr">
                    <option class="text-gray-800" :value="yr" x-text="yr"></option>
                </template>
            </select>
            <select @change.prevent="initAttendances" name="attendanceMonth" id="attendanceMonth" x-model="attendanceMonth" class="inline-flex items-center text-white border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-md text-sm px-4 py-1.5 cursor-pointer" placeholder="Select month here">
                <option class="text-gray-800" value="">All Months</option>
                <template x-for="item in graphSelection" :key="item.month">
                    <option class="text-gray-800" :value="item.month" x-text="item.month"></option>
                </template>
            </select>
        </div>

        <div class="flex items-center gap-3">
        
        <div class="relative">
            <span class="absolute top-1/2 left-4 -translate-y-1/2 hover:cursor-pointer">
              
                <?php includeWithArgs('../images/icons/magnify.php', ['color' => '#fff', 'class' => 'w-4 h-4', 'view' => '0 0 20 20']); ?>

            </span>
            <input
            type="text"
            placeholder="Search here ..."
            id="search-input" 
            x-model="attSearchQuery" 
            @input="attCurrentPage = 1"  
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-100 focus:ring-brand-200/10 dark:focus:border-brand-400 h-9 w-full rounded-lg border border-gray-200 bg-transparent py-2.0 pr-14 pl-12 text-sm text-white placeholder:text-white focus:ring-1 focus:outline-hidden lg:w-[310px] dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30"
        />

        <button
            id="search-button"             
            class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-md border border-gray-200 bg-transparent px-[5px] py-[2.5px] text-xs -tracking-[0.2px] text-white dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400"
        >
            <span> ⌘ </span>
            <span> F </span>
        </button>
        </div>        
        <button @click.prevent="navigate('attendance_form')" type="button" class="inline-flex items-center  text-[#04ea13] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-md text-sm px-4 py-1.5  cursor-pointer">                                
            <?php includeWithArgs('../images/icons/add.php', ['color' => '#04ea13', 'class' => 'w-4 h-4 mr-1', 'view' => '0 0 24 24']); ?>
                ADD ATTENDANCE
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
                        Classification
                    </p>
                    </div>
                </th>
                <th class="py-2 h-auto text-center">
                    <div class="flex items-center">
                    <p>
                        No. of Attendees
                    </p>
                    </div>
                </th class="py-2 h-auto">
                <th class="py-2">
                    <div class="flex items-center">
                    <p>
                        Date Attended
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
            <template x-for="(att, index) in attPaginatedItems" :key="att.id">
                <tr class="text-sm text-gray-100 text-theme-sm dark:text-white/90">
                    <td class="py-2">
                        <div class="flex items-center gap-3">
                            <div><p x-text="(attCurrentPage - 1) * attPageSize + index + 1"></p></div>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center gap-3">
                            <div><p x-text="att.classification"></p></div>
                        </div>
                    </td>
                    <td class="py-2 text-center">
                        <div class="flex items-center text-center">
                        <p x-text="att.quantity" class="text-gray-100 text-center text-theme-sm dark:text-gray-400"></p> <span class="ml-2">people</span>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center">
                        <p x-text="att.attended_on">
                        </p>
                        </div>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center justify-center">
                            
                                <button type="button" @click="editAttendance(att)" class="inline-flex items-center text-[#fae62c] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-base text-sm px-2 py-1 focus:outline-none cursor-pointer">
                                <?php includeWithArgs('../images/icons/edit.php', ['color' => '#fae62c', 'class' => 'w-4 h-4 mr-1', 'view' => '0 0 494.936 494.936']); ?>
                                    Edit
                                </button>         
                                
                                <button @click.prevent="deleteAttendanceConfirm(att.id)" type="button" class="inline-flex items-center text-[#ff8904] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-base text-sm px-2 py-1  cursor-pointer">                                
                                <?php includeWithArgs('../images/icons/delete.php', ['color' => '#ff8904', 'class' => 'w-4 h-4 mr-1', 'view' => '0 0 24 24']); ?>
                                    Delete
                                </button>

                                <button @click.prevent="viewAttendance(att)" type="button" class="inline-flex items-center text-[#23ddfa] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border shadow-xs font-medium leading-5 rounded-base text-sm px-2 py-1  cursor-pointer">
                                <?php includeWithArgs('../images/icons/magnify.php', ['color' => '#23ddfa', 'class' => 'w-3 h-3 mr-1', 'view' => '0 0 20 20']); ?>
                                    View
                                </button>

                        </div>
                    </td>
                </tr>
            </template>            
            <template x-if="attendances.length === 0">
                <tr class="border-b border-gray-200">
                    <td colspan="5" class="text-center text-gray-100">
                        No data found yet ...
                    </td>
                </tr>
            </template>
        </tbody>
        <tfoot>        
            <tr>                
                <td colspan="5">                
                    <div class="flex items-center justify-between">
                        <!-- Pagination Container -->
                        <div class="flex items-center space-x-1 p-2 bg-transparent box-border">                    
                                <!-- Summary Information Indicator -->
                                <span class="text-lg text-white mr-2">
                                    Page <span class="font-semibold" x-text="attCurrentPage"></span> of <span class="font-semibold" x-text="attTotalPages"></span>
                                </span>
                                
                                <!-- First & Previous Buttons -->
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold" 
                                    @click="attCurrentPage = 1" 
                                    :disabled="attCurrentPage === 1"
                                    :class="attCurrentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    «
                                </button>
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                    @click="attCurrentPage--" 
                                    :disabled="attCurrentPage === 1"
                                    :class="attCurrentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    ‹
                                </button>

                                <!-- Truncated Page Numbers -->
                                <template x-for="page in attVisiblePages" :key="page">
                                    <button 
                                        class="px-3 py-1 font-bold border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border"
                                        @click="attCurrentPage = page" 
                                        x-text="page"
                                        :class="attCurrentPage === page ? 'px-4 py-2 bg-gradient-to-t from-slate-400 via-slate-600 to-slate-400 text-white' : 'text-gray-400 cursor-pointer'">
                                    </button>
                                </template>

                                <!-- Next & Last Buttons -->
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                    @click="attCurrentPage++" 
                                    :disabled="attCurrentPage === attTotalPages"
                                    :class="attCurrentPage === attTotalPages ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    ›
                                </button>
                                <button 
                                    class="px-3 py-1 border border-gray-100 bg-gradient-to-t from-slate-700 via-slate-800 to-slate-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 box-border text-lg text-white font-bold"
                                    @click="attCurrentPage = attTotalPages" 
                                    :disabled="attCurrentPage === attTotalPages"
                                    :class="attCurrentPage === attTotalPages ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'">
                                    »
                                </button>                    
                        </div>
                        <div class="flex items-center justify-center space-x-1">
                            <div class="p-2 bg-transparent text-white border-1 border-gray-100 box-border">
                                Total Attendance: <span x-text="attendanceTotal"></span>
                            </div>
                            <div class="p-2 bg-transparent text-white border-1 border-gray-100 box-border">
                                # of Entry: <span x-text="attendances.length"></span>
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