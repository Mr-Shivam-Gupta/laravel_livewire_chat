<div x-data="{type:'all'}" class="flex flex-col transition-all h-full overflow-hidden">
  <header class="px-3 z-10 bg-white sticky top-0 w-full py-2">
    <div class="border-b justify-between flex items-center pb-2">
        <div class="flex items-center text-2xl">
            <h5 class="font-extrabold text-2xl">Chats</h5>
        </div>
       <button>
        <svg class=" h-7 w-7" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"  viewBox="0 0 16 16">
            <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
          </svg>
       </button>
    </div>
    {{-- if need addd overflow-x-scroll bleow --}}
    <div class="flex gap-3 items-center overflow-x-scroll overflow-hidden  p-2 bg-white">
        <button @click="type='all'" :class="{'bg-blue-100 border-0 text-black':type=='all'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5  border " >
            All</button>
        <button @click="type='deleted'" :class="{'bg-blue-100 border-0 text-black':type=='deleted'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5  border " >
            Deleted</button>
    </div>
  </header>

  <main class="overflow-y-scroll overflow-hidden grow h-full relative" style="contain: content">
<ul class="p-2 grid w-full space-y-2">
    <li class="py-3 hover:bg-gray-50 rounded-2xl   transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2">
        <a href="#" class="shrink-0">
            <x-avatar/>
        </a>

        <aside class="grid grid-cols-12 w-full">

            <a href="#" class=" col-span-11 border-b pb-2 border-gray-200  relative overflow-hidden truncate leading-5 w-full flex-nowrap">
                    <div class="flex justify-between w-full items-center">
                        <h6 class=" truncate font-medium tracking-wider text-gray-500 ">John Doe</h6>
                    <small class="text-gray-700">5d</small>
                    </div>

                    <div class="flex gap-x-2 items-center">
                        <span> </span>
                        <span> </span>
                    </div>
            </a>


        </aside>
    </li>
</ul>
  </main>
</div>
