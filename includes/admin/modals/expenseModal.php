<div id="expenseModal" class="fixed inset-0 z-999999 flex items-center justify-center p-4 sm:p-0 hidden">
  
  <!-- Backdrop Layer -->
  <div class="fixed inset-0 bg-gray-900/75 transition-opacity" aria-hidden="true"></div>

  <!-- Modal Wrapper -->
  <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6 z-10">
    <div>
      <!-- Success Icon Container -->
      <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
        <!-- SVG Green Checkmark Icon -->
        <svg class="h-6 w-6 text-green-600" xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
      </div>
      
      <div class="mt-3 text-center sm:mt-5">
        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">   
          Expense saved successfully!
        </h3>
        <div class="mt-2">
          <p class="text-sm text-gray-500">
            You will be redirected to the expenses table. Please wait ...
          </p>
        </div>
      </div>
    </div>
  </div>
</div>