<div id="aboutPage" class="max-w-[1920px] md:h-[70vh] flex items-center justify-center mx-auto gap-24 my-10 sm:my-32 sm:pt-48">
    <div class="flex flex-row gap-4">
        <img
            src="./images/laptop.png" 
            alt="About Me" 
            class="hidden sm:flex object-cover rounded-xl w-[100px] h-[300px] filter grayscale brightness-50"   
        />
        <img
            src="./images/laptop.png" 
            alt="About Me" 
            class="hidden sm:flex object-cover rounded-xl w-[100px] h-[200px] filter grayscale brightness-50"   
        />
    </div>
    <div>
        <div x-html="description"></div>

        <div class="flex gap-4 mt-4 max-w-[600px] mx-auto mb-6">
            <div class="bg-gradient-to-r from-gray-800 to-black p-5 rounded-lg cursor-pointer">
                <h2 class="sm:text-4xl text-2xl font-semibold bg-gradient-to-r from-blue-600 to-pink-500 bg-clip-text text-transparent"><span x-text="number_of_projects"></span><span> +</span></h2>
                <p class="text-gray-400">Projects</p>
            </div>
            <div class="bg-gradient-to-r from-gray-800 to-black p-5 rounded-lg cursor-pointer">
                <h2 class="sm:text-4xl text-2xl font-semibold bg-gradient-to-r from-blue-600 to-pink-500 bg-clip-text text-transparent"><span x-text="years_of_experience"></span><span> +</span></h2>
                <p class="text-gray-400">years experience</p>
            </div>
            <div class="bg-gradient-to-r from-gray-800 to-black p-5 rounded-lg cursor-pointer">
                <h2 class="sm:text-4xl text-2xl font-semibold bg-gradient-to-r from-blue-600 to-pink-500 bg-clip-text text-transparent"><span x-text="number_of_clients"></span><span> +</span></h2>
                <p class="text-gray-400">happy clients</p>
            </div>
        </div>
    </div>
</div>