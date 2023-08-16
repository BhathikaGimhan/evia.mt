@php
    if(auth()->user()){
        $layout = 'layouts.master';
    } else {
        $layout = 'layouts.frontend';
        $container = 'container pt-100 pb-100';
        $col = 'col-md-10';
    }
@endphp

@extends($activeTemplate.$layout)

@section('content')

      <div class="{{$container ?? ''}}">
        <div class="row justify-content-center">
            <div class="{{$col ?? 'col-md-12'}}">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg--sec d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="card-title text-white mt-1">
                            @if($my_ticket->status == 0)
                                <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                            @elseif($my_ticket->status == 1)
                                <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                            @elseif($my_ticket->status == 2)
                                <span class="badge badge--warning py-2 px-3">@lang('Replied')</span>
                            @elseif($my_ticket->status == 3)
                                <span class="badge badge--white py-2 px-3">@lang('Closed')</span>
                            @endif
                            [Ticket#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                        </h5>
                        @if ($my_ticket->status != 3)
                         <button class="btn btn--danger btn-sm close-button" type="button" title="@lang('Close Ticket')" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>
                        @endif
                        </button>
                    </div>
                    <div class="card-body">
                        @if($my_ticket->status != 4)
                            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-between">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form--control" id="inputMessage" placeholder="@lang('Your Reply')" rows="4" cols="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-10">
                                        <div class="row justify-content-between">
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="inputAttachments">@lang('Attachments')</label>
                                                    <input type="file" name="attachments[]" id="inputAttachments" class="form-control"/>
                                                    <div id="fileUploadsContainer"></div>
                                                    <small class="my-2 ticket-attachments-message text-muted">
                                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label for="" class="d-block">&nbsp;</label>
                                                    <a href="javascript:void(0)" class="btn btn--base btn-sm" onclick="extraTicketAttachment()">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="" class="d-block">&nbsp;</label>
                                            <button type="submit" class="btn btn--base btn-sm w-100" name="replayTicket" value="1">
                                                <i class="fa fa-reply"></i> @lang('Reply')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                        
                        <div class="row mt-2">
                            <div class="col-md-12">
                                @foreach($messages as $message)
                                    @if($message->admin_id == 0)
                                        <div class="row border border-primary border-radius-3 my-3 py-3 mx-2">
                                            <div class="col-md-3 border-right text-right">
                                                <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                            </div>
                                            <div class="col-md-9">
                                                <p class="text-muted font-weight-bold my-3">
                                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                <p>{{$message->message}}</p>
                                                @if($message->attachments()->count() > 0)
                                                    <div class="mt-2">
                                                        @foreach($message->attachments as $k=> $image)
                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="row border border-warning border-radius-3 my-3 py-3 mx-2">
                                            <div class="col-md-3 border-right text-right">
                                                <h5 class="my-3">{{ $message->admin->name }}</h5>
                                                <p class="lead text-muted">@lang('Staff')</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p class="text-muted font-weight-bold my-3">
                                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                <p>{{$message->message}}</p>
                                                @if($message->attachments()->count() > 0)
                                                    <div class="mt-2">
                                                        @foreach($message->attachments as $k=> $image)
                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
   
@endsection

@push('script')
     <script>
            'use strict';
            (function ($) {
                $('.delete-message').on('click', function (e) {
                    $('.message_id').val($(this).data('id'));
                });
            })(jQuery);

            function extraTicketAttachment() {
                 $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control mt-2" required />')
            }
     </script>
@endpush

@push('style')

<style>
    .border-warning{
        background-color: #ffd96729
    }
</style>

@endpush