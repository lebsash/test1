<div class="row">
    <div class="form-group col-sm-5">
        <label>{{ $label }}</label>
        <select class="form-control" name="{{ $fieldName }}">
            <option value="">- {{ isset($optionBlankLabel) ? $optionBlankLabel : 'Select' }} -</option>
            @foreach ($options as $option)
                <option value="{{ $option['value'] }}" data-data-1="{{ $option['data-1'] }}" {{ (isset($selected) ? ( $selected == $option['value'] ? 'selected="selected"' : '') : '' ) }}>{{ $option['label'] }}</option>
            @endforeach
        </select>
        <em>{{ (isset($description) ? $description : '' )}}</em>
    </div>
</div>
