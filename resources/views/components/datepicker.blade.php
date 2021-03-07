@props(['id'])

<input {{ $attributes }} type="text" class="form-control datetimepicker-input" id="{{ $id }}" data-toggle="datetimepicker" data-target="#{{ $id }}"
onchange="this.dispatchEvent(new InputEvent('input'))"
/>


@push('js')
<script type="text/javascript">
    $(function () {
        $('#{{ $id }}').datetimepicker({
        	format: 'L'
        });
    });
</script>
@endpush