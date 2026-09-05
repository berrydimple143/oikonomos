<div id="viewIncomeModal" class="fixed inset-0 z-999999 flex items-center justify-center p-4 sm:p-0 hidden">
  
  <!-- Backdrop Layer -->
  <div class="fixed inset-0 bg-gray-900/90 transition-opacity" aria-hidden="true"></div>

  <!-- Modal Wrapper -->
  <div class="relative flex items-start justify-start transform overflow-hidden rounded-lg border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] px-4 pt-2 pb-4 shadow-xl transition-all sm:my-4 sm:w-full sm:max-w-sm sm:p-6 z-10">
    <div>
      <div class="mt-1 sm:mt-2">        
        <h3 class="text-lg font-semibold leading-6 text-gray-300"><span class="rounded-md p-1 border border-gray-300 bg-transparent">Income Details</span></h3>
        <div class="mt-3 text-sm text-gray-400">
          <p>Source: <span class="text-gray-200" x-text="source"></span></p>
          <p>Amount: <span class="text-gray-200" x-text="amount"></span></p>
          <p>Received From: <span class="text-gray-200" x-text="received_from"></span></p>
          <p>Date Received: <span class="text-gray-200" x-text="received_on"></span></p>
          <p>Description: <span class="text-gray-200" x-text="description"></span></p>
        </div><br>
        <button @click.prevent="closeIncomeDetails" type="button" class="w-[80px] justify-center inline-flex items-center p-1 text-sm font-semibold rounded-md shadow-md text-[#ef9014] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                <?php includeWithArgs('../images/icons/close.php', ['color' => '#ef9014', 'class' => 'w-4 h-4 mr-2', 'view' => '0 0 24 24']); ?>
                Close          
            </button>
     </div>      
    </div>    
  </div>

</div>