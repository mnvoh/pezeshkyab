@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 text-center">
			{{--<h3 class="text-center">{{ trans('main4.doctors') }}</h3>--}}
			{{--<hr />--}}
			<a href="#" class="admin-stat-item shade1">
				<span class="title">{{ trans('main4.total_doctors') }}</span>
				<span class="stat">{{ $total_doctors }}</span>
			</a>

			<a href="#" class="admin-stat-item shade1">
				<span class="title">{{ trans('main4.active_doctors') }}</span>
				<span class="stat">{{ $active_doctors }}</span>
			</a>

			<a href="#" class="admin-stat-item shade1">
				<span class="title">{{ trans('main4.pending_doctors') }}</span>
				<span class="stat">{{ $pending_doctors }}</span>
			</a>

			<a href="#" class="admin-stat-item shade1">
				<span class="title">{{ trans('main4.banned_doctors') }}</span>
				<span class="stat">{{ $banned_doctors }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main4.admins') }}</h3>--}}
			{{--<hr />--}}

			@if(isset($master_admin) && $master_admin)
				<a href="#" class="admin-stat-item shade2">
					<span class="title">{{ trans('main4.total_admins') }}</span>
					<span class="stat">{{ $total_admins }}</span>
				</a>
				<a href="#" class="admin-stat-item shade2">
					<span class="title">{{ trans('main4.minor_admins') }}</span>
					<span class="stat">{{ $minor_admins }}</span>
				</a>
				<a href="#" class="admin-stat-item shade2">
					<span class="title">{{ trans('main4.master_admins') }}</span>
					<span class="stat">{{ $master_admins }}</span>
				</a>
				{{--<br /><br />--}}
			@endif


			{{--<h3>{{ trans('main4.transactions') }}</h3>--}}
			{{--<hr />--}}

			<a href="#" class="admin-stat-item shade3">
				<span class="title">{{ trans('main4.finished_transactions') }}</span>
				<span class="stat">{{ $finished_transactions }}</span>
			</a>
			<a href="#" class="admin-stat-item shade3">
				<span class="title">{{ trans('main4.unsettled_transactions') }}</span>
				<span class="stat">{{ $unsettled_transactions }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main4.reservations') }}</h3>--}}
			{{--<hr />--}}


			<a href="#" class="admin-stat-item shade4">
				<span class="title">{{ trans('main4.active_reservations') }}</span>
				<span class="stat">{{ $active_reservations }}</span>
			</a>
			<a href="#" class="admin-stat-item shade4">
				<span class="title">{{ trans('main4.free_reservations') }}</span>
				<span class="stat">{{ $free_reservations }}</span>
			</a>
			<a href="#" class="admin-stat-item shade4">
				<span class="title">{{ trans('main4.done_reservations') }}</span>
				<span class="stat">{{ $done_reservations }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main.medical_question') }}</h3>--}}
			{{--<hr />--}}

			<a href="#" class="admin-stat-item shade5">
				<span class="title">{{ trans('main4.total_questions') }}</span>
				<span class="stat">{{ $medical_questions }}</span>
			</a>
			<a href="#" class="admin-stat-item shade5">
				<span class="title">{{ trans('main4.answered_questions') }}</span>
				<span class="stat">{{ $answered_questions }}</span>
			</a>
			<a href="#" class="admin-stat-item shade5">
				<span class="title">{{ trans('main4.unanswered_questions') }}</span>
				<span class="stat">{{ $unanswered_questions }}</span>
			</a>

			{{--<br /><br />--}}


			{{--<h3>{{ trans('main4.other') }}</h3>--}}
			{{--<hr />--}}

			<a href="#" class="admin-stat-item shade6">
				<span class="title">{{ trans('main2.fees') }}</span>
				<span class="stat">{{ $fees }}</span>
			</a>
			<a href="#" class="admin-stat-item shade6">
				<span class="title">{{ trans('main4.hospitals') }}</span>
				<span class="stat">{{ $hospitals }}</span>
			</a>
			<a href="#" class="admin-stat-item shade6">
				<span class="title">{{ trans('main4.mednews') }}</span>
				<span class="stat">{{ $medical_news }}</span>
			</a>
			<a href="#" class="admin-stat-item shade6">
				<span class="title">{{ trans('main4.chat_msgs') }}</span>
				<span class="stat">{{ $chat_msgs }}</span>
			</a>
			<a href="#" class="admin-stat-item shade6">
				<span class="title">{{ trans('main4.specialties') }}</span>
				<span class="stat">{{ $specialties }}</span>
			</a>

        </div>
    </div>
@endsection