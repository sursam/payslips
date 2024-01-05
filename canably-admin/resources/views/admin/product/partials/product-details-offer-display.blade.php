 <div class="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0 mb-6">
     <!-- Author -->
     <div class="flex items-center sm:mr-4">

         <a class="block text-xl font-semibold text-slate-800 whitespace-nowrap" href="#0">
             {{ $productData->name? $productData->name:'' }}
         </a>
     </div>
     <!-- Right side -->
     <div class="flex flex-wrap items-center sm:justify-end space-x-4">
         <!-- Tag -->
         <div
             class="inline-flex items-center text-xs font-medium text-slate-100 bg-slate-900 bg-opacity-60 rounded-full text-center px-2 py-0.5" style="{{ $productData->discount ? 'display: show;' : 'display: none;' }}">
             <svg class="w-3 h-3 shrink-0 fill-current text-amber-500 mr-1" viewBox="0 0 12 12">
                 <path
                     d="M11.953 4.29a.5.5 0 00-.454-.292H6.14L6.984.62A.5.5 0 006.12.173l-6 7a.5.5 0 00.379.825h5.359l-.844 3.38a.5.5 0 00.864.445l6-7a.5.5 0 00.075-.534z" />
             </svg>
             {{ $productData->discount ? 'Special Discount' : '' }}
         </div>
         <!-- Rating -->
         <div class="flex items-center space-x-2 mr-2">
             <!-- Stars -->
             {{--
                To Do: Need to fix a design for dynamic width fill up
                --}}
             {{-- dynamic fillup need design fix --}}
             <div class="flex space-x-1 profile-rating">
                <div class="show-rating-list profile-rating--list">
                    @php ($filledWidth = (($productData->average_rating / 5) * 100))
                    <div class="rating_area">
                        <div class="gray_rating"></div>
                        <div class="filled_rating" style="width: {{ $filledWidth }}%;"></div>
                    </div>
                </div>
            </div>
             <!-- Rate -->
             <div class="inline-flex text-sm font-medium text-amber-600">{{ $productData->average_rating >0 ? $productData->average_rating : 'No Rating yet' }}</div>
         </div>
     </div>
 </div>
