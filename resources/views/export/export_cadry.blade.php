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
                <td class="text-center fw-bold align-middle">
                    {{ $loop->index + 1 }}
                </td>
                <td class="text-center align-middle"> {{ $item->last_name }} </td>
                <td class="text-center align-middle"> {{ $item->first_name }} </td>
                <td class="text-center align-middle"> {{ $item->middle_name }} </td>

                <td class="text-center align-middle"> {{ $item->birth_region->name }} </td>
                <td class="text-center align-middle"> {{ $item->birth_city->name }} </td>
                <td class="text-center align-middle"> {{ $item->birht_date }} </td>
                <td class="text-center align-middle"> {{ $item->address_region->name }} </td>
                <td class="text-center align-middle"> {{ $item->address_city->name }} </td>
                <td class="text-center align-middle"> {{ $item->address }} </td>

                <td class="text-center align-middle"> {{ $item->allStaffs[0]->staff->category->name ?? '' }} </td>

                <td class="text-center align-middle"> {{ $item->pass_region->name }} </td>
                <td class="text-center align-middle"> {{ $item->pass_city->name ?? '' }} </td>
                <td class="text-center align-middle"> {{ $item->passport }} </td>
                <td class="text-center align-middle"> {{ $item->pass_date }} </td>
                <td class="text-center align-middle"> {{ $item->jshshir }} </td>

                <td class="text-center align-middle"> {{ $item->education->name }} </td>
                <td class="text-center align-middle"> {{ $item->nationality->name }} </td>
                <td class="text-center align-middle"> {{ $item->party->name }} </td>
                <td class="text-center align-middle"> {{ $item->cadry_title->name }} </td>
                <td class="text-center align-middle"> {{ $item->cadry_degree->name }} </td>
                <td class="text-center align-middle"> {{ $item->military_rank }} </td>
                <td class="text-center align-middle"> {{ $item->deputy }} </td>
                <td class="text-center align-middle"> </td>
                <td class="text-center align-middle"> {{ $item->phone }} </td>

                <td class="text-center align-middle"> Erkak </td>

                <td class="text-center align-middle"> {{ $item->job_date }} </td>

                <td class="text-center align-middle"> {{ $item->allStaffs[0]->department->name ?? '' }} </td>
                <td class="text-center align-middle"> {{ $item->allStaffs[0]->staff_date ?? '' }} </td>
                <td class="text-center align-middle"> {{ $item->allStaffs[0]->staff_full ?? '' }} </td>
            </tr>
        @endforeach
    </tbody>
</table>

</html>
