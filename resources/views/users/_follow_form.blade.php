@can('follow', $user)
<div class="text-center mt-2 mb-4">
  @if(Auth::user()->isFollowing($user->id))
    <form action="{{ route('followers.delete', $user->id) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
    </form>
  @else
    <form action="{{ route('followers.add', $user->id) }}" method="post">
      {{ csrf_field() }}
      <button type="submit" class="btn btn-sm btn-primary">关注</button>
    </form>
  @endif
</div>
@endcan
