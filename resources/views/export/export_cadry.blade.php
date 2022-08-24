<html>
<style>
    table,
    th,
    td {
        border: 1px solid;
    }
</style>
<table class="table">
    <thead>
        <tr>
            <th width="150px" style="align-items: center; text-align: center;">Familiyasi</th>
            <th width="150px" style="align-items: center; text-align: center;">Ismi</th>
            <th width="150px" style="align-items: center; text-align: center;">Otasining ismi</th>
            <th width="150px" style="align-items: center; text-align: center;">Tug'ilgan joyi</th>
            <th width="150px" style="align-items: center; text-align: center;">Tug'ilgan sanasi</th>
            <th width="150px" style="align-items: center; text-align: center;">Yashayotgan mazili</th>
            <th width="150px" style="align-items: center; text-align: center;">Pasport berilgan jpyi</th>
            <th width="150px" style="align-items: center; text-align: center;">Seriya raqami</th>
            <th width="150px" style="align-items: center; text-align: center;">Pasport berilgan sanasi</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
            <th width="150px" style="align-items: center; text-align: center;">Action</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($cadries as $item)
            <tr>
                <td style="align-items: center; text-align: center;">
                    {{ $loop->index + 1 }}
                </td>
                <td style="align-items: center; text-align: center;"> {{ $item->last_name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->first_name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->middle_name }} </td>

                <td style="align-items: center; text-align: center;"> {{ $item->birth_region->name }},{{ $item->birth_city->name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->birht_date }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->address_region->name }}, {{ $item->address_city->name }} ,{{ $item->address }}  </td>

                <td style="align-items: center; text-align: center;"> {{ $item->pass_region->name }},{{ $item->pass_city->name ?? '' }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->passport }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->pass_date }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->jshshir }} </td>

                <td style="align-items: center; text-align: center;"> {{ $item->education->name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->nationality->name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->party->name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->cadry_title->name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->cadry_degree->name }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->military_rank }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->deputy }} </td>
                <td style="align-items: center; text-align: center;"> </td>
                <td style="align-items: center; text-align: center;"> {{ $item->phone }} </td>

                <td style="align-items: center; text-align: center;"> Erkak </td>

                <td style="align-items: center; text-align: center;"> {{ $item->job_date }} </td>

                <td style="align-items: center; text-align: center;"> {{ $item->allStaffs[0]->department->name ?? '' }}
                </td>
                <td style="align-items: center; text-align: center;"> {{ $item->allStaffs[0]->staff_date ?? '' }} </td>
                <td style="align-items: center; text-align: center;"> {{ $item->allStaffs[0]->staff_full ?? '' }} </td>   
                <td style="align-items: center; text-align: center;">
                    {{ $item->allStaffs[0]->staff->category->name ?? '' }} </td>

            </tr>
        @endforeach
    </tbody>
</table>

</html>
