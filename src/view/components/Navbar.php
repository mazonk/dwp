<header class="w-[100%] fixed top-0 left-0 right-0 bg-bgDark z-[10]">
  <nav class="max-w-[1440px] w-[100%] flex justify-between items-center gap-[4rem] mx-auto py-[1rem] px-[100px] z-[10]">
    <!-- Logo -->
    <div>logo</div>

    <!-- Menu  -->
    <!-- (the ml-[] is for balancing the different width of the elements on either siede of the navbar thus it is in the center of the page) -->
    <div class="flex justify-center items-center gap-[2.5rem] ml-[195px]">
      <div>
        <a href="/dwp" class="font-medium">Home</a>
      </div>
      <div>
        <a href="/dwp/movies" class="font-medium">All Movies</a>
      </div>
      <div>
        <a href="/dwp/upcoming" class="font-medium">Upcoming Movies</a>
      </div>
      <!-- TODO: Scroll down to ticket section -->
      <div>
        <a href="" class="font-medium">Tickets</a>
      </div>
      <!-- TODO: Scroll down to contact section it is in the footer -->
      <div>
        <a href="" class="font-medium">Contact</a>
      </div>
    </div>

    <div class="flex items-center gap-[2rem]">
      <!-- Venue -->
      <div class="relative">
        <button class="flex gap-[.375rem]">
          <i class="ri-map-pin-2-fill h-[18px] text-[18px]"></i>
          <span class="translate-y-[.5px]">Venue Name</span>
        </button>
        <!-- Dropdown -->
        <div class="absolute min-w-[150px] top-[40px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">
          <button class="w-full py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
            Venue Name
          </button>
          <button class="w-full py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
            Venue Name
          </button>
          <button class="w-full py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
            Venue Name
          </button>
        </div>
      </div>
      <!-- Login -->
      <a href="" class="py-[.625rem] px-[1.25rem] bg-primary text-textDark font-medium leading-tight rounded-[8px] ease-in-out duration-[.15s] hover:bg-primaryHover ">
        Login
      </a>
    </div>
  </nav>
</header>