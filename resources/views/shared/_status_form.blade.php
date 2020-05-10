<form action="{{route('statuses.store',$user->id)}}" method="POST">
	@include('shared._error')
	@csrf
	<textarea name="content" class="form-control" rows="3" placeholder="没事聊聊....."></textarea>
	<div class="text-right">
		<button class="btn btn-primary mt-3" type="submit">
			发布
		</button>
	</div>
</form>