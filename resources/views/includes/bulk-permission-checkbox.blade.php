@php if(isset($permissions)) { $supersubset = $permissions->pluck('id')->toArray(); }@endphp
<div class="col-md-12">
    <div class="d-flex-space-between">
        <label class="mt-2">Permissions</label>
        <div class="checkbox mt-2">
            <input type="checkbox" id="check-permission" @if(isset($supersubset) && isset($permissionsViaRole)) @if(!array_diff($supersubset, $permissionsViaRole)) checked @endif @endif>
            <label for="check-permission">Select all permissions</label>
            @error('permissions')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
@foreach($permissionsGroups as $type => $data)
@php $subset = $data->pluck('id')->toArray(); @endphp
<div class="col-md-3 col-sm-12">
    <div class="card">
        <div class="card-header d-flex-space-between">
            <div class="checkbox">
                <input type="checkbox" class="check-permission" onchange="childrenPermissionCheckbox('{{ $type }}', this)" id="check-permission-{{ $type }}" @if(isset($subset) && isset($permissionsViaRole)) @if(!array_diff($subset, $permissionsViaRole)) checked @endif @endif>
                <label for="check-permission-{{ $type }}">Select all {{ $type }}</label>
            </div>
        </div>
        <div class="card-body">
            @foreach($data as $key => $value)
            <div class="checkbox mt-2 mb-2">
                <input class="check-permission check-permission-{{ $type }}" onchange="parentPermissionCheckbox('{{ $type }}', this)" type="checkbox" name="permissions[]" value="{{ $value->id }}" id="permission-{{ $type }}-{{ $key }}" @if(isset($permissionsViaRole)) @if(in_array($value->id, $permissionsViaRole)) checked @endif @endif>
                <label for="permission-{{ $type }}-{{ $key }}">{{ $value->name }}</label>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach