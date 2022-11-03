<html>
<div style="overflow-x:auto;">
    <table style="border: 1pt solid black;" cellpadding="0" cellspacing="0">
        <tr>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                #</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                FIO</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Tug'ilgan joyi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Tug'ilgan sanasi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Yashayotgan mazili</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Pasport berilgan jpyi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Seriya raqami</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Pasport berilgan sanasi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                JSHSHIR</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Ma'lumoti</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Institutu</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Mutaxassisligi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Millati</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Partiyaviyligi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Title</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Degree</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Xarbiy unvoni</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Deputatligi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Tillari</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Phone</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Jinsi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Ishga kirgan sanasi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Bo'lim nomi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Lavozim sanasi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Lavozimi</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Kategoriya</th>
            <th
                style="border: 1pt solid black;background-color: #4b5bf3;align-items: center;text-align: center;font-weight: bold;">
                Jazo turi</th>
        </tr>
        <tbody>

            @foreach ($cadries as $item)
                <tr>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $loop->index + 1 }}
                    </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->last_name }} {{ $item->first_name }} {{ $item->middle_name }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->birth_region->name }},{{ $item->birth_city->name }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->birht_date }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->address_region->name }},
                        {{ $item->address_city->name }} ,{{ $item->address }} </td>

                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->pass_region->name }},{{ $item->pass_city->name ?? '' }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->passport }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->pass_date }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;"> {{ $item->jshshir }}
                    </td>

                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->education->name }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ implode(',', $item->instituts->pluck('institut')->toArray()) }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ implode(',', $item->instituts->pluck('speciality')->toArray()) }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->nationality->name }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->party->name }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->cadry_title->name }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->cadry_degree->name }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->military_rank }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;"> {{ $item->deputy }}
                    </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;"> </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;"> {{ $item->phone }}
                    </td>

                    <td style="border: 1pt solid black; align-items: center; text-align: center;"> Erkak </td>

                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->job_date }} </td>

                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->allStaffs[0]->department->name ?? '' }}
                    </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->allStaffs[0]->staff_date ?? '' }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->allStaffs[0]->staff_full ?? '' }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        {{ $item->allStaffs[0]->staff->category->name ?? '' }} </td>
                    <td style="border: 1pt solid black; align-items: center; text-align: center;">
                        @if ($item->discips->first())
                            {{ $item->discips->first()->number }}, {{ $item->discips->first()->date_action }} yil,
                            {{ $item->discips->first()->type_action }}
                        @else
                            Ko'rilmagan
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>


</html>
