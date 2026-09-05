<div x-show="page === 'income_form'" class="grid grid-cols-1 gap-3 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A]">
    <style>
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }
    </style>
    <form @submit.prevent="submitIncome" class="md:col-span-6 p-4 sm:p-3 space-y-2">

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
          <label for="source" class="block text-sm font-semibold text-gray-100">Source <span class="text-sm text-red-500">*</span></label>
          <input list="sources" type="text" x-model="source" id="source" name="source" autocomplete="source" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Type a source here ..." required="">
            <datalist id="sources">
                <option value="Tithes">
                <option value="Offering">
                <option value="Donation">
                <option value="Pledge">
                <option value="Contribution">
                <option value="Faith Promise">
                <option value="First Fruit">
            </datalist>
        </div>
        <div>
          <label for="amount" class="block text-sm font-semibold text-gray-100">Amount <span class="text-sm text-red-500">*</span></label>
          <input type="text" x-model="amount" id="amount" name="amount" autocomplete="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Type amount here ..." required="">
        </div>        
      </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="received_from" class="block text-sm font-semibold text-gray-100">Received From <span class="text-xs italic">(Optional)</span></label>
                <input type="text" x-model="received_from" id="received_from" name="received_from" autocomplete="received_from" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Type received from here ...">
            </div>
            <div>
                <label for="date_received" class="block text-sm font-semibold text-gray-100">Date Received</label>
                <input type="datetime-local" step="1" x-model="date_received" id="date_received" name="date_received" autocomplete="date_received" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Please select date finished here ...">
            </div>
        </div>  
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-100">Description</label>
            <textarea x-model="description" id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Type a description here ..."></textarea>
        </div>
        <div class="pt-2 flex items-start justify-between space-x-1">
            <button type="submit" class="w-[170px] justify-center inline-flex items-center p-2 text-sm font-semibold rounded-md shadow-md text-[#04ea13] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                <?php includeWithArgs('../images/icons/save.php', ['color' => '#04ea13', 'class' => 'w-3 h-3 mr-2', 'view' => '0 0 32 32']); ?>
                Save Changes          
            </button>
            <button @click.prevent="navigate('income')" type="button" class="w-[170px] justify-center inline-flex items-center p-2 text-sm font-semibold rounded-md shadow-md text-[#fae62c] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                <?php includeWithArgs('../images/icons/cancel.php', ['color' => '#fae62c', 'class' => 'w-4 h-4 mr-2', 'view' => '0 0 24 24']); ?>
                Cancel          
            </button>
        </div>    
    </form>
</div>