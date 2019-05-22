<h1>Hi {{ $name }}</h1>
<br>
Your account has been created in {{ env('APP_NAME') }}. Following are the details:<br>
<strong>Name: </strong> {{ $name }} <br>
<strong>Email: </strong> {{ $email }}<br>
<strong>Password: </strong> {{ $password }}<br>
<strong>Plan: </strong> {{ $plan }}<br>

<p>Click <a href="{{ route('login') }}">here </a> to login to {{ env('APP_NAME') }}</p>
