<html>
        <head>
            <meta charset='utf-8'>
            <style>
                table, th, td {
                  border: 0px;
                }
            </style>
          <meta http-equiv=Content-Type content="text/html; charset=utf-8">
        </head>
        <body style="padding: 0; margin-top: 0in"> 
            <table class="table" cellpadding="0" cellspacing="0" style="margin-left:-25.5pt; margin-top: 0in; border-collapse:collapse;">
                    <tr>    
                        <th width="15%" style="min-width: 15%"></th>
                        <th width="12%" style="min-width: 12%"></th>
                        <th width="12%" style="min-width: 12%"></th>
                        <th width="12%" style="min-width: 12%"></th>
                        <th width="12%" style="min-width: 12%"></th>
                        <th width="12%" style="min-width: 12%"></th>
                        <th width="10%"  style="min-width: 10%"></th>
                        <th width="100px"  style="max-width: 100px"></th>
                    </tr>
                <tbody>
                    <tr>
                        <td colspan="8" style="text-align: center;  font-size: 18.5">
                            <b>MA'LUMOTNOMA<b>
                            <p style="margin-bottom: 0px; margin-top: 0px"><b>{{$cadry->last_name}} {{$cadry->first_name}} {{$cadry->middle_name}}</b></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                        <td style="text-align: right" rowspan="8">    
                            <img src="{{asset('storage/'.$cadry->photo)}}" width="112" height="153">       
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="7">{{$cadry->post_date}} dan:</td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="6"><b>{{$cadry->post_name}}</b></td>
                        <td></td>
                    </tr>
                    <tr style="font-size: 14.5px;">
                        <td colspan="3">
                            <b>Tug'ilgan yili:</b>
                        </td>
                        <td></td>
                        <td colspan="3">  
                            <b>Tug'ilgan joyi:</b>
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px">
                        <td colspan="3" style="vertical-align: top; margin-bottom: 4pt">
                            {{$cadry->birht_date}}
                        </td>
                        <td></td>
                        <td colspan="3">  
                            {{$cadry->birth_region->name ?? ''}}, {{$cadry->birth_city->name ?? ''}}
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px;">
                        <td colspan="3">
                            <b>Millati:</b>
                        </td>
                        <td></td>
                        <td colspan="3">  
                            <b>Partiyaviyligi:</b>
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="3" style="vertical-align: top">
                            {{$cadry->nationality->name}}
                        </td>
                        <td></td>
                        <td colspan="3">  
                            {{$cadry->party->name}}
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px;">
                        <td colspan="3">  
                            <b>Ma'lumoti:</b>
                        </td>
                        <td></td>
                        <td colspan="3">   
                            <b>Tamomlagan:</b>
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan='3' style="vertical-align: top">
                            {{$cadry->education->name ?? ''}}
                        </td>
                        <td></td>
                        <td colspan="4">   
                            {{$cadry->info_education->date2 ?? ''}} yil, {{$cadry->info_education->institut ?? ''}}
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="3"> 
                            <b>Ma'lumoti bo'yicha mutaxassisligi:</b>
                        </td>
                        <td></td>
                        <td colspan="4">  
                            {{$cadry->info_education->speciality ?? ''}}
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px;">
                        <td colspan="3"> 
                            <b>Ilmiy darajasi:</b>
                        </td>
                        <td></td>
                        <td colspan="4">  
                            <b>Ilmiy unvoni:</b>
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="3"> 
                            {{$cadry->cadry_degree->name ?? ''}}
                        </td>
                        <td></td>
                        <td colspan="4">  
                            {{$cadry->cadry_title->name ?? ''}}
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px;">
                        <td colspan="3"> 
                            <b>Qaysi chet tillarini biladi:</b>
                        </td>
                        <td></td>
                        <td colspan="4"> 
                            <b>Xarbiy (maxsus) unvoni:</b>
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="3"> 
                            {{$lan}}
                        </td>
                        <td></td>
                        <td colspan="4">  
                            {{$cadry->military_rank}}
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px;">
                        <td colspan="8"> 
                            <b>Davlat mukofotlari bilan taqdirlanganmi(qanaqa):</b>
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="8"> 
                            @if ($incentives->count())
                                @foreach ($incentives as $incentive)
                                    {{$incentive->type_action}}, 
                                @endforeach
                            @else
                                Taqdirlanmagan
                            @endif
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px;">
                        <td colspan="8"> 
                           <b>Xalq deputatlari respublika, viloyat, shahar va tuman Kengashi deputatimi yoki boshqa saylanadigan organlarning a'zosimi(to'liq ko'rsatilishi lozim):</b>
                        </td>
                    </tr>
                    <tr style="font-size: 14.5px; margin-bottom: 4pt">
                        <td colspan="8"> 
                            {{$cadry->deputy}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="text-align: center;  font-size: 18.5; margin-bottom: 4pt">
                            <b>MEHNAT FAOLIYATI<b>
                        </td>
                    </tr>
                    @foreach ($carers as $carer)
                        <tr style="font-size: 14.5; margin-bottom: 4pt">
                            <td style="vertical-align: top;">
                                {{$carer->date1}}-{{$carer->date2}} yy.
                            </td>
                            <td colspan="7">
                                - {{$carer->staff}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="text-autospace:none"><span>&nbsp;</span></p>

            <b><span><br clear="all" style="page-break-before:always">
                </span></b>

            <b style="text-align:center; font-size:12.0pt; margin-top: 0px">{{$cadry->last_name}} {{$cadry->first_name}} {{$cadry->middle_name}}ning yaqin qarindoshlari haqida ma'lumot</b>
    
            <p style="text-align:center; margin-bottom: 5px; margin-top: 0px"><b><span>MA'LUMOT</span></b></p>

            <table class="table" cellpadding="0" cellspacing="0" style="margin-left:-25.5pt; border-collapse:collapse; border:none; text-align: center;  font-size: 14.5">
                <tr>    
                    <th width="16%" style="min-width: 16%;"></th>
                    <th width="18%" style="min-width: 18%;"></th>
                    <th width="22%" style="min-width: 22%;"></th>
                    <th width="22%" style="min-width: 22%;"></th>
                    <th width="22%" style="min-width: 22%;"></th>
                </tr>
                <tbody>
                    <tr>
                        <td style="border:solid black 1pt;"><b>Qarindoshligi</b></td>
                        <td style="border:solid black 1pt;"><b>Familiyasi,ismi va otasining ismi</b></td>
                        <td style="border:solid black 1pt;"><b>Tug'ilgan yili va joyi</b></td>
                        <td style="border:solid black 1pt;"><b>Ish joyi va lavozimi</b></td>
                        <td style="border:solid black 1pt;"><b>Turar joyi</b></td>
                    </tr>
                    @foreach ($cadry_relatives as $item)
                        <tr>
                            <td style="border: solid black 1pt;"><b>{{$item->relative->name}}</b></td>
                            <td style="border: solid black 1pt;">{{$item->fullname}}</td>
                            <td style="border: solid black 1pt;">{{$item->birth_place}}</td>
                            <td style="border: solid black 1pt;">{{$item->post}}</td>
                            <td style="border: solid black 1pt;">{{$item->address}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        </body>
    </html>