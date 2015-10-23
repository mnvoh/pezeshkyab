@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 text-center">
			{{--<h3 class="text-center">{{ trans('main.doctors') }}</h3>--}}
			{{--<hr />--}}
			<a href="{{ route('admins.doctors') }}" class="admin-stat-item shade1">
				<span class="title">{{ trans('main.total_doctors') }}</span>
				<span class="stat">{{ $total_doctors }}</span>
			</a>

			<a href="{{ route('admins.doctors') }}?status=active" class="admin-stat-item shade1">
				<span class="title">{{ trans('main.active_doctors') }}</span>
				<span class="stat">{{ $active_doctors }}</span>
			</a>

			<a href="{{ route('admins.doctors') }}?status=pending" class="admin-stat-item shade1">
				<span class="title">{{ trans('main.pending_doctors') }}</span>
				<span class="stat">{{ $pending_doctors }}</span>
			</a>

			<a href="{{ route('admins.doctors') }}?status=banned" class="admin-stat-item shade1">
				<span class="title">{{ trans('main.banned_doctors') }}</span>
				<span class="stat">{{ $banned_doctors }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main.admins') }}</h3>--}}
			{{--<hr />--}}

			@if(isset($master_admin) && $master_admin)
				<a href="{{ route('admins.admins') }}" class="admin-stat-item shade2">
					<span class="title">{{ trans('main.total_admins') }}</span>
					<span class="stat">{{ $total_admins }}</span>
				</a>
				<a href="{{ route('admins.admins') }}?type=minor" class="admin-stat-item shade2">
					<span class="title">{{ trans('main.minor_admins') }}</span>
					<span class="stat">{{ $minor_admins }}</span>
				</a>
				<a href="{{ route('admins.admins') }}?type=master" class="admin-stat-item shade2">
					<span class="title">{{ trans('main.master_admins') }}</span>
					<span class="stat">{{ $master_admins }}</span>
				</a>
				{{--<br /><br />--}}
			@endif


			{{--<h3>{{ trans('main.transactions') }}</h3>--}}
			{{--<hr />--}}

			<a href="{{ route('admins.transactions') }}?status=paid" class="admin-stat-item shade3">
				<span class="title">{{ trans('main.finished_transactions') }}</span>
				<span class="stat">{{ $finished_transactions }}</span>
			</a>
			<a href="{{ route('admins.transactions') }}?settled=0" class="admin-stat-item shade3">
				<span class="title">{{ trans('main.unsettled_transactions') }}</span>
				<span class="stat">{{ $unsettled_transactions }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main.reservations') }}</h3>--}}
			{{--<hr />--}}


			<a href="{{ route('admins.reservations') }}?status=active" class="admin-stat-item shade4">
				<span class="title">{{ trans('main.active_reservations') }}</span>
				<span class="stat">{{ $active_reservations }}</span>
			</a>
			<a href="{{ route('admins.reservations') }}?status=free" class="admin-stat-item shade4">
				<span class="title">{{ trans('main.free_reservations') }}</span>
				<span class="stat">{{ $free_reservations }}</span>
			</a>
			<a href="{{ route('admins.reservations') }}?status=done" class="admin-stat-item shade4">
				<span class="title">{{ trans('main.done_reservations') }}</span>
				<span class="stat">{{ $done_reservations }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main.medical_question') }}</h3>--}}
			{{--<hr />--}}

			<a href="{{ route('admins.medical_question') }}" class="admin-stat-item shade5">
				<span class="title">{{ trans('main.total_questions') }}</span>
				<span class="stat">{{ $medical_questions }}</span>
			</a>
			<a href="{{ route('admins.medical_question') }}?answered=answered" class="admin-stat-item shade5">
				<span class="title">{{ trans('main.answered_questions') }}</span>
				<span class="stat">{{ $answered_questions }}</span>
			</a>
			<a href="{{ route('admins.medical_question') }}?answered=unanswered" class="admin-stat-item shade5">
				<span class="title">{{ trans('main.unanswered_questions') }}</span>
				<span class="stat">{{ $unanswered_questions }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main.other') }}</h3>--}}
			{{--<hr />--}}

			<a href="{{ route('admins.fees') }}" class="admin-stat-item shade6">
				<span class="title">{{ trans('main.fees') }}</span>
				<span class="stat">{{ $fees }}</span>
			</a>
			<a href="{{ route('admins.insurances') }}" class="admin-stat-item shade6">
				<span class="title">{{ trans('main.insurances') }}</span>
				<span class="stat">{{ $insurances }}</span>
			</a>
			<a href="{{ route('admins.specialties') }}" class="admin-stat-item shade6">
				<span class="title">{{ trans('main.specialties') }}</span>
				<span class="stat">{{ $specialties }}</span>
			</a>
			<a href="{{ route('admins.hospitals') }}" class="admin-stat-item shade6">
				<span class="title">{{ trans('main.hospitals') }}</span>
				<span class="stat">{{ $hospitals }}</span>
			</a>
			<a href="{{ route('admins.medical_news') }}" class="admin-stat-item shade6">
				<span class="title">{{ trans('main.mednews') }}</span>
				<span class="stat">{{ $medical_news }}</span>
			</a>
			<a href="{{ route('admins.chats') }}" class="admin-stat-item shade6">
				<span class="title">{{ trans('main.chat_msgs') }}</span>
				<span class="stat">{{ $chat_msgs }}</span>
			</a>


        </div>
    </div>
@endsection