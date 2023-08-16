@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
          <div class="card shadow border-0">
            <div class="card-body d-flex justify-content-between">
                <h5 class="mt-2">@lang('My Tickets')</h5>
                <a class="btn btn--base btn-sm" href="{{route('ticket.open')}}"> <i class="las la-plus"></i> @lang('New Ticket')</a>
            </div>
          </div>
          <div class="table-responsive--md">
            <table class="table custom--table">
              <thead>
                <tr>
                    <th scope="col">@lang('Subject')</th>
                    <th scope="col">@lang('Status')</th>
                    <th scope="col">@lang('Last Reply')</th>
                    <th scope="col">@lang('Action')</th>
                </tr>
              </thead>
              <tbody>
                @foreach($supports as $key => $support)
                <tr>
                    <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [Ticket#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                    <td data-label="@lang('Status')">
                        @if($support->status == 0)
                            <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                        @elseif($support->status == 1)
                            <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                        @elseif($support->status == 2)
                            <span class="badge badge--warning py-2 px-3">@lang('Customer Reply')</span>
                        @elseif($support->status == 3)
                            <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
                        @endif
                    </td>
                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                    <td data-label="@lang('Action')">
                        <a href="{{ route('ticket.view', $support->ticket) }}" class="icon-btn btn--primary">
                            <i class="fa fa-desktop"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            {{paginateLinks($supports)}}
          </div>
        </div>
      </div>
@endsection
