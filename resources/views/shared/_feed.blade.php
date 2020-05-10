@if(Auth::check())
<ul class="list-unstyled">
	@foreach($feed_items as $status)
		@include('statuses.__status',['user'=>$status->user])
	@endforeach
</ul>
<div class="mt-5">
	{!! $feed_items->render() !!}
</div>
@else
<p>没有数据</p>
@endif