<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[70px]' : '-translate-x-full'"
  class="fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden bg-gradient-to-r from-slate-800 via-slate-800/97 to-slate-900 px-5 dark:border-slate-800 dark:bg-black lg:static lg:translate-x-0"
>
  <div class="py-6">&nbsp;</div>
  <!-- SIDEBAR HEADER -->
  <div
    class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
  >
    <!-- Sidebar Menu -->
    <nav class="text-gray-200">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px]">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            ADMIN PANEL
          </span>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Menu Item Dashboard -->
          <li class="p-1 hover:bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 hover:p-1 hover:rounded-full" :class="(page === '') ? 'bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 p-1 rounded-full' : ''">
            <a @click.prevent="navigate('')" class="menu-item group flex items-center justify-start space-x-2 cursor-pointer">
              
            <?php includeWithArgs('../images/icons/dashboard.php', ['color' => '#fff', 'class' => 'w-7 h-7', 'view' => '0 0 24 24']); ?>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Dashboard
              </span>
            </a>            
          </li>
          <!-- Menu Item Dashboard -->         

          <li class="p-1 hover:bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 hover:p-1 hover:rounded-full" :class="(page === 'income' || page === 'income_form') ? 'bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 p-1 rounded-full' : ''">
            <a @click.prevent="navigate('income')" class="menu-item group flex items-center justify-start space-x-2 cursor-pointer">
              <?php includeWithArgs('../images/icons/work.php', ['color' => '#fff', 'class' => 'w-5 h-5', 'view' => '0 0 60 60']); ?>
              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Income
              </span>
            </a>
          </li>

          <!-- Menu Item Profile -->
          <li class="p-1 hover:bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 hover:p-1 hover:rounded-full" :class="(page === 'expense' || page === 'expense_form') ? 'bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 p-1 rounded-full' : ''">
            <a @click.prevent="navigate('expense')" class="menu-item group flex items-center justify-start space-x-2 cursor-pointer">
              <?php includeWithArgs('../images/icons/experience.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 512 512']); ?>
              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Expenses
              </span>
            </a>
          </li>

          <li class="p-1 hover:bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 hover:p-1 hover:rounded-full" :class="(page === 'attendance' || page === 'attendance_form') ? 'bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 p-1 rounded-full' : ''">
            <a @click.prevent="navigate('attendance')" class="menu-item group flex items-center justify-start space-x-2 cursor-pointer">
              <?php includeWithArgs('../images/icons/experience.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 512 512']); ?>
              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Attendance
              </span>
            </a>
          </li>

          <li class="p-1 hover:bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 hover:p-1 hover:rounded-full" :class="(page === 'projection' || page === 'projection_form') ? 'bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 p-1 rounded-full' : ''">
            <a @click.prevent="navigate('projection')" class="menu-item group flex items-center justify-start space-x-2 cursor-pointer">
              <?php includeWithArgs('../images/icons/experience.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 512 512']); ?>
              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Projection
              </span>
            </a>
          </li>
          
          <li class="p-1 hover:bg-gradient-to-t from-slate-500 via-slate-700 to-slate-300 hover:p-1 hover:rounded-full">
            <a @click.prevent="logout" class="menu-item group flex items-center justify-start space-x-2 cursor-pointer">
              <?php includeWithArgs('../images/icons/logout.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 -0.5 25 25']); ?>
              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Logout
              </span>
            </a>
          </li>

        </ul>
      </div>     
    </nav>    
  </div>
</aside>