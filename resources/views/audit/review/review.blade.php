@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.audit', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.audit', 2) }}
        
        @if($id!=NULL)
        <span class="panel-btn">
            @if(Auth::user()->can('create-audit'))
            <a class="btn btn-sm btn-info" href="{{ URL::to("lab") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.create-audit', 1) }}
            </a>
            @endif

            @if(Auth::user()->can('import-data'))
            <a class="btn btn-sm btn-info" href="{{ URL::to("import/".$id) }}" >
                <span class="fa fa-download"></span>
                {{ Lang::choice('messages.import-audit', 1) }}
            </a>
            <a class="btn btn-sm btn-info" href="" onclick="window.history.back();return false;">
                <i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span>
            </a>
            @endif

        </span>
        @endif
       
    </div>
    <div class="panel-body">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', 1) }}</span></button>
          {!! session('message') !!}
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">

                <table class="table table-striped table-bordered table-hover {!! !$responses->isEmpty()?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.response-no', 1) }}</th>
                            <th>{{ Lang::choice('messages.assessor', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab', 1) }}</th>
                            <th>{{ Lang::choice('messages.audit', 1) }}</th>
                            <th>{{ Lang::choice('messages.date', 1) }}</th>
                            <th>{{ Lang::choice('messages.status', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($responses as $response)
                        <tr @if(session()->has('active_review'))
                                {!! (session('active_review') == $response->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $response->id }}</td>
                            <td>{{ $response->user->name }}</td>
                            <td>{{ $response->lab->name }}</td>
                            <td>{{ $response->auditType->name }}</td>
                            <td>{{ $response->created_at }}</td>
                            <td>{{ $response->status==App\Models\Review::COMPLETE?Lang::choice('messages.audit-status', 1):Lang::choice('messages.audit-status', 2) }}</td>
                            <td>
                              <a href="{{ URL::to("review/" . $response->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {{ Lang::choice('messages.view', 1) }}</span></a>
                              <a href="{{ URL::to("review/" . $response->id . "/edit") }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i><span> {{ Lang::choice('messages.edit', 1) }}</span></a>
                              <a href="{{ URL::to("review/" . $response->id . "/complete") }}" class="btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i><span> {{ Lang::choice('messages.mark-audit-complete', 1) }}</span></a>
                              <a href="{{ URL::to("review/" . $response->id . "/export") }}" class="btn btn-default btn-sm"><i class="fa fa-external-link"></i><span> {{ Lang::choice('messages.export-audit', 1) }}</span></a>
                              <a href="{{ URL::to("report/" . $response->id) }}" class="btn btn-info btn-sm"><i class="fa fa-bar-chart"></i><span> {{ Lang::choice('messages.run-reports', 1) }}</span></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {!! session(['SOURCE_URL' => URL::full()]) !!}
        </div>
      </div>
</div>
@stop