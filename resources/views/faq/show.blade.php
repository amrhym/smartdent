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
                        <a href="{{ route('steps.index') }}">@lang('Steps')</a></li>
                    <li class="breadcrumb-item active">@lang('Steps Info')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Steps Info')</h3>
                <div class="card-tools">
                    @can('Steps-update')
                        <a href="{{ route('steps.edit', $prescriptions) }}?user_id={{ $prescriptions->user_id }}" class="btn btn-info">@lang('Edit')</a>
                    @endcan
                    <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
            <div id="print-area" class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoice p-3 mb-3">
                            <div class="text-center">
                                @if (!$prescriptions->isEmpty())
                                    <p class="text-right">@lang('Prescription ID') #{{ str_pad($prescriptions[0]['id'], 4, '0', STR_PAD_LEFT) }}<br></p>
                                @endif
                                <!-- info row -->

                                <!-- /.row -->
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_id">@lang('Patient Name')</label>
                                        @if (!$prescriptions->isEmpty())
                                        <p>{{ App\Models\User::get_name($prescriptions[0]['user_id']) }}</p>
                                        @endif
                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="t1" class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">@lang('Steps')</th>
                                                    <th scope="col">@lang('On Clinic')</th>
                                                    <th scope="col">@lang('Payment')</th>

                                                </tr>
                                            </thead>
                                            <tbody id="medicine">
                                            @if (!$prescriptions->isEmpty())
                                            @foreach($prescriptions as $p)
                                                <tr>
                                                        <td>
                                                            {{ $p['step'] }}
                                                        </td>
                                                        <td>
                                                            {{ $p['on_clinic'] }}
                                                        </td>
                                                        <td>
                                                            {{ $p['payment'] }}
                                                        </td>
                                                </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                               <td>No data Found</td>
                                               <td>No data Found</td>
                                               <td>No data Found</td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
