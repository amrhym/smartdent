@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('steps.index') }}">@lang('Prescription')</a></li>
                    <li class="breadcrumb-item active">@lang('Add Prescription')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Add Prescription')</h3>
            </div>
            <div class="card-body">
                <form class="form-material form-horizontal" action="{{ route('steps.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id">@lang('Select Patient') <b class="ambitious-crimson">*</b></label>
                                <select name="user_id" id="user_id" class="form-control custom-width-100 select2 @error('user_id') is-invalid @enderror" required>
                                    <option value="">--@lang('Select')--</option>
                                    @foreach($patients as $patient) {
                                        <option value="{{ $patient->id }}" @if($patient->id == request()->user_id) selected @endif>{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Prescription Date') <b class="ambitious-crimson">*</b></label>
                                <input type="text" name="prescription_date" id="prescription_date" class="form-control flatpickr @error('prescription_date') is-invalid @enderror" placeholder="@lang('Prescription Date')" value="{{ old('prescription_date', date('Y-m-d')) }}" required>
                                @error('prescription_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="t1" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('Step')</th>
                                            <th scope="col">@lang('On Clinic')</th>
                                            <th scope="col">@lang('Payment needed')</th>
                                            <th scope="col" class="custom-white-space">@lang('Add / Remove')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (old('medicine_name'))
                                            @foreach (old('medicine_name') as $key => $value)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="medicine_name[]" class="form-control" value="{{ old('medicine_name')[$key] }}" placeholder="@lang('Step')">
                                                    </td>
                                                    <td>
                                                        <select name="medicine_type[]" class="form-control select2" id="medicine_type[]" value="{{ old('medicine_type')[$key] }}">
                                                            <option value="">--@lang('Select')--</option>
                                                            <option value="1">@lang('Yes')</option>
                                                            <option value="0">@lang('No')</option>
                                                           </select>


                                                    </td>
                                                    <td>
                                                        <select name="instruction[]" class="form-control select2" id="instruction[]" value="{{ old('instruction')[$key] }}">
                                                            <option value="">--@lang('Select')--</option>
                                                            <option value="1">@lang('Yes')</option>
                                                            <option value="0">@lang('No')</option>
                                                        </select>


                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-info m-add"><i class="fas fa-plus"></i></button>
                                                        <button type="button" class="btn btn-info m-remove"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tbody id="medicine">
                                        <tr>
                                            <td>
                                                <input type="text" name="medicine_name[]" class="form-control" value="" placeholder="@lang('Step')">
                                            </td>
                                            <td>
                                                <select name="medicine_type[]" class="form-control" id="medicine_type[]" value="">
                                                    <option value="">--@lang('On Clinic')--</option>
                                                    <option value="1">@lang('Yes')</option>
                                                    <option value="0">@lang('No')</option>
                                                </select>


                                            </td>
                                            <td>
                                                <select name="instruction[]" class="form-control" id="instruction[]" value="">
                                                    <option value="">--@lang('Select')--</option>
                                                    <option value="1">@lang('Yes')</option>ma
                                                    <option value="0">@lang('No')</option>
                                                </select>


                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-info m-add"><i class="fas fa-plus"></i></button>
                                                <button type="button" class="btn btn-info m-remove"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                    <a href="{{ route('steps.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/steps.js') }}"></script>
@endpush
