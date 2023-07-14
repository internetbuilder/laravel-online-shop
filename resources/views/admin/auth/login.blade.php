<x-auth-layout>
    <x-slot:title>
        Login
    </x-slot>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="logo">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="login-box">
            <form class="login-form" action="{{ route('admin.login.post') }}" method="POST" role="form">
                @csrf
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
                <div class="form-group">
                    <label class="control-label" for="email">Email Address</label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="Email address" autofocus value="{{ old('email') }}">
                    @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
                </div>
                <div class="form-group">
                    <label class="control-label" for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">

                </div>
                <div class="form-group">
                    <div class="utility">
                        <div class="animated-checkbox">
                            <label>
                                <input type="checkbox" name="remember"><span class="label-text">Stay Signed in</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
                </div>
            </form>
        </div>
    </section>
    

</x-auth-layout>