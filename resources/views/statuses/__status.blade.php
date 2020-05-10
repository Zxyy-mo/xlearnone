<li class="medio mt-4 mb-4">
	<a href="{{route('users.show',$user->id)}}">
		<img src="{{$user->gravatar()}}" alt="{{$user->name}}" class="mr-3 gravatar">
	</a>
	<div class="media-body">
		<h5 class="mt-0 mb-1">{{$user->name}} <small> / {{ $status->created_at->diffForHumans() }}</small></h5>
		<!-- $status是微博 然后是微博的发布日期diffForHumans更改显示方式 -->
   	 	{{ $status->content }}
 	 </div>
 	 @can('destroy',$status)
 	 	<form action="{{route('statuses.destroy',$status->id)}}" method="POST" onsubmit="return confirm('您确定是否要删除')">
 	 		@csrf
 	 		{{method_field('DELETE')}}
 	 		<button type="submit" class="btn btn-sm btn-danger">
 	 			删除
 	 		</button>
 	 	</form>
 	 @endcan
</li>