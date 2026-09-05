<?php require_once './src/Functions/helpers.php'; ?>
<div id="contactPage" class="min-h-screen bg-slate-900 text-slate-100 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
  <div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-12">
    
    <!-- Left Column: Contact Information -->
    <div class="md:col-span-5 bg-slate-900 border border-slate-700/50 p-8 flex flex-col justify-between text-white relative">
      <!-- Decorative background blur -->
      <div class="absolute top-0 right-0 -mt-12 -mr-12 w-40 h-40 bg-slate-700 rounded-full blur-2xl opacity-50"></div>
      
      <div>
        <h2 class="text-3xl font-extrabold tracking-tight">Get in touch</h2>
        <p class="mt-4 text-slate-200 text-sm leading-relaxed">
          I would love to hear from you. Fill out the form and I will get back to you within 24 hours.
        </p>
      </div>

      <!-- Info items -->
      <div class="mt-2 space-y-6">
        <div class="flex items-center space-x-4">
          <div class="bg-slate-800 p-3 rounded-lg">            
            <?php includeWithArgs('./images/icons/telephone.php', ['color' => '#fff']); ?>
          </div>
          <div>
            <p class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Call me</p>
            <p class="text-sm font-medium"><span x-text="mobile"></span> / <span x-text="info_phone"></span></p>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <div class="bg-slate-800 p-3 rounded-lg">
            <?php includeWithArgs('./images/icons/envelope.php', ['color' => '#fff']); ?>
          </div>
          <div>
            <p class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Email me</p>
            <p class="text-sm font-medium" x-text="info_email"></p>
          </div>
        </div>

        <div class="flex items-center space-x-4">          
          <div class="bg-slate-800 p-3 rounded-lg">
            <?php includeWithArgs('./images/icons/linkedin.php', ['width' => '6', 'height' => '6', 'color' => '#b8b8ff']); ?>
          </div>
          <div>
            <p class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Connect With Me</p>
            <a :href="linkedin" target="_blank" class="text-sm font-medium" x-text="linkedin"></a>
          </div>
        </div>

        <div class="flex items-center space-x-4">          
          <div class="bg-slate-800 p-3 rounded-lg">
            <?php includeWithArgs('./images/icons/fb.php', ['width' => '6', 'height' => '6', 'color' => '#b8b8ff']); ?>
          </div>
          <div>
            <p class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Message Me</p>
            <a :href="facebook" target="_blank" class="text-sm font-medium" x-text="facebook"></a>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <div class="bg-slate-800 p-3 rounded-lg">
            <?php includeWithArgs('./images/icons/location.php', ['color' => '#fff']); ?>
          </div>
          <div>
            <p class="text-xs text-slate-300 uppercase tracking-wider font-semibold">Address</p>
            <p class="text-sm font-medium" x-text="address"></p>
          </div>
        </div>


      </div>
      <div>&nbsp;</div>     
    </div>

    <!-- Right Column: Contact Form -->
    <form @submit.prevent="sendMessage" class="md:col-span-7 p-8 sm:p-12 space-y-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="text-gray-700">
          <label for="firstname" class="block text-sm font-semibold">First name <span class="text-red-500 font-normal">*</span></label>
          <input type="text" x-model="firstname" id="firstname" name="firstname" autocomplete="firstname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Please type your first name here ..." required="">
        </div>
        <div class="text-gray-700">
          <label for="lastname" class="block text-sm font-semibold">Last name <span class="text-red-500 font-normal">*</span></label>
          <input type="text" x-model="lastname" id="lastname" name="lastname" autocomplete="lastname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Please type your last name here ..." required="">
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="text-gray-700">
          <label for="email" class="block text-sm font-semibold">Email address <span class="text-red-500 font-normal">*</span></label>
          <input type="email" x-model="email" id="email" name="email" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Please type your email here ..." required="">
        </div>
        <div class="text-gray-700">
          <label for="phone" class="block text-sm font-semibold">Phone number <span class="text-gray-400 font-normal">(Optional)</span></label>
          <input type="text" x-model="phone" id="phone" name="phone" autocomplete="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="+1 (555) 000-0000">
        </div>
      </div>

      <div class="text-gray-700">
        <label for="subject" class="block text-sm font-semibold">Subject <span class="text-red-500 font-normal">*</span></label>
        <input type="text" x-model="subject" id="subject" name="subject" autocomplete="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Please type your subject here ..." required="">
      </div>

      <div class="text-gray-700">
        <label for="message" class="block text-sm font-semibold">Message <span class="text-red-500 font-normal">*</span></label>
        <textarea id="message" x-model="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border p-2.5 text-sm outline-none transition-all" placeholder="Leave me a message..." required=""></textarea>
      </div>

      <div class="pt-2">
        <button type="submit" class="w-full justify-center inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
          Send Message
          <svg class="ml-2 -mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>
      </div>
    </form>

  </div>
</div>
