<div class="frame-list">
                      
                      <div class="search_core">
                      <span class="core_text core">Dữ liệu: <span class="core_data"> {{ $paginate}}</span></span>
                      <input type="text" id="search_ip" onkeyup="Search(this)" placeholder="Tìm kiếm">
                        <button class="backindex"  onclick="return Query('back','')" >back</button>
                    </div>
                      <table class="mytable">
                          <tr class="prepend-data">
                              <th>ID</th>
                              <th>MÃ</th>
                              <th>HỌ TÊN</th>
                              <th>SỐ ĐIỆN THOẠI</th>
                              <th>ĐỊA CHỈ</th>
                              <th>EMAIL</th>
                              <th>XOÁ</th>
                              <th>SỬA</th>
                          </tr>
                          
                         
                          
                          @foreach ($decode_limit as $limit)
                            
                          <tr>    
                              <td  class="wait-data">{{ $limit->id }}</td>
                              <td  class="wait-data">{{ $limit->Ma }}</td>
                              <td  class="wait-data">{{ $limit->HoTen }}</td>
                              <td  class="wait-data">{{ $limit->Sdt }}</td>
                              <td  class="wait-data">{{ $limit->DiaChi }}</td>
                              <td  class="wait-data">{{ $limit->Email }}</td>
                              <td  class="wait-data"><button type="button" onclick="return Query('delete','{{ $limit->id }}')" class="btn-xoa btnAc">xoá</button></td>
                              <td  class="wait-data"><button type="button"   onclick="return Query('openupdate','{{ $limit->id }}')"  class="btn-sua btnAc">sửa</button></td>
                          </tr>
                          @endforeach

                         

                      </table>
                      <div class="notdata">
                                <h2>
                                    KHÔNG TÌM THẤY KẾT QUẢ
                                </h2>
                      </div>
                      <div class="wait_paginate">
                                  <img src="{{asset('/public/images/load.gif')}}" alt="">
                       </div>
                       @if( $totalPage > 1)     
                      <nav aria-label="Page navigation" class="mypagination">
                          @php
                              $end = 0;
                            
                          @endphp
                         
                         <ul class="pagination">
                          <li class="page-item" onclick="Paginate('Prev','','',this,'{{$UrlSearch}}');"><a class="page-link aPrev" href="javascript:void(0)">Previous</a></li>
                          @foreach ($slice_Paginate as $idx)
                          @php
                              ++$end;
                              $crpage = (int)$currentPage ;
                            
                          @endphp
                              @if ($end  == count($slice_Paginate))
                                     
                                     <li class="page-item"  onclick="Paginate('numbpage','{{$idx}}','end',this, '{{$UrlSearch}}')" >
                                     <input type="hidden" class="ip_end" value="{{ $idx }}">
                                     @if ($currentPage  != '' && $idx == $UrlPage || ( $end == 1 && $UrlPage == 1) )
                                     
                                        <a class="page-link myactive" href="javascript:void(0)"> {{$idx}}</a></li>
                              
                                       @else
                                         <a class="page-link" href="javascript:void(0)"> {{$idx}}</a>
                                     
                                     @endif
                                 </li>
                              @elseif ($currentPage  != '' && $idx == $UrlPage || ( $end == 1 && $UrlPage == 1) )
                              <li class="page-item"  onclick="Paginate('numbpage','{{$idx}}','end',this,'{{$UrlSearch}}')" >
                             
                              <a class="page-link myactive" href="javascript:void(0)"> {{$idx}}</a></li>
                             
                           
                              @else
                                   <li class="page-item"  onclick="Paginate('numbpage','{{$idx }}','notend',this,'{{$UrlSearch}}')"  ><a class="page-link" href="javascript:void(0)"> {{$idx}}</a></li>
                              @endif
                        
                          @endforeach
                          <li class="page-item" onclick="Paginate('Next','','',this,'{{$UrlSearch}}');"><a class="page-link aNext" href="javascript:void(0)">Next</a></li>
                      </ul>
                      </nav>
                      @endif
                  </div>