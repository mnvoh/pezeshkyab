@extends('master')

@section('content')

    @include('appointment.step-viewer')


    <div class="row">
        <div class="col-sm12 col-md-10 col-lg-8">
            @if(isset($error))
                <p class="text-error">{{ $error }}</p>
            @endif
            <table class="table table-bordered">
                <tr>
                    <th colspan="2" class="text-center">{{ trans('main.invoice') }}</th>
                </tr>
                <tr>
                    <th>{{ trans('main.title') }}</th>
                    <td>{{ $filled_info['b_fee_title'] }}</td>
                </tr>
                <tr>
                    <th>{{ trans('main.amount') }}</th>
                    <td>{{ $filled_info['b_fee_amount'] }} {{ trans('currencies.irr') }}</td>
                </tr>
				<tr>
					<th>{{ trans('main.selected_insurance') }}</th>
					<td>{{ $filled_info['b_insurance_title'] ? $filled_info['b_insurance_title'] : '-' }}</td>
				</tr>
				<tr>
					<th>{{ trans('main.final_amount') }}</th>
					<td>
						{{ $filled_info['b_fee_amount'] * $filled_info['b_insurance_rate'] }}
						{{ trans('currencies.irr') }}
					</td>
				</tr>
            </table>
            @if(is_numeric($filled_info['b_fee_amount']) && $filled_info['b_fee_amount'] > 0)
                <form action="{{ $next_step_link }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-block btn-success"  name="form-submitted" value="true">
                        {{ trans('main.pay') }}
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection

