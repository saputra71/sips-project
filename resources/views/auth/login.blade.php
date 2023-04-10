  <style>
      #flash-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  </style>
<x-guest-layout>
    <div id="flash-screen">
        <h1 class="mt-2" style="text-align: center; font: 17pt 'Times New Roman';">Hai Admin, Selamat Datang di Aplikasi</h1>
        <br>
        <img src="{{asset('AdminLTE/dist')}}/img/kewzlogo_black.png" alt="AdminLTE Logo" class="brand-image" style="weight: 75px; height: 75px;">
        <h1 class="mt-2" style="text-align: center; font: 17pt 'Times New Roman';">SIPS</h1>
        <br>
        <p>Mohon Menunggu ...</p>
      </div>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{asset('AdminLTE/dist')}}/img/kewzlogo_black.png" alt="AdminLTE Logo" class="brand-image" style="weight: 75px; height: 75px;">
            <h1 class="mt-2" style="text-align: center; font: 17pt 'Times New Roman';">SIPS</h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Name') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Kata Sandi') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi ?') }}
                </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Masuk') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<script >
    // Menampilkan flash screen saat halaman dimuat
    window.onload = function() {
      document.getElementById("flash-screen").style.display = "flex";
      
      // Menghapus flash screen setelah 3 detik
      setTimeout(function() {
        document.getElementById("flash-screen").style.display = "none";
      }, 3000);
    }
    </script>