<?php require_once './src/Functions/helpers.php'; ?>
    <a class="ml-4 max-w-[100px]" href="">
        <img width="60" height="60" src="./images/logo2.png" alt="">
    </a>
    <ul class="hidden sm:flex font-semibold">
        <li class="p-5">
            <a href="#aboutPage" class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/about.php', ['color' => '#fff', 'class' => 'w-4 h-4', 'view' => '0 0 24 24']); ?>
                <span>About Me</span> 
            </a>
        </li>
        <li class="p-5">
            <a href="#projectPage" class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/work.php', ['color' => '#fff', 'class' => 'w-4 h-4', 'view' => '0 0 60 60']); ?>
                <span>Projects</span> 
            </a>
        </li>
        <li class="p-5">
            <a href="#experiencePage" class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/experience.php', ['color' => '#fff', 'class' => 'w-5 h-5', 'view' => '0 0 512 512']); ?>
                <span>Experiences</span> 
            </a>
        </li>            
        <li class="p-5">
            <a href="#contactPage" class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/contact.php', ['color' => '#fff', 'class' => 'w-4 h-4', 'view' => '0 0 64 64']); ?>
                <span>Contact</span> 
            </a>
        </li>
    </ul>

<!-- Mobile View Menu -->
<div class="block sm:hidden">
    <div @click.prevent="showMobile" class="mr-4 p-1 border border-gray-500 cursor-pointer">
        <span x-show="!showMobileMenu"><?php include('./images/icons/menu.php'); ?></span>
        <span x-show="showMobileMenu"><?php include('./images/icons/exit.php'); ?></span>
    </div>    
</div>

<div x-show="showMobileMenu" :class="showMobileMenu ? 'z-10 text-gray-300 fixed h-full left-0 top-0 w-[65%] border-r bg-gradient-to-r from-[#2D82B5] via-blue-500 to-[#015c92] ease-in-out duration-500' : 'fixed left-[-100%]'">
    
    
    <a class="p-8">
        <img class="ml-6" width="80" height="80"  src="./images/logo.jpg" alt="">
    </a>
    <ul class="flex flex-col items-start justify-start font-semibold">
        <li class="p-5">
            <a href="#aboutPage" @click="showMobileMenu = !showMobileMenu" class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/about.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 24 24']); ?>
                <span>About</span> 
            </a>
        </li>
        <li class="p-5">
            <a class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/work.php', ['color' => '#fff', 'class' => 'w-5 h-5', 'view' => '0 0 60 60']); ?>
                <span>Projects</span> 
            </a>
        </li>
        <li class="p-5">
            <a class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/experience.php', ['color' => '#fff', 'class' => 'w-6 h-6', 'view' => '0 0 512 512']); ?>
                <span>Experience</span> 
            </a>
        </li>            
        <li class="p-5">
            <a class="flex items-center justify-center space-x-2" href="">
                <?php includeWithArgs('./images/icons/contact.php', ['color' => '#fff', 'class' => 'w-5 h-5', 'view' => '0 0 64 64']); ?>
                <span>Contact</span> 
            </a>
        </li>
    </ul>
</div>