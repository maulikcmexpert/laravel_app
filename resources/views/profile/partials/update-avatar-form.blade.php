<style>
    .img-avatar {
        width: 90px;

    }

    .img-avatar img {
        border-radius: 50%
    }
</style>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            User Avatar
        </h2>
        <div class="img-avatar">
            <img src="{{ 'storage/'.$user->avatar}}" alt="user avatar">
        </div>

        <form method="post" action="{{route('profile.avatar.ai')}}">
            @csrf
            <div class="flex items-center gap-4">
                <x-primary-button>Generate Avatar</x-primary-button>
            </div>
        </form>

        <p class="mt-1 text-sm text-gray-600">
            Add user avatar
        </p>
    </header>

    @if (session('message'))
    <div style="color:green">
        {{ session('message') }}
    </div>
    @endif

    <form method="post" action="{{ route('profile.avatar') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Avatar" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" autofocus autocomplete="avatar" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

        </div>
    </form>
</section>