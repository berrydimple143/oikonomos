<div x-show="page === 'attendance_form'" class="grid grid-cols-1 gap-3 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A]">
    <style>
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }
    </style>
    <form @submit.prevent="submitAttendance" class="md:col-span-6 p-4 sm:p-3 space-y-2">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
            <label for="classification" class="block text-sm font-semibold text-gray-100">Classification <span class="text-sm text-red-500">*</span></label>
            <input list="classifications" type="text" x-model="classification" id="classification" name="classification" autocomplete="classification" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Type a classification here ..." required="">
                <datalist id="classifications">
                    <option value="Young People">
                    <option value="Children">
                    <option value="Ladies">
                    <option value="Men">
                </datalist>
            </div>
            <div>
            <label for="quantity" class="block text-sm font-semibold text-gray-100">Number of Attendees <span class="text-sm text-red-500">*</span></label>
            <input type="text" x-model="quantity" id="quantity" name="quantity" autocomplete="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Type quantity here ..." required="">
            </div>
            <div>
                <label for="date_attended" class="block text-sm font-semibold text-gray-100">Date Attended</label>
                <input type="datetime-local" step="1" x-model="date_attended" id="date_attended" name="date_attended" autocomplete="date_attended" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Please select date attended here ...">
            </div>        
        </div>
        <div>
            <label for="attdescription" class="block text-sm font-semibold text-gray-100">Description</label>
            <textarea x-model="attdescription" id="attdescription" name="attdescription" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Type a description here ..."></textarea>
        </div>
        <div class="pt-2 flex items-start justify-between space-x-1">
            <button type="submit" class="w-[170px] justify-center inline-flex items-center p-2 text-sm font-semibold rounded-md shadow-md text-[#04ea13] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                <?php includeWithArgs('../images/icons/save.php', ['color' => '#04ea13', 'class' => 'w-3 h-3 mr-2', 'view' => '0 0 32 32']); ?>
                Save Changes          
            </button>
            <button @click.prevent="navigate('attendance')" type="button" class="w-[170px] justify-center inline-flex items-center p-2 text-sm font-semibold rounded-md shadow-md text-[#fae62c] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                <?php includeWithArgs('../images/icons/cancel.php', ['color' => '#fae62c', 'class' => 'w-4 h-4 mr-2', 'view' => '0 0 24 24']); ?>
                Cancel          
            </button>
        </div>    
    </form>
</div>