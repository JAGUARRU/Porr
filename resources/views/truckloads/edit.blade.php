<x-app-layout title="แก้ไขการจัดส่ง">
    <div class="container grid px-6 mx-auto ">


        <div class="my-6">

            <div class="flex">
                <a href="{{ route('truckloads.view', $route->truck_id) }}" class="flex items-center justify-between px-6 py-3 text-sm leading-5 mx-2 transition-colors duration-150 bg-blue-500 text-white font-semibold hover:text-gray-200 border border-blue-500 hover:border-transparent rounded-lg">
                    <span class="text-base">ย้อนกลับ</span>
                </a>
            </div>

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                ข้อมูลการจัดส่งเส้นทาง #{{ $route->id }}
            </h2>
    
            @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
            @endif
            
            @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">เกิดข้อผิดพลาดบางอย่าง</div>

                <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="flex flex-row">
                <svg class="w-6 h-6 dark:text-white" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
                </svg>
                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    แก้ไขข้อมูลการจัดส่ง
                </h4>
            </div>
            
            <form action="{{ url('truckloads/'.$route->id) }}" method="POST" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 text-base font-semibold text-gray-600 dark:text-gray-400">
                @csrf
                @method('PUT')

  
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">

                    <div class="col-span-2">

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">สถานะ</label>
                            <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="route_status" value="{{ old('route_status', $route->route_status) }}">
                                <option value="0" {{ ($route->route_status == Helper::GetRouteStatus(0)) ? ("selected") : ("")}}>{{Helper::GetRouteStatus(0)}}</option>
                                <option value="1" {{ ($route->route_status == Helper::GetRouteStatus(1)) ? ("selected") : ("")}}>{{Helper::GetRouteStatus(1)}}</option>
                                <option value="2" {{ ($route->route_status == Helper::GetRouteStatus(2)) ? ("selected") : ("")}}>{{Helper::GetRouteStatus(2)}}</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="text-gray-700 dark:text-gray-400">กำหนดวันส่ง</label>
                            <input type="datetime-local" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" id="transportDate" name="transportDate" value="{{ old('transportDate', $route->transportDate) }}"/>
                        </div> 

                        <div class="flex mt-12 place-content-end pb-4">
                            <div class="pr-6">
                                <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    บันทึก
                                </button>
                            </div>
                            <div class="pr-4">
                                <button class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    กลับ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>  

            </form>  

            <div class="flex flex-row">
                <svg class="w-6 h-6 dark:text-white" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
                </svg>
                <h4 class="mb-4 text-lg pl-2 font-semibold text-gray-600 dark:text-gray-300">
                    แก้ไขรายการออเดอร์
                </h4>
            </div>
    
            <div class="w-full overflow-hidden rounded-lg shadow-xs mt-4 ">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="font-semibold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">รหัสออเดอร์</th>
                                <th class="px-4 py-3">ร้านค้า</th>
                                <th class="px-4 py-3">ติดต่อ</th>
                                <th class="px-4 py-3">สถานะ</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
 
                            @php
                                $lists = $route->lists()->with('order')->paginate(10);
                            @endphp

                            @foreach ($lists as $list)

                            <tr class="text-gray-700 dark:text-gray-400 text-center">
                                <td class="px-4 py-3">
                                    {{  $list->order->id }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $list->order->retail_name}}
                                </td>
                                <td class="px-4 py-3 text-left">

                                    @php
                                        // current info from retail
                                        $retail = $list->order->retail()->get()->first();
                                    @endphp
                                    
                                    <div><span>เบอร์โทรศัพท์:</span> {{ $retail->retail_phone }}</div>
                                    <div><span>ช่องทางติดต่ออื่น:</span> {{ $retail->retail_contact }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span @class([
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-600' => $list->route_list_status != "รอส่ง",
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-600' => $list->route_list_status == "รอส่ง"
                                    ])>
                                        {{ $list->route_list_status }}  
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2 text-sm w-full">
   

                                            @if ($route->route_status == Helper::GetRouteStatus(1))
                                            <form method="post" action="{{ route('truckloads.update_order', ["id"=>$route->id, "order_id" => $list->order->id, "type"=>"toggle"]) }}" class="flex justify-between">
                                                    @csrf
                                                    @method('put')
                                                <button
                                                    type="submit"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                                                    @if ($list->route_list_status == "รอส่ง")
                                                    ตั้งเป็นส่งสำเร็จแล้ว
                                                    @else
                                                    ตั้งเป็นรอส่ง
                                                    @endif
                                                </button>
                                            </form>
                                            @endif

                                            <form method="post" action="{{ route('truckloads.update_order', ["id"=>$route->id, "order_id" => $list->order->id, "type"=>"cancel"]) }}" class="flex justify-between">
                                                @csrf
                                                @method('put')

                                                <button
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                    aria-label="Cancel">
                                                    ยกเลิก
                                                </button>
                                            </form>
                                            
                                    </div>
                                </td>
                            </tr>
                        
                            @endforeach
    
                        </tbody>
                    </table>
            
                </div>
                <div
                    class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">
                        {{ __('pagination.showing') }} {{ $lists->firstItem() }}-{{ $lists->lastItem() }} {{ __('pagination.of') }} {{ $lists->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        <nav aria-label="Table navigation">
                            <ul class="inline-flex items-center">
                                
                                <li>
                                    <a href="{{ $lists->url( $lists->currentPage() - 1 ) }}">
                                        <button
                                            class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                            aria-label="Previous">
                                            <svg class="w-4 h-4 fill-current" aria-hidden="true"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </a>
                                </li>
    
                                @php
    
                                $curPage = $lists->currentPage();
                                $totalPage = $lists->lastPage();
    
                                $startPage = ($curPage < 5)? 1 : $curPage - 4;
                                $endPage = 8 + $startPage;
                                $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
                                $diff = $startPage - $endPage + 8;
                                $startPage -= ($startPage - $diff > 0) ? $diff : 0;
    
                                @endphp
    
                                @if($lists->total())
                                    
                                    @for ($i=$startPage; $i<=$endPage; $i++)
                                        <li>
                                            <a href="{{ $lists->url($i) }}">
                                                @php
                                                    if ($curPage != $i) echo '<button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                    else echo '<button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">'.$i.'</button>';
                                                @endphp
                                            </a>
                                        </li> 
                                    @endfor
                            
                                @endif
    
                                <li>
                                    <a href="{{ $lists->nextPageUrl() }}">
                                    <button
                                        class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                        aria-label="Next">
                                        <svg class="w-4 h-4 fill-current" aria-hidden="true"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    </a>
                                </li>
    
                            </ul>
                        </nav>
                    </span>
                </div>
            </div>

    

        </div>
    </div>
</x-app-layout>