@if ($options)  
    @foreach ($options as $item)
        <option value="{{$item->id}}"> {{$item->name}} </option>
    @endforeach
@endif