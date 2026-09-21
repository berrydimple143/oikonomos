<div id="changePasswordModal" class="fixed inset-0 z-999999 flex items-center justify-center p-4 sm:p-0 hidden">  
  <!-- Backdrop Layer -->
    <div class="fixed inset-0 bg-gray-900/90 transition-opacity" aria-hidden="true"></div>
    <!-- Modal Wrapper -->
    <div class="relative flex items-start justify-start transform overflow-hidden rounded-lg border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] px-4 pt-2 pb-4 shadow-xl transition-all sm:my-4 sm:w-full sm:max-w-md sm:p-4 z-10">        
        <div class="w-full overflow-x-auto">

            <style>
                .checkbox-grid {
                    display: grid;
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                    gap: 10px;
                }
            </style>
            <form @submit.prevent="submitPasswordChange" class="md:col-span-6 p-4 sm:p-3 space-y-2">   
                <div class="flex items-center justify-center text-center text-white">
                    <span>CHANGE PASSWORD FORM</span>
                </div>
                <div class="flex items-center justify-center text-center" x-show="hasPasswordError">
                    <span class="text-orange-400" x-text="passwordError"></span>
                </div>
                <div>
                    <label for="old_password" class="block text-sm font-semibold text-gray-400 mb-1 pl-1">Current Password <span class="text-xs italic">(<span class="text-red-600">*</span>)</span></label>
                    <div class="relative w-full">                        
                        <input
                            type="password" 
                            x-model="old_password"  
                            id="old_password"  
                            x-ref="pass1" 
                            name="old_password"  
                            autocomplete="old_password"  
                            placeholder="Type your current password here ..."                           
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-100 focus:ring-brand-200/10 dark:focus:border-brand-400 h-10 w-full rounded-lg border border-gray-200 bg-transparent py-1.5 pr-14 pl-3 text-xs text-white placeholder:text-white focus:ring-1 focus:outline-hidden lg:w-full dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30" required="true"/>
                        <button
                            id="old-button"             
                            type="button"  
                            @mouseenter.prevent="showPass1" 
                            @mouseleave.prevent="hidePass1" 
                            class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 bg-transparent px-[3px] py-[1.5px] text-xs -tracking-[0.2px] text-white dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400"
                        >
                            <span x-show="!isEyeOpen1">
                                <?php includeWithArgs('../images/icons/eye.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 24 24']); ?>
                            </span>
                            <span x-show="isEyeOpen1">
                                <?php includeWithArgs('../images/icons/eye-open.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 24 24']); ?>
                            </span>
                        </button>
                    </div>  
                </div>
                <div>
                    <label for="new_password" class="block text-sm font-semibold text-gray-400 mb-1 pl-1">New Password <span class="text-xs italic">(<span class="text-red-600">*</span>)</span></label>
                    <div class="relative w-full">                        
                        <input
                            type="password" 
                            x-model="new_password"  
                            id="new_password"  
                            x-ref="pass2"
                            name="new_password"  
                            autocomplete="new_password"  
                            placeholder="Type your new password here ..."                           
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-100 focus:ring-brand-200/10 dark:focus:border-brand-400 h-10 w-full rounded-lg border border-gray-200 bg-transparent py-1.5 pr-14 pl-3 text-xs text-white placeholder:text-white focus:ring-1 focus:outline-hidden lg:w-full dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30" required="true"/>
                        <button
                            id="new-button"        
                            type="button"      
                            @mouseenter.prevent="showPass2" 
                            @mouseleave.prevent="hidePass2"
                            class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 bg-transparent px-[3px] py-[1.5px] text-xs -tracking-[0.2px] text-white dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400"
                        >
                            <span x-show="!isEyeOpen2">
                                <?php includeWithArgs('../images/icons/eye.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 24 24']); ?>
                            </span>
                            <span x-show="isEyeOpen2">
                                <?php includeWithArgs('../images/icons/eye-open.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 24 24']); ?>
                            </span>
                        </button>
                    </div>  
                </div>                
                <div>
                    <label for="retype_password" class="block text-sm font-semibold text-gray-400 mb-1 pl-1">Confirm New Password <span class="text-xs italic">(<span class="text-red-600">*</span>)</span></label>
                    <div class="relative w-full">                        
                        <input
                            type="password" 
                            x-model="retype_password"  
                            id="retype_password"  
                            x-ref="pass3"
                            name="retype_password"  
                            autocomplete="retype_password"  
                            placeholder="Confirm your new password here ..."                           
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-100 focus:ring-brand-200/10 dark:focus:border-brand-400 h-10 w-full rounded-lg border border-gray-200 bg-transparent py-1.5 pr-14 pl-3 text-xs text-white placeholder:text-white focus:ring-1 focus:outline-hidden lg:w-full dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30" required="true"/>
                        <button
                            id="retype-button"          
                            type="button"    
                            @mouseenter.prevent="showPass3" 
                            @mouseleave.prevent="hidePass3"
                            class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 bg-transparent px-[3px] py-[1.5px] text-xs -tracking-[0.2px] text-white dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400"
                        >
                            <span x-show="!isEyeOpen3">
                                <?php includeWithArgs('../images/icons/eye.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 24 24']); ?>
                            </span>
                            <span x-show="isEyeOpen3">
                                <?php includeWithArgs('../images/icons/eye-open.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 24 24']); ?>
                            </span>
                        </button>
                    </div>  
                </div>                
                <div class="pt-2 flex items-start justify-between space-x-1">
                    <button type="submit" class="w-[170px] justify-center inline-flex items-center p-2 text-sm font-semibold rounded-md shadow-md text-[#04ea13] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                        <?php includeWithArgs('../images/icons/save.php', ['color' => '#04ea13', 'class' => 'w-3 h-3 mr-2', 'view' => '0 0 32 32']); ?>
                        Save Changes          
                    </button>
                    <button @click.prevent="navigate(pageName)" type="button" class="w-[170px] justify-center inline-flex items-center p-2 text-sm font-semibold rounded-md shadow-md text-[#ff8904] border border-gray-200 bg-gradient-to-t from-[#1E293B] via-[#334155] to-[#0F172A] hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-[#fff] dark:focus:ring-[#fff] box-border transition-colors duration-200">            
                        <?php includeWithArgs('../images/icons/cancel.php', ['color' => '#ff8904', 'class' => 'w-4 h-4 mr-2', 'view' => '0 0 24 24']); ?>
                        Cancel          
                    </button>
                </div>    
            </form>

        </div>
    </div>
</div>